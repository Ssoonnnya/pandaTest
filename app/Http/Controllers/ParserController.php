<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriptions;
use App\Models\olxLink;
use GuzzleHttp\Client;

class ParserController extends Controller
{
    public function index(Request $request) {
        echo('hello world');
    }
}
