<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    /**
     * Display the community homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('client.community.index');
    }
}
