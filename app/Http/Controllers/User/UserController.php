<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showProfile(ShowUserRequest $request)
    {
        try {
            $params = $request->validated();
            return view('pages.admin.users.user-show', ['user' => Auth::user(), 'showModal' => $params['show_modal'] ?? false]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Created new user False');
        }
    }
}
