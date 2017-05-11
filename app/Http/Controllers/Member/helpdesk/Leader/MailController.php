<?php namespace App\Http\Controllers\Member\helpdesk\Leader;
// controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\helpdesk\Leader\TicketController;

// models
use App\User;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Ticket\Ticket_source;
use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\Model\helpdesk\Ticket\Tickets;

// classes
use App;
use DB;
use Crypt;
use Schedule;
use File;
use Artisan;
use Exception;

/**
 * MailController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Cara <kamal@cara.com.my>
 */
class MailController extends Controller {

	/**
	 * constructor
	 * Create a new controller instance.
	 * @param type TicketController $TicketController
	 */
	public function __construct(TicketController $TicketController) {
		$this->TicketController = $TicketController;
	}

	

	/**
	 * separate reply
	 * @param type $body 
	 * @return type string
	 */
	public function separate_reply($body) {
		$body2 = explode('---Reply above this line---', $body);
		$body3 = $body2[0];
		return $body3; 
	}

	/**
	 * Decode Imap text
	 * @param type $str
	 * @return type string
	 */
	public function decode_imap_text($str) {
		$result = '';
		$decode_header = imap_mime_header_decode($str);
		foreach ($decode_header AS $obj) {
			$result .= htmlspecialchars(rtrim($obj->text, "\t"));
		}
		return $result;
	}

	/**
	 * fetch_attachments
	 * @return type
	 */
	public function fetch_attachments(){
		$uploads = Upload::all();
		foreach($uploads as $attachment) {
			$image = @imagecreatefromstring($attachment->file); 
	        ob_start();
	        imagejpeg($image, null, 80);
	        $data = ob_get_contents();
	        ob_end_clean();
	        $var = '<a href="" target="_blank"><img src="data:image/jpg;base64,' . base64_encode($data)  . '"/></a>';
	        echo '<br/><span class="mailbox-attachment-icon has-img">'.$var.'</span>';
	    }
	}

	/**
	 * function to load data
	 * @param type $id 
	 * @return type file
	 */
	public function get_data($id){
		$attachments = Ticket_attachments::where('id','=',$id)->get();
		foreach($attachments as $attachment)
		{
    			header('Content-type: application/'.$attachment->type.'');
				header('Content-Disposition: inline; filename='.$attachment->name.'');
				header('Content-Transfer-Encoding: binary');
				echo $attachment->file;
    	}
	}

}
