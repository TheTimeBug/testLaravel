<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class t2 extends Controller
{
    function viewT2($id){
        $user = $id;
        return view('t2',['id'=>$user]);
    }
}
