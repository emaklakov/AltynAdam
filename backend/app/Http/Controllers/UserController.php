<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\BlockUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function show($user_id)
	{
		$user = User::findOrFail($user_id);

		$response = $user->getInfo();

		return response($response, 200);
	}

	public function block(BlockUser $request, $user_id)
	{
		if($request->user()->id == $user_id) {
			return $this->sendError('Action is prohibited', null, 403);
		}

		$user = User::blockUser($request->validated(), $user_id);

		$response = [
			'id' => $user['id'],
			'is_blocked' => $user['is_blocked'],
		];

		return response($response, 200);
	}
}
