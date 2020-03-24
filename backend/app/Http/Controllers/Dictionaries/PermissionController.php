<?php

namespace App\Http\Controllers\Dictionaries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dictionaries\Permission\StorePermission;
use App\Http\Requests\Dictionaries\Permission\UpdatePermission;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
	public function index(){
		return Permission::all();
	}

	public function store(StorePermission $request){
		$permission = Permission::createPermission($request->validated());

		$permission['roles'] = $permission->roles;

		return response($permission, 201);
	}

	public function show($permission_id){
		$permission = Permission::findOrFail($permission_id);

		$permission['roles'] = $permission->roles;

		return response($permission, 200);
	}

	public function update(UpdatePermission $request, $permission_id){
		$permission = Permission::findOrFail($permission_id);

		$permission = Permission::updatePermission($request->validated(), $permission);

		$permission['roles'] = $permission->roles;

		return response($permission, 200);
	}

	public function destroy($permission_id){
		$permission = Permission::findOrFail($permission_id);
		$permission->delete();

		return response(null, 200);
	}
}
