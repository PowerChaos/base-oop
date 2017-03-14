<?php
//Our functions to show the pages and other things, so do not remove
include (getenv("DOCUMENT_ROOT")."/inc/include.php");
//first we include our sesions , else users can not login , so do not remove :D
$session = new Session();
//here you can start your content based on pages , just put your page in /pages/ and call it like /?page=home
$page = new Page;
$page->Showpage($_GET['perm'],$_GET['file'],$_SESSION['rank']);
//Page::Showpage($_GET['perm'],$_GET['file'],$_SESSION['rank']);
/* CopyRight PowerChaos 2016 */
?>