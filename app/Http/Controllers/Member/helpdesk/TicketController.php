<?php namespace App\Http\Controllers\Member\helpdesk;
// controllers
use App\Http\Controllers\Controller;

// requests
use App\Http\Requests\helpdesk\CreateTicketRequest;
use App\Http\Requests\helpdesk\TicketRequest;
use App\Http\Requests\helpdesk\TicketEditRequest;
// models
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\Model\helpdesk\Ticket\Ticket_Status;
use App\Model\helpdesk\Ticket\Ticket_source;
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Ticket\Ticket_Form_Data;
use App\Model\helpdesk\Manage\Sla_plan;
use App\User;
use DB;
use App\Classes\UserClass;
// classes
use Auth;
use Hash;
use Input;
use Mail;
use PDF;
use Exception;
use Config;
use Response;
use URL;

/**
 * TicketController
 *
 * @package 	Controllers
 * @subpackage 	Controller
 * @author     	Cara <kamal@cara.com.my>
 */
class TicketController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type response
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Check the response of the ticket
	 * @param type $user_id
	 * @param type $subject
	 * @param type $body
	 * @param type $helptopic
	 * @param type $sla
	 * @param type $priority
	 * @return type string
	 */
	//($user_id, $subject, $body,$ticketSetting, $assignto, $from_data)
	public function check_ticket($user_id, $subject, $body, $ticketSetting, $assignto, $form_data) {
		$read_ticket_number = explode('[#',$subject);
		if(isset($read_ticket_number[1]))
		{
				
			$separate = explode("]", $read_ticket_number[1]);
			$new_subject = substr($separate[0], 0, 20);
			$find_number = Tickets::where('ticket_number', '=', $new_subject)->first();
			$thread_body = explode("---Reply above this line---", $body);
			$body = $thread_body[0];
			if (count($find_number) > 0) {
				$id = $find_number->id;
				$ticket_number = $find_number->ticket_number;
				if($find_number->status > 1)
				{
					$find_number->status = 1;
					$find_number->closed = 0;
					$find_number->closed_at = date('Y-m-d H:i:s');
					$find_number->reopened = 1;
					$find_number->reopened_at = date('Y-m-d H:i:s');
					$find_number->save();
	
					$ticket_status = Ticket_Status::where('id','=',1)->first();
					$user_name = User::where('id','=', $user_id)->first();
					$username = $user_name->firstname . " " . $user_name->lastname;
					$ticket_threads = new Ticket_Thread;
					$ticket_threads->ticket_id = $id;
					$ticket_threads->user_id = $user_id;
					$ticket_threads->is_internal = 1;
					$ticket_threads->body = $ticket_status->message. " " . $username;
					$ticket_threads->save();
	
				}
				if (isset($id)) {
					if ($this->ticket_thread($subject, $body, $id, $user_id)) {
						return array($ticket_number,1);
					}
				}
			} else {
				$ticket_number = $this->create_ticket($user_id, $subject, $body, $ticketSetting, $assignto, $form_data);
				return array($ticket_number,0);
			}
		} else {
			$ticket_number = $this->create_ticket($user_id, $subject, $body, $ticketSetting, $assignto, $form_data);
			//$ticket_number = $this->create_ticket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto, $form_data);
			return array($ticket_number,0);
		}
	}
	
	/**
	 * Create Ticket
	 * @param type $user_id
	 * @param type $subject
	 * @param type $body
	 * @param type $helptopic
	 * @param type $sla
	 * @param type $priority
	 * @return type string
	 */
	protected function create_ticket($user_id, $subject, $body, $ticketSetting, $assignto, $form_data) {
		$max_number = Tickets::whereRaw('id = (select max(`id`) from tkt_tickets)')->first();
		if($max_number == null) {
			$ticket_number = "AAAA-9999-9999999";
		} else {
			foreach ($max_number as $number) {
				$ticket_number = $max_number->ticket_number;
			}
		}
		$ticket = new Tickets;
		$ticket->ticket_number = $this->ticket_number($ticket_number);
		$ticket->user_id = $user_id;
		$ticket->dept_id = $ticketSetting['department'];
		$ticket->help_topic_id = $ticketSetting['help_topic_id'];
		$ticket->sla = $ticketSetting['sla'];
		$ticket->assigned_to = $assignto;
		$ticket->status = $ticketSetting['status'];
		$ticket->priority_id = $ticketSetting['priority_id'];
		$ticket->source = $ticketSetting['source'];
		$ticket->save();
		/*
		$sla_plan = Sla_plan::where('id','=',$ticketSetting['sla'])->first();
		$ovdate = $ticket->created_at;
		$new_date = date_add($ovdate, date_interval_create_from_date_string($sla_plan->grace_period));
		$ticket->duedate = $new_date;
		$ticket->save();*/
		$ticket_number = $ticket->ticket_number;
		$id = $ticket->id;
		if ($this->ticket_thread($subject, $body, $id, $user_id) == true)
			return $ticket_number;
		else return 0;
	}
	
	/**
	 * Generate Ticket Thread
	 * @param type $subject
	 * @param type $body
	 * @param type $id
	 * @param type $user_id
	 * @return type
	 */
	public function ticket_thread($subject, $body, $id, $user_id) {
		$thread = new Ticket_Thread;
		$thread->user_id = $user_id;
		$thread->ticket_id = $id;
		$thread->poster = 'client';
		$thread->title = $subject;
		$thread->body = $body;
		if ($thread->save()) 
			return true;
		else return false;
	}
	
	

	/**
	 * Save the data of new ticket and show the New ticket page with result
	 * @param type CreateTicketRequest $request
	 * @return type response
	 */
	public function post_newticket(CreateTicketRequest $request) {
		$email = $request->input('email');
		$fullname = $request->input('fullname');
		$helptopic = $request->input('helptopic');
		$sla = $request->input('sla');
		$duedate = $request->input('duedate');
		$assignto = $request->input('assignto');

		$subject = $request->input('subject');
		$body = $request->input('body');
		$priority = $request->input('priority');
		$phone = $request->input('phone');
		$source = Ticket_source::where('name','=','email')->first();
		$headers = null;
		$help = Help_topic::where('id','=',$helptopic)->first();	
		$form_data = null;
		//create user
		if ($this->create_user($email, $fullname, $subject, $body, $phone, $helptopic, $sla, $priority, $source->id, $headers, $help->department, $assignto, $form_data)) {
			return Redirect('newticket')->with('success', 'Ticket created successfully!');
		} else {
			return Redirect('newticket')->with('fails', 'fails');
		}
	}

	/**
	 * Shows the ticket thread details
	 * @param type $id
	 * @return type response
	 */
	public function thread($id) {
		$lock = Tickets::where('id','=',$id)->first();
		if($lock->lock_by == Auth::user()->id || $lock->lock_at < date('Y-m-d H:i:s', strtotime('-3 minutes', strtotime($lock->lock_at)))) {
			if(Auth::user()->role == 'agent'){
				
				$dept = Department::where('name','=',Auth::user()->primary_dpt)->first();

				$tickets = Tickets::where('id', '=', $id)->where('dept_id','=', $dept->id)->first();
			} else {
				$tickets = Tickets::where('id', '=', $id)->first();
			}
			$thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
			return view('themes.default1.agent.helpdesk.ticket.timeline', compact('tickets'), compact('thread'));
		} else {
			return Redirect()->back()->with('fails', 'This ticket has been locked by other agent');
		}			
	}

	/**
	 * Replying a ticket
	 * @param type Ticket_Thread $thread
	 * @param type TicketRequest $request
	 * @return type bool
	 */
	public function reply(Ticket_Thread $thread, TicketRequest $request, Ticket_attachments $ta ) {
	  	$attachments = $request->file('attachment');
	  	$check_attachment = null;
	  	// Event fire
	  	$eventthread = $thread->where('ticket_id',$request->input('ticket_ID'))->first();$eventuserid = $eventthread->user_id;$emailadd = User::where('id',$eventuserid)->first()->email;$source = $eventthread->source;$form_data = $request->except('ReplyContent','ticket_ID','attachment');
        \Event::fire(new \App\Events\ClientTicketFormPost($form_data,$emailadd,$source));
	  	// dd($attachments);
	  	// }
	  	//return $attachments;
	  	$reply_content = $request->input('ReplyContent');
	  	$thread->ticket_id = $request->input('ticket_ID');
	  	$thread->poster = 'support';
	  	$thread->body = $request->input('ReplyContent');
	  	$thread->user_id = Auth::user()->id;
	  	$ticket_id = $request->input('ticket_ID');
	  	//dd($ticket_id);
	  	$tickets = Tickets::where('id', '=', $ticket_id)->first();
		$tickets->isanswered = '1';
		$tickets->save();

	  	$ticket_user = User::where('id','=',$tickets->user_id)->first();

	  	if($tickets->assigned_to == 0 )
	  	{
		   	$tickets->assigned_to = Auth::user()->id;
		 	$tickets->save();
		   	$thread2 = New Ticket_Thread;
		    $thread2->ticket_id = $thread->ticket_id;
		   	$thread2->user_id = Auth::user()->id;
		   	$thread2->is_internal = 1;
		   	$thread2->body = "This Ticket have been assigned to " . Auth::user()->first_name . " " . Auth::user()->last_name;
		   	$thread2->save();
	  	}
	  	if($tickets->status > 1)
	  	{
	   		$tickets->status = '1';
	   		$tickets->closed_at = '0';
	   		$tickets->closed = null;
	   		$tickets->reopened_at = date('Y-m-d H:i:s');
	   		$tickets->reopened = 1;
	   		$tickets->isanswered = '1';
	  		$tickets->save(); 
	  	}
	  	$thread->save();
	  	
	  	//$atachPath = '';
	   	foreach ($attachments as $attachment) {
	    	if($attachment != null){
	    		$name = $attachment->getClientOriginalName();
	    		//dd(dirname($attachment));
	    		$type = $attachment->getClientOriginalExtension();
	    		$size = $attachment->getSize();
	    		$data = file_get_contents($attachment->getRealPath());
	    		// $tem_path = $attachment->getRealPath();
	    		// $tem = basename($tem_path).PHP_EOL;
	    		// //dd($tem);
	    		$attachPath=$attachment->getRealPath();
	    		//dd($attachPath);
	    		$ta->create(['thread_id' => $thread->id,'name'=>$name,'size'=>$size,'type'=>$type,'file'=>$data,'poster'=>'ATTACHMENT']);

	    		$check_attachment = 1;
		   } else {
		   		$check_attachment = null;
		   }
  		}

  		
		$thread = Ticket_Thread::where('ticket_id', '=', $ticket_id)->first();
	  	$ticket_subject = $thread->title;
	  	$user_id = $tickets->user_id;
	  	$user = User::where('id','=',$user_id)->first();
	  	$email = $user->email;
	  	$user_name = $user->user_name;
	  	$ticket_number = $tickets->ticket_number;
	  	$company = $this->company();
	  	$username  =  $ticket_user->user_name;
  		if(!empty(Auth::user()->agent_sign)) {
		    $agentsign = Auth::user()->agent_sign; 
  		}
  		else{
   			$agentsign = null;  
  		}
  
		  	// foreach($attachments as $attachment){ 
		  	// $pathToFile = $attachment->getRealPath();
		  	// $name = $attachment->name;
		  	// $data = $attachment->file;
		  	// $display = $attachment->file;
		  	// $mime = $attachment->type;
		  	// }
		  	//dd(sizeOf($attachments));
		  	//$size = sizeOf($attachments);
		  	//dd($thread->id);\
		   	// mail to main user
		  	//$path = 'C:\wamp\tmp\php5D3A.tmp';

	  		// Event
	  		\Event::fire(new \App\Events\FaveoAfterReply($reply_content,$user->phone_number,$request,$tickets));
	  		
		   	Mail::send(array('html'=>'emails.ticket_re-reply'), ['content' => $reply_content, 'ticket_number' => $ticket_number, 'From' => $company, 'name'=>$username, 'Agent_Signature' => $agentsign], function ($message) use ($email, $user_name, $ticket_number, $ticket_subject, $attachments, $check_attachment) {
    		$message->to($email, $user_name)->subject($ticket_subject . '[#' . $ticket_number . ']');
    		// if(isset($attachments)){
    		if($check_attachment == 1){
	    		$size = sizeOf($attachments);
	    		for($i=0;$i<$size;$i++){
	           	$message->attach($attachments[$i]->getRealPath(), ['as' => $attachments[$i]->getClientOriginalName(), 'mime' => $attachments[$i]->getClientOriginalExtension()]);
	           	}
           	}
           	},true);

   
   			$collaborators = Ticket_Collaborator::where('ticket_id','=',$ticket_id)->get();
   			foreach ($collaborators as $collaborator) {
    			//mail to collaborators
    			$collab_user_id = $collaborator->user_id;
			    $user_id_collab = User::where('id','=',$collab_user_id)->first();
			    $collab_email = $user_id_collab->email;
			    if($user_id_collab->role == "user") {
			    	$collab_user_name = $user_id_collab->user_name;
				} else {
					$collab_user_name = $user_id_collab->first_name . " " . $user_id_collab->last_name;
				}
			    Mail::send('emails.ticket_re-reply', ['content' => $reply_content, 'ticket_number' => $ticket_number, 'From' => $company, 'name'=>$collab_user_name, 'Agent_Signature' => $agentsign], function ($message) use ($collab_email, $collab_user_name, $ticket_number, $ticket_subject, $attachments, $check_attachment) {
			    $message->to($collab_email, $collab_user_name)->subject($ticket_subject . '[#' . $ticket_number . ']');
				if($check_attachment == 1){
	    			$size = sizeOf($attachments);
	    			for($i=0;$i<$size;$i++){
	           			$message->attach($attachments[$i]->getRealPath(), ['as' => $attachments[$i]->getClientOriginalName(), 'mime' => $attachments[$i]->getClientOriginalExtension()]);
	           			}
           			}
           		},true);
   			}
			return 1;
 		}


	/**
	 * Print Ticket Details
	 * @param type $id
	 * @return type respponse
	 */
	public function ticket_print($id) {
		$tickets = Tickets::where('id', '=', $id)->first();
		$thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
		$html = view('themes.default1.agent.helpdesk.ticket.pdf', compact('id', 'tickets', 'thread'))->render();
		return PDF::load($html)->show();
	}

	/**
	 * Generates Ticket Number
	 * @param type $ticket_number
	 * @return type integer
	 */
	public function ticket_number($ticket_number) {
		$number = $ticket_number;
		$number = explode('-', $number);
		$number1 = $number[0];
		if ($number1 == 'ZZZZ') {
			$number1 = 'AAAA';
		}
		$number2 = $number[1];
		if ($number2 == '9999') {
			$number2 = '0000';
		}
		$number3 = $number[2];
		if ($number3 == '9999999') {
			$number3 = '0000000';
		}
		$number1++;
		$number2++;
		$number3++;
		$number2 = sprintf('%04s', $number2);
		$number3 = sprintf('%07s', $number3);
		$array = array($number1, $number2, $number3);
		$number = implode('-', $array);
		return $number;
	}

	/**
	 * check email for dublicate entry
	 * @param type $email
	 * @return type bool
	 */
	public function check_email($email) {
		$check = User::where('email', '=', $email)->first();
		if ($check == true) {
			return $check;
		} else {
			return false;
		}
	}

	

	/**
	 * Default helptopic
	 * @return type string
	 */
	public function default_helptopic() {
		$helptopic = "1";
		return $helptopic;
	}

	/**
	 * Default SLA plan
	 * @return type string
	 */
	public function default_sla() {
		$sla = "1";
		return $sla;
	}

	/**
	 * Default Priority
	 * @return type string
	 */
	public function default_priority() {
		$priority = "1";
		return $prioirty;
	}

	

	/**
	 * function to Ticket Close
	 * @param type $id
	 * @param type Tickets $ticket
	 * @return type string
	 */
	public function close($id, Tickets $ticket) { 
		$ticket_status = $ticket->where('id', '=', $id)->first();
		$ticket_status->status = 3;
		$ticket_status->closed = 1;
		$ticket_status->closed_at = date('Y-m-d H:i:s');
		$ticket_status->save();
		$ticket_thread = Ticket_Thread::where('ticket_id','=',$ticket_status->id)->first();
		$ticket_subject = $ticket_thread->title;
		$ticket_status_message = Ticket_Status::where('id','=',$ticket_status->status)->first();
		$thread = New Ticket_Thread;
		$thread->ticket_id = $ticket_status->id;
		$thread->user_id = Auth::user()->id;
		$thread->is_internal = 1;
		$thread->body = $ticket_status_message->message . " " . Auth::user()->firstname . " " . Auth::user()->lastname;
		$thread->save();
		$user_id = $ticket_status->user_id;
		$user = User::where('id','=',$user_id)->first();
		$email = $user->email;
		$user_name = $user->firstname;
		$ticket_number = $ticket_status->ticket_number;
		$company = "Bitregion";
		Mail::send('helpticket.emails.close_ticket', ['ticket_number' => $ticket_number, 'from'=>$company], function ($message) use ($email, $user_name, $ticket_number, $ticket_subject) {
			$message->to($email, $user_name)->subject($ticket_subject.'[#' . $ticket_number . ']');
		});

		return "your ticket" . $ticket_status->ticket_number . " has been closed";
	}

	/**
	 * function to Ticket resolved
	 * @param type $id
	 * @param type Tickets $ticket
	 * @return type string
	 */
	public function resolve($id, Tickets $ticket) {
		$ticket_status = $ticket->where('id', '=', $id)->first();
		$ticket_status->status = 2;
		$ticket_status->closed = 1;
		$ticket_status->closed_at = date('Y-m-d H:i:s');
		$ticket_status->save();
		$ticket_status_message = Ticket_Status::where('id','=',$ticket_status->status)->first();
		$thread = New Ticket_Thread;
		$thread->ticket_id = $ticket_status->id;
		$thread->user_id = Auth::user()->id;
		$thread->is_internal = 1;
		$thread->body = $ticket_status_message->message . " " . Auth::user()->first_name . " " . Auth::user()->last_name;
		$thread->save();
		return "your ticket" . $ticket_status->ticket_number . " has been resolved";
	}

	/**
	 * function to Open Ticket
	 * @param type $id
	 * @param type Tickets $ticket
	 * @return type
	 */
	public function open($id, Tickets $ticket) {
		$ticket_status = $ticket->where('id', '=', $id)->first();
		$ticket_status->status = 1;
		$ticket_status->reopened_at = date('Y-m-d H:i:s');
		$ticket_status->save();
		$ticket_status_message = Ticket_Status::where('id','=',$ticket_status->status)->first();
		$thread = New Ticket_Thread;
		$thread->ticket_id = $ticket_status->id;
		$thread->user_id = Auth::user()->id;
		$thread->is_internal = 1;
		$thread->body = $ticket_status_message->message . " " . Auth::user()->first_name . " " . Auth::user()->last_name;
		$thread->save();
		return "your ticket" . $ticket_status->ticket_number . " has been opened";
	}

	/**
	 * Function to delete ticket
	 * @param type $id
	 * @param type Tickets $ticket
	 * @return type string
	 */
	public function delete($id, Tickets $ticket) {
		$ticket_delete = $ticket->where('id', '=', $id)->first();
		if($ticket_delete->status == 5)
		{
			$ticket_delete->delete();
			$ticket_threads = Ticket_Thread::where('ticket_id','=',$id)->get();
			foreach($ticket_threads as $ticket_thread)
			{
				$ticket_thread->delete();
			}
			$ticket_attachments = Ticket_attachments::where('ticket_id','=',$id)->get();
			foreach ($ticket_attachments as $ticket_attachment) 
			{
				$ticket_attachment->delete();
			}
			return "your ticket has been delete";	
		}
		else
		{
			$ticket_delete->is_deleted = 1;
			$ticket_delete->status = 5;
			$ticket_delete->save();
			$ticket_status_message = Ticket_Status::where('id','=',$ticket_delete->status)->first();
			$thread = New Ticket_Thread;
			$thread->ticket_id = $ticket_delete->id;
			$thread->user_id = Auth::user()->id;
			$thread->is_internal = 1;
			$thread->body = $ticket_status_message->message . " " . Auth::user()->first_name . " " . Auth::user()->last_name;
			$thread->save();
			return "your ticket" . $ticket_delete->ticket_number . " has been delete";	
		}
		
	}

	/**
	 * Function to ban an email
	 * @param type $id
	 * @param type Tickets $ticket
	 * @return type string
	 */
	public function ban($id, Tickets $ticket) {
		$ticket_ban = $ticket->where('id', '=', $id)->first();
		$ban_email = $ticket_ban->user_id;
		$user = User::where('id', '=', $ban_email)->first();
		$user->ban = 1;
		$user->save();
		$Email = $user->email;
		return "the user has been banned";
	}

	/**
	 * function to assign ticket
	 * @param type $id
	 * @return type bool
	 */
	public function assign($id) {
		$UserEmail = Input::get('assign_to');
		$assign_to = explode('_', $UserEmail);
		$ticket = Tickets::where('id', '=', $id)->first();

		if($assign_to[0] == 'team') {
			$ticket->team_id = $assign_to[1];
			$team_detail = Teams::where('id','=',$assign_to[1])->first();
			$assignee = $team_detail->name;

			$ticket_number = $ticket->ticket_number;
			$ticket->save();

			$ticket_thread = Ticket_Thread::where('ticket_id','=',$id)->first();
			$ticket_subject = $ticket_thread->title;

			$thread = New Ticket_Thread;
			$thread->ticket_id = $ticket->id;
			$thread->user_id = Auth::user()->id;
			$thread->is_internal = 1;
			$thread->body = "This Ticket has been assigned to " . $assignee;
			$thread->save();

			// $master = Auth::user()->first_name . " " . Auth::user()->last_name;
			// if(Alert::first()->internal_status == 1 || Alert::first()->internal_assigned_agent == 1) {
			// 	// ticket assigned send mail
			// 	Mail::send('emails.Ticket_assign', ['agent' => $agent, 'ticket_number' => $ticket_number, 'from'=>$company, 'master' => $master, 'system' => $system], function ($message) use ($agent_email, $agent, $ticket_number, $ticket_subject) {
			// 			$message->to($agent_email, $agent)->subject($ticket_subject.'[#' . $ticket_number . ']');
			// 		});
			// }

		} elseif ($assign_to[0] == 'user') {
			$ticket->assigned_to = $assign_to[1];
			$user_detail = User::where('id','=',$assign_to[1])->first();
			$assignee = $user_detail->first_name . ' ' . $user_detail->last_name;

			$company = $this->company();
			$system = $this->system();
			
			$ticket_number = $ticket->ticket_number;
			$ticket->save();

			$ticket_thread = Ticket_Thread::where('ticket_id','=',$id)->first();
			$ticket_subject = $ticket_thread->title;

			$thread = New Ticket_Thread;
			$thread->ticket_id = $ticket->id;
			$thread->user_id = Auth::user()->id;
			$thread->is_internal = 1;
			$thread->body = "This Ticket has been assigned to " . $assignee;
			$thread->save();

			$agent = $user_detail->first_name;
			$agent_email = $user_detail->email;
			
			$master = Auth::user()->first_name . " " . Auth::user()->last_name;
			// if(Alert::first()->internal_status == 1 || Alert::first()->internal_assigned_agent == 1) {
				// ticket assigned send mail
				Mail::send('emails.Ticket_assign', ['agent' => $agent, 'ticket_number' => $ticket_number, 'from'=>$company, 'master' => $master, 'system' => $system], function ($message) use ($agent_email, $agent, $ticket_number, $ticket_subject) {
						$message->to($agent_email, $agent)->subject($ticket_subject.'[#' . $ticket_number . ']');
					});
			// }

		}
			
		return 1;
	}

	

	/**
	 * Search
	 * @param type $keyword 
	 * @return type array
	 */
	public function search($keyword) {    
    	if(isset($keyword)) {
      		$data = array('ticket_number' => Tickets::search($keyword));     
	      	return $data;
   		} else {
    	return "no results";
    	}
 	}


   	
   	/**
   	 * select_all
   	 * @return type
   	 */
   	public function select_all() {

   		if(Input::has('select_all'))
   		{
	   		$selectall = Input::get('select_all');
	   		// dd($selectall);
	   		$value = Input::get('submit');
	   		// dd($value);
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
 	 * lock
 	 * @param type $id 
 	 * @return type null
 	 */
 	public function lock($id){
 		$ticket = Tickets::where('id','=',$id)->first();
 		$ticket->lock_by = Auth::user()->id;
 		$ticket->lock_at = date('Y-m-d H:i:s');
 		$ticket->save();
	}

	

	
}
