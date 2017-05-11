<?php namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;

class TicketHelpTopicManager extends Model {

	protected $table = 'tkt_help_topic_manager';
	protected $fillable = ['id','topic_id','assign_to','created_at','updated_at'];
	
	
	
}