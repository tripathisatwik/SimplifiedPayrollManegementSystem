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
if($action == "save_employee"){
	$save = $crud->save_employee();
	if($save)
		echo $save;
}
if($action == "delete_employee"){
	$save = $crud->delete_employee();
	if($save)
		echo $save;
}

if($action == "save_employee_allowance"){
	$save = $crud->save_employee_allowance();
	if($save)
		echo $save;
}
if($action == "delete_employee_allowance"){
	$save = $crud->delete_employee_allowance();
	if($save)
		echo $save;
}

if($action == "save_employee_deduction"){
	$save = $crud->save_employee_deduction();
	if($save)
		echo $save;
}
if($action == "delete_employee_deduction"){
	$save = $crud->delete_employee_deduction();
	if($save)
		echo $save;
}

if($action == "save_employee_attendance"){
	$save = $crud->save_employee_attendance();
	if($save)
		echo $save;
}
if($action == "delete_employee_attendance"){
	$save = $crud->delete_employee_attendance();
	if($save)
		echo $save;
}
if($action == "delete_employee_attendance_single"){
	$save = $crud->delete_employee_attendance_single();
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