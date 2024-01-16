<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\OrganisationType;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    //
    public function index()
    {
        return view('organisations.index');
    }

    //store organisation of organisation
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'organisation_type_id' => 'required|exists:organisation_types,id',
            // other fields to validate
        ]);

        $organisation = Organisation::create($validatedData);

        // Find parent OrganisationType
        $organisationType = OrganisationType::find($validatedData['organisation_type_id']);
        $parentOrganisationType = $organisationType->parents()->first();
        if ($parentOrganisationType) {
            $parentOrganisation = Organisation::where('organisation_type_id', $parentOrganisationType->id)->first();
            if ($parentOrganisation) {
                $organisation->organisation_id = $parentOrganisation->id;
            }
        }
        $organisation->save();

        return redirect()->route('admin.organisations.index')->with('success', 'Organisation created successfully');
    }

    public function update(Organisation $organisation)
    {
        $data = request()->validate([
            'name' => 'required',
        ]);

        $organisation->update($data);
        return redirect()->route('admin.organisations.index')->with('success', 'Organisation created successfully');
    }


}
