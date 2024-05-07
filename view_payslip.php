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
</style>
<?php include 'dbconnect.php';
if (isset($_GET['id'])) {
	$payroll_id = $_GET['id'];
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
					<div class="card-body">
						<ul class="list-group">
							<?php
							$all_qry = $conn->query("SELECT * from allowances ");
							$t_arr = array(1 => "Monthly", 2 => "Semi-Monthly", 3 => "Once");
							while ($row = $all_qry->fetch_assoc()) :
								$all_arr[$row['id']] = $row['allowance'];
							endwhile;
							foreach (json_decode($allowances) as $k => $val) :

							?>
								<li>
									<?php echo $all_arr[$val->aid] ?> Allowance
									<span class="badge"><?php echo number_format($val->amount, 2) ?></span>
								</li>

							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="deduction">
				<div class="card">
					<div class="card-header">
						<span><b>Deductions</b></span>

					</div>
					<div class="card-body">
						<ul class="list-group">
							<?php
							$all_qry = $conn->query("SELECT * from deductions ");
							$t_arr = array(1 => "Monthly", 2 => "Semi-Monthly", 3 => "Once");
							while ($row = $all_qry->fetch_assoc()) :
								$ded_arr[$row['id']] = $row['deduction'];
							endwhile;
							foreach (json_decode($deductions) as $k => $val) :

							?>
								<li>
									<?php echo $ded_arr[$val->did] ?>
									<span class="badge"><?php echo number_format($val->amount, 2) ?></span>
								</li>

							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script>
</script>