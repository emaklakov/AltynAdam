<?php

namespace App\Http\Requests\User;

use App\Helpers\HelperChecks;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class BlockUser extends FormRequest
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
			'is_blocked' => ['required', 'boolean'],
		];

		return $rules;
	}
}
