<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    //
    public function index()
    {
        return view('organisations.index');
    }
}
