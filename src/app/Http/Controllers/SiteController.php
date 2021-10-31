<?php

namespace App\Http\Controllers;

use App\Models\DiscordNotification;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function history(Request $request)
    {
        $page = $request->has('page') ? $request->get('page') : 1;
        $count = DiscordNotification::where('id', '>', 0)->count();
        $limit = 30;

        if ($page > ceil($count/$limit)) {
            return redirect('/history?page=1');
        }

        $notifies = DiscordNotification::orderBy('updated_at', 'desc')->limit($limit)->offset(($page - 1) * $limit)->get()->toArray();

        return view('history', [
            'page' => $page,
            'notifies' => $notifies,
            'limit' => $limit,
            'count' => $count,
        ]);
    }
}
