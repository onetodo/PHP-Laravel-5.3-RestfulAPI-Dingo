<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;

class UserController extends BaseController
{
	public function index(){
		$users = User::all();
		return $this->collection($users, new UserTransformer);
	}   
	
	public function show($id){
		$user = User::findOrFail($id);
		return $this->response->item($user, new UserTransformer);
	}
	
	public function store(Request $request){
		$rules = array(
				'name'       => 'required',
				'email'      => 'required|email',
		);
		$validator = Validator::make($request->all(), $rules);

		if ( $validator->fails() ) {
			return $this->response->errorBadRequest();
		}
		
		$user = new User;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = bcrypt($request->password);

		$user->save();
		
		return ['success' => true ];
	}

	public function update($id, Request $request){
		$rules = array(
				'name'       => 'required',
				'email'      => 'required|email',
		);
		$validator = Validator::make($request->all(), $rules);

		if ( $validator->fails() ) {
			return $this->response->errorBadRequest();
		} 
		
		$user = User::findOrFail($id);
		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = bcrypt($request->password);
		$user->save();
		
		return ['success' => true ];
	}
}
