<?php

namespace App\Http\Controllers;

use App\Models\OrganisationType;
use Illuminate\Http\Request;

class OrganisationTypeController extends Controller
{
    //index
    public function index()
    {
        return view('organisation_types.index');
    }

    //store
    public function store()
    {
        //validate the request data
        $validatedData = request()->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);
        //create a new organisation type
        $organisationType = OrganisationType::create($validatedData);

        //redirect to the organisation type index page
        return redirect()->route('admin.organisation-types.index');

    }
    public function organisationTypeOrganisation(OrganisationType $organisationType)
    {

        //validate the request data
        $validatedData = request()->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $newOrganisationType = OrganisationType::create($validatedData);

        // Associate the new OrganisationType as a child of the existing one
        $organisationType->children()->attach($newOrganisationType->id, [
            'notes' => $newOrganisationType->description,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        //redirect to the organisation type index page
        return redirect()->route('admin.organisation-types.index');

    }
}
