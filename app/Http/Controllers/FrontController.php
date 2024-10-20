<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Services\frontService;
use Illuminate\Http\Request;

class FrontController extends Controller
{

    protected $frontService;

    public function __construct(frontService $frontService)
    {
        $this->frontService = $frontService;
    }

    public function index()
    {
        $data = $this->frontService->getFrontPageData();
        // return $data;
        return view('front.index', $data);
    }
    
    // model binding
    public function details(Ticket $ticket)
    {
        return $ticket;
    }

    public function category(Category $category)
    {
        return $category;
    }
}
