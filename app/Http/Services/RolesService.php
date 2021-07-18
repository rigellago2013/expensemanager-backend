<?php
namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\User;

class RolesService extends BaseService
{
    public function __construct(Request $request, Roles $roles)
    {
        parent::__construct($roles, $request);
    }
    
    public function getModel()
    {
        return $this->model;
    }
} 