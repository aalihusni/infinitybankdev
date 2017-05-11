<?php namespace App\Http\Requests\helpdesk;
use App\Http\Requests\Request;
use Response;
use Auth;
use Input;
/**
 * TicketRequest
 *
 * @package Request
 * @author  Cara <kamal@cara.com.my>
 */
class TicketRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		
		
		if(Auth::user()->user_type==1){
			$note = Input::get ( 'note' );
			$rules['ticket_ID'] = 'required';
			if(empty($note))
				$rules['ReplyContent'] = 'required|min:10';
			
		}else{
			$rules = [
					'ticket_ID' => 'required',
					'ReplyContent' => 'required|min:20',
			];
		}
		return $rules;
		/*
		return [
			'ticket_ID' => 'required',
			'ReplyContent' => 'required|min:20',
		];*/
	}
	
	#### OPTIONAL RESPONSE ####
	public function response(array $errors)
	{
		$errors['response'] = 0;
		$errors['custom_msg'] = 'Fail! Please check the error.';
		return Response::json ( array (
				'errors' => $errors
		) );
			
	}
	
	#### OPTIONAL AUTHORIZE FORBIDDEN  ####
	public function forbiddenResponse()
	{
	return Response::json ( array (
			'response' => 0,
			'errors' => array('custom_msg'=>'Forbidden Action.')
		) );
	}

}
