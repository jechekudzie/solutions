<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organisation;
use App\Models\OrganisationType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ApiController extends Controller
{
    //
    private $generatedNumbers = [];

    /*
     |--------------------------------------------------------------------------
     | Organisation Types Management Routes
     |--------------------------------------------------------------------------
     */
    public function fetchTemplate()
    {
        $organisations = OrganisationType::whereDoesntHave('parents')->get();
        $data = $this->formatTreeData($organisations);
        return response()->json($data);
    }

    private function formatTreeData($organisations)
    {
        $data = [];

        foreach ($organisations as $organisation) {

            $data[] = [
                'id' => $organisation->id,
                'text' => $organisation->name,
                'slug' => $organisation->slug,
                'children' => $this->formatTreeData($organisation->children),
            ];

        }
        return $data;
    }

    /*
     |--------------------------------------------------------------------------
     | Organisation Management Routes
     |--------------------------------------------------------------------------
     */
    function generateUniqueNumber($min, $max)
    {
        $num = rand($min, $max);
        while (in_array($num, $this->generatedNumbers)) {
            $num = rand($min, $max);
        }
        $this->generatedNumbers[] = $num;
        return $num;
    }
    public function fetchOrganisationInstances()
    {
        $organisations = OrganisationType::whereDoesntHave('parents')->get();
        $data = [];

        foreach ($organisations as $organisation) {
            //random number
            $rand = $this->generateUniqueNumber(1, 1000000);

            $data[] = [
                'id' => $rand . '-ot-' . $organisation->id,
                'text' => $organisation->name,
                'type' => 'organisationType',
                'slug' => $organisation->slug,
                'parentId' => null, // Set parent ID to null for top-level Organisation Types
                'parentName' => null,
                'children' => $this->formatOrganisationTreeData($organisation->organisations()->get()),
            ];
        }

        return response()->json($data);
    }

    private function formatOrganisationTreeData($organisations)
    {
        $data = [];

        foreach ($organisations as $organisation) {
            //random number
            $rand = $this->generateUniqueNumber(1, 1000000);

            if ($organisation instanceof Organisation) {

                //add the organisation id to the organisationType children array elements
                $organisation->organisationType->children->map(function ($item) use ($organisation) {
                    $item->organisation_id = $organisation->id;
                });

                // Assuming $organisation is an instance of Organisation
                $parentOrganisation = $organisation->parentOrganisation; // This will get the parent Organisation

                $data[] = [
                    'id' => $rand . '-o-' . $organisation->id,
                    'text' => $organisation->name,
                    'type' => 'organisation',
                    'slug' => $organisation->slug,
                    'parentId' => $organisation->organisation_id,// Set parent ID to organisation_id for child organisations
                    'parentName' => optional($parentOrganisation)->name,
                    'children' => $this->formatOrganisationTreeData($organisation->organisationType->children),
                ];
            } else {
                // This is presumably an OrganisationType instance
                $parentOrgType = $organisation->parents()->first(); // Retrieve the first parent OrganisationType

                $data[] = [
                    'id' => $rand . '-ot-' . $organisation->id,
                    'text' => $organisation->name,
                    'type' => 'organisationType',
                    'slug' => $organisation->slug,
                    'parentId' => $parentOrgType ? $rand . '-ot-' . $parentOrgType->id : null, // Use parent OrganisationType ID if available
                    'parentName' => $parentOrgType ? $parentOrgType->name : null,
                    'children' => $this->formatOrganisationTreeData($organisation->organisations()->where('organisation_id', $organisation->organisation_id)->get()),
                ];
            }
        }
        return $data;
    }

    //fetchOrganisation via API
    public function fetchOrganisation(Organisation $organisation){
        //return json response
        return response()->json($organisation);
    }



}
