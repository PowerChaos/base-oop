<?php
class Permission{
	protected $rank;
	protected $groep;
	
	static function rank($rank)
	{
		switch ($rank)
		{
			case "user":
		return $_SESSION['loggedin'] == 1;
		break;
			case "admin":
		return $_SESSION['admin'] == 1;
		break;
			case "staff":
			if ($_SESSION['admin'] == 1 || $_SESSION['staff'] == 1 )
				return true;
			break;
		}
	}
	
	static function groep($groep)
	{
		switch ($groep)
		{
			case "user":
		return $_SESSION['loggedin'] == 1;
		break;
			case "admin":
		return $_SESSION['admin'] == 1;
		break;
			case "staff":
			if ($_SESSION['admin'] == 1 || $_SESSION['staff'] == 1 )
				return true;
			break;
		}
	}
	
}	