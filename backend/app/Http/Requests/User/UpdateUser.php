<?php

namespace App\Http\Requests\User;

use App\Helpers\HelperChecks;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class UpdateUser extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return auth()->check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'name' => ['string', 'min:1', 'max:255'],
			'phone' => ['string', 'min:12', 'max:12', 'phone_number', 'unique:users'],
			'password' => ['integer', 'min:1000', 'max:9999'],
		];

		Validator::extend('phone_number', function($attribute, $value, $parameters) {
			return HelperChecks::isPhoneNumber($value);
		});

		Validator::replacer('phone_number', function($message, $attribute, $rule, $parameters) {
			return str_replace(':attribute', $attribute, ':attribute is invalid phone number. Correct format +77000000000');
		});

		return $rules;
	}
}
