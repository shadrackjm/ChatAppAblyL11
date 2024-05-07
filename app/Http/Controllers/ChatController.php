<?php

namespace App\Http\Controllers;

use App\Models\User; //import this
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function loadDashboard(){
        // fetch them here except the logged in user as user should not see him or herself in a list
        $all_users = User::where('id','!=',auth()->user()->id)->get();
        return view('dashboard',compact('all_users'));
    }
}
