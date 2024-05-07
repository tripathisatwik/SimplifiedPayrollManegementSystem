<?php 
$id = $_POST['id'];
calculate_payroll($id);
function calculate_payroll($id) {
include 'dbconnect.php';
	$am_in = "09:00";
	$pm_out = "17:00";
	mysqli_query($conn, "DELETE FROM payroll_items where payroll_id=" . $id);

	$pay_result = mysqli_query($conn, "SELECT * FROM payroll where id = " . $id);
	$pay = mysqli_fetch_array($pay_result);

	$employee_result = mysqli_query($conn, "SELECT * FROM employee");

	if ($pay['type'] == 1)
		$dm = 22;
	else
		$dm = 11;

	$calc_days = abs(strtotime($pay['date_to'] . " 23:59:59")) - strtotime($pay['date_from'] . " 00:00:00 -1 day");
	$calc_days = floor($calc_days / (60 * 60 * 24));

	$att_result = mysqli_query($conn, "SELECT * FROM attendance where date(datetime_log) between '" . $pay['date_from'] . "' and '" . $pay['date_from'] . "' order by UNIX_TIMESTAMP(datetime_log) asc  ");
	while ($row = mysqli_fetch_array($att_result)) {
		$date = date("Y-m-d", strtotime($row['datetime_log']));
		if ($row['log_type'] == 1) {
			if (!isset($attendance[$row['employee_id'] . "_" . $date]['log'][$row['log_type']]))
				$attendance[$row['employee_id'] . "_" . $date]['log'][$row['log_type']] = $row['datetime_log'];
		} else {
			$attendance[$row['employee_id'] . "_" . $date]['log'][$row['log_type']] = $row['datetime_log'];
		}
	}

	$deductions_result = mysqli_query($conn, "SELECT * FROM employee_deductions where (`type` = '" . $pay['type'] . "' or (date(effective_date) between '" . $pay['date_from'] . "' and '" . $pay['date_from'] . "' ) ) ");
	$allowances_result = mysqli_query($conn, "SELECT * FROM employee_allowances where (`type` = '" . $pay['type'] . "' or (date(effective_date) between '" . $pay['date_from'] . "' and '" . $pay['date_from'] . "' ) ) ");

	while ($row = mysqli_fetch_assoc($deductions_result)) {
		$ded[$row['employee_id']][] = array('did' => $row['deduction_id'], "amount" => $row['amount']);
	}
	while ($row = mysqli_fetch_assoc($allowances_result)) {
		$allow[$row['employee_id']][] = array('aid' => $row['allowance_id'], "amount" => $row['amount']);
	}

	while ($row = mysqli_fetch_assoc($employee_result)) {
		$salary = $row['salary'];
		$daily = $salary / 22;
		$min = (($salary / 22) / 8) / 60;
		$absent = 0;
		$late = 0;
		$dp = 22 / $pay['type'];
		$present = 0;
		$net = 0;
		$allow_amount = 0;
		$ded_amount = 0;

		for ($i = 0; $i < $calc_days; $i++) {
			$dd = date("Y-m-d", strtotime($pay['date_from'] . " +" . $i . " days"));
			$count = 0;
			$p = 0;
			if (isset($attendance[$row['id'] . "_" . $dd]['log']))
				$count = count($attendance[$row['id'] . "_" . $dd]['log']);

			if (isset($attendance[$row['id'] . "_" . $dd]['log'][1])) {
				$att_mn = abs(strtotime($attendance[$row['id'] . "_" . $dd]['log'][2])) - strtotime($attendance[$row['id'] . "_" . $dd]['log'][1]);
				$att_mn = floor($att_mn / 60);
				$net += ($att_mn * $min);
				$late += (240 - $att_mn);
				$present += .5;
			}
		}

		$ded_arr = array();
		$all_arr = array();

		if (isset($allow[$row['id']])) {
			foreach ($allow[$row['id']] as $arow) {
				$all_arr[] = $arow;
				$net += $arow['amount'];
				$allow_amount += $arow['amount'];
			}
		}
		if (isset($ded[$row['id']])) {
			foreach ($ded[$row['id']] as $drow) {
				$ded_arr[] = $drow;
				$net -= $drow['amount'];
				$ded_amount += $drow['amount'];
			}
		}

		$absent = $dp - $present;
		$data = " payroll_id = '" . $pay['id'] . "' ";
		$data .= ", employee_id = '" . $row['id'] . "' ";
		$data .= ", absent = '$absent' ";
		$data .= ", present = '$present' ";
		$data .= ", late = '$late' ";
		$data .= ", salary = '$salary' ";
		$data .= ", allowance_amount = '$allow_amount' ";
		$data .= ", deduction_amount = '$ded_amount' ";
		$data .= ", allowances = '" . json_encode($all_arr) . "' ";
		$data .= ", deductions = '" . json_encode($ded_arr) . "' ";
		$data .= ", net = '$net' ";
		$save[] = mysqli_query($conn, "INSERT INTO payroll_items set " . $data);
	}
    
	if (isset($save)) {
        mysqli_query($conn, "UPDATE payroll set status = 1 where id = " . $pay['id']);
		return 1;
	}
    // echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
}
?>
