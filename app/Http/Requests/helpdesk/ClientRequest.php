<?php namespace App\Http\Requests\helpdesk;
use App\Http\Requests\Request;
use Response;
/**
 * CompanyRequest
 *
 * @package Request
 * @author  Cara <kamal@cara.com.my>
 */
class ClientRequest extends Request {

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
		return [
			'helptopic'=>'required|exists:tkt_help_topic,id',
			'Subject'=>'required|min:1',
			'Details'=>'required|min:30',
		];
	}
	
	#### OPTIONAL RESPONSE ####
	public function response(array $errors)
	{
		$errors['response'] = 0;
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
