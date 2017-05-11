<?php namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use Carbon\Carbon;
class Tickets extends Model {

	protected $table = 'tkt_tickets';
	protected $fillable = ['id','ticket_number','num_sequence','user_id','priority_id','sla','help_topic_id','max_open_ticket','captcha','status','system_status', 'lock_by','lock_at','source','isoverdue','reopened','isanswered','is_deleted','closed','is_transfer','transfer_at','reopened_at','duedate','closed_at','last_message_at','last_response_at','created_at','updated_at'];
	
	public function getMyTickets($data)
	{
		return Tickets::select('tkt_tickets.*','TD.title','TD.body','TD.created_at','TP.priority','TP.priority_color','TS.name as tktstatus')
		->join ( 'tkt_ticket_thread as TD', 'tkt_tickets.id', '=', 'TD.ticket_id' )
		->join ( 'tkt_ticket_priority as TP', 'tkt_tickets.priority_id', '=', 'TP.id' )
		->join ( 'tkt_ticket_status as TS', 'tkt_tickets.status', '=', 'TS.id' )
		->where(function($query)use($data){
			$query->where('tkt_tickets.user_id',$data['user_id']);
			$query->whereIn('status', $data['status']);
			
		})
		->groupBy('TD.ticket_id')
		->orderBy ( 'tkt_tickets.id', 'desc' );
	}
	
	public function Threads()
	{
		return $this->hasMany('App\Model\helpdesk\Ticket\Ticket_Thread','ticket_id')
		->select('tkt_ticket_thread.*','U.profile_pic','U.firstname','U.lastname','U.user_type')
		->join ( 'users as U', 'U.id', '=', 'tkt_ticket_thread.user_id' )
		->orderBy ( 'tkt_ticket_thread.id', 'asc' );
	
	}
	
	public function getAssignedTickets($data)
	{
		return Tickets::select('tkt_tickets.*','TD.title','TD.body','TD.created_at','TP.priority','TP.priority_color','TS.name as tktstatus','U.profile_pic','U.firstname','U.lastname')
		->join ( 'tkt_ticket_thread as TD', 'tkt_tickets.id', '=', 'TD.ticket_id' )
		->join ( 'tkt_ticket_priority as TP', 'tkt_tickets.priority_id', '=', 'TP.id' )
		->join ( 'tkt_ticket_status as TS', 'tkt_tickets.status', '=', 'TS.id' )
		->join ( 'users as U', 'U.id', '=', 'tkt_tickets.user_id' )
		->where(function($query)use($data){
			$query->where('tkt_tickets.assigned_to',$data['assigned_to']);
			$query->whereIn('status', $data['status']);
		})
		->groupBy('TD.ticket_id')
		->orderBy ( 'tkt_tickets.id', 'desc' );
	}
	
	#### ALL TICKETS ###
	public function getAll($data)
	{
		return Tickets::select('tkt_tickets.*','TD.title','TD.body','TD.created_at','TP.priority','TP.priority_color','TS.name as tktstatus','U.profile_pic','U.firstname','U.lastname',
		'U.country_code','UA.profile_pic as assignProfile_pic','UA.firstname as assignFname','UA.lastname as assignLname','HT.topic','HT.css_class')
		->join ( 'tkt_ticket_thread as TD', 'tkt_tickets.id', '=', 'TD.ticket_id' )
		->join ( 'tkt_ticket_priority as TP', 'tkt_tickets.priority_id', '=', 'TP.id' )
		->join ( 'tkt_ticket_status as TS', 'tkt_tickets.status', '=', 'TS.id' )
		->join ( 'users as U', 'U.id', '=', 'tkt_tickets.user_id' )
		->join ( 'users as UA', 'UA.id', '=', 'tkt_tickets.assigned_to','LEFT' )
		->join ( 'tkt_help_topic as HT', 'HT.id', '=', 'tkt_tickets.help_topic_id','LEFT' )
		
		->where(function($query)use($data){
			if (key_exists ( 'assigned_to', $data ))
			$query->where('tkt_tickets.assigned_to',$data['assigned_to']);
			if (key_exists ( 'Unassigned', $data ))
				$query->whereNull('tkt_tickets.assigned_to');
			if (key_exists ( 'filter_unassigned', $data ))
					$query->whereIn('tkt_tickets.help_topic_id',$data['filter_unassigned']);
				
			if (key_exists ( 'status', $data ))
			$query->whereIn('tkt_tickets.status', $data['status']);
		})
		->groupBy('TD.ticket_id')
		->orderBy ( 'tkt_tickets.id', 'desc' );
	}
	
	public function getAllByManager($data)
	{
		return Tickets::select('tkt_tickets.*','TD.title','TD.body','TD.created_at','TP.priority','TP.priority_color','TS.name as tktstatus','U.profile_pic','U.firstname','U.lastname',
				'U.country_code','UA.profile_pic as assignProfile_pic','UA.firstname as assignFname','UA.lastname as assignLname','HT.topic','HT.css_class')
				->join ( 'tkt_ticket_thread as TD', 'tkt_tickets.id', '=', 'TD.ticket_id' )
				->join ( 'tkt_ticket_priority as TP', 'tkt_tickets.priority_id', '=', 'TP.id' )
				->join ( 'tkt_ticket_status as TS', 'tkt_tickets.status', '=', 'TS.id' )
				->join ( 'users as U', 'U.id', '=', 'tkt_tickets.user_id' )
				->join ( 'users as UA', 'UA.id', '=', 'tkt_tickets.assigned_to','LEFT' )
				->join ( 'tkt_help_topic as HT', 'HT.id', '=', 'tkt_tickets.help_topic_id','LEFT' )
				->join ( 'tkt_help_topic_manager as HTM', 'HTM.topic_id', '=', 'HT.id','LEFT' )
	
				->where(function($query)use($data){
					if (key_exists ( 'manager_code', $data ))
					{
						//$query->where('HTM.assign_to',$data['manager_code']);
						$query->where(function($innerQry)use($data)
						{
							$innerQry->where('HTM.assign_to',$data['manager_code']);
							if(key_exists('FILTER_ALL_PLUS_INDIV_ASSIGN',$data))
								$innerQry->orWhere('tkt_tickets.assigned_to_manager_id', $data['FILTER_ALL_PLUS_INDIV_ASSIGN']);
						});
						
					}
					
						if (key_exists ( 'filter_unassigned', $data ))
							$query->whereIn('tkt_tickets.help_topic_id',$data['filter_unassigned']);
					
							/*
						if (key_exists ( 'help_topic_id', $data ))
							$query->where('tkt_tickets.help_topic_id',$data['help_topic_id']); */
						
							
							if (key_exists ( 'help_topic_id', $data ))
							{
								
								$query->where(function($innerQry)use($data)
								{
									$innerQry->where('tkt_tickets.help_topic_id',$data['help_topic_id']);
									if(key_exists('help_topic_id_plus_ind_assigned',$data))
										$innerQry->orWhere('tkt_tickets.assigned_to_manager_id', $data['help_topic_id_plus_ind_assigned']);
								});
							
							}
							
							
							
						
						if (key_exists ( 'assigned_to_manager_id', $data ))
							$query->where('tkt_tickets.assigned_to_manager_id', $data['assigned_to_manager_id']);
						
							if (key_exists ( 'status', $data ))
								$query->whereIn('tkt_tickets.status', $data['status']);
							
						
				})
				->groupBy('TD.ticket_id')
				->orderBy ( 'tkt_tickets.id', 'desc' );
	}
	
	#### ALL TICKETS ###
	public function getSurrender($data)
	{
		return Tickets::select('tkt_tickets.*','TD.title','TD.body','TD.created_at','TP.priority','TP.priority_color','TS.name as tktstatus','U.profile_pic','U.firstname','U.lastname',
				'U.country_code','UA.profile_pic as assignProfile_pic','UA.firstname as assignFname','UA.lastname as assignLname')
				->join ( 'tkt_ticket_thread as TD', 'tkt_tickets.id', '=', 'TD.ticket_id' )
				->join ( 'tkt_ticket_priority as TP', 'tkt_tickets.priority_id', '=', 'TP.id' )
				->join ( 'tkt_ticket_status as TS', 'tkt_tickets.status', '=', 'TS.id' )
				->join ( 'tkt_ticket_surrender as SU', 'tkt_tickets.id', '=', 'SU.ticket_id' )
				->join ( 'users as U', 'U.id', '=', 'tkt_tickets.user_id' )
				->join ( 'users as UA', 'UA.id', '=', 'SU.user_id','LEFT' )
				->where(function($query)use($data){
					if (key_exists ( 'surrender_cur_status', $data ))
						$query->where('SU.status',$data['surrender_cur_status']);
					if (key_exists ( 'Unassigned', $data ))
						$query->whereNull('tkt_tickets.assigned_to');
					
				})
				->groupBy('SU.id')
				->orderBy ( 'SU.id', 'desc' );
	}
	
	public function countTicket($data)
	{
		return Tickets::where(function($query)use($data){
					if (key_exists ( 'assigned_to', $data ))
						$query->where('assigned_to',$data['assigned_to']);
					if (key_exists ( 'Unassigned', $data )){
						
						$allTopicIDs = array();
						foreach (Help_topic::get() as $t)
							$allTopicIDs[] = $t->id;
							$assignedTopicIDs = array();
							foreach (TicketHelpTopicManager::groupBy('topic_id')->get() as $tm)
								$assignedTopicIDs[] = $tm->topic_id;
								$unassignedTopics = array_diff($allTopicIDs, $assignedTopicIDs);
								//$condition ['filter_unassigned'] = $unassignedTopics;
						//$query->whereNull('assigned_to');
						$query->whereIn('help_topic_id',$unassignedTopics);
						$query->whereIn('status', [1]);
					}
					if (key_exists ( 'status', $data ))
						$query->whereIn('status', $data['status']);
				})
				->count();
	}
	
	public function countTicketBKP($data)
	{
		return Tickets::where(function($query)use($data){
			if (key_exists ( 'assigned_to', $data ))
				$query->where('assigned_to',$data['assigned_to']);
				if (key_exists ( 'Unassigned', $data ))
					$query->whereNull('assigned_to');
					if (key_exists ( 'status', $data ))
						$query->whereIn('status', $data['status']);
		})
		->count();
	}
	
	public function countSurrender($data)
	{
		return Ticket_Surrender::where(function($query)use($data){
			if (key_exists ( 'status', $data ))
				$query->whereIn('status', $data['status']);
		})
		->distinct('ticket_id')
		->count('ticket_id');
	}
	
	public static function cronJob()
	{
		$date = Carbon::now();
		$hour = $date->hour;
		
		if ($hour == 1) {  ### CRON WILL RUN AT 1 AM EVERYDAY ######
		
			$openTickets = Tickets::where(['status'=>1])->get();
			foreach ($openTickets as $ticket)
			{
				$LatestThread = Ticket_Thread::where ( 'ticket_id', '=', $ticket->id )->orderBy ( 'id', 'desc' )->first();
				$cDate = Carbon::parse($LatestThread->created_at);
				if($LatestThread->user_id == 1 && !empty($LatestThread->body) && $cDate->diffInDays() >= 1)
				{
					echo 'ID '.$ticket->id.' Days : '. $cDate->diffInDays()."<br>\r\n";
					self::close($ticket->id);
				}
			}
		}
	}
	
	private static function close($id) {
		
		$ticket = new Tickets();
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
		$thread->user_id = 1;
		$thread->is_internal = 1;
		$thread->body = $ticket_status_message->message . " System.";
		$thread->save();
	}
}