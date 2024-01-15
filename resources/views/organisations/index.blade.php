@extends('layouts.admin')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0" id="page-title">Organisations</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Organisations</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="flex-grow-1">

                                        <a href="" class="btn btn-info add-btn">
                                            <i class="fa fa-refresh"></i> Refresh
                                        </a>
                                        <button id="new-button" class="btn btn-success add-btn">
                                            <i class="fa fa-plus"></i> Add new
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-4">
                        <div class="card">
                            <div class="card-body">
                                <!--start tree-->
                                <div id="tree"></div>
                                <!--end tree-->
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-5">
                        <div class="card border card-border-light">
                            <div class="card-header">
                                <h6 id="card-title" class="card-title mb-0">Add New Organisation</h6>
                                <p style="font-size: 15px;color: red;"><i class="fa fa-arrow-left"></i> Select an
                                    organisation type</p>
                            </div>
                            <div class="card-body">
                                <form id="organisationTypeform" action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Organisation</label>
                                        <input type="text" name="name" class="form-control" id="fieldName"
                                               placeholder="Enter organisation name" value="">
                                    </div>

                                    <!-- Make sure the name attribute matches your database column name -->
                                    <input type="hidden" name="organisation_id" value="" id="parent_id">
                                    <input type="hidden" name="parent_name" value="" id="parent_name">
                                    <input type="hidden" name="organisation_type" value="" id="organisation_type">
                                    <input type="hidden" name="organisation_type_id" value="" id="organisation_type_id">

                                    <div class="text-start">
                                        <button id="submit-button" type="submit" class="btn btn-primary">Add New
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3">
                        <div id="manageOrganisation" class="card border card-border-light">
                            <div class="card-header">
                                <h6 id="card-title" class="card-title mb-0">Manage Organisation</h6>
                            </div>
                            <div class="card-body">

                                <div class="text-start" style="margin-bottom: 10px;">
                                    <button id="submit-button" type="submit" class="btn btn-primary">Organisation
                                        Roles
                                    </button>
                                </div>

                                <div class="text-start" style="margin-bottom: 10px;">
                                    <button id="submit-button" type="submit" class="btn btn-primary">Organisation
                                        Permissions
                                    </button>
                                </div>
                                <div class="text-start" style="margin-bottom: 10px;">
                                    <button id="submit-button" type="submit" class="btn btn-primary">Organisation
                                        Users
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!--end col-->
                    <!--end card-->
                </div>

            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>

    <script>
        $(document).ready(function () {
            var tree = $('#tree').tree({
                primaryKey: 'id',
                dataSource: '/api/admin/organisations',
                checkboxes: true,
                uiLibrary: 'bootstrap4',
                cascadeCheck: false,
            });

            function fetchOrganisation(organisation) {
                $.ajax({
                    url: '/api/admin/organisations/' + organisation + '/edit',
                    type: 'GET',
                    success: function (data) {
                        // Assuming 'data' is the returned object with 'name' and 'description'
                        $('#fieldName').val(data.name); // Set the name
                        $('#fieldDescription').val(data.description); // Set the description
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

            function clearOrganisationTypeFields() {
                $('#fieldName').val(''); // Clears an input field
                $('#fieldDescription').val(''); // Clears an input field
                // Add more fields as needed
            }

            //get the form
            organisationTypeform = $('#organisationTypeform');
            //hide the form
            organisationTypeform.hide();

            let [rand, type, organisation_id] = [null, null, null];

            var checkedNodeId = null; // Variable to store the ID of the checked node
            var nodeToUncheck = null; // Variable to store the ID of the node to uncheck

            // Get references to the hidden field and the element to display the checked node's name
            var hiddenNodeIdField = $('#hiddenNodeId');
            var checkedNodeNameElement = $('#checkedNodeName');

            let parentId = null; // Node ID
            let parentName = null; // Parent Name
            let recordData = null; // Record Data
            let primaryNodeId = null; // Primary Node ID
            let nodeName = null; // Node Name
            let organisationID = null; // Organisation ID
            let organisationType = null; // Organisation Type
            let organisationName = null; // Organisation Name
            let organisationSlug = null; // Organisation Slug

            //form data
            var submitButton = $('#submit-button');
            var cardTitle = $('#card-title');
            var pageTitle = $('#page-title');

            // Get Record ID and record text on checkbox change
            tree.on('checkboxChange', function (e, $node, record, state) {
                if (state === 'checked') {
                    recordData = record;
                    primaryNodeId = record.id;
                    nodeName = record.text;
                    parentId = record.parentId;
                    parentName = record.parentName;

                    // Split the node record
                    [rand, type, organisation_id] = record.id.split('-');

                    // Organisation details
                    organisationID = organisation_id;
                    organisationType = type;
                    organisationName = nodeName;
                    organisationSlug = record.slug;

                    alert('Primary Node ID: (' + primaryNodeId + ')' + ' ID: (' + organisationID + ')' + ' Type: (' + organisationType + ')' + ' Organisation Name: (' + organisationName + ')' + ' Organisation Slug: (' + organisationSlug + ')' + ' is ' + state +
                        '\nParent ID: (' + parentId + ')' + ' Parent Name: (' + parentName + ')');

                    // Update the form action attribute with the new ID
                    cardTitle.text('Add - ' + organisationName);
                    pageTitle.text('Add - ' + organisationName);
                    submitButton.text('Add ' + organisationName + ' New');
                    $('#parent_id').val(parentId);
                    $('#parent_name').val(parentName);
                    $('#organisation_type').val(organisationType);
                    $('#organisation_type_id').val(organisationID);

                    if (organisationType === 'ot') {
                        organisationTypeform.show();
                        $('input[name="_method"]').val('POST');
                        clearOrganisationTypeFields();
                        $('#organisationTypeform').attr('action', '/admin/organisations/store');
                    }

                    if (organisationType === 'o') {
                        organisationTypeform.show();
                        $('#organisationTypeform').attr('action', '/admin/organisations/' + organisationSlug + '/update');
                        $('input[name="_method"]').val('PATCH');
                        submitButton.text('Update ' + organisationName + ' Details');
                        fetchOrganisation(organisationSlug);
                    }

                    // Check if there is a previously checked node
                    if (nodeToUncheck !== null) {
                        var previousNode = tree.getNodeById(nodeToUncheck);
                        tree.uncheck(previousNode);

                        // Update the form action attribute with the new ID
                        cardTitle.text('Add - ' + organisationName);
                        pageTitle.text('Add - ' + organisationName);
                        submitButton.text('Add ' + organisationName + ' New');
                        organisationTypeform.show();
                    }

                    // Store the ID of the new checked node
                    checkedNodeId = primaryNodeId;
                    // Store the ID of the new node to uncheck
                    nodeToUncheck = checkedNodeId;

                    // Update the hidden field with the checkedNodeId value
                    hiddenNodeIdField.val(checkedNodeId);
                    // Update the element to display the checked node's name
                    checkedNodeNameElement.text(nodeName);
                } else if (state === 'unchecked') {
                    // Handling the unchecked node

                    // Reset nodeToUncheck if the unchecked node is the same as nodeToUncheck
                    if (nodeToUncheck === record.id) {
                        nodeToUncheck = null;
                    }

                    cardTitle.text('Add New Organisation');
                    pageTitle.text('Organisation');
                    submitButton.text('Add New');
                    $('#parent_id').val(parentId);
                    $('#parent_name').val(parentName);
                    $('#organisation_type').val(organisationType);
                    $('#organisation_type_id').val(organisationID);
                    organisationTypeform.hide();

                    //alert(record.id + ' is unchecked' + 'node to be unchecked is: ' + nodeToUncheck);
                }
            });
        });
    </script>
@endsection
