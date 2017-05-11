<?php namespace App\Model\helpdesk\Manage;

use Illuminate\Database\Eloquent\Model;
use App\Model\helpdesk\Ticket\Tickets;

class Help_topic extends Model
{
	protected $table = 'tkt_help_topic';
	protected $fillable = 	[
								'id','topic', 'parent_topic', 'custom_form', 'department', 'ticket_status', 'priority','css_class','description',
								'sla_plan', 'thank_page', 'ticket_num_format', 'internal_notes', 'status', 'type','auto_assign',
								'auto_response','ordering'
							];
	
	public function countTicket($data)
	{
		
		return Tickets::where(function($query)use($data){
					$query->where('status', $data['status']);
					$query->where('help_topic_id', $data['help_topic_id']);
					
		})
		->count();
	}
}							