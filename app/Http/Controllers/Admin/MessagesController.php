<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class MessagesController extends Controller
{
    public function store()
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'content' => 'required'
        ])
        

        Mail::to('positivejvr@gmail.com')->send()

        return 'Mensaje enviado';
    }

}
