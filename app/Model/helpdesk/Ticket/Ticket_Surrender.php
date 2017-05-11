<?php namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket_Surrender extends Model
{
	protected $table = 'tkt_ticket_surrender';
	protected $fillable = [
							'id','ticket_id','user_id','status','created_at','updated_at'
							];
}
