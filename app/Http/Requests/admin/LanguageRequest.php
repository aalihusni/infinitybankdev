<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Response;
use Illuminate\Support\Facades\Input;
use App\User;

class LanguageRequest extends FormRequest {
	public function rules() {
		$language_id = Input::get ( 'language_id' );
		
		if ($language_id) {
			$rules ['name'] = 'required|unique:language,name,' . $language_id;
			$rules ['code'] = 'required|unique:language,code,' . $language_id;
		} else {
			$rules ['name'] = 'required|unique:language';
			$rules ['code'] = 'required|unique:language';
		}
		$rules ['image'] = 'required';
		$rules ['sort_order'] = 'required';
		return $rules;
	}
	
	/**
	 * Determine if the user is valid to become leader.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}
	
	// ### OPTIONAL RESPONSE ####
	public function response(array $errors) {
		return Response::json ( array (
				'errors' => $errors,
				'response' => 0 
		) );
	}
	
	// ### OPTIONAL AUTHORIZE FORBIDDEN ####
	public function forbiddenResponse() {
		return Response::json ( array (
				'response' => 0,
				'errors' => array (
						'filter_id' => 'User must have user_type : 2 & user_class > 0' 
				) 
		) );
	}
}
?>