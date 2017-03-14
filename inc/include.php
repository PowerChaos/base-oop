<?php
function __autoload($class_name) {
    require_once(getenv("DOCUMENT_ROOT")."/inc/classes/$class_name.class.php");
}
?>