<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganisationTypeController extends Controller
{
    //index
    public function index()
    {
        return view('organisation_types.index');
    }
}
