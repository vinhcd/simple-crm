<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileController extends Controller
{
    public function login(Request $request)
    {
        return redirect()->to('/mobile?uuid=abc12345');
    }
}
