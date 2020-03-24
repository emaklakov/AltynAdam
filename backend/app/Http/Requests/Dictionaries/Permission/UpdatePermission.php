<?php

namespace App\Http\Requests\Dictionaries\Permission;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermission extends FormRequest
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
			'slug' => ['string', 'min:1', 'max:255', 'unique:permissions']
		];

		return $rules;
	}
}
