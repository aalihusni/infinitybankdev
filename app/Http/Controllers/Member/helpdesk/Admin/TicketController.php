<?php
namespace App\Http\Controllers\Member\helpdesk\Admin;
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
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Manage\Sla_plan;
use App\Model\helpdesk\Manage\Leaders;
use App\User;
use DB;
use App\Classes\UserClass;
use Illuminate\Http\Request;

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
use App\Model\helpdesk\Ticket\Ticket_Surrender;
use App\Model\helpdesk\Ticket\TicketManager;
use App\Model\helpdesk\Ticket\TicketHelpTopicManager;
/**
 * TicketController
 *
 * @package Controllers
 * @subpackage Controller
 * @author Cara <kamal@cara.com.my>
 */
class TicketController extends Controller {
	
	/**
	 * Create a new controller instance.
	 * 
	 * @return type response
	 */
	public function __construct() {
		// SettingsController::smtp();
		$this->middleware ( 'admin', [ 
				'except' => 'quick_login'
		] );
	}
	
	/**
	 * Show the Myticket list page
	 * 
	 * @return type response
	 */
	public function getAll($TicketStatus, User $user, Tickets $ticket,Help_topic $topic,Request $request,TicketManager $tktManager,TicketHelpTopicManager $topicManager) {
		
		//Tickets::cronJob();
		$manager = '';
		
		/*
		if ($request->session()->has('TKT_MANAGER')) {
    		$manager = $request->session()->get('TKT_MANAGER');
		}*/
		$defaultQuery = 1;
		if ($request->cookie('TKT_MANAGER')) {
			$manager = $request->cookie('TKT_MANAGER');
			$defaultQuery = 2;
		}
			
		
		$condition = array ();
		switch ($TicketStatus) {
			case 'Open' :
				$condition ['status'] = [ 
						1 
				];
				break;
			case 'Closed' :
				$condition ['status'] = [ 
						2,3
				];
				break;
			case 'Unassigned' :
				//$condition ['Unassigned'] = 'NULL';
				$allTopicIDs = array();
				foreach ($topic->get() as $t)
					$allTopicIDs[] = $t->id;
					$assignedTopicIDs = array();
					foreach ($topicManager->groupBy('topic_id')->get() as $tm)
						$assignedTopicIDs[] = $tm->topic_id;
						$unassignedTopics = array_diff($allTopicIDs, $assignedTopicIDs);
						$condition ['filter_unassigned'] = $unassignedTopics;
				$defaultQuery = 1;
				$condition ['status'] = [
						1
				];
				break;
			case 'Trashed' :
				$condition ['status'] = [ 
						5 
				];
				break;
			case 'Surrendered' :
				return $this->getSurrender();
			break;
				
				
		}
		if($defaultQuery == 2)
		{
			$condition ['manager_code'] = $manager;
			$tickets = $ticket->getAllByManager ( $condition )->paginate ( 30 );
		}
		else $tickets = $ticket->getAll ( $condition )->paginate ( 30 );
		
		$ticketsArr = array ();
		foreach ( $tickets as $open ) {
			$string = strip_tags ( $open->title );
			$TicketDatarow = Ticket_Thread::where ( 'ticket_id', '=', $open->id )->orderBy ( 'id', 'desc' )->first ();
			$LastResponse = User::where ( 'id', '=', $TicketDatarow->user_id )->first ();
			$lastReplierFromAdmin = $TicketDatarow->replier;
			if ($LastResponse->user_type == "2") {
				$rep = "#F39C12";
				$username = $LastResponse->firstname;
				$tID = $open->id ;
				$lastReplierFromAdmin = Ticket_Thread::where (function($sql)use($open){
					$sql->where('ticket_id',$open->id);
					$sql->where('user_id','<>',$open->user_id);
				})->orderBY('id','desc')->pluck ('replier');
				
			} else {
				$rep = "#000";
				$username = $LastResponse->firstname . " " . $LastResponse->lastname;
				if ($LastResponse->firstname == null || $LastResponse->lastname == null) {
					$username = $LastResponse->firstname;
				}
			}
			$totalThread = Ticket_Thread::where ( [ 
					'ticket_id' => $open->id 
			] )->count ();
			
			$assignMgrCode = '';
			if($open->assigned_to_manager_id)
			{
				$assignMgrCode = TicketManager::whereId($open->assigned_to_manager_id)->pluck('manager_code');
			}
			$ticketsArr [] = ( object ) array (
					'id' => $open->id,
					'title' => $open->title,
					'tktTitle' => str_limit ( $string, 40 ),
					'count' => $totalThread,
					'ticket_number' => $open->ticket_number,
					'tktstatus' => $open->tktstatus,
					'last_updated_at' => $TicketDatarow->updated_at,
					'priority' => $open->priority,
					'priority_color' => $open->priority_color,
					'rep' => $rep,
					'lastreplier' => $username,
					//'assignTo' => $open->assignFname . ' ' . $open->assignLname,
					//'assigned_to' => $open->assigned_to,
					'assignTo' => $assignMgrCode,
					'assigned_to' => $open->assigned_to_manager_id,
					'country_code' => $open->country_code,
					'from' => $open->firstname,
					'replier' => $lastReplierFromAdmin,
					'topic' => $open->topic,
					'system_status' => $open->system_status,
					'css_class'=>$open->css_class
			);
		}
		
		return view ( 'helpticket.admin.ticket.all' )->with ( 'open', $ticketsArr )->with ( 'tktStatus', $TicketStatus )->with ( 'ticket', $ticket )->with ( 'renderOpenList', $tickets )
		//->with('helptopic',$topic->whereStatus(1)->get())
		->with('helptopic',$topic->OrderBy('ordering','asc')->get())
		->with('manager',$manager)
		->with('firstDrop','')
		->with('secondDrop','')
		->with('managers',$tktManager->get());
	}
	
	public function getTicketByCatogryOrAssigned(Request $request,Tickets $ticket,Help_topic $topic,TicketHelpTopicManager $topicManager,TicketManager $tktManager)
	{
		$TicketStatus = $request->tktStatus;
		$firstOptVal = $request->optionValue;
		$secondDrop = $request->secondDrop;
		
		$condition = array ();
		switch ($TicketStatus) {
			case 'Open' :
				$condition ['status'] = [
				1
				];
				break;
			case 'Closed' :
				$condition ['status'] = [2,3];
				break;
			case 'Unassigned' :
				$condition ['Unassigned'] = 'NULL';
				break;
			case 'Trashed' :
				$condition ['status'] = [5];
				break;
			case 'Surrendered' :
				return $this->getSurrender();
				break;
		}
		
		
		if ($request->cookie('TKT_MANAGER')) {
			$MgrSessionCode = $request->cookie('TKT_MANAGER');
			$managerDetail = TicketManager::where(['manager_code'=>$MgrSessionCode])->first();
			$assigned_to_manager_id = $managerDetail->id;
		}else{
			$MgrSessionCode = '';
			$assigned_to_manager_id = 111111111;
		}
		
		switch ($firstOptVal) {
			case 'AssignedTo' :
				$condition ['assigned_to_manager_id'] = $assigned_to_manager_id;
				break;
			case 'BLANK':
				
				break;
			default :
				#### FOR SPECIFIC CATEGORY #####
				$AssignedTopics = $topicManager->where(['assign_to'=>$MgrSessionCode,'topic_id'=>$firstOptVal])->count();
				$hasIndAssigned = 0;
				if(!$AssignedTopics)
				{
					$firstOptVal = 0; #### MANAGER NOT ALLOW SEE THE TICKET OF OTHERS  #####
					$hasIndAssigned = Tickets::where(['assigned_to_manager_id'=>$assigned_to_manager_id,'help_topic_id'=>$request->optionValue])->count();
					#### MANAGER CAN SEE THE TICKET OF SELECTED CATEGORY IF IND ASSIGN TO SELECTED CATEGORY #####
				}
				
				if($secondDrop == 'All')
					$firstOptVal = $request->optionValue; #### MANAGER CAN SEE THE TICKET OF SELECTED CATEGORY #####
				
				$condition['help_topic_id'] = $firstOptVal;
				
				if($hasIndAssigned)
					$condition['help_topic_id_plus_ind_assigned'] = $assigned_to_manager_id;
					
				
			break;
		}
		
		switch ($secondDrop) {
			case 'All' :
				
				break;
			case 'Unassigned':
				if(!in_array($firstOptVal,['AssignedTo'])){
					
					$allTopicIDs = array();
					foreach ($topic->get() as $t)
						$allTopicIDs[] = $t->id;
						$assignedTopicIDs = array();
					foreach ($topicManager->groupBy('topic_id')->get() as $tm)
						$assignedTopicIDs[] = $tm->topic_id;
					$unassignedTopics = array_diff($allTopicIDs, $assignedTopicIDs);
					$condition ['filter_unassigned'] = $unassignedTopics;
					
				}
				break;
			default :
				//$condition ['manager_code'] = $secondDrop; 
				if($firstOptVal == 'AssignedTo' && !in_array($secondDrop,['All','Unassigned']))
				{
					
				}else{
					$condition ['manager_code'] = $MgrSessionCode; ### All Ticket Assigned to Cookies MGR CODE
				}
				
				if($firstOptVal=='BLANK')
				{
					$condition ['FILTER_ALL_PLUS_INDIV_ASSIGN'] = $assigned_to_manager_id; ### LIST ALL TICKET OF ASSIGNED CATEGORY + INDIVIDUAL ASSIGN TICKET FROM OTHER MANAGER #####
				}
				
			break;
		}
		
		$tickets = $ticket->getAllByManager ( $condition )->paginate ( 30 );
		
		$tickets->appends ( array ('optionValue'=>$firstOptVal,'secondDrop'=>$secondDrop,'tktStatus'=>$TicketStatus ) );
		
		$ticketsArr = array ();
		foreach ( $tickets as $open ) {
			$string = strip_tags ( $open->title );
			$TicketDatarow = Ticket_Thread::where ( 'ticket_id', '=', $open->id )->orderBy ( 'id', 'desc' )->first ();
			$LastResponse = User::where ( 'id', '=', $TicketDatarow->user_id )->first ();
			$lastReplierFromAdmin = $TicketDatarow->replier;
			if ($LastResponse->user_type == "2") {
				$rep = "#F39C12";
				$username = $LastResponse->firstname;
				$tID = $open->id ;
				$lastReplierFromAdmin = Ticket_Thread::where (function($sql)use($open){
					$sql->where('ticket_id',$open->id);
					$sql->where('user_id','<>',$open->user_id);
				})->orderBY('id','desc')->pluck ('replier');
		
			} else {
				$rep = "#000";
				$username = $LastResponse->firstname . " " . $LastResponse->lastname;
				if ($LastResponse->firstname == null || $LastResponse->lastname == null) {
					$username = $LastResponse->firstname;
				}
			}
			$totalThread = Ticket_Thread::where ( [
					'ticket_id' => $open->id
			] )->count ();
			
			$assignMgrCode = '';
			if($open->assigned_to_manager_id)
			{
				$assignMgrCode = TicketManager::whereId($open->assigned_to_manager_id)->pluck('manager_code');
			}
			
			$ticketsArr [] = ( object ) array (
					'id' => $open->id,
					'title' => $open->title,
					'tktTitle' => str_limit ( $string, 40 ),
					'count' => $totalThread,
					'ticket_number' => $open->ticket_number,
					'tktstatus' => $open->tktstatus,
					'last_updated_at' => $TicketDatarow->updated_at,
					'priority' => $open->priority,
					'priority_color' => $open->priority_color,
					'rep' => $rep,
					'lastreplier' => $username,
					//'assignTo' => $open->assignFname . ' ' . $open->assignLname,
					'assignTo' => $assignMgrCode,
					'assigned_to' => $open->assigned_to_manager_id,
					'country_code' => $open->country_code,
					'from' => $open->firstname,
					'replier' => $lastReplierFromAdmin,
					'topic' => $open->topic,
					'system_status' => $open->system_status,
					'css_class'=>$open->css_class
			);
		}
		
		if (!in_array($secondDrop, ['Unassigned','All'])) {
			$secondDrop = '';
		}
		
		return view ( 'helpticket.admin.ticket.all' )->with ( 'open', $ticketsArr )->with ( 'tktStatus', $TicketStatus )->with ( 'ticket', $ticket )->with ( 'renderOpenList', $tickets )
		//->with('helptopic',$topic->whereStatus(1)->get())
		->with('helptopic',$topic->get())
		->with('manager',$MgrSessionCode)
		->with('firstDrop',$request->optionValue)
		->with('secondDrop',$secondDrop)
		->with('managers',$tktManager->get());
		
		
	}
	
	
	public function updateUserTicketTopic(Request $request)
	{
		$ticketID = $request->updateTicketID;
		$topicID = $request->topicID;
		DB::table('tkt_tickets')
            ->where('id', $ticketID)
            ->update(['help_topic_id' => $topicID]);
		
		return Response::json ( ['ticketID'=>$ticketID,'topic'=>Help_topic::whereId($topicID)->pluck('topic')]);
	}
	
	public function changeManager(Request $request)
	{
		$manager = $request->manager;
		if (in_array($manager, ['Unassigned','All'])) {
		   return Response::json ( ['data'=>1,'optionValue'=>$manager]);
		}
		//$request->session()->put('TKT_MANAGER', ''.$manager.'');
		
		$response = new \Illuminate\Http\Response();
		//return $response->withCookie(cookie('TKT_MANAGER', ''.$manager.'', 60));
		return response(['data'=>1,'optionValue'=>$manager])->withCookie(cookie('TKT_MANAGER',  ''.$manager.'', 60000));
		
		//return Response::json ( ['data'=>1]);
	}
	
	/**
	 * Show the Myticket list page
	 *
	 * @return type response
	 */
	private function getSurrender() {
		$ticket = new Tickets;
		$condition = array ();
		//$condition ['surrender_cur_status'] = '0';
		$condition ['Unassigned'] = 'NULL';
		$TicketStatus = 'Surrendered';
		$tickets = $ticket->getSurrender ( $condition )->paginate ( 30 );
		$ticketsArr = array ();
		foreach ( $tickets as $open ) {
			$string = strip_tags ( $open->title );
			$TicketDatarow = Ticket_Thread::where ( 'ticket_id', '=', $open->id )->orderBy ( 'id', 'desc' )->first ();
			$LastResponse = User::where ( 'id', '=', $TicketDatarow->user_id )->first ();
			if ($LastResponse->user_type == "2") {
				$rep = "#F39C12";
				$username = $LastResponse->firstname;
			} else {
				$rep = "#000";
				$username = $LastResponse->firstname . " " . $LastResponse->lastname;
				if ($LastResponse->firstname == null || $LastResponse->lastname == null) {
					$username = $LastResponse->firstname;
				}
			}
			$totalThread = Ticket_Thread::where ( [
					'ticket_id' => $open->id
					] )->count ();
			$ticketsArr [] = ( object ) array (
					'id' => $open->id,
					'title' => $open->title,
					'tktTitle' => str_limit ( $string, 40 ),
					'count' => $totalThread,
					'ticket_number' => $open->ticket_number,
					'tktstatus' => $open->tktstatus,
					'last_updated_at' => $TicketDatarow->updated_at,
					'priority' => $open->priority,
					'priority_color' => $open->priority_color,
					'rep' => $rep,
					'lastreplier' => $username,
					'surrenderedBy' => $open->assignFname . ' ' . $open->assignLname,
					'assigned_to' => $open->assigned_to,
					'country_code' => $open->country_code,
					'from' => $open->firstname
			);
		}
	
		return view ( 'helpticket.admin.ticket.surrender' )->with ( 'open', $ticketsArr )->with ( 'tktStatus', $TicketStatus )->with ( 'ticket', $ticket )->with ( 'renderOpenList', $tickets );
	}
	
	/**
	 * Shows the ticket thread details
	 * 
	 * @param type $id        	
	 * @return type response
	 */
	public function Detail(Request $request,$id,Leaders $Leader,Tickets $tktObj,Help_topic $topic,TicketManager $tktManager) {
		$id = \Crypt::decrypt ( $id );
		
		$tickets = Tickets::where ( 'id', '=', $id )->first ();
		
		### PREVIOUS TICKET ###
		$previousTickets = $tktObj->getMyTickets(['user_id'=>$tickets->user_id,'status'=>[1,2,3]])->paginate(100);
		$prevTktArr = array();
		foreach ($previousTickets as $prevTkt)
		{
			if($prevTkt->id == $tickets->id)
				continue;
			$string = strip_tags($prevTkt->title);
			$TicketDatarow = Ticket_Thread ::where('ticket_id', '=', $prevTkt->id)->orderBy('id', 'desc')->first();
			$LastResponse = User::where('id', '=', $TicketDatarow->user_id)->first();
			if($LastResponse->user_type == "2") {
				$rep = "#F39C12";
				$username = $LastResponse->firstname;
			} else {
				$rep = "#000"; $username = $LastResponse->firstname ." ". $LastResponse->lastname. ' ('.$TicketDatarow->replier.')';
			}
			$totalThread = Ticket_Thread::where(['ticket_id'=>$prevTkt->id])->count();
			$prevTktArr[] = ( object ) array('id'=>$prevTkt->id,'title'=>$prevTkt->title,'tktTitle'=>str_limit($string,40),'count'=>$totalThread,'created_at'=>$prevTkt->created_at,
					'ticket_number'=>$prevTkt->ticket_number,'tktstatus'=>$prevTkt->tktstatus,'last_updated_at'=>$TicketDatarow->updated_at,'status'=>$prevTkt->status,
					'priority'=>$prevTkt->priority,'rep'=>$rep,'lastreplier'=>$username);
		}
		
		### PREVIOUS TICKETS ###
		
		
		
		$thread = Ticket_Thread::where ( 'ticket_id', '=', $tickets->id )->first ();
		$priority = Ticket_Priority::where ( 'id', '=', $tickets->priority_id )->first ();
		$sla = $tickets->sla;
		$SlaPlan = Sla_plan::where ( 'id', '=', 1 )->first ();
		$response = Ticket_Thread::where ( 'ticket_id', '=', $tickets->id )->where ( 'is_internal', '=', 0 )->get ();
		foreach ( $response as $last ) {
			$ResponseDate = $last->created_at;
		}
		$help_topic = Help_topic::where ( 'id', '=', $tickets->help_topic_id )->first ();
		$conversations = $tickets->Threads ()->where ( 'is_internal', '=', 0 )->paginate ( 10 );
		$conversationsArr = array ();
		foreach ( $conversations as $conv ) {
			// ## ATTACHMENT ####
			$attachments = Ticket_attachments::where ( 'thread_id', '=', $conv->id )->get ();
			$attachmentData = array ();
			foreach ( $attachments as $attachment ) {
				
				$size = $attachment->size;
				$units = Config::get('helpdesk.units');
				$power = $size > 0 ? floor ( log ( $size, 1024 ) ) : 0;
				$value = number_format ( $size / pow ( 1024, $power ), 2, '.', ',' ) . ' ' . $units [$power];
				if ($attachment->poster == 'ATTACHMENT') {
					$fileType = '';
					$varfileDetail = '';
					$attType = strtoupper ( $attachment->type );
					/*
					if ($attachment->type == 'jpg' || $attachment->type == 'JPG' || $attachment->type == 'jpeg' || $attachment->type == 'JPEG' || $attachment->type == 'png' || $attachment->type == 'PNG' || $attachment->type == 'gif' || $attachment->type == 'GIF') {
						$image = @imagecreatefromstring ( $attachment->file );
						ob_start ();
						imagejpeg ( $image, null, 80 );
						$data = ob_get_contents ();
						ob_end_clean ();
						$fileType = 'Image';
						$imageSource = base64_encode ( $data );
					} else {
						$imageSource = '';
					}*/
					$fileType = 'Image';
					$imageSource = '';
					$attachmentData [] = ( object ) array (
							'fileDetail' => $varfileDetail,
							'filename' => $attachment->name,
							'file_path' => $attachment->file_path,
							'filesize' => $value,
							'poster' => $attachment->poster,
							'image_id' => $attachment->id,
							'fileType' => $fileType,
							'attachmentType' => $attType,
							'imageSource' => $imageSource 
					)
					;
				}
			}
			// ## ATTACHMENT ####
			
			$body = $conv->body;
			$conversationsArr [] = ( object ) array (
					'name' => $conv->firstname . ' ' . $conv->lastname,
					'body' => $body,
					'note' => $conv->note,
					'id' => $conv->id,
					'created_at' => $conv->created_at,
					'profile_pic' => $conv->profile_pic,
					'attachments' => $attachmentData ,
					'replier' => $conv->replier
			);
		}
		
		$TicketCreator = User::find($tickets->user_id);
		//$availableLeaders = $Leader->getLeadersToAssign(['country_code'=>$TicketCreator->country_code])->get();
		$loggedInMgrCode = 'F';
		if ($request->cookie('TKT_MANAGER')) {
			$loggedInMgrCode = $request->cookie('TKT_MANAGER');
		}
		
		
		return view ( 'helpticket.admin.ticket.detail', compact ( 'id' ) )
		->with ( 'tickets', $tickets )->with ( 'thread', $thread )
		//->with ( 'leaders', $availableLeaders )
		->with ( 'assignToDetail', User::where('id',$tickets->assigned_to)->select('firstname', 'lastname','email')->first())
		->with ( 'priority', $priority )->with ( 'sla', $sla )
		->with ( 'SlaPlan', $SlaPlan )->with ( 'Creator', User::find ( $tickets->user_id ) )
		->with ( '$response', $response )->with ( 'ResponseDate', $ResponseDate )
		->with ( 'conversations', $conversationsArr )->with ( 'last', $last )
		->with ( 'status', Ticket_Status::where ( 'id', '=', $tickets->status )
				->first () )->with ( 'help_topic', $help_topic )
		->with ( 'department', Department::where ( 'id', '=', $help_topic->department )->first () )
		->with('prevTkts',$prevTktArr)
		->with('totalPrev',$previousTickets->total()-1)
		->with('helptopic',$topic->whereStatus(1)->OrderBy('ordering','asc')->get())
		->with('leaders',$tktManager->get())
		->with('loggedInMgrCode',$loggedInMgrCode);
	}
	
	/**
	 * function to assign ticket
	 * @param type $id
	 * @return type bool
	 */
	public function assign($id) {
	
			$assign_to = Input::get('assign_to');
			$ticket = Tickets::where('id', '=', $id)->first();
			$response = ['response' => 0,'message'=>'Failed'];
			$ticket->assigned_to_manager_id = $assign_to;
			$ticket->save();
			$response = ['response' => 1,'message'=>'Success'];
			return Response::json ( $response );
			
		}
		
		public function assignBKP($id) {
		
			$UserEmail = Input::get('assign_to');
			$assign_to = explode('_', $UserEmail);
			$ticket = Tickets::where('id', '=', $id)->first();
			$response = ['response' => 0,'message'=>'Failed'];
		
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
			} elseif ($assign_to[0] == 'user') {
				$ticket->assigned_to = $assign_to[1];
				$user_detail = User::where('id','=',$assign_to[1])->first();
				$assignee = $user_detail->firstname . ' ' . $user_detail->lastname;
		
				$company = Config::get('helpdesk.site_name');
				$system = Config::get('helpdesk.system_support');
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
		
				### UPDATE SURRENDER CURRENT STATUS #####
				Ticket_Surrender::where('ticket_id', $id)
				->update(['status' => 1]);
		
		
				$agent = $user_detail->firstname;
				$agent_email = $user_detail->email;
					
				$master = Auth::user()->first_name . " " . Auth::user()->last_name;
		
				Mail::send('helpticket.emails.Ticket_assign', ['agent' => $agent, 'ticket_number' => $ticket_number, 'from'=>$company, 'master' => $master, 'system' => $system], function ($message) use ($agent_email, $agent, $ticket_number, $ticket_subject) {
					$message->to($agent_email, $agent)->subject($ticket_subject.'[#' . $ticket_number . ']');
				});
					// }
					$response = ['response' => 1,'message'=>'Success'];
			}
				
			return Response::json ( $response );
				
		}


		/**
		 * function to change status of Ticket
		 * @param type $id
		 * @param type Tickets $ticket
		 * @return type
		 */
		public function temporaryPending($id, Tickets $ticket) {
			
			$ticket_status = $ticket->where('id', '=', $id)->first();
			$ticket_status->system_status = 1;
			$ticket_status->save();
			return "Success";
		}
		
	public function Search(Request $request)
	{
		//dd('d');
		
		$labelText = "Status : ".Input::get('ticket_status');
		$filter_type 		= Input::get('filter_type');
		$filter_text 		= Input::get('filter_text');
		$filter_datefrom 	= Input::get('filter_datefrom');
		$filter_dateto 		= Input::get('filter_dateto');
		$filter_replier 	= Input::get('filter_replier');
		
		$Category = Input::get('Category');
		$MgrCode = Input::get('MgrCode');
		
		
		
		$sql =  Tickets::select('tkt_tickets.*','TD.title','TD.body','TD.created_at','TP.priority','TP.priority_color','TS.name as tktstatus','U.profile_pic','U.firstname','U.lastname',
				'U.country_code','UA.profile_pic as assignProfile_pic','UA.firstname as assignFname','UA.lastname as assignLname','HT.topic')
				->join ( 'tkt_ticket_thread as TD', 'tkt_tickets.id', '=', 'TD.ticket_id' )
				->join ( 'tkt_ticket_priority as TP', 'tkt_tickets.priority_id', '=', 'TP.id' )
				->join ( 'tkt_ticket_status as TS', 'tkt_tickets.status', '=', 'TS.id' )
				->join ( 'users as U', 'U.id', '=', 'tkt_tickets.user_id' )
				->join ( 'users as UA', 'UA.id', '=', 'tkt_tickets.assigned_to','LEFT' )
				->join ( 'tkt_help_topic as HT', 'HT.id', '=', 'tkt_tickets.help_topic_id','LEFT' );
				
				if($MgrCode <> 'All')
				{
					$sql->join ( 'tkt_help_topic_manager as HTM', 'HTM.topic_id', '=', 'HT.id','LEFT' );
				}
				
			
				switch($filter_type){
					case 'id':
					case 'email':
					case 'country_code':
					case 'alias':
						$sql->where ( 'U.'.$filter_type, '=', $filter_text );
					break;
					case 'ticket_number':
						$sql->where ( 'tkt_tickets.ticket_number', 'like', '%' . $filter_text . '%' );
						break;
				}	
				$labelText .= " , ".camel_case($filter_type)." : ".$filter_text;
			if ($filter_datefrom)
				{
					$sql->whereBetween('tkt_tickets.created_at',[$filter_datefrom,$filter_dateto]);
					$labelText .= " , Date Range : ".$filter_datefrom.' - '.$filter_dateto;
				}
				if($filter_replier){
					$sql->where('TD.replier',$filter_replier);
					$labelText .= " , Reply By : ".$filter_replier;
				}
				
					switch (Input::get('ticket_status')) {
						case 'Open' :
							$status = [1];
							break;
						case 'Closed' :
							$status = [2,3];
							break;
						case 'Unassigned' :
							$status = [1,2,3,4,5];
							break;
						case 'Trashed' :
							$status = [5];
							break;
						case 'Surrendered' :
							$status = [1,2,3,4,5];
							break;
					}
					$sql->whereIn('tkt_tickets.status',$status);
			
			#### FOR CATEGORIES AND ASSIGNED TO ME ####
			if(!in_array($Category,['BLANK','AssignedTo']))
			{
				$sql->where('tkt_tickets.help_topic_id',$Category);
				$labelText .= " , Help Topic  : ".Help_topic::whereId($Category)->pluck('topic');
			}
			
			$assigned_to_manager_id = '';
			if ($request->cookie('TKT_MANAGER')) {
					$MgrSessionCode = $request->cookie('TKT_MANAGER');
					$assigned_to_manager_id = TicketManager::where(['manager_code'=>$MgrSessionCode])->pluck('id');
			}
			if($Category == 'AssignedTo' && $assigned_to_manager_id)
			{
				$sql->where('tkt_tickets.assigned_to_manager_id', $assigned_to_manager_id);
				$labelText .= " , Individual Assigned To   : " .$MgrSessionCode;
			}
			#### FOR CATEGORIES AND ASSIGNED TO ME ####
			
			if($MgrCode <> 'All')
			{
				if($Category == 'AssignedTo')
				{
				}else{
					
					$sql->where(function($innerQry)use($MgrCode)
					{
						$innerQry->where('HTM.assign_to',$MgrCode);
					});
					$labelText .= " , Topic Under : " .$MgrCode;
				}
			}
				
			
			$lists = 	$sql->groupBy('TD.ticket_id')
		->orderBy ( 'tkt_tickets.id', 'desc' )->get();
			
		$ticketsArr = array ();
		foreach ( $lists as $open ) {
			$string = strip_tags ( $open->title );
			$TicketDatarow = Ticket_Thread::where ( 'ticket_id', '=', $open->id )->orderBy ( 'id', 'desc' )->first ();
			$LastResponse = User::where ( 'id', '=', $TicketDatarow->user_id )->first ();
			$lastReplierFromAdmin = $TicketDatarow->replier;
			if ($LastResponse->user_type == "2") {
				$rep = "#F39C12";
				$username = $LastResponse->firstname;
				$tID = $open->id ;
				$lastReplierFromAdmin = Ticket_Thread::where (function($sql)use($open){
					$sql->where('ticket_id',$open->id);
					$sql->where('user_id','<>',$open->user_id);
				})->orderBY('id','desc')->pluck ('replier');
		
			} else {
				$rep = "#000";
				$username = $LastResponse->firstname . " " . $LastResponse->lastname;
				if ($LastResponse->firstname == null || $LastResponse->lastname == null) {
					$username = $LastResponse->firstname;
				}
			}
			$totalThread = Ticket_Thread::where ( [
					'ticket_id' => $open->id
			] )->count ();
			$ticketsArr [] = ( object ) array (
					'id' => $open->id,
					'title' => $open->title,
					'tktTitle' => str_limit ( $string, 40 ),
					'count' => $totalThread,
					'ticket_number' => $open->ticket_number,
					'tktstatus' => $open->tktstatus,
					'last_updated_at' => $TicketDatarow->updated_at,
					'priority' => $open->priority,
					'priority_color' => $open->priority_color,
					'rep' => $rep,
					'lastreplier' => $username,
					'assignTo' => $open->assignFname . ' ' . $open->assignLname,
					'assigned_to' => $open->assigned_to,
					'country_code' => $open->country_code,
					'from' => $open->firstname,
					'replier' => $lastReplierFromAdmin,
					'topic' => $open->topic,
					'system_status' => $open->system_status,
			);
		}
		
			return view('helpticket.admin.ticket.filter-list')
			->with('lists',$ticketsArr)
			->with('labelText',$labelText);
		
		
	}
}
