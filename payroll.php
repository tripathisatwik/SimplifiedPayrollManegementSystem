<?php include 'dbconnect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Payroll</title>
	<link rel="stylesheet" href="style.css">
	<style>
		.action-buttons button,
		form {
			display: inline-block;
			vertical-align: middle;
		}
	</style>
	<script>
		function reset() {
			$('#manage-payroll').get(0).reset();
		}

		function confirmDelete() {
			return confirm("Are you sure you want to delete this record?");
		}

		$(document).ready(function() {
			$('button[data-id]').click(function() {
				start_load();
				var cat = $('#manage-payroll');
				cat.get(0).reset();
				cat.find("[name='id']").val($(this).attr('data-id'));
				cat.find("[name='datefrom']").val($(this).attr('data-datefrom'));
				cat.find("[name='dateto']").val($(this).attr('data-dateto'));
				cat.find("[name='type']").val($(this).attr('data-type'));
				end_load();
			});
		});

		function validateDate() {
			var fromDate = document.getElementsByName('datefrom')[0].value;
			var toDate = document.getElementsByName('dateto')[0].value;
			var currentDate = new Date().toISOString().split('T')[0];

			if (fromDate > currentDate || toDate > currentDate) {
				alert("Please select only past dates.");
				return false;
			}
			return true;
		}
	</script>
</head>

<body>
	<div class="depmain">
		<div class="depleft">
			<form action="http://localhost/final/index.php?page=payroll" method="post" id="manage-payroll" onsubmit="return validateDate()">
				<div class="depleftup">Payroll</div>
				<div class="depleftmid">
					<div>
						<input type="hidden" name="id">
						<label>Date Form:</label><br>
						<input type="date" name="datefrom" required>
						<label>Date To:</label><br>
						<input type="date" name="dateto" required>
						<label>Type:</label><br>
						<select name="type" id="">
							<option value="1">Monthly</option>
							<option value="2">Semi-Monthly</option>
						</select>
					</div>
				</div>
				<div class="depleftdown">
					<input type="submit" name="submit" value="Submit">
					<button type="button" onclick="reset()">Cancel</button>
				</div>
			</form>
		</div>
		<div class="depright">
			<table>
				<tr>
					<th>Reference No</th>
					<th>Date From</th>
					<th>Date To</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php
				$sql = "select * from payroll";
				$result = mysqli_query($conn, $sql);
				$num = mysqli_num_rows($result);
				$sno = 1;
				if ($num > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td>" . $row['ref_no'] . "</td>";
						echo "<td>" . $row['date_from'] . "</td>";
						echo "<td>" . $row['date_to'] . "</td>";
						echo "<td class='text-center'>";
						if ($row['status'] == 0) {
							echo "<img src='./icons/new.png' alt='new' style='height:20px; width: 60px;'>";
						} else if ($row['status'] == 1) {
							echo "<img src='./icons/calculated.png' alt='calculated' style='height:25px; width: 60px;'>";
						};
						echo "</td>";
						echo "<td class='action-buttons'>";
						$p_id = $row['id'];
						if ($row['status'] == 0) {
							echo "<button><img src='./icons/accounting.png' alt='Calculate'>" . calculate_payroll($p_id, $conn) . "</button>";
						} else if ($row['status'] == 1) {
							echo "<button><a href='http://localhost/final/index.php?page=payroll_items'><img src='./icons/watch.png' alt='View'>";
							$_SESSION["payroll"] = $p_id;
							echo "</a></button>";
						};
				?>
						<button type="button" data-id="<?php echo $row['id']; ?>" data-datefrom="<?php echo $row['date_from'] ?>" data-dateto="<?php echo $row['date_to']; ?>" data-type="<?php echo $row['type']; ?>"><img src="./icons/editing-modified.png" alt="Edit"></button>
						<form method="post" onsubmit="return confirmDelete()">
							<input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
							<button type="submit" name="delete"><img src="./icons/delete-modified.png" alt="Delete"></button>
						</form>
						</td>
						</tr>
				<?php
					}
				}
				?>
			</table>
		</div>
	</div>

</body>


</html>

<?php
if (isset($_POST['submit'])) {
	if (empty($_POST['datefrom']) || empty($_POST['dateto']) || empty($_POST['type'])) {
		echo '<script>alert("All fields are required")</script>';
		echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
		exit();
	}

	$edit_id = $_POST['id'];
	$refno = date('Y') .'-'. mt_rand(1,9999);
	$date_from = $_POST['datefrom'];
	$date_to = $_POST['dateto'];
	$type = $_POST["type"];
	$datenow = date("Y-m-d H:i", time());

	if ($type == 2) {
		$expectedDateTo = date('Y-m-d', strtotime($date_from . ' +15 days'));
		if ($date_to != $expectedDateTo) {
			echo '<script>alert("For Semi-Monthly, Date To should be exactly 15 days greater than Date From")</script>';
			echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
			exit();
		}
	} elseif ($type == 1) {
		$daysInMonth = date('t', strtotime($date_from))-1;
		$expectedDateTo = date('Y-m-d', strtotime($date_from . ' +' . $daysInMonth . ' days'));
		if ($date_to != $expectedDateTo) {
			echo '<script>alert("For Monthly, Date To should be exactly ' . $daysInMonth . ' days greater than Date From")</script>';
			echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
			exit();
		}
	}
	

	if (empty($date_to) || empty($date_from) || empty($type)) {
		echo '<script>alert("All fields are required")</script>';
		echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
	} else {
		$sql = "select * from payroll  where id='$edit_id'";
		$result = mysqli_query($conn, $sql);
		$num = mysqli_num_rows($result);
		if ($num > 0) {
			$sql_update = "UPDATE `payroll` SET `date_from`='$date_from',`date_to`='$date_to',`type`='$type',`status`='0' WHERE id='$edit_id' ";
			$result_update = mysqli_query($conn, $sql_update);
			if ($result_update) {
				echo '<script>alert("Allowance Data Updated")</script>';
				echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
			}
		} else {
			$sql_insert = "INSERT INTO `payroll`(`id`, `ref_no`, `date_from`,`date_to`,`type`,`status`,`date_created`) VALUES ('','$refno','$date_from','$date_to','$type','0','$datenow')";
			$result_insert = mysqli_query($conn, $sql_insert);
			if ($result_insert) {
				echo '<script>alert("New Allowance Added")</script>';
				echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
			}
		}
	}
}

if (isset($_POST['delete'])) {
	$delete_id = $_POST['delete_id'];
	$result_delete1 = mysqli_query($conn, "DELETE FROM payroll WHERE id=$delete_id");
	$result_delete2 = mysqli_query($conn, "DELETE FROM payroll_items WHERE payroll_id=$delete_id");
	if (!$result_delete1 && !$result_delete2) {
		echo "Error deleting record: " . mysqli_error($conn);
	} else {
		echo '<script>alert("Allowance Deleted")</script>';
		echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
	}
}

function calculate_payroll($id, $conn) {
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
		echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
	}

	if (isset($save)) {
		mysqli_query($conn, "UPDATE payroll set status = 1 where id = " . $pay['id']);
		return 1;
	}
}
?>