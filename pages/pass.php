<?php echo "<h1>".$_SESSION[ERROR]."</h1>";
$_SESSION[ERROR] ="";
if ($_POST[info] == 'pass')
{
$pass = new Gebruikers;
$pass->ChangePass($_POST['oldpass'],$_POST['newpass'],$_POST['newpass2']);
}	
if (Permission::rank('user')){ //begin user
?>
<form action="" method="post" id='pass' name='pass'>
<input type="hidden" name="info" value="pass" />
  oud Wachtwoord:<br>
  <input class="form-control" type="text" name="oldpass"><br>
  Nieuw Wachtwoord:<br>
  <input class="form-control" type="password" name="newpass"><br>
  Herhaling Nieuw Wachtwoord:<br>
  <input class="form-control" type="password" name="newpass2"><br>
  <input class="btn btn-danger" type="submit" value="Submit">
</form>
<?php
}
else
{
echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/\" />";	
}
?>