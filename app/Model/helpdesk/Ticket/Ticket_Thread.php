<?php namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket_Thread extends Model
{
	protected $table = 'tkt_ticket_thread';
	protected $fillable = [
							'id','pid','ticket_id','staff_id','user_id','thread_type','poster','source','is_internal','title','body','note', 'format','ip_address','created_at','updated_at','replier'
							];
}
