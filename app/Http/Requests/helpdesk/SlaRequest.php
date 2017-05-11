<?php namespace App\Http\Requests\helpdesk;
use App\Http\Requests\Request;

/**
 * SlaRequest
 *
 * @package Request
 * @author  Cara <kamal@cara.com.my>
 */
class SlaRequest extends Request {

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
			'name' => 'required|unique:sla_plan',
			'grace_period' => 'required',
		];
	}

}
