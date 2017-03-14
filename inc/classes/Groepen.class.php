<?php
class Groepen
{	
protected $db;
protected $session;
public function __construct() {
 // start db en Sessie
$this->db = new db;
$this->session = new Session; 
}
	static function Splitter($string, $separator = ',')
	{
	//Explode on comma
	$vals = explode($separator, $string);

	//Trim whitespace
	$vals = array_map("trim", $vals);

	//Return empty array if no items found
	//http://php.net/manual/en/function.explode.php#114273
	return array_diff($vals, array(""));
	}

	function AddGebruikers($id,$gebruikers) // Voeg gebruikers toe aan groep
	{
		foreach($gebruikers as $a => $b)
		{
			$users = $this->db->select('groep',"id = {$id}",'','','fetch','user');
			if (!empty($users['user']))
			{
				$str = self::Splitter($users['user']);
				sort($str);
				if (!in_array($gebruikers[$a], $str)) {
					$gebruikers[$a] = $users['user'].','.$gebruikers[$a];
				}
				else
				{
					$gebruikers[$a] = $users['user'];	
				}
			}
		$update = array("user" => $gebruikers[$a]);
		$bind = array(":uid" => $id);				
		$this->db->update("groep",$update,"id=:uid",$bind);
		}
		$_SESSION[ERROR] .= "Gebruikers met id $gebruikers[$a] successvol toegevoegt aan groep $id<br>" ;
	} // Einde Gebruikers Groep
	
	function AddEigenaars($id,$gebruikers) // Voeg eigenaar toe aan groep
	{
		foreach($gebruikers as $a => $b)
		{
			$users = $this->db->select('gebruikers',"id = {$gebruikers[$a]}",'','','fetch');
				if (!empty($users['groep']))
				{
				$_SESSION[ERROR] .= "Gebruiker $users[naam] zit al in groep id $users[groep]<br>" ;
				}
				else
				{
					$update = array("groep" => $id);
					$bind = array(":id" => $gebruikers[$a]);				
				$this->db->update("gebruikers",$update,"id=:id",$bind);
				$_SESSION[ERROR] .= "Gebruiker $users[naam] successvol toegevoegt aan groep $id <br>" ;
				}
		}
	} // Einde Eigenaars Groep
	
	function AddGroep($gebruikers) // groep Toevoegen
	{
		foreach($gebruikers as $a => $b)
		{
		$update = array("naam" => $gebruikers[$a]);			
		$this->db->insert("groep",$update);
		$_SESSION[ERROR] .= "Groep $gebruikers[$a] Succesvol Toegevoegd<br>";
		}
	} // Einde Groep Toevoegen
	
	function DelGroep($id) // groep verwijderen
	{
		$bind = array(":id" => $id);			
		$this->db->delete("groep","id = :id",$bind);
		$_SESSION[ERROR] = "Groep id $id Succesvol verwijderd<br>";
	} // Einde Groep verwijderen
	
	function DelEigenaar($id,$groep) // eigenaar uit groep verwijderen
	{
		$update = array("groep" => '');
		$bind = array(":id" => $id);				
		$this->db->update("gebruikers",$update,"id=:id",$bind);
		$_SESSION[ERROR] = "Eigenaar id $id is uit groep id $groep verwijderd" ;
	} // Einde eigenaar uit Groep verwijderen
	
	function DelGebruiker($id,$groep) // gebruiker uit groep verwijderen
	{			
		$result = $this->db->select("groep","id=$groep","","","fetch");
			$str = self::Splitter($result['user']);
			sort($str);
			if(($key = array_search($id, $str)) !== false) {
			unset($str[$key]);
			}
		$name = implode(",",$str);
		$update = array("user" => $name);
		$bind = array(":groep" => $groep);		
		$this->db->update("groep",$update,"id=:groep",$bind);
		$_SESSION[ERROR] = "Gebruiker id $id is uit groep id $groep verwijderd" ;
	} // Einde gebruiker uit Groep verwijderen

		function GroepNaam($groep,$naam) // Verander Groep Naam
	{
		$update = array("naam" => $naam);
		$bind = array(":id" => $groep);				
		$this->db->update("groep",$update,"id=:id",$bind);
		$_SESSION[ERROR] = "Groepsnaam is aangepast naar $naam" ;
	} // Einde Verander Groep Naam
	
} // Einde Class
?>