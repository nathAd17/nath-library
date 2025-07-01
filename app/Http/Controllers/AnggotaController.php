<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index() {
        $members = User::with(['transactions', 'notifications', 'badges', 'gamificationLogs'])->isAnggota()->get();

        return view('pages.members', $members);
    }
}
