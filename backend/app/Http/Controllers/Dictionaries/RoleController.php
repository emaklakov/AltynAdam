<?php

namespace App\Http\Controllers\Dictionaries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dictionaries\Role\StoreRole;
use App\Http\Requests\Dictionaries\Role\UpdateRole;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
	public function index(){
		return Role::all();
	}

	public function store(StoreRole $request){
		$role = Role::createRole($request->validated());

		$role['permissions'] = $role->permissions;

		return response($role, 201);
	}

	public function show($role_id){
		$role = Role::findOrFail($role_id);

		$role['permissions'] = $role->permissions;

		return response($role, 200);
	}

	public function update(UpdateRole $request, $role_id){
		$role = Role::findOrFail($role_id);

		$role = Role::updateRole($request->validated(), $role);

		$role['permissions'] = $role->permissions;

		return response($role, 200);
	}

	public function destroy($role_id){
		$role = Role::findOrFail($role_id);
		$role->delete();

		return response(null, 200);
	}
}
