<?php

require_once "init.php";

$q = $_GET['q']?? '';


$skart = new Flipkart;
$skart->set_url($q);
$data = $skart->collect();
echo $skart->render_json($data);
exit();