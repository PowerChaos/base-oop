<script>
$(document).ready(function() {
$('#example').dataTable( {
  "ajax": {
    "url": "../ajax/ajaxexample.php",
    "type": "POST",
	data:{"groep" : "<?php echo $_SESSION['groep']?>",},
  }
} );
});
</script>
<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>id</th>
                <th>Naam</th>
                <th>Groep</th>
                <th>GroepNaam</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>id</th>
                <th>Naam</th>
                <th>Groep</th>
                <th>GroepNaam</th>
            </tr>
        </tfoot>
    </table>