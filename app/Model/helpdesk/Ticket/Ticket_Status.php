<?php namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket_Status extends Model
{
	protected $table = 'tkt_ticket_status';
	protected $fillable = [
							'id','name','state','message','mode','flag','sort','properties'
							];
}

