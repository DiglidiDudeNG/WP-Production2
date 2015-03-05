<?php

$etape1 = $_GET['etape1'];

var_dump($etape1);

if(!isset($etape1)){
	wp_redirect( home_url() ); exit; 
}




?>