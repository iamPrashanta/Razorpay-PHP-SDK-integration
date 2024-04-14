<?php
define('APP_NAME', "My Website");
define('web_source', "website");

define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT']);

//database connctions
define('_CONN', DOC_ROOT . "/_connect.php");
// SUB - Vendor Autoload
define('DOC_ROOT_AUTOLOAD', DOC_ROOT  . "/vendor/autoload.php");
