<?php
require(getenv("DOCUMENT_ROOT")."/inc/include.php");
//verwerking Data van home.php Login Form

//LOGIN CONFIG

if(isset($_POST['btn-login']))
{
$session = new Session();
$db = new db;
       // convert username and password from _GET to _SESSION

    $hash = new PasswordStorage;
    $username = $_POST["username"];
    $username = addslashes($username);
	$pass = $_POST["password"];
    $pass = addslashes ($pass);
$arr = array(
    ":username" => $username,
	);
$result = $db->select("gebruikers","naam=:username","1",$arr,"rowcount");
        if ($result != 0)
            {
				$passhash = $db->select("gebruikers","naam=:username","1",$arr,"fetch");
				$result2 = $hash->verify_password($pass,$passhash['wachtwoord']);					
	if ($result2 != 0)
            {	
			$up = array(
	"wachtwoord" => $hash->create_hash($pass)
				);			
	$db->update("gebruikers",$up,"naam=:username",$arr);
			
	;
	
	$_SESSION['loggedin'] = 1;
	$_SESSION['id'] = $passhash['id'];
	$_SESSION['naam'] = $passhash['naam'];
	$_SESSION['hash'] = $passhash['wachtwoord'];
	$_SESSION['groep'] = $passhash['groep'];
	if ($passhash['rechten'] == '3')
	{
		
		$_SESSION['admin'] = "1";
		$_SESSION['rank'] = "admin";
		$check = "Welkom Admin $_SESSION[naam]";
		echo "1";
	}
	elseif ($passhash['rechten'] == '2')
	{

		$_SESSION['staff'] = "1";
		$_SESSION['rank'] = "staff";
		$check = "Welkom Staff $_SESSION[naam]";
		echo "1";
	}
	elseif ($passhash['rechten'] =='b')
		{
					echo "0";
					$_SESSION['loggedin'] = 0;
		}

	else
	{
		$check = "Welkom Gebruiker $_SESSION[naam]";
		echo "1";
	}

	$_SESSION[ERROR] = "$check";
	}
		 else 
        {
            echo "Niets Gevonden met $username en $pass";
		}		

			}				
else
 {
            echo "gebruiker $username bestaat niet";
 }
 } //Einde verwerking Data van home.php Login Form
 else
 {
	 echo "geen post ?";
 }
 /* CopyRight PowerChaos 2016 */

 ?>