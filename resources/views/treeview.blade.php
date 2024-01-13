<html>
<head>
    <meta charset="utf-8" />
    <title>Treeview Example</title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="tree"></div>
<script>
    var tree = $('#tree').tree({
        primaryKey: 'id',
        dataSource: '/api/administration/organization-types',
        width: 300,
        border: true
    });

    /*tree.on('select', function (e, node, id) {
        alert('select is fired for node with id=' + id);
    });*/

</script>
</body>
</html>
