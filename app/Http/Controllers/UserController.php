<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function index() {
        $users = User::all();

        // $roles = [
        //     ['id' => 1, 'name' => 'admin',],
        //     ['id' => 2, 'name' => 'anggota',],
        //     ['id' => 3, 'name' => 'pustakawan']
        // ];

        $roles = ['admin','anggota','pustakawan'];

        return view('pages.users', compact(['users', 'roles']));
    }
}
