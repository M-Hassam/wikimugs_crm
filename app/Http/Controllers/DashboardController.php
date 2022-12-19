<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $roles = auth()->user()->getRoleNames();
        $domains = Domain::all();

        //if($roles->contains('ADMIN')) {
            return view('admin.dashboard')->with('domains', $domains);
        //}
        //if($roles->contains('SALES_ADMIN')) {
            // return view('admin.dashboard')->with('domains', $domains);
        //}

    }
}
