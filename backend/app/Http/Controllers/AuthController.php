<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\SignupAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
	public function signup(SignupAuth $request)
	{
		$user = User::createUser($request->validated());

		$token = $user->createToken($request->device_name)->plainTextToken;

		$response = [
			'token' => $token,
			'user' => $user->getInfo(),
		];

		return response($response, 201);
	}

	public function login(Request $request)
	{
		$user = User::where('phone', $request->phone)->first();

		if(!$user || !Hash::check($request->password, $user->password)) {
			return $this->sendError('The provided credentials are incorrect', null, 401);
		}

		if($user->is_blocked) {
			return $this->sendError('User blocked', null, 401);
		}

		$token = $user->createToken($request->device_name)->plainTextToken;

		$response = [
			'token' => $token,
			'user' => $user->getInfo(),
		];

		return response($response, 200);
	}

	public function logout(Request $request)
	{
		$data = $request->all();

		$user = $request->user();

		if (array_key_exists('device_name', $data) && !empty($data['device_name'])) {
			$user->tokens()->where('name', $data['device_name'])->delete();
		} else {
			$user->tokens()->delete();
		}

		return response(null, 200);
	}

	public function user(Request $request)
	{
		$user = $request->user();

		$response = [
			'user' => $user->getInfo(),
		];

		return response($response, 200);
	}
}
