<?php

namespace App\Http\Controllers\API\Select2;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return User::select([
            'id',
            'username as text'
        ])->paginate(10);
    }
}
