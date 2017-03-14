<?php
class Page {
private $info;
private $file;
private $perm;
private $page;
private $rank;
private $show;

 public function __construct() {
 // start db en Sessie
$this->session = new Session; 
	}

protected function Template($info)
{
include (getenv("DOCUMENT_ROOT")."/template/boot/$info.php");
}

public function Showpage($perm,$page,$rank=Null)
{	
	switch ($perm)
	{	
	case "admin":
		if ($rank == 'admin')
		{
		$file = getenv("DOCUMENT_ROOT")."/pages/admin/".$page.".php";
		break;
		}
		else
		{
		goto home;
			break;
		}	
	case "staff":
		if (($rank == 'admin') OR ($rank == 'staff'))
		{
		$file = getenv("DOCUMENT_ROOT")."/pages/staff/".$page.".php";
		break;
		}
		else
		{
		goto home;
			break;
		}
	case 'logout':
	session_destroy();
	return header("Refresh:0; url=../?logout=success");
	break;
	default:
		home:
		$file = getenv("DOCUMENT_ROOT")."/pages/".$page.".php";
		break;
	}
if (file_exists($file))
{
//here we show the header , feel free to adjust to fit your own template (pages/template/)
$this->Template("header");
//my sidebar , depending on template you need it or not ( pages/template/)
$this->Template("sidebar");
include ("$file");
//Here is the footer -> read the footer.php file in "/pages/template/"
$this->Template("footer");
}
else
{	
//here we show the header , feel free to adjust to fit your own template (pages/template/)
$this->Template("header");
//my sidebar , depending on template you need it or not ( pages/template/)
$this->Template("sidebar");
include (getenv("DOCUMENT_ROOT")."/pages/home.php");
$this->Template("footer");
}
}
}
/* CopyRight PowerChaos 2016 */
?>