<?php
namespace App\Classes;

use App\User;
use App\Classes\TrailLogClass;
use Carbon\Carbon;
use Mail;
use App\TrailLog;
use DB;
use Storage;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use S3Files;
use App\Classes\AdminClass;

class DemoClass
{
   public static function changeImageData($dataFrom,$dataTo)
   {
   	echo "Start \r\n";
   	AdminClass::addCronLog('Change Image DataString To Image Start');
   	###  CHANGE IMAGE ###
   	//preg_match('/ src=(".*?"|\'.*?\'|.*?)[ >]/i', $body, $m);
   	//$data = str_replace('data:image/png;base64,', '', $m[1]);
   	//$src = $m[1];
   	$conversations = Ticket_Thread::where(function($sql)use($dataFrom,$dataTo){
   		$sql->where('id', '>=', $dataFrom);
   		$sql->where('id', '<', $dataTo);
   	})->get();
   	
   	
   	$lastID = '';
   	echo "CONV Before Loop \r\n";
   	foreach($conversations as $conv){
   		echo 'CONV Before Loop\r\n';
   	$body = $conv->body;
   	
   	preg_match('/ src=(".*?"|\'.*?\'|.*?)[ >]/i', $body, $m);
   	if(!count($m))
   		continue;
    echo 'ID '.$conv->id." \r\n";
   /*
   	$search = preg_match_all('/<([^\/!][a-z1-9]*)/i',$body,$matches);
  	if(empty($matches[0]))
  	continue;
   	 */
   	
   	$final_tags = '';
   	$dom = new \DOMDocument();
   	//$dom->loadHTML($body);
   	@$dom->loadHTML($body);
   	$img_tags = $dom->getElementsByTagName('img');
   	# Roll through the `img` tags.
   	echo "IMG Before Loop \r\n";
   	foreach ($img_tags as $tag) {
   		echo "IMG After Loop \r\n";
   		##CONVERT##
   		$data = $tag->getAttribute('src');
   		$SubStr = substr("$data", 0,10);
   		
   		if($SubStr <> 'data:image')
   			continue;
   				
   			list($type, $data) = explode(';', $data);
   			list(, $data)      = explode(',', $data);
   			//$data = str_replace('data:image/jpeg;base64,', '', $data);
   			$data = str_replace(' ', '+', $data);
   			$data = base64_decode($data);
   			$imageName = rand() . '.png';
   			$path = 'helpdesk/attachments/'.$imageName;
   			Storage::put($path, $data);
   			$ImageUrl =  S3Files::url('helpdesk/attachments/'.$imageName);
   			## CONVERT##
   			# Set the `src` attribute to be the new value.
   			$tag->setAttribute('src', $ImageUrl);
   			# Save the tag into the HTML.
   			$dom->saveHTML($tag);
   			$final_tags = preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $dom->saveHTML());
   				
   	}
   
   	# Strip out the DOCTYPE, html & body tags.
	   	if($final_tags){
	   		$conv->body = $final_tags;
	   		$conv->save();
	   		
	   	}
	   	$lastID = $conv->id;
   	}
   	echo "Finish \r\n";
   	AdminClass::addCronLog('#Last Check ID'.$lastID.' Change Image DataString To Image Finish');
   	###  CHANGE IMAGE ###
   	
   }
	
	public function testinfoforvideo()
	{
			
		$LatestUpdatedRows = TrailLog::select(DB::raw('max(id) as id'))->where(function($sql){
			$sql->where('title','Update Wallet Address');
		})->groupBy('user_id')->orderBy('id', 'desc')->get();
	
	
		$ChangedData = '';
		foreach ($LatestUpdatedRows as $list)
		{
			$detail = TrailLog::whereId($list->id)->select('to','user_id')->first();
			$UserRow = User::find($detail->user_id);
			if(is_null($UserRow)) continue;
			if($UserRow->wallet_address != $detail->to)
			{
				### Update The Wallet Address From Latest Trail Log #####
				$ChangedData .=  'User ID : '.$detail->user_id.' '.$UserRow->country_code. ' User.Address : '.$UserRow->wallet_address.' , Latest : '.$detail->to."<br>";
				$UserRow->wallet_address = $detail->to;
				$UserRow->save();
				TrailLogClass::addTrailLog($detail->user_id, "Update Wallet Address", $detail->to, $UserRow->wallet_address);
	
			}
		}
		Mail::raw(''.$ChangedData.'', function($message) {
			$message->to('sesemeeee@gmail.com')
			->subject('Wallet Address Checked from User.Address to Trail Log Latest Address ');
		});
	}
	
	
	public function testinfoforvideoLocal()
	{
			
		$LatestUpdatedRows = TrailLog::select(DB::raw('max(id) as id'))->where(function($sql){
			$sql->where('title','Update Wallet Address');
		})->groupBy('user_id')->orderBy('id', 'desc')->get();
	
	
		$ChangedData = '';
		foreach ($LatestUpdatedRows as $list)
		{
			$detail = TrailLog::whereId($list->id)->select('to','user_id')->first();
			//$UserRow = User::find($detail->user_id);
			$UserRow = DB::table('latestusers')->where('id', $detail->user_id)->first();
			if($UserRow->wallet_address != $detail->to)
			{
				### Update The Wallet Address From Latest Trail Log #####
				$ChangedData .=  'User ID : '.$detail->user_id.' '.$UserRow->country_code. ' User.Address : '.$UserRow->wallet_address.' , Latest : '.$detail->to."<br>";
				//$UserRow->wallet_address = $detail->to;
				//$UserRow->save();
				//TrailLogClass::addTrailLog($detail->user_id, "Update Wallet Address", $detail->to, $UserRow->wallet_address);
	
				DB::table('latestusers')
				->where('id', $UserRow->id)
				->update(['wallet_address' => $detail->to]);
				TrailLogClass::addTrailLog($detail->user_id, "Update Wallet Address", $detail->to, $UserRow->wallet_address);
			}
		}
		Mail::raw(''.$ChangedData.'', function($message) {
			$message->to('sesemeeee@gmail.com')
			->subject('Wallet Address Checked from User.Address to Trail Log Latest Address ');
		});
	}
}