<?php
if (Permission::rank('admin')){
	if ($_POST['groep'])
	{
		$groep = new Groepen;
		switch($_POST['groep'])
		{
			case "addgebruikers":
				$groep->AddGebruikers($_POST['gid'],$_POST['gebruikers']);
				break;
			case "addeigenaars":
				$groep->AddEigenaars($_POST['gid'],$_POST['gebruikers']);
				break;
			case "addgroep":
				$groep->AddGroep($_POST['groepen']);
				break;
			case "delgroep":
				$groep->DelGroep($_POST['id']);
				break;
			case "deleigenaar":
				$groep->DelEigenaar($_POST['id'],$_POST['groepnaam']);
				break;	
			case "delgebruiker":
				$groep->DelGebruiker($_POST['id'],$_POST['groepnaam']);
				break;
			case "groepnaam":
				$groep->GroepNaam($_POST['waarde'],$_POST['data']);
				break;
			}
	}

	
	
echo "<h1>".$_SESSION[ERROR]."</h1>";
$_SESSION[ERROR] ="";
$db = new db;
$result = $db->select("groep");
?>
<script type="text/javascript" class="init">
$(document).ready(function() {
 $('table.table').DataTable( {
	aaSorting: []	
    } );	
} );
function groep(val, dat) {
	$.ajax({
	type: "POST",
	url: "../ajax/groep.php",
	data:'waarde='+val+'&groep='+dat,
	success: function(data){
		//alert(data);
		//alert ("groep: " +dat+ " en waarde: " +val);
		$("#modal").modal('show');
		$("#modalcode").html(data);
		
	}
	});
}
function del(val, dat, groep) {
	$.ajax({
	type: "POST",
	url: "../ajax/groep.php",
	data:'waarde='+val+'&del='+dat+'&groep='+groep,
	success: function(data){
		//alert(data);
		//alert ("del: " +dat+ " en waarde: " +val+ " en groep: " +groep);
		$("#modal").modal('show');
		$("#modalcode").html(data);
		
	}
	});
}
</script>
<button type="button" class="btn-lg btn-primary text-center" data-toggle="modal" data-target="#modal" id="groep" onclick="groep(this.id,'toevoegen');"><i class="material-icons" title="Groep Toevoegen" aria-hidden="true">group_add</i><span class="sr-only">Groep Toevoegen</span></button>
<br><br><table border=1 id='groep' class="table table-striped table-bordered table-hover">
  <thead>
  <tr>	
	<td>Gid</td>
	<td>Groep</td>
	<td>Eigenaars</td>
	<td>Gebruikers</td>
	</tr>
</thead>
<tbody>	
<?php
foreach($result as $info) {
$str = Groepen::Splitter($info[user]);
sort($str);
$count = count($str); 
echo "<tr><td class=warning ><a href='#' data-toggle='modal' data-target='#modal' id='$info[id]' onclick='del(this.id,\"delete\");'>  <i class='fa fa-trash-o' title='Verwijder Groep' aria-hidden='true'></i><span class='sr-only'>Verwijder Groep</span></a> $info[id]</td>";
$groep = $db->select("gebruikers","groep=$info[id]");
echo "<td class='danger'>$info[naam] <a href='#' data-toggle='modal' data-target='#modal' id='$info[id]' onclick='groep(this.id,\"groepnaam\");'><i class='fa fa-pencil-square-o' title='Verander GroepsNaam' aria-hidden='true'></i><span class='sr-only'>Verander Groepsnaam</span></a></td><td class=info>";
if (!empty($groep))
{
foreach($groep as $class) {
echo " $class[naam] <a href='#' data-toggle='modal' data-target='#modal' id='$class[id]' onclick='del(this.id,\"eigenaars\",\"$info[id]\");'><i class='fa fa-times' title='Verwijder Eigenaar' aria-hidden='true'></i><span class='sr-only'>Verwijder eigenaar</span></a> (<font color=red>$class[id]</font>)&nbsp";
}
echo "<a href='#' data-toggle='modal' data-target='#modal' id='$info[id]' onclick='groep(this.id,\"eigenaars\");'><i class='fa fa-user-plus' title='Voeg Eigenaar toe' aria-hidden='true'></i><span class='sr-only'>Voeg Eigenaar Toe</span></a>";
}
else
{
	echo"Geen Eigenaars <a href='#' data-toggle='modal' data-target='#modal' id='$info[id]' onclick='groep(this.id,\"eigenaars\");'><i class='fa fa-user-plus' title='Voeg Eigenaar toe' aria-hidden='true'></i><span class='sr-only'>Voeg Eigenaar Toe</span></a>";
}
echo "</td><td class=success>";
if (!empty($str))
{
for($i=0;$i < $count;$i++){
$gebruikers = $db->select("gebruikers","id=$str[$i]","","","fetch");
echo "$gebruikers[naam] <a href='#' data-toggle='modal' data-target='#modal' id='$gebruikers[id]' onclick='del(this.id,\"gebruikers\",\"$info[id]\");'><i class='fa fa-times' title='Verwijder Persoon' aria-hidden='true'></i><span class='sr-only'>Verwijder Persoon</span></a> (<font color=red>$gebruikers[id]</font>) &nbsp";
}
echo "<a href='#' data-toggle='modal' data-target='#modal' id='$info[id]' onclick='groep(this.id,\"gebruikers\");'><i class='fa fa-user-plus' title='Voeg Persoon toe' aria-hidden='true'></i><span class='sr-only'>Voeg Persoon Toe</span></a>";
}
else
{
	echo "Geen Gebruikers <a href='#' data-toggle='modal' data-target='#modal' id='$info[id]' onclick='groep(this.id,\"gebruikers\");'>  <i class='fa fa-user-plus' title='Voeg Persoon toe' aria-hidden='true'></i><span class='sr-only'>Voeg Persoon Toe</span></a>";
}
echo "</td></tr>";
}
echo "</tbody></table>";
}
?>