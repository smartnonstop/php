<?php


$file = (isset($_GET['file']))? htmlspecialchars($_GET['file']) : die('ERROR');

$do = unlink($file);

