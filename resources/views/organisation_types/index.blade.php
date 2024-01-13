@extends('layouts.admin')

@section('content')
    <div id="tree"></div>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var tree = $('#tree').tree({
            primaryKey: 'id',
            dataSource: '/api/administration/organisation-types',
            checkboxes: true,
            uiLibrary: 'bootstrap4',
            cascadeCheck: false,
        });

        var checkedNodeId = null; // Variable to store the ID of the checked node
        var nodeToUncheck = null; // Variable to store the ID of the node to uncheck

        // Get references to the hidden field and the element to display the checked node's name
        var hiddenNodeIdField = document.getElementById('hiddenNodeId');
        var checkedNodeNameElement = document.getElementById('checkedNodeName');

        //
        // Get Record ID and record text on checkbox change
        tree.on('checkboxChange', function (e, $node, record, state) {
            if (state === 'checked') {

                var primaryId = record.id; // Get the primary ID of the checked node
                var nodeName = record.text; // Get the name of the checked node
                alert('Organisation Type Is: ' + record.text + ' (ID: ' + primaryId + ') is ' + state);

                // Check if there is a previously checked node
                if (nodeToUncheck !== null) {
                    // Uncheck the previously checked node
                    var previousNode = tree.getNodeById(nodeToUncheck);
                    tree.uncheck(previousNode);
                }

                // Store the ID of the new checked node
                checkedNodeId = primaryId;
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
