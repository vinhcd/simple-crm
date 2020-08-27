<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileController extends Controller
{
    public function login(Request $request)
    {
        return redirect()->to('/mobile?uuid=c0b2ebc1-d1ea-4b23-814a-3abc47b04629');
    }
}
