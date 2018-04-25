<?php

require_once "init.php";

$q = "iphone";
$skart = new Flipkart;
$skart->set_url($q);
$data = $skart->collect();
echo $skart->render_json($data);

exit();


$q = "bag";
$skart = new Flipkart;
$skart->set_url($q);
$skart->file_find_query();

exit();

