<?php
class Gebruikers
{	
protected $db;
protected $session;
public function __construct() {
 // start db en Sessie
$this->db = new db;
$this->session = new Session; 
}
	function ChangePass($oldpass="",$newpass="",$newpassret="",$id="")
	{
		$hash = new PasswordStorage;
		$p2= $hash->verify_password($oldpass,$_SESSION["hash"]);
		if (((($p2) AND ($newpass == $newpassret) AND (!empty($newpassret)))) OR (!empty($id)))
		{
		$update = array("wachtwoord" => $hash->create_hash($newpass));
		$bind = array(":uid" => $id?$id:$_SESSION[id]);				
		$this->db->update("gebruikers",$update,"id=:uid",$bind);
		if (empty($id)){
		$_SESSION[hash] = $hash->create_hash($newpass);
		}
		echo "<div class='alert alert-success'>Wachtwoord met succes veranderd</div>";		
		}
		else
		{
		echo "<div class='alert alert-danger text-center'>Wachtwoord komt niet overeen<br>oud wachtwoord: $oldpass<br>nieuw wachtwoord: $newpass <br>Wachtwoord Herhaling: $newpassret</div>";	
		}
	} // einde verwerking password	
	
	//verander Rechten
	function ChangeRechten($waarde,$data)
	{
		if ($waarde > 1)
		{
		$update = array("rechten" => $data);
		$bind = array(":waarde" => $waarde);				
		$this->db->update("gebruikers",$update,"id =:waarde",$bind);
		
		switch ($data) {
		case "3":
			$data = "admin";
			break;
		case "2":
			$data = "staff";        
        break;
		case "b":
			$data = "Geblokeerd";
		break;
		default:
			$data = "gebruiker";
		}
		$_SESSION[ERROR] = "Rechten zijn aangepast naar $data" ;
		}
		else
		{
		$_SESSION[ERROR] = "de rechten van id $waarde kan niet worden veranderd";
		}
	}
	//einde Verander Rechten

	//Verander Naam
	function ChangeName($waarde,$data)
	{
			$bind = array(":data" => $data);
			$tel = $this->db->select("gebruikers","naam = :data","",$bind,"rowcount");
			if ($tel == '1')
			{
				$_SESSION[ERROR] = "Gebruiker $data bestaat al , kies een andere Naam" ;
			}
		else
		{	
		$update = array("naam" => $data);
		$bind = array(":waarde" => $waarde);				
		$this->db->update("gebruikers",$update,"id =:waarde",$bind);
		$_SESSION[ERROR] = "naam is aangepast naar $data" ;
		}
	} 
	//Einde Verander Naam
	
	// Voeg Gebruiker Toe
	function AddUser($data,$naam)
	{
		$hash = NEW PasswordStorage;
		$pass = $hash->create_hash($data);
		$bind = array("naam" => $naam,"wachtwoord" => $pass);				
		$this->db->insert("gebruikers",$bind);
		$_SESSION[ERROR] = "Gebruiker <font color='red'>$naam</font> Toegevoegd met wachtwoord: <font color='red'>$data</font>" ;
	}
		
	
}
?>