<?php

require_once('controller/MasterController.php');

setlocale(LC_ALL, "sv_SE", "sv_SE.utf-8", "sv", "swedish");

session_start();

$start = new \controller\MasterController();
$start->applicationRouter();
?>