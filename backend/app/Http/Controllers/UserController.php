<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\BlockUser;
use App\Http\Requests\User\PermissionUser;
use App\Http\Requests\User\RoleUser;
use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateUser;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function index(Request $request){
		$per_page = $request->input('per_page', "10");

		$data = $request->all();

		$sort = 'desc';
		if (array_key_exists('sort', $data) && !empty($data['sort'])) {
			$sort = $data['sort'];
		}

		return User::orderBy('created_at', $sort)
			->paginate($per_page);
	}

	public function store(StoreUser $request)
	{
		$user = User::createUser($request->validated());

		$response = $user->getInfo();

		return response($response, 201);
	}

	public function show($user_id)
	{
		$user = User::findOrFail($user_id);

		$response = $user->getInfo();

		return response($response, 200);
	}

	public function update(UpdateUser $request, $user_id)
	{
		$user = User::findOrFail($user_id);

		$user = User::updateUser($request->validated(), $user);

		$response = $user->getInfo();

		return response($response, 200);
	}

	public function block(BlockUser $request, $user_id)
	{
		if($request->user()->id == $user_id) {
			return $this->sendError('Action is prohibited', null, 403);
		}

		$user = User::findOrFail($user_id);

		$user = User::blockUser($request->validated(), $user);

		$response = [
			'id' => $user['id'],
			'is_blocked' => $user['is_blocked'],
		];

		return response($response, 200);
	}

	public function roles(RoleUser $request, $user_id)
	{
		$user = User::findOrFail($user_id);

		$data = $request->validated();

		$roles = Role::whereIn('id', $data['roles'])->get();

		$user->roles()->detach();
		$user->roles()->saveMany($roles);

		$response = $user->roles;

		return response($response, 200);
	}

	public function permissions(PermissionUser $request, $user_id)
	{
		$user = User::findOrFail($user_id);

		$data = $request->validated();

		$permissions = Permission::whereIn('id', $data['permissions'])->get();

		$user->permissions()->detach();
		$user->permissions()->saveMany($permissions);

		$response = $user->permissions;

		return response($response, 200);
	}
}
