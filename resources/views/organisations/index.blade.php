@extends('layouts.admin')

@section('content')
    <div id="tree"></div>

    <span id="location"></span>

    <script>
       /* $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

       var tree = $('#tree').tree({
           primaryKey: 'id',
           dataSource: '/api/administration/organisations',
           checkboxes: true,
           uiLibrary: 'bootstrap4',
           cascadeCheck: false,
       });

       let [rand, type, organisation_id] = [null, null, null];

        var checkedNodeId = null; // Variable to store the ID of the checked node
        var nodeToUncheck = null; // Variable to store the ID of the node to uncheck

        // Get references to the hidden field and the element to display the checked node's name
        var hiddenNodeIdField = document.getElementById('hiddenNodeId');
        var checkedNodeNameElement = document.getElementById('checkedNodeName');

        let parentId = null; //this is the node ID
        let parentName = null; //this is the node ID
        let recordData = null; //this is the node ID
        let primaryNodeId = null; //this is the node ID
        let nodeName = null; //this is the node name
        let organisationID = null; //this is actual organisation ID
        let organisationType = null; //this is actual organisation type
        let organisationName = null; //this is actual organisation name

        // Get Record ID and record text on checkbox change
        tree.on('checkboxChange', function (e, $node, record, state) {
            if (state === 'checked') {
                recordData = record; // Get the primary ID of the checked node
                primaryNodeId = record.id; // Get the primary ID of the checked node
                nodeName = record.text; // Get the name of the checked node
                parentId = record.parentId; // Get the parent ID of the checked node
                parentName = record.parentName; // Get the parent ID of the checked node
                //split the node record
                [rand, type, organisation_id] = record.id.split('-');

                //organisation details
                organisationID = organisation_id; // Get the actual organisation ID
                organisationType = type; // Get the actual type of record OT or O
                organisationName = nodeName; // Get the actual organisation name


                alert( 'Primary Node ID: (' + primaryNodeId +')' + ' ID: (' + organisationID +')' + ' Type: (' + organisationType +')' + ' Organisation Name: (' + organisationName +')' + ' is ' + state +
                '\nParent ID: (' + parentId +')' + ' Parent Name: (' + parentName +')'
                );

                // Check if there is a previously checked node
                if (nodeToUncheck !== null) {
                    // Uncheck the previously checked node
                    var previousNode = tree.getNodeById(nodeToUncheck);
                    tree.uncheck(previousNode);
                }

                // Store the ID of the new checked node
                checkedNodeId = primaryNodeId;
                // Store the ID of the new node to uncheck
                nodeToUncheck = checkedNodeId;

                // Update the hidden field with the checkedNodeId value
                hiddenNodeIdField.value = checkedNodeId;
                // Update the element to display the checked node's name
                checkedNodeNameElement.textContent = nodeName;
            }
        });

    </script>
@endsection
