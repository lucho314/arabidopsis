<html>
<head><title>prueba</title>
<link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery.autocomplete.js">
</script>
<script type="text/javascript">
    $(function()
    {
        // Updated script
        var categories = $.map($("#mySelectId option"),function(e, i)
        {
          return e;
        });

        $("#myTextBoxId").autocomplete(categories,
        {
            formatItem : function(item) { return item.text; }
        });
        // Added to fill hidden field with option value
        $("#myTextBoxId").result(function(event, item, formatted)
        {
            $("#myHiddenField").val(item.value);
        }
    )});
</script>

</head>
<body>
<input type="text" id="myTextBoxId"></input>
<!-- added hidden field to store selection option value -->
<input type="hidden" id="myHiddenField" name="selectedCategory"></input>
<select id="mySelectId" style="display: none">
    <option>Category 1</option>
    <option>Category 2</option>
    <option>...</option>
</select>
</body>
</html>