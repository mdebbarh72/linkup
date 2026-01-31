<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->input('q');
        $users = collect();

        if ($query) {
            $users = User::query()
                ->where('email', 'like', "%{$query}%")
                ->orWhereHas('profile', function ($q) use ($query) {
                    $q->where('pseudo', 'like', "%{$query}%");
                })
                ->with('profile') 
                ->get();
        }

        return view('search', [
            'users' => $users,
            'query' => $query
        ]);
    }
}