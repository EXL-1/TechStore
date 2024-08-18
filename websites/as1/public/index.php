<?php 
session_start();
session_regenerate_id(true);
require '../autoload.php';

$routes = new \techstore\Routes();
$contents = new \techstore\Content();

$entryPoint = new \Framework\EntryPoint($routes);
$contents = $contents->fetchData();
$entryPoint->run($contents);