<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use App\Http\Services\RolesService;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    private $rolesService;

    public function __construct(RolesService $rolesService)
    {
        $this->rolesService = $rolesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->rolesService->all();
        return $this->sendResponse($roles,'success');
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
            'display_name' => $request['display_name'],
            'description' => $request['description']
        ];

        $validator =  Validator::make($data, [
            'display_name' => ['required', 'string', 'max:255'],    
            'description' => ['required', 'string', 'max:255'],
        ]);
        
        if ($validator->fails()) {
            return $this->sendError('Error creating role.',$validator->errors(), 400);
        }

        $role = $this->rolesService->getModel()->updateOrCreate(['id' => $request->id],
            [
                'display_name' => $request->display_name,
                'description' => $request->description
            ]
        );

        if($role) {
            return $this->sendResponse($role, 'Role successfully created.');
        } else {
            return $this->sendError('Error creating role.', null, 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(Roles $roles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit(Roles $roles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roles $roles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $role = $this->rolesService->find($request->id);
        if($role) {
            $role->delete();
            return $this->sendResponse('', 'Expense sucessfully deleted.');   
        } else {
            return $this->sendError('Error deleting expense.', "Role doesn't exist.", 400);   
        }
    }
}
