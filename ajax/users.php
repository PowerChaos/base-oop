<?php
require(getenv("DOCUMENT_ROOT")."/inc/include.php");
$session = new Session;
if ($_POST['bewerk'] == "blokeer")
{
	$id = $_POST['id'];
	if ($id > 1)
	{
	$update = array("rechten" => "b");
	$bind = array(":id" => $id);
	$db = new db;	
	$db->update("gebruikers",$update,"id =:id",$bind);
	$_SESSION[ERROR] = "Gebruiker $id successvol geblokeerd";
	}	
else
{
$_SESSION[ERROR] = "Gebruiker $id kan niet worden geblokeerd Voor Veiligheid";
}			
}
if ($_POST['bewerk'] == "deblokeer")
{
	$id = $_POST['id'];
	if ($id > 1)
	{
	$update = array("rechten" => "0");
	$bind = array(":id" => $id);
	$db = new db;	
	$db->update("gebruikers",$update,"id =:id",$bind);
	
$_SESSION[ERROR] = "Gebruiker $id successvol geDeblokeerd";		
}
else
{
$_SESSION[ERROR] = "Gebruiker $id kan niet worden gedeblokeerd Voor Veiligheid";
}
}
if ($_POST['bewerk'] == "delete")
{
	$id = $_POST['id'];
	if ($id > 1)
	{
	$bind = array(":id" => $id);
	$db = new db;	
	$db->delete("gebruikers","id =:id",$bind);
	
$_SESSION[ERROR] = "Gebruiker $id successvol verwijderd";		
}
else
{
$_SESSION[ERROR] = "Gebruiker $id kan niet worden verwijderd Voor Veiligheid";
}
}	
?>
<script>
function werkbij(val,dat) {
	$.ajax({
	type: "POST",
	url: "../ajax/users.php",
	data:'bewerk='+dat+'&id='+val,
	success: function(data){
	//alert(dat+" Succesvol uitgevoerd");
	window.location.reload();
	}
	});
}
</script>
<?php
if ($_POST['groep'] == "blokeer")
{
?>
<table border=1 class="table table-striped table-bordered table-hover">
<thead>
<tr>
    <th><center>Blokeer <font color='red'>id <?php echo $_POST['waarde'];?></font></center></th>
	</tr>
</thead>
<tbody>	
<tr class='info'>
<td><center><button TYPE="submit" class='btn btn-danger' VALUE="blokeer" id="<?php echo $_POST['waarde']; ?>" onclick="werkbij(this.id,'blokeer');"><i class='material-icons' title='Blokeer' aria-hidden='true'>lock</i><span class="sr-only">Blokeer</span></button></center></td>
</tr>
</tbody>
</table>
<br>
<?php
}
elseif ($_POST['groep'] == "deblokeer")
{
?>
<table border=1 class="table table-striped table-bordered table-hover">
<thead>
<tr>
    <th><center>deBlokeer <font color='red'>id <?php echo $_POST['waarde'];?></font></center></th>
	</tr>
</thead>
<tbody>	
<tr class='info'>
<td><center><button TYPE="submit" class='btn btn-success' VALUE="deblokeer" id="<?php echo $_POST['waarde']; ?>" onclick="werkbij(this.id,'deblokeer');"><i class='material-icons' title='deBlokeer' aria-hidden='true'>lock_open</i><span class="sr-only">deBlokeer</span></button></center></td>
</tr>
</tbody>
</table>
<br>
<?php
}
elseif ($_POST['groep'] == "verwijder")
{
?>
<table border=1 class="table table-striped table-bordered table-hover">
<thead>
<tr>
    <th><center>verwijder <font color='red'>id <?php echo $_POST['waarde'];?></font></center></th>
	</tr>
</thead>
<tbody>	
<tr class='info'>
<td><center><button TYPE="submit" class='btn btn-danger' VALUE="delete" id="<?php echo $_POST['waarde']; ?>" onclick="werkbij(this.id,'delete');"><i class='material-icons' title='verwijder' aria-hidden='true'>delete_forever</i><span class="sr-only">verwijder</span></button></center></td>
</tr>
</tbody>
</table>
<br>
<?php
}
elseif ($_POST['groep'] == "rechten")
{
?>
<form action="../a/gebruikers" method="POST" class='text-center'>
<input type="hidden" name="users" value="rechten">
<input type="hidden" name="id" value="<?php echo $_POST['waarde'] ?>">
<table border=1 class="table table-striped table-bordered table-hover text-center">
<thead>
<tr>
	<th><center>Pas Rechten aan voor <font color='red'>id <?php echo $_POST['waarde'];?></font></center></th>
	</tr>
<thead>
<tbody>
<tr>						
	<td>
	 <select class="form-control" name="rechten" id="rechten">
<option value='0'>Gebruiker</option>
<option value='2'>Staff</option>
<option value='3'>Admin</option>
<option value='b'>Geblokeerd</option>
</select>
	</td>
  </tr>
 </tbody>
</table>
<button TYPE="submit" class='btn btn-success' VALUE="rechten aanpassen"><i class='material-icons' title='Rechten aanpassen' aria-hidden='true'>verified_user</i><span class="sr-only">Pas rechten aan</span></button>
</form>	
<br>
<?php
}
elseif ($_POST['groep'] == "hernoem")
{
	$bind = array(":pn" => $_POST['waarde']);
	$db = new db;	
	$account = $db->select("gebruikers","id =:pn","",$bind,"fetch");
?>
<form action="../a/gebruikers" method="POST" class='text-center'>
<input type="hidden" name="users" value="hernoem">
<input type="hidden" name="id" value="<?php echo $_POST['waarde'] ?>">
<table border=1 class="table table-striped table-bordered table-hover text-center">
<thead>
<tr>
	<th><center>Pas Naam aan voor <font color='red'><?php echo $account['naam'];?></font></center></th>
	</tr>
<thead>
<tbody>
<tr>						
	<td>
<input type="text" name="naam" value='<?php echo $account['naam'];?>'><br>
	</td>
  </tr>
 </tbody>
</table>
<button TYPE="submit" class='btn btn-success' VALUE="naam aanpassen"><i class='material-icons' title='Rechten aanpassen' aria-hidden='true'>verified_user</i><span class="sr-only">Pas naam aan</span></button>
</form>	
<br>
<?php
}
elseif ($_POST['groep'] == "toevoegen")
{
?>
<form action="../a/gebruikers" method="POST" class='text-center'>
<input type="hidden" name="users" value="toevoegen">
<table border=1 class="table table-striped table-bordered table-hover text-center">
<thead>
<tr>
	<th><center>Gebruikers Naam</center></th>
	<th><center>wachtwoord</center></th>
	</tr>
<thead>
<tbody>
<tr>						
	<td>
<input type="text" name="naam" value='Naam Gebruiker' onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Naam Gebruiker';}"><br>
	</td>
<td>
<input type="text" name="wachtwoord" value='Nieuw Wachtwoord' onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Wachtwoord';}">
</td>	
  </tr>
 </tbody>
</table>
<button TYPE="submit" class='btn btn-success' VALUE="Toevoegen"><i class='material-icons' title='Rechten aanpassen' aria-hidden='true'>verified_user</i><span class="sr-only">Toevoegen</span></button>
</form>	
<br>
<?php
}
elseif ($_POST['groep'] == "wachtwoord")
{
?>
<form action="../a/gebruikers" method="POST" class='text-center'>
<input type="hidden" name="users" value="wachtwoord">
<input type="hidden" name="id" value='<?php echo $_POST['waarde']?>'>
<table border=1 class="table table-striped table-bordered table-hover text-center">
<thead>
<tr>
	<th><center>Nieuw Wachtwoord voor <font color='red'>id <?php echo $_POST['waarde']?></font></center></th>
	</tr>
<thead>
<tbody>
<tr>						
	<td>
<input type="text" name="wachtwoord" value='Nieuw Wachtwoord' onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Nieuw Wachtwoord';}">
	</td>	
  </tr>
 </tbody>
</table>
<button TYPE="submit" class='btn btn-success' VALUE="Verander"><i class='material-icons' title='Nieuw Wachtwoord' aria-hidden='true'>vpn_key</i><span class="sr-only">Verander</span></button>
</form>	
<br>
<?php
}
/* CopyRight PowerChaos 2016 */
?>