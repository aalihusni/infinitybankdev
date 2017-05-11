<?php namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket_attachments extends Model
{
	protected $table = 'tkt_ticket_attachment';
	protected $fillable = [
							'id','thread_id','name','size','type','file','file_path','data','poster','updated_at','created_at'
							];
}
