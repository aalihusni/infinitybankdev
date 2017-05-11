<?php namespace App\Http\Controllers\Member\helpdesk;

// controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\SettingsController;
use Illuminate\Http\Request;


// requests
use App\Http\Requests\helpdesk\CheckTicket;
use App\Http\Requests\helpdesk\TicketRequest;


use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\Model\helpdesk\Ticket\Ticket_Status;
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Manage\Sla_plan;
// models
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\User;

use App\Classes\UserClass;
// classes
use Auth;
use Hash;
use Input;
use Exception;


use Mail;
use Redirect;
use Lang;
use Response;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use Storage;
use S3Files;

/**
 * GuestController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Cara <kamal@cara.com.my>
 */
class UserTicketController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type void
	 */

	public function __construct() {
		//SettingsController::smtp();
		// checking authentication
		$this->middleware('auth');
	}


	/**
	 * Get my ticket
	 * @param type Tickets $tickets
	 * @param type Ticket_Thread $thread
	 * @param type User $user
	 * @return type Response
	 */
	public function getMyticket(User $user, Tickets $ticket) {
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		$openTickets = $ticket->getMyTickets(['user_id'=>$user_id,'status'=>[1]])->paginate(20);
		$openArr = array();
		foreach ($openTickets as $open)
		{
			$string = strip_tags($open->title);
			$TicketDatarow = Ticket_Thread ::where('ticket_id', '=', $open->id)->orderBy('id', 'desc')->first();
			$LastResponse = User::where('id', '=', $TicketDatarow->user_id)->first();
			if($LastResponse->user_type == "2") {
				$rep = "#F39C12";
				$username = $LastResponse->firstname;
			} else { $rep = "#000"; $username = $LastResponse->firstname ." ". $LastResponse->lastname;
			if($LastResponse->firstname==null || $LastResponse->lastname==null) {
				$username = $LastResponse->firstname;
			}}
			$totalThread = Ticket_Thread::where(['ticket_id'=>$open->id])->count();
			$openArr[] = ( object ) array('id'=>$open->id,'title'=>$open->title,'tktTitle'=>str_limit($string,40),'count'=>$totalThread,
					'ticket_number'=>$open->ticket_number,'tktstatus'=>$open->tktstatus,'last_updated_at'=>$TicketDatarow->updated_at,
					'priority'=>$open->priority,'priority_color'=>$open->priority_color,'rep'=>$rep,'lastreplier'=>$username);
		}
		//dd($openArr);
		$opens = Tickets::where('user_id', '=' , Auth::user()->id)
		->where('status', '=', 1)
		->orderBy('id', 'DESC')
		->paginate(20);
		
		$closeTickets = $ticket->getMyTickets(['user_id'=>$user_id,'status'=>[2,3]])->paginate(20);
		//dd($closeTickets);
		$closeArr = array();
		foreach ($closeTickets as $close)
		{
			$string = strip_tags($close->title);
			$TicketDatarow = Ticket_Thread ::where('ticket_id', '=', $close->id)->orderBy('id', 'desc')->first();
			$LastResponse = User::where('id', '=', $TicketDatarow->user_id)->first();
			if($LastResponse->user_type == "2") {
				$rep = "#F39C12";
				$username = $LastResponse->firstname;
			} else { $rep = "#000"; $username = $LastResponse->firstname ." ". $LastResponse->lastname;
			if($LastResponse->firstname==null || $LastResponse->lastname==null) {
				$username = $LastResponse->firstname;
			}}
			$totalThread = Ticket_Thread::where('ticket_id', '=', $close->id)->count();
			$closeArr[] = ( object ) array('id'=>$close->id,'title'=>$close->title,'tktTitle'=>str_limit($string,40),'count'=>$totalThread,
					'ticket_number'=>$close->ticket_number,'tktstatus'=>$close->tktstatus,'last_updated_at'=>$TicketDatarow->updated_at,
					'priority'=>$close->priority,'priority_color'=>$close->priority_color,'rep'=>$rep,'lastreplier'=>$username);
		}
		
		$closeBKP = Tickets::where('user_id', '=' , Auth::user()->id)
		                ->whereIn('status', [2, 3]) 
		                ->orderBy('id', 'DESC')
		                ->paginate(20);
		
		return view('helpticket.ticket.mytickets')
				->with('open',$openArr)
				
				->with('renderOpenList',$openTickets)
				->with('renderCloseList',$closeTickets)
				->with('close',$closeArr);
	}
	
	/**
	 * select_all 
	 * @return type
	 * Update Status
	 */
	public function updateStatus() {
	
		if(Input::has('select_all'))
		{
			$selectall = Input::get('select_all');
			$value = Input::get('submit');
			foreach($selectall as $delete)
			{
				$ticket = Tickets::whereId($delete)->first();
				if($value == "Delete"){
					$ticket->status = 5;
					$ticket->save();
				} elseif($value == "Close") {
					$ticket->status = 2;
					$ticket->closed = 1;
					$ticket->closed_at = date('Y-m-d H:i:s');
					$ticket->save();
				} elseif($value == "Open") {
					$ticket->status = 1;
					$ticket->reopened = 1;
					$ticket->reopened_at = date('Y-m-d H:i:s');
					$ticket->closed = 0;
					$ticket->closed_at = null;
					$ticket->save();
				}
			}
			if($value == "Delete"){
				return redirect()->back()->with('success','Moved to trash');
			} elseif($value == "Close") {
				return redirect()->back()->with('success','Tickets has been Closed');
			} elseif($value == "Open") {
				return redirect()->back()->with('success','Ticket has been Opened');
			}
		}
		return redirect()->back()->with('fails','None Selected!');
	}
	

	
	/**
	 * reply
	 * @param type $value
	 * @return type view
	 */
	public function postCommentOfTicket($id, Request $request) {
		$comment = $request->get('comment');
		### Convert IMAGE DATA ###
		$final_tags = '';
		$dom = new \DOMDocument();
		$dom->loadHTML($comment);
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
				$comment = preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $dom->saveHTML());
					
		}
		### Convert IMAGE DATA ###
		
		if($comment != null) {
			$tickets = Tickets::where('id','=',$id)->first();
			$tickets->closed_at = null;
			$tickets->closed = 0;
			$tickets->status = 1;
			$tickets->reopened_at = date('Y-m-d H:i:s');
			$tickets->reopened = 1;
			$threads = new Ticket_Thread;
			$threads->user_id = Auth::user()->id;
			$threads->ticket_id = $tickets->id;
			$threads->poster = "user";
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


	
	

	/**
	 * Post Check ticket
	 * @param type CheckTicket $request
	 * @param type User $user
	 * @param type Tickets $ticket
	 * @param type Ticket_Thread $thread
	 * @return type Response
	 */
	public function PostCheckTicket() {

			$Email = \Input::get('email');
			$Ticket_number = \Input::get('ticket_number');

			$ticket = Tickets::where('ticket_number', '=', $Ticket_number)->first();
			if($ticket == null) {
				return \Redirect::route('form')->with('fails', 'There is no such Ticket Number');
			} else {
				$userId = $ticket->user_id;
				$user = User::where('id', '=', $userId)->first();	

				if($user->role == 'user') {
					$username = $user->user_name;
				} else {
					$username = $user->first_name." ".$user->last_name;
				}

				if($user->email != $Email) {
					return \Redirect::route('form')->with('fails', "Email didn't match with Ticket Number");
				} else {
					$code = $ticket->id;
					$code = \Crypt::encrypt($code);

					$company = $this->company();

					\Mail::send('emails.check_ticket',
						array('link'=>\URL::route('check_ticket',$code),'user'=>$username, 'from'=>$company),
						function($message) use($user, $username, $Ticket_number) {
							$message->to($user->email, $username)->subject('Ticket link Request ['.$Ticket_number.']');
						}
					);
					return \Redirect::back()
						->with('success','We have sent you a link by Email. Please click on that link to view ticket');
				}
			}
	}		

	/**
	 * get ticket email
	 * @param type $id 
	 * @return type
	 */
	public function getTicketDetail($id) {
		//$id1 = \Crypt::decrypt($id);
		$tickets = Tickets::where('id','=',\Crypt::decrypt($id))->first();
		$thread = Ticket_Thread::where('ticket_id','=',\Crypt::decrypt($id))->first();
		$priority = Ticket_Priority::where('id','=',$tickets->priority_id)->first();
		
		$sla = $tickets->sla;
		$SlaPlan = Sla_plan::where('id','=',1)->first();
		$response = Ticket_Thread::where('ticket_id','=',$tickets->id)->where('is_internal','=',0)->get();
		foreach($response as $last){
		$ResponseDate  = $last->created_at;
		}
		$help_topic = Help_topic::where('id','=',$tickets->help_topic_id)->first();
		$conversations = $tickets->Threads()->where('is_internal', '=', 0)->paginate(10);
		$conversationsArr = array();
		foreach ($conversations as $conv)
		{
			### ATTACHMENT ####
			
			$attachments = Ticket_attachments::where('thread_id','=',$conv->id)->get();
			$attachmentData =  array();
			foreach($attachments as $attachment)
			{
		
				$size = $attachment->size;
				$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
				$power = $size > 0 ? floor(log($size, 1024)) : 0;
				$value = number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
				if($attachment->poster == 'ATTACHMENT')
				{
					$fileType = '';
					$varfileDetail = '';
					$attType = strtoupper($attachment->type);
					$fileType = 'Image';
					$imageSource = '';
		
					$attachmentData[] = (object)array(
							'fileDetail'=>$varfileDetail,
							'filename'=>$attachment->name,
							'file_path' => $attachment->file_path,
							'filesize'=>$value,
							'poster'=>$attachment->poster,
							'image_id'=>$attachment->id,
							'fileType'=>$fileType,
							'attachmentType'=>$attType,
							'imageSource'=>$imageSource
		
					);
				}   }
				### ATTACHMENT ####
		
				$body = $conv->body;
				$conversationsArr[] = (object)array(
						'name'=>$conv->firstname.' '.$conv->lastname,
						'body'=>$body,
						'id'=>$conv->id,
						'created_at'=>$conv->created_at,
						'profile_pic'=>$conv->profile_pic,
						'attachments'=>$attachmentData
				);
		}
		/*
		$conversations = Ticket_Thread::
							where('ticket_id', '=', $tickets->id)->where('is_internal', '=', 0)->paginate(10); */
		
		//helpticket.ticket.mytickets
		return view('helpticket.ticket.ckeckticket',compact('id'))
		->with('tickets',$tickets)
		->with('thread',$thread)
		->with('priority',$priority)
		->with('sla',$sla)
		->with('SlaPlan',$SlaPlan)
		->with('$response',$response)
		->with('ResponseDate',$ResponseDate)
		->with('conversations',$conversationsArr)
		//->with('conversations',$conversations)
		->with('last',$last)
		->with('status',Ticket_Status::where('id','=',$tickets->status)->first())
		->with('help_topic',$help_topic)
		->with('department',Department::where('id', '=', $help_topic->department)->first());
		
		
	}
    
	
	
}
