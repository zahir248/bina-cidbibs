<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    public function home()
    {
        return view('client.home');
    }
}
