<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userService->all();
        return $this->sendResponse($users,'success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'role_id' => $request['role_id'],
        ];

        $validator =  Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 
            'password' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error creating user.',$validator->errors(), 400);
        }

        $data['password'] = Hash::make($data['password']);
        $user = $this->userService->getModel()->updateOrCreate(['id' => $request->id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id
            ]
        );

        return $this->sendResponse($user, 'User successfully created.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = $this->userService->find($request['id']);
        $data = $user->delete();

        if($data) {
            return $this->sendResponse('', 'User sucessfully deleted.');   
        } else {
            return $this->sendResponse('', 'Error deleting user.');   
        }
    }
    
    /**
     * Change password.
     */
    public function changePassword(Request $request){

        $user = $this->userService->find($this->getCurrentUser()->id);
        if (!Hash::check($request->old_password, $user->password))
        {
            return response('Password invalid. Old password.', 400);
        }
        $user->password = Hash::make($request->new_password);
        
        if($user->save()) {
            return $this->sendResponse($user, 'User sucessfully deleted.');   
        } else {
            return $this->sendError('Error changing password.', null, 400);   
        }
    }

    public function logout(Request $request){
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return $this->sendResponse('success', 'User successfully loggedout.');
    }

}
