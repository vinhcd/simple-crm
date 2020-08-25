<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileController extends Controller
{
    public function login(Request $request)
    {
        return redirect()->to('/mobile?uuid=1200ff02-341c-414c-a8db-ecd68ca0ceeb');
    }
}
