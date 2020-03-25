<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PermissionUser extends FormRequest
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
			'permissions' => ['array', 'min:1'],
			'permissions.*' => ['integer', 'min:1'],
		];

		return $rules;
	}
}
