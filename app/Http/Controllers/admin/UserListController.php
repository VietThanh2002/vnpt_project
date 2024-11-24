<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserListController extends Controller
{
    public function index(Request $request){

        $users = User::where('role', 1)->orderBy('name', 'DESC');

        if($request->get('keyword') != ""){
            $users = $users->where('name','like','%'.$request->keyword.'%');
            $users = $users->orWhere('phone_number','like','%'.$request->keyword.'%');
            $users = $users->orWhere('email','like','%'.$request->keyword.'%');
        }

        $users = $users->paginate(10);

        // dd($user);

        return view('admin.users.list', [
            'users' => $users
        ]);
    }
}
