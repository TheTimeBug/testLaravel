<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class t3 extends Controller
{
    public function handle($id = null, $name = "Not Set")
    {
        if ($id === null) {
            return $this->notFound();
        }

        return $this->found($id, $name);
    }

    public function found($id, $name)
    {
        return view('t3',['id'=>$id,'name'=>$name]);
    }

    public function notFound()
    {
        return view('NotFound');
    }
}
