<style>
	.primary {
		margin: 20px;
	}

	.data {
		background-color: #f9f9f9;
		padding: 20px;
		border-radius: 5px;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
	}

	.data h5,
	.data h4 {
		margin: 5px 0;
	}

	.data hr {
		border-top: 1px solid #ddd;
		margin: 10px 0;
	}

	.row {
		display: flex;
	}

	.payroll_info,
	.employee_info {
		flex: 1;
	}

	.card {
		margin-top: 20px;
		border: 1px solid #ddd;
		border-radius: 5px;
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
	}

	.card-header {
		background-color: #f0f0f0;
		padding: 10px;
		border-bottom: 1px solid #ddd;
		font-weight: bold;
	}

	.card-body {
		padding: 10px;
	}

	.list-group {
		margin: 0;
		padding: 0;
	}

	.list-group li {
		list-style: none;
		padding: 5px 0;
	}

	.badge {
		background-color: #007bff;
		margin-left: 5px;
		padding: 5px 10px;
		border-radius: 5px;
		color: #fff;
	}

	.all_dud {
		display: flex;
		justify-content: space-between;
	}

	.allowance,
	.deduction {
		flex-basis: 48%;
	}

	table {
		width: 100%;
		border-collapse: collapse;
		margin-top: 20px;
	}

	th,
	td {
		padding: 5px;
		border: 1px solid #ddd;
		text-align: left;
	}

	th {
		background-color: #007bff;
		color: #fff;
	}
</style>
<?php include 'dbconnect.php';
if (isset($_GET['id']) && isset($_GET['empid'])) {
	$payroll_id = $_GET['id'];
	$employee_id = $_GET['empid'];
	$payroll = $conn->query("SELECT p.*,concat(e.lastname,', ',e.firstname,' ',e.middlename) as ename,e.employee_no FROM payroll_items p inner join employee e on e.id = p.employee_id  where payroll_id=" . $_GET['id']);
	foreach ($payroll->fetch_array() as $key => $value) {
		$$key = $value;
	}
	$pay = $conn->query("SELECT * FROM payroll where id = " . $payroll_id)->fetch_array();
	$pt = array(1 => "Monhtly", 2 => "Semi-Monthly");
}
?>

<div class="primary">
	<div class="data">
		<h5><b><small>Employee ID :</small><?php echo $employee_no ?></b></h5>
		<h4><b><small>Name: </small><?php echo ucwords($ename) ?></b></h4>
		<hr>
		<div class="row">
			<div class="payroll_info">
				<p><b>Payroll Ref : <?php echo $pay['ref_no'] ?></b></p>
				<p><b>Payroll Range : <?php echo date("M d, Y", strtotime($pay['date_from'])) . " - " . date("M d, Y", strtotime($pay['date_to'])) ?></b></p>
				<p><b>Payroll type : <?php echo $pt[$pay['type']] ?></b></p>
			</div>
			<div class="employee_info">
				<p><b>Days of Absent : <?php echo $absent ?></b></p>
				<p><b>Tardy/Undertime (mins) : <?php echo $late ?></b></p>
				<p><b>Total Allowance Amount : <?php echo number_format($allowance_amount, 2) ?></b></p>
				<p><b>Total Deduction Amount : <?php echo number_format($deduction_amount, 2) ?></b></p>
				<p><b>Net Pay : <?php echo number_format($net, 2) ?></b></p>
			</div>
		</div>

		<hr>
		<div class="all_dud">
			<div class="allowance">
				<div class="card">
					<div class="card-header">
						<span><b>Allowances</b></span>
					</div>
					<div class="card-body" id="allowance_list">
						<table>
							<tr>
								<th>S.no.</th>
								<th>Name</th>
								<th>Type of Allowance</th>
								<th>Amount</th>
							</tr>
							<?php
							$sno = 1;
							$result2 = mysqli_query($conn, "SELECT * FROM `employee_allowances` INNER JOIN allowances on allowance_id=allowances.id where employee_id = " . $employee_id);
							while ($row = $result2->fetch_assoc()) {
							?>
								<tr>
									<td><?php echo $sno++ ?></td>
									<td><?php echo $row['allowance'] ?></td>
									<td>
										<?php
										if ($row['type'] == 1) {
											echo 'Monthly';
										} else if ($row['type'] == 2) {
											echo 'Semi-Monthly';
										} else if ($row['type'] == 1) {
											echo 'Once';
										}
										?>
									</td>
									<td><?php echo $row['amount'] ?></td>
								</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</div>
			<div class="deduction">
				<div class="card">
					<div class="card-header">
						<span><b>Deductions</b></span>
					</div>
					<div class="card-body" id="deduction_list">
						<table>
							<tr>
								<th>S.no.</th>
								<th>Name</th>
								<th>Type of Deductions</th>
								<th>Amount</th>
							</tr>
							<?php
							$sno = 1;
							$result2 = mysqli_query($conn, "SELECT * FROM `employee_deductions` INNER JOIN deductions on deduction_id=deductions.id where employee_id = " . $employee_id);
							while ($row = $result2->fetch_assoc()) {
							?>
								<tr>
									<td><?php echo $sno++ ?></td>
									<td><?php echo $row['deduction'] ?></td>
									<td>
										<?php
										if ($row['type'] == 1) {
											echo 'Monthly';
										} else if ($row['type'] == 2) {
											echo 'Semi-Monthly';
										} else if ($row['type'] == 1) {
											echo 'Once';
										}
										?>
									</td>
									<td><?php echo $row['amount'] ?></td>
								</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>