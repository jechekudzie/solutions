@extends('layouts.admin')

@section('content')


    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0" id="page-title">Organisation Types</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Organisation Types</li>
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

                                        <a href="{{route('admin.organisation-types.index')}}" class="btn btn-info  add-btn">
                                            <i class="fa fa-refresh"></i> Refresh
                                        </a>
                                       {{-- <button id="new-button" class="btn btn-success  add-btn">
                                            <i class="fa fa-plus"></i> Add new
                                        </button>--}}
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
                    <div class="col-xxl-8">
                        <div class="card border card-border-light">
                            <div class="card-header">
                                <h6 id="card-title" class="card-title mb-0">Add New Organisation Type</h6>
                            </div>
                            <div class="card-body">
                                <form id="organisationTypeform" action="/admin/organisation-types/store" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Organisation Type</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                               placeholder="Enter organisation type" value="">
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Describe Organisation Type</label>
                                        <textarea type="text" name="description" class="form-control" id="description"
                                                  placeholder="Describe Organisation Type"></textarea>
                                    </div>
                                    <div class="text-start">
                                        <button id="submit-button" type="submit" class="btn btn-primary">Add New</button>
                                    </div>
                                </form>


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

        $(document).ready(function() {
            // Initialize the tree
            var tree = $('#tree').tree({
                primaryKey: 'id',
                dataSource: '/api/admin/organisation-types',
                checkboxes: true,
                uiLibrary: 'bootstrap4',
                cascadeCheck: false,
            });

            var checkedNodeId = null; // Variable to store the ID of the checked node
            var nodeToUncheck = null; // Variable to store the ID of the node to uncheck

            // Get references to the hidden field and the element to display the checked node's name
            var hiddenNodeIdField = $('#hiddenNodeId');
            var checkedNodeNameElement = $('#checkedNodeName');
            var previousNode = null; // Variable to store the ID of the previously checked node

            let recordData = null; // Record Data
            let primaryNodeId = null; // Primary Node ID
            let nodeName = null; // Node Name
            let organisationTypeName = null; // Organisation slug
            let organisationTypeSlug = null; // Organisation slug

            //form data
            var submitButton = $('#submit-button');
            var cardTitle = $('#card-title');
            var pageTitle = $('#page-title');
            // Get Record ID and record text on checkbox change
            tree.on('checkboxChange', function(e, $node, record, state) {
                if (state === 'checked') {
                    recordData = record;
                    primaryNodeId = record.id;
                    nodeName = record.text;
                    organisationTypeName = nodeName;
                    organisationTypeSlug = record.slug; // Get the name of the checked node

                    //alert('Organisation Type Is: ' + nodeName + ' (ID: ' + primaryNodeId + ') ' + 'Organisation Type Slug:' + organisationTypeSlug + ' is' + state);

                    // Update the form action attribute with the new ID
                    cardTitle.text('Add - ' + organisationTypeName + ' Organisation Type');
                    pageTitle.text('Add - ' + organisationTypeName + ' Organisation Type');
                    submitButton.text('Add ' + organisationTypeName + 'Organisation Type');
                    $('#organisationTypeform').attr('action', '/admin/organisation-types/' + organisationTypeSlug);

                    // Check if there is a previously checked node
                    if (nodeToUncheck !== null) {
                        // Uncheck the previously checked node
                         previousNode = tree.getNodeById(nodeToUncheck);
                        tree.uncheck(previousNode);

                        //clear the form fields
                        $('#name').val('');
                        $('#description').val('');

                        cardTitle.text('Add - ' + organisationTypeName + ' Organisation Type');
                        pageTitle.text('Add - ' + organisationTypeName + ' Organisation Type');
                        submitButton.text('Add ' + organisationTypeName + ' Organisation Type');
                        $('#organisationTypeform').attr('action', '/admin/organisation-types/' + organisationTypeSlug);

                    }

                    // Store the ID of the new checked node
                    checkedNodeId = primaryNodeId;
                    // Store the ID of the new node to uncheck
                    nodeToUncheck = checkedNodeId;

                    // Update the hidden field with the checkedNodeId value
                    hiddenNodeIdField.val(checkedNodeId);
                    // Update the element to display the checked node's name
                    checkedNodeNameElement.text(nodeName);
                }
                else if (state === 'unchecked') {
                    // Handling the unchecked node
                    // Reset nodeToUncheck if the unchecked node is the same as nodeToUncheck
                    if (nodeToUncheck === record.id) {
                        nodeToUncheck = null;
                    }
                    //clear form fields
                    $('#name').val('');
                    $('#description').val('');

                    cardTitle.text('Add New Organisation Type');
                    pageTitle.text('Organisation Types');
                    submitButton.text('Add New');
                    $('#organisationTypeform').attr('action', '/admin/organisation-types/store');
                }


            });
        });


    </script>



@endsection
