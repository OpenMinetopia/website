<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'instances' => auth()->user()->instances()->latest()->get()
        ]);
    }
} 