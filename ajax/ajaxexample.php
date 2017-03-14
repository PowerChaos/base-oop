<?php
require(getenv("DOCUMENT_ROOT")."/inc/include.php");
$out = array();
if ($_POST['groep'] >='1')
{
	$db = new db();
	$groep = $_POST['groep'];
	$arr = array(":groep" => $groep);
	$result = $db->select("groep", "id=:groep","", $arr);
	$grcount = $db->select("groep", "id=:groep","", $arr, "rowcount");
		if ($grcount > "0" )
		{
			foreach($result as $info) {
				$str = Groepen::Splitter($info['user']);
				sort($str);
				$tel = count($str);
				if (!empty($str))
				{
					for($i=0;$i < $tel;$i++){
						$value = $str[$i];
							$arr = array(":gebruiker" => "$value");
							$resultg = $db->select("gebruikers", "id=:gebruiker","",$arr, "fetch");		
						$out[] = array($resultg['id'],$resultg['naam'],$info['id'],$info['naam']);										
					}	
				}
			}
		} // Geen Groep
}//end if		
else
{
	$out[] = array("Geen id","Geen Naam","Geen Groep ID","Geen Groep Naam");
}//end else		
	$out2[data] = $out; 
	// output to the browser
	echo json_encode($out2);			
	?>