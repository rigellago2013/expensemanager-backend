<?php
namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\User;

class UserService extends BaseService
{
    public function __construct(Request $request, User $user)
    {
        parent::__construct($user, $request);
    }

    public function getModel()
    {
        return $this->model;
    }
} 