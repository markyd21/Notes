<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\friendships;
use App\Http\Requests;

class FriendController extends Controller
{
    public function index()
	{
		$userId = Auth::user()->id;
		$myFriends = friendships::join('users', 'users.id', '=', 'friendships.friend_id')
					->where('friendships.user_id', $userId)
					->get();
        return $myFriends;
	}
}
