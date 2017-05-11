<?php namespace App\Http\Controllers\Member\helpdesk\Leader;
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
use App\Model\helpdesk\Ticket\Ticket_Surrender;
use App\Model\helpdesk\Agent\Department;


use App\Model\helpdesk\Manage\Help_topic;
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
		
		//$this->middleware('auth');
		$this->middleware('roles');
	}

	
	/**
	 * Show the Myticket list page
	 * @return type response
	 */
	public function myticket_ticket_list($TicketStatus,User $user, Tickets $ticket) {
		
		
		switch ($TicketStatus)
		{
			case 'Open':
				$status = [1];
				break;
			case 'Closed':
				$status = [2,3];
				break;
		}
		
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		//$tickets = Tickets::where('status', '=', 1)->where('assigned_to', '=', Auth::user()->id)->get();
		$tickets = $ticket->getAssignedTickets(['assigned_to'=>$user_id,'status'=>$status])->paginate(20);
		$ticketsArr = array();
		foreach ($tickets as $open)
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
			$ticketsArr[] = ( object ) array('id'=>$open->id,'title'=>$open->title,'tktTitle'=>str_limit($string,40),'count'=>$totalThread,
					'ticket_number'=>$open->ticket_number,'tktstatus'=>$open->tktstatus,'last_updated_at'=>$TicketDatarow->updated_at,
					'priority'=>$open->priority,'priority_color'=>$open->priority_color,'rep'=>$rep,'lastreplier'=>$username,
			'from'=>$open->firstname);
		}
		
		return view('helpticket.ticket.leader.myticket')
		->with('open',$ticketsArr)
		->with('tktStatus',$TicketStatus)
		->with('renderOpenList',$tickets);
	}


	
	

	

	/**
	 * Shows the ticket thread details
	 * @param type $id
	 * @return type response
	 */
	public function thread($id) {
		$id = \Crypt::decrypt($id);
		
		$lock = Tickets::where('id','=',$id)->first();
		if($lock->lock_by == Auth::user()->id || $lock->lock_at < date('Y-m-d H:i:s', strtotime('-3 minutes', strtotime($lock->lock_at)))) {
			$tickets = Tickets::where('id', '=', $id)->where('assigned_to','=', Auth::user()->id)->first();
		
			$thread = Ticket_Thread::where('ticket_id','=',$tickets->id)->first();
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
						/*
						if($attachment->type == 'jpg'||$attachment->type == 'JPG'||$attachment->type == 'jpeg'||$attachment->type == 'JPEG'||$attachment->type == 'png'||$attachment->type == 'PNG'||$attachment->type == 'gif'||$attachment->type == 'GIF')
						{
							$image = @imagecreatefromstring($attachment->file);
							ob_start();
							imagejpeg($image, null, 80);
							$data = ob_get_contents();
							ob_end_clean();
							$fileType = 'Image';
							$imageSource = base64_encode($data);
							
						} else{
							$imageSource = '';
							
						}*/
						
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
			return view('helpticket.ticket.leader.timeline',compact('id'))
			->with('tickets',$tickets)
			->with('thread',$thread)
			->with('priority',$priority)
			->with('sla',$sla)
			->with('SlaPlan',$SlaPlan)
			->with('Creator',User::find($tickets->user_id))
			->with('$response',$response)
			->with('ResponseDate',$ResponseDate)
			->with('conversations',$conversationsArr)
			->with('last',$last)
			->with('status',Ticket_Status::where('id','=',$tickets->status)->first())
			->with('help_topic',$help_topic)
			->with('department',Department::where('id', '=', $help_topic->department)->first());
			
			//$thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
			//return view('themes.default1.agent.helpdesk.ticket.timeline', compact('tickets'), compact('thread'));
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
	  	$eventthread = $thread->where('ticket_id',$request->input('ticket_ID'))->first();
	  	$eventuserid = $eventthread->user_id;
	  	$emailadd = User::where('id',$eventuserid)->first()->email;
	  	$source = $eventthread->source;
	  	$form_data = $request->except('ReplyContent','ticket_ID','attachment');
      
	  	$reply_content = $request->input('ReplyContent');
	  	$thread->ticket_id = $request->input('ticket_ID');
	  	$thread->poster = 'support';
	  	$thread->body = $request->input('ReplyContent');
	  	$thread->note = $request->input('note');
	  	$thread->user_id = Auth::user()->id;
	  	$ticket_id = $request->input('ticket_ID');
	  	//dd($ticket_id);
	  	$tickets = Tickets::where('id', '=', $ticket_id)->first();
		$tickets->isanswered = '1';
		$result = $tickets->save();
		
		if($request->input('replier'))
			$thread->replier = $request->input('replier');
		
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
	  	$i=0;
	  	$fileDetail = array();
	   	foreach ($attachments as $attachment) {
	   		
	    	if($attachment != null){
	    		
	    		$name = $attachment->getClientOriginalName();
	    		$type = $attachment->getClientOriginalExtension();
	    		$size = $attachment->getSize();
	    		$data = file_get_contents($attachment->getRealPath());
	    		$attachPath=$attachment->getRealPath();
	    		
	    		$filename = 'Br-Ticket'.$thread->id."-".str_random(5) . '.' . $attachment->getClientOriginalExtension();
	    		$destinationPath = 'helpdesk/attachments/';
	    		$attachment->move($destinationPath, $filename);
	    		
	    		$file_path = $destinationPath.''.$filename;
	    		//$attachmentID = $ta->create(['thread_id' => $thread->id,'name'=>$name,'size'=>$size,'type'=>$type,'file'=>$data,'file_path'=>$file_path,'poster'=>'ATTACHMENT']);
	    		 
	    		$attachmentID = $ta->create(['thread_id' => $thread->id,'name'=>$filename,'size'=>$size,'type'=>$type,'file_path'=>$file_path,'poster'=>'ATTACHMENT']);
	    		$check_attachment = 1;
	    		
	    		$fileDetail[] = $attachmentID;
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
	  	$company = Config::get('helpdesk.site_name');
	  	$username  =  $ticket_user->user_name;
  		if(!empty(Auth::user()->alias)) {
		    $agentsign = Auth::user()->alias; 
  		}
  		else{
   			$agentsign = null;  
  		}
  		$result=1;
  		/*
		   	$result = Mail::send(array('html'=>'helpticket.emails.ticket_re-reply'), ['content' => $reply_content, 'ticket_number' => $ticket_number, 'From' => $company, 'name'=>$username, 'Agent_Signature' => $agentsign], function ($message) use ($email, $user_name, $ticket_number, $ticket_subject, $attachments, $check_attachment,$fileDetail) {
    		$message->to($email, $user_name)->subject($ticket_subject . '[#' . $ticket_number . ']');
    		
    		if($check_attachment == 1){
    			
	    		$size = sizeOf($attachments);
	    		for($i=0;$i<$size;$i++){
	    		$message->attach($fileDetail[$i]->file_path, ['as' => $fileDetail[$i]->name, 'mime' => $fileDetail[$i]->type]);
	           	//$message->attach($attachments[$i]->getRealPath, ['as' => $attachments[$i]->getClientOriginalName(), 'mime' => $attachments[$i]->getClientOriginalExtension()]);
	           	}
           	}
           	},true); */
			if($result)
			$response = ['response' => 1,'message'=>'Success! You have successfully replied to your ticket'];
			else
				$response = ['response' => 0,'message'=>'Fail! For some reason your reply was not posted. Please try again later'];
			return Response::json ( $response );
 		}

	/**
	 * Ticket edit and save ticket data
	 * @param type $ticket_id
	 * @param type Ticket_Thread $thread
	 * @return type bool
	 */
	public function ticket_edit_post($ticket_id, Ticket_Thread $thread, Tickets $ticket) {

		if (Input::get('subject') == null) {
			return 1;
		}
		elseif (Input::get('sla_paln') == null) {
			return 2;	
		}
		elseif (Input::get('help_topic') == null) {
			return 3;
		}
		elseif (Input::get('ticket_source') == null) {
			return 4;
		}
		elseif (Input::get('ticket_priority') == null) {
			return 5;
		}
		else {
			$ticket = $ticket->where('id', '=', $ticket_id)->first();		
			$ticket->sla = Input::get("sla_paln");
			$ticket->help_topic_id = Input::get("help_topic");
			$ticket->source = Input::get("ticket_source");
			$ticket->priority_id = Input::get("ticket_priority");
			$ticket->save();

			$threads = $thread->where('ticket_id', '=', $ticket_id)->first();		
			$threads->title = Input::get("subject");
			$threads->save();
			return 0;
		}
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
		$thread->body = $ticket_status_message->message . " " . Auth::user()->first_name . " " . Auth::user()->last_name;
		$thread->save();
		
		$user_id = $ticket_status->user_id;
		$user = User::where('id','=',$user_id)->first();
		$email = $user->email;
		$user_name = $user->user_name;
		$ticket_number = $ticket_status->ticket_number;

		$company = $this->company();

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
	 * Function to post internal note
	 * @param type $id
	 * @return type bool
	 */
	public function InternalNote($id) {
		$InternalContent = Input::get('InternalContent');
		$thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
		$NewThread = new Ticket_Thread;
		$NewThread->ticket_id = $thread->ticket_id;
		$NewThread->user_id = Auth::user()->id;
		// $NewThread->thread_type = 'M';
		$NewThread->is_internal = 1;
		$NewThread->poster = Auth::user()->role;
		$NewThread->title = $thread->title;
		$NewThread->body = $InternalContent;
		$NewThread->save();
		return 1;
	}

	/**
	 * Function to surrender a ticket
	 * @param type $id
	 * @return type bool
	 */
	public function surrender($id) {
		$ticket = Tickets::where('id', '=', $id)->first();
		 if($ticket->assigned_to == Auth::user()->id)
		 {
		 	$thread = Ticket_Thread::where('ticket_id','=',$ticket->id)->first();
		 	$User = Auth::user();
			$InternalContent = Auth::user()->first_name." ".Auth::user()->last_name . " has Surrendered the assigned Ticket";
			$thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
			$NewThread = new Ticket_Thread;
			$NewThread->ticket_id = $thread->ticket_id;
			$NewThread->user_id = Auth::user()->id;
			$NewThread->is_internal = 1;
			$NewThread->poster = Auth::user()->alias;
			$NewThread->title = $thread->title;
			$NewThread->body = $InternalContent;
			$NewThread->save();
			
			$TktSurrender = new Ticket_Surrender();
			$TktSurrender->ticket_id = $thread->ticket_id;
			$TktSurrender->user_id = Auth::user()->id;
			$TktSurrender->save();
			
			$ticket->assigned_to = null;
			$ticket->save();
			$response = ['response' => 1,'message'=>'Success! You have Unassigned your ticket'];
			$admins = User::where('user_type','=',1)->get();
			$updated_subject = 'Surrender : '.$thread->title . '[#' . $ticket->ticket_number . ']';
			foreach($admins as $admin)
			{
				$admin_email = $admin->email;
				$admin_user = $admin->firstname;
				Mail::send('helpticket.emails.Ticket_Surrender', ['Leader' => $User->firstname.' '.$User->lastname.' ('.$User->country_code.')','content'=>$thread->body,
				'ticket_number' => $ticket->ticket_number, 'from'=>'System'
				],
				function ($message) use ($admin_email, $admin_user, $updated_subject) {
					$message->to($admin_email, $admin_user)->subject($updated_subject);
				});
			}
			
	    }else 
	    		$response = ['response' => 0,'message'=>'Fail! For some reason your request failed.'];
	    	
	    return Response::json ( $response );
		
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
	 * Search
	 * @param type $keyword 
	 * @return type array
	 */
 	public function stores($ticket_number) 
  	{    
    	$this->layout->header = $ticket_number;
    	$content = View::make('themes.default1.admin.tickets.ticketsearch', with(new Tickets()))
    		->with('header', $this->layout->header)
    		->with('ticket_number', \App\Model\Tickets::stores($ticket_number));    	
    	if (Request::header('X-PJAX')) {
    		return $content;
    	} else { 
      		$this->layout->content = $content; 
    	} 
  	}

	

	



	/**
	 * shows unassigned tickets
	 * @return type
	 */
	public function unassigned() {
		
	}

	public function get_unassigned() {
		
	}

	/**
	 * shows tickets assigned to Auth::user()
	 * @return type
	 */
	public function myticket() {
		return view('themes.default1.agent.helpdesk.ticket.myticket');
	}


	/**
	 * cleanMe
	 * @param type $input 
	 * @return type
	 */
	public function cleanMe($input) {
		$input = mysqli_real_escape_string($input);
		$input = htmlspecialchars($input, ENT_IGNORE, 'utf-8');
		$input = strip_tags($input);
		$input = stripslashes($input);
		return $input;
	}

	/** 
	 * autosearch
	 * @param type Image $image 
	 * @return type json
	 */
   	public function autosearch($id)
   	{
   		$term = \Input::get('term');
   		$user = \App\User::where('email', 'LIKE', '%'.$term.'%')->lists('email');
   		echo json_encode($user);
   	}

   	/** 
	 * autosearch2
	 * @param type Image $image 
	 * @return type json
	 */
   	public function autosearch2(User $user)
   	{
   	$user = $user->lists('email');
   	echo json_encode($user);
   	}

	/** 
	 * autosearch
	 * @param type Image $image 
	 * @return type json
	 */
   	public function usersearch()
   	{
   		$email = Input::get('search');	
   		$ticket_id = Input::get('ticket_id');	
   		$data = User::where('email','=',$email)->first();

		$ticket_collaborator = Ticket_Collaborator::where('ticket_id','=',$ticket_id)->where('user_id','=',$data->id)->first();   		
		if(!isset($ticket_collaborator))
   		{
	   		$ticket_collaborator = new Ticket_Collaborator;
	   		$ticket_collaborator->isactive = 1;
	   		$ticket_collaborator->ticket_id = $ticket_id;
	   		$ticket_collaborator->user_id = $data->id;
	   		$ticket_collaborator->role = 'ccc';
	   		$ticket_collaborator->save();
	   		return  '<div id="alert11" class="alert alert-dismissable" style="color:#60B23C;background-color:#F2F2F2;"><button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Success!</h4><h4><i class="icon fa fa-user"></i>'.$data->user_name.'</h4><div id="message-success1">'.$data->email.'</div></div>';
	   	} else {
	   		return  '<div id="alert11" class="alert alert-warning alert-dismissable"><button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i>'.$data->user_name.'</h4><div id="message-success1">'.$data->email.'<br/>This user already Collaborated</div></div>';
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
   	 * user time zone
   	 * @param type $utc 
   	 * @return type date
   	 */
	public static function usertimezone($utc) {
		$set = System::whereId('1')->first();
		$timezone = Timezones::whereId($set->time_zone)->first();
		$tz = $timezone->name;
		$format = $set->date_time_format;
		date_default_timezone_set($tz);
		$offset = date('Z', strtotime($utc));
		$format = Date_time_format::whereId($format)->first()->format;
		$date = date($format, strtotime($utc) + $offset);
		return $date;
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
