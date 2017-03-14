<?php
$versie = "1.0.0";
if (Permission::rank('admin'))
{	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/repos/PowerChaos/base-oop/tags');
	$result = curl_exec($ch);
	curl_close($ch);
	///Deocde Json
	$data = json_decode($result,true);
	?>
<?php	foreach ($data as $key => $value)
		{
		if ($value[name] > $versie)
		{			
	echo "<div class='alert alert-danger text-center'>
			<a href='$value[zipball_url]'>Nieuwe Versie $value[name] Beschikbaar</a>
				</div>"; 
		}
			elseif ($value[name] == $versie)
			{			
				echo "<div class='alert alert-success text-center'>
				<a href='$value[zipball_url]'>Laatste Versie $value[name] is Geinstaleerd</a>
				</div>"; 
			}
		}
}
?>	