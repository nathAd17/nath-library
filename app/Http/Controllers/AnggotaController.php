<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index() {
        $roles = ['admin','anggota','pustakawan'];
        $members = User::with(['transactions', 'notifications', 'badges', 'gamificationLogs'])->get();

        return view('pages.members', compact('members', 'roles'));
    }
}
