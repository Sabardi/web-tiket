<?php

namespace App\Http\Controllers;

// use App\Models\Category;
// use App\Models\Ticket;
use Illuminate\Http\Request;

class FrontController extends Controller
{

    // konsep mvcp
    // public function index()
    // {
    //     $categories = Category::latest()->get();
    //     $popular_tickets = Ticket::where('is_popular', true)->take(4)->get();
    //     $new_tickets = Ticket::latest()->get();
    //     return view('front.index', compact('categories', 'popular_tickets', 'new_tickets'));
    // }
}
