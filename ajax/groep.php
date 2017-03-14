<?php
require(getenv("DOCUMENT_ROOT")."/inc/include.php");
$waarde = $_POST['waarde'];
if (!empty($waarde))
{
	if ($_POST['del'] == 'delete') //delete groep
	{
		?>
		<form action="../a/groepen" method="POST" class='text-center'>
<input type="hidden" name="groep" value="delgroep">
<input type="hidden" name="id" value="<?php echo$waarde?>">
    <input type="submit" value="Bevestig Verwijdering van groep <?php echo $waarde ?>" class="btn btn-danger">
</form>
<?php		
	}
	
	if ($_POST['del'] == 'eigenaars') //delete eigenaar
	{
		?>
		<form action="../a/groepen" method="POST" class='text-center'>
<input type="hidden" name="groep" value="deleigenaar">
<input type="hidden" name="groepnaam" value="<?php echo $_POST['groep']?>">
<input type="hidden" name="id" value="<?php echo$waarde?>">
    <input type="submit" value="Bevestig Verwijdering eigenaar <?php echo $waarde ?> uit groep id <?php echo $_POST['groep']?>" class="btn btn-danger">
</form>
<?php		
	}
	if ($_POST['del'] == 'gebruikers') //delete gebruiker
	{
		?>
		<form action="../a/groepen"" method="POST" class='text-center'>
<input type="hidden" name="groep" value="delgebruiker">
<input type="hidden" name="groepnaam" value="<?php echo $_POST['groep']?>">
<input type="hidden" name="id" value="<?php echo$waarde?>">
    <input type="submit" value="Bevestig Verwijdering gebruiker <?php echo $waarde ?> uit groep id <?php echo $_POST['groep']?>" class="btn btn-danger">
</form>
<?php		
	}	
if ($_POST['groep'] == 'gebruikers')
{
$db = new db;
$account = $db->select("gebruikers","rechten !='b'");
?>
    <SCRIPT language="javascript"> 
        function addRow(tableID) {
 
            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
 
            var colCount = table.rows[0].cells.length;
 
            for(var i=0; i<colCount; i++) {
 
                var newcell = row.insertCell(i);
 
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                }
            }
        }
    </SCRIPT>
<p class='text-center'> 
  <input type="button" class="btn btn-danger" value="Voeg meer personen toe" onClick="addRow('invoer')" /> 
</p>
<form action="../a/groepen" method="POST" class='text-center'>
<input type="hidden" name="groep" value="addgebruikers">
<input type="hidden" name="gid" value="<?php echo $waarde ?>">
<table border=1 class="table table-striped table-bordered table-hover">
<thead>
<tr>
	<th>Gebruikers</th>
	</tr>
<thead>
<tbody id="invoer">
<tr>						
	<td>
	 <select class="form-control" name="gebruikers[]" id="gebruikers[]">
 <?php
 foreach($account as $class) {
echo "<option value='$class[id]'>$class[naam]</option>";
}
?>
</select>
	</td>
  </tr>
 </tbody>
</table>
    <input type="submit" value="Voeg Toe" class="btn btn-success text-center">
</form>	
	
<?php	
}
if ($_POST['groep'] == 'eigenaars')
{
$db = new db;
$account = $db->select("gebruikers","rechten !='b'");

?>
    <SCRIPT language="javascript"> 
        function addRow(tableID) {
 
            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
 
            var colCount = table.rows[0].cells.length;
 
            for(var i=0; i<colCount; i++) {
 
                var newcell = row.insertCell(i);
 
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                }
            }
        }
    </SCRIPT>
<p class='text-center'> 
  <input type="button" class="btn btn-danger" value="Voeg meer Eigenaars toe" onClick="addRow('invoer')" /> 
</p>
<form action="../a/groepen" method="POST" class='text-center'>
<input type="hidden" name="groep" value="addeigenaars">
<input type="hidden" name="gid" value="<?php echo $waarde ?>">
<table border=1 class="table table-striped table-bordered table-hover">
<thead>
<tr>
	<th>Eigenaars</th>
	</tr>
<thead>
<tbody id="invoer">
<tr>						
	<td>
	 <select class="form-control" name="gebruikers[]" id="gebruikers[]">
 <?php
 foreach($account as $class) {
echo "<option value='$class[id]'>$class[naam]</option>";
}
?>
</select>
	</td>
  </tr>
 </tbody>
</table>
<p class="bg-danger text-center">Je kan maar Eigenaar zijn van 1 Groep</p>
    <input type="submit" value="Voeg Eigenaars Toe" class="btn btn-success text-center">
</form>	
	
<?php	
}
if ($_POST['groep'] == 'toevoegen')
{
?>
    <SCRIPT language="javascript"> 
        function addRow(tableID) {
 
            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
 
            var colCount = table.rows[0].cells.length;
 
            for(var i=0; i<colCount; i++) {
 
                var newcell = row.insertCell(i);
 
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                }
            }
        }
    </SCRIPT>
<p class='text-center'> 
  <input type="button" class="btn btn-danger" value="Voeg meer Groepen toe" onClick="addRow('invoer')" /> 
</p>
<form action="../a/groepen" method="POST" class='text-center'>
<input type="hidden" name="groep" value="addgroep">
<table border=1 class="table table-striped table-bordered table-hover">
<thead>
<tr>
	<th>GroepNaam</th>
	</tr>
<thead>
<tbody id="invoer">
<tr>						
	<td>
	 <input type="text" class="form-control" name="groepen[]" id="groepen[]">
	</td>
  </tr>
 </tbody>
</table>
    <input type="submit" value="Voeg Groep Toe" class="btn btn-success text-center">
</form>	
<?php	
}
if ($_POST['groep'] == 'groepnaam') //eigenaars toevoegen
{
$waarde = $_POST['waarde'];
$db = new db;
$naam = $db->select("groep","id = $waarde","","","fetch");
?>
<form action="../a/groepen" method="POST" class='text-center'>
<input type="hidden" name="groep" value="groepnaam">
<input type="hidden" name="waarde" value="<?php echo $waarde ?>">
<table border=1 class="table table-striped table-bordered table-hover">
<thead>
<tr>
	<th>GroepNaam</th>
	</tr>
<thead>
<tbody id="invoer">
<tr>						
	<td>
	 <input type="text" class="form-control" name="data" id="data" value="<?php echo $naam['naam']?>">
	</td>
  </tr>
 </tbody>
</table>
    <input type="submit" value="Verander GroepNaam" class="btn btn-success text-center">
</form>	
<?php
}
}
?>