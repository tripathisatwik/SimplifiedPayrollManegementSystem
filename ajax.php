<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}

if($action == "save_payroll"){
	$save = $crud->save_payroll();
	if($save)
		echo $save;
}
if($action == "delete_payroll"){
	$save = $crud->delete_payroll();
	if($save)
		echo $save;
}
if($action == "calculate_payroll"){
	$save = $crud->calculate_payroll();
	if($save)
		echo $save;
}