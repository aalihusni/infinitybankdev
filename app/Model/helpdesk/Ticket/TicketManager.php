<?php namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;

class TicketManager extends Model {

	protected $table = 'tkt_manager';
	protected $fillable = ['id','manager_code','status','created_at','updated_at'];
	
	public function getAssignedTopics($data)
	{
		return TicketHelpTopicManager::join('tkt_manager as TM','TM.manager_code','=','tkt_help_topic_manager.assign_to')
		->join('tkt_help_topic as HT','HT.id','=','tkt_help_topic_manager.topic_id')
								->where(function($query)use($data){
									$query->where('tkt_help_topic_manager.assign_to',$data['manager_code']);
		})->select('HT.topic','HT.id')->get();
	}
	
}