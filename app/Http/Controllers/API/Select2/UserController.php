<?php

namespace App\Http\Controllers\API\Select2;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): LengthAwarePaginator
    {
        // @phpstan-ignore-next-line
        return User::query()
            ->where('username', 'like', '%' . $request->input('q') . '%')
            ->select([
                'id',
                'username as text'
            ])->paginate(10);
    }
}
