<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RoleUser extends FormRequest
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
			'roles' => ['array', 'min:1'],
			'roles.*' => ['integer', 'min:1'],
		];

		return $rules;
	}
}
