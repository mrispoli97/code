<?php

// include classes
foreach(glob(__DIR__ . '/classes/*.php') as $filename){
  include $filename;
}

// get data
$jsonData = new buildData();
$data = $jsonData -> main();

// templating
include 'templates/init.php';
