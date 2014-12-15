<?php
session_start();
define('IN_TG',true);
require dirname(__FILE__).'/includes/common.inc.php';
_unsetcookies();
_location(null,'login.php');

?>