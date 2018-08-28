<?php
require_once(__DIR__."/../includes/class.config.php");
require_once(__DIR__."/../includes/class.auth.php");
$auth = Auth::getAuth();
echo $auth->createHashedPassword($_REQUEST['password']);
