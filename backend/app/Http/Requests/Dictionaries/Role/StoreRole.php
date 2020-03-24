<?php

namespace App\Http\Requests\Dictionaries\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRole extends FormRequest
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
			'name' => ['required', 'string', 'max:255'],
			'slug' => ['required', 'string', 'max:255', 'unique:roles'],
		];

		return $rules;
	}
}
