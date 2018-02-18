<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Favorite;
use Illuminate\Http\Response;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Reply $reply)
    {
        $reply->favorite();
        return back();
    }
}
