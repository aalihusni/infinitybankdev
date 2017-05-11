<?php namespace App\Http\Controllers\Member\helpdesk;

// controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\helpdesk\TicketController;
// requests
use Illuminate\Http\Request;
use App\Http\Requests\helpdesk\ClientRequest;
// models
use App\Model\helpdesk\Form\Forms;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Settings\TicketSetting;
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Settings\Ticket;
use App\Model\helpdesk\Ticket\Ticket_source;
use App\User;


// classes
use Form;
use Input;
use Mail;
use Hash;
use Redirect;
use Config;
use DateTime;
use DateTimeZone;
use Exception;
use Auth;
use Lang;
use Response;
use App\Model\helpdesk\Manage\Leaders;
use DB;

use Storage;
use S3Files;
/**
 * FormController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Cara <kamal@cara.com.my>
 */
class FormController extends Controller {

	/**
	 * Create a new controller instance.
	 * Constructor to check
	 * @return void
	 */
	public function __construct(TicketController $TicketController) {
		// mail smtp settings
		//SettingsController::smtp();
		// creating a TicketController instance
		$this->TicketController = $TicketController;
	}

	/**
	 * getform
	 * @param type Help_topic $topic
	 * @return type
	 */
	public function preForm(Help_topic $topic) {

		$helptopic = $topic->whereStatus(1)->OrderBy('ordering','asc')->get();
		return view('helpticket.ticket.User.form2', compact('helptopic'));
	}

	public function getForm() {

		if(empty($_POST['topic']))
		{
			return view('helpticket.ticket.User.form2')->withErrors('Please select your ticket purpose!');
		}
		else {
			//$helptopic = $topic->get();
			return view('helpticket.ticket.User.form')->with('topic',$_POST['topic']);
		}
	}



	/**
	 * Posted form
	 * @param type Request $request
	 * @param type User $user
	 */

	public function postedForm(User $user, ClientRequest $request, TicketSetting $ticket_settings) {
		//return Redirect::route('user.getform')->with('success','Ticket Created Successfully','message','Ticket Created Successfully');
		$form_extras = $request->except('Name','Phone','Email','Subject','Details','helptopic','_wysihtml5_mode','_token');
		$subject = $request->get('Subject');
		$details = $request->get('Details');
		
		### Convert IMAGE DATA ###
		$final_tags = '';
		$dom = new \DOMDocument();
		$dom->loadHTML($details);
		$img_tags = $dom->getElementsByTagName('img');
		# Roll through the `img` tags.
		foreach ($img_tags as $tag) {
			##CONVERT##
			$data = $tag->getAttribute('src');
			$SubStr = substr("$data", 0,4);
			if($SubStr == 'http')
				continue;
				list($type, $data) = explode(';', $data);
				list(, $data)      = explode(',', $data);
				$data = str_replace(' ', '+', $data);
				$data = base64_decode($data);
				$imageName = time().'-'.rand() . '.png';
				$path = 'helpdesk/attachments/'.$imageName;
				Storage::put($path, $data);
				$ImageUrl =  S3Files::url('helpdesk/attachments/'.$imageName);
				## CONVERT##
				# Set the `src` attribute to be the new value.
				$tag->setAttribute('src', $ImageUrl);
				# Save the tag into the HTML.
				$dom->saveHTML($tag);
				$details = preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $dom->saveHTML());
					
		}
		### Convert IMAGE DATA ###
		
		$ticket_settings = $ticket_settings->first();
		$HelpTopic = Help_topic::find($request->helptopic);
		$topicID = $request->helptopic;
		if(is_null($HelpTopic))
			$topicID = $ticket_settings->help_topic;
		$ticketSetting =  array(
			'status'=>$ticket_settings->status,
			'help_topic_id'=>$topicID,
			'sla'=>$ticket_settings->sla,
			'priority_id'=>$ticket_settings->priority,
			'department'=>$HelpTopic->department,
			'source'=>1
		);

		$collaborator = null;
		$assignto = null;
		$UserDetail = Auth::user();
		$Leader = Leaders::where(['country_code'=>$UserDetail->country_code,'default'=>1])->first();
		if(is_null($Leader))
			$assignto = null;
		else $assignto = $Leader->user_id;
		// check emails

		$username = $UserDetail->firstname;
		$user_id = $UserDetail->id;
		DB::beginTransaction();
		$ticket_number = $this->TicketController->check_ticket($user_id, $subject, $details,$ticketSetting, $assignto, $form_extras);
		//$ticket_number[0] = 0;
		if($ticket_number[0])
			DB::commit();
		else {
			return Response::json ( array (
				'response' => 0,
				'errors' => array('custom_msg'=>'Action Failed. Please try again!')
			) );
		}

		$ticket_number2 = $ticket_number[0];
		$ticketdata = Tickets::where('ticket_number','=',$ticket_number2)->first();
		$threaddata = Ticket_Thread::where('ticket_id','=',$ticketdata->id)->first();
		$is_reply = $ticket_number[1];
		$system = Config::get('helpdesk.system_support');
		$updated_subject = $threaddata->title . '[#' . $ticket_number2 . ']';
		$emailadd = Auth::user()->email;
		$source = 1;
		$company = Config::get('helpdesk.site_name');
		$ticket_creator = $username;
		if($ticket_number2)
		{
			$response = ['response' => 1,'message'=>'Ticket Created Successfully'];
			// send ticket create details to user
			if($is_reply == 0)
			{
				$mail = "Admin_mail";
				if(Auth::user()) {
					$sign = Auth::user()->alias;
				} else {
					$sign = $company;
				}
				/*
					Mail::send('helpticket.emails.Ticket_Create', ['sign'=>$sign, 'content' => null, 'name' => $username, 'ticket_number' => $ticket_number2, 'system' => $system], function ($message) use ($emailadd, $username, $ticket_number2, $updated_subject) {
						$message->to($emailadd, $username)->subject($updated_subject);
					});
					*/
			}
			else
			{
				$mail = "email_reply";
			}

			$admins = User::where('user_type','=',1)->get();
			foreach($admins as $admin)
			{
				$admin_email = $admin->email;
				$admin_user = $admin->firstname;
				/*
                Mail::send('helpticket.emails.'.$mail, ['agent' => $admin_user,'content'=>$details,
                'ticket_number' => $ticket_number2, 'from'=>$company, 'email' => $emailadd, 'name' => $ticket_creator,
                 'system' => $system],
                function ($message) use ($admin_email, $admin_user, $ticket_number2, $updated_subject) {
                    $message->to($admin_email, $admin_user)->subject($updated_subject);
                }); */
			}

			// send email to agents
			$agents = Leaders::join ( 'users as U', 'U.id', '=', 'leaders.user_id' )
				->where('leaders.country_code','=',$UserDetail->country_code)
				->select('U.email','U.firstname','leaders.country_code','leaders.created_at as addedOn')->get();
			foreach($agents as $agent)
			{
				$agent_email = $agent->email;
				$agent_user = $agent->firstname;
				/*
                Mail::send('helpticket.emails.'.$mail, ['agent' => $agent_user ,'content'=>$details ,
                 'ticket_number' => $ticket_number2, 'from'=>$company, 'email' => $emailadd,
                 'name' => $ticket_creator, 'system' => $system], function ($message)
                 use ($agent_email, $agent_user, $ticket_number2, $updated_subject) {
                    $message->to($agent_email, $agent_user)->subject($updated_subject);
                }); */
			}

			//return Redirect::route('create-ticket')->with('success','Ticket Created Successfully');
			//return ['0'=>$ticket_number2, '1'=>true];
		}
		else
			$response = ['response' => 0,'message'=>'Action Failed. Please try again!'];
		return Response::json ( $response );

	}



	/**
	 * reply
	 * @param type $value
	 * @return type view
	 */
	public function post_ticket_reply($id, Request $request) {
		$comment = $request->input('comment');
		if($comment != null) {
			$tickets = Tickets::where('id','=',$id)->first();
			$threads = new Ticket_Thread;
			$tickets->closed_at = null;
			$tickets->closed = 0;
			$tickets->reopened_at = date('Y-m-d H:i:s');
			$tickets->reopened = 1;
			$threads->user_id = $tickets->user_id;
			$threads->ticket_id = $tickets->id;
			$threads->poster = "client";
			$threads->body = $comment;
			try {
				$threads->save();
				$tickets->save();
				return \Redirect::back()->with('success1','Successfully replied');
			} catch(Exception $e) {
				return \Redirect::back()->with('fails1',$e->errorInfo[2]);
			}
		} else {
			return \Redirect::back()->with('fails1','Please fill some data!');
		}


	}


}