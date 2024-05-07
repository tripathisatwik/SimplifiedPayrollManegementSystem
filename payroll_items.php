<?php
include 'dbconnect.php';
$id = $_SESSION['payroll'];
$result = mysqli_query($conn, "SELECT * FROM payroll where id ='$id'");
while ($pay = mysqli_fetch_assoc($result)) {
?>
	<style>
		button {
			border: none;
			color: white;
			padding: 10px 20px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
			border-radius: 4px;
		}

		button a {
			color: white;
			text-decoration: none;
		}

		.print-btn,
		.back-btn {
			background-color: #007bff;
		}

		.primary {
			background-color: #f2f2f2;
			padding: 20px;
			border-radius: 5px;
		}

		.primary .upper {
			margin-bottom: 20px;
		}

		h3,
		h4 {
			color: #333;
		}

		.primary .info p {
			margin-bottom: 10px;
		}

		hr {
			border: 0;
			border-top: 1px solid #ccc;
			margin: 20px 0;
		}

		.data table {
			width: 100%;
			border-collapse: collapse;
		}

		.data th {
			background-color: #007bff;
			color: white;
			padding: 8px;
		}

		.data td {
			border: 1px solid #ddd;
			padding: 8px;
		}

		.data tr:hover {
			background-color: #f2f2f2;
		}

		.print-btn {
			position: absolute;
			top: 10rem;
			right: 5rem;
		}

		.modal {
			display: none;
			position: fixed;
			z-index: 1;
			padding-top: 100px;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: auto;
			background-color: rgb(0, 0, 0);
			background-color: rgba(0, 0, 0, 0.4);
		}

		.modal-content {
			background-color: #fefefe;
			margin: auto;
			padding: 20px;
			border: 1px solid #888;
			width: 80%;
			height: 500px;
		}

		.close {
			color: #aaaaaa;
			position: absolute;
			top: 95px;
			right: 135px;
			font-size: 28px;
			font-weight: bold;
		}

		.close:hover,
		.close:focus {
			color: #000;
			text-decoration: none;
			cursor: pointer;
		}
	</style>
	<button class="back-btn"><a href='http://localhost/final/index.php?page=payroll'>Back</a></button>
	<div class="primary">
		<div class="upper">
			<h3>Payroll Information</h3>
			<h4><b>Payroll : <?php echo $pay['ref_no'] ?></b></h4>
		</div>
		<div class="info">
			<button class="print-btn" onclick="printPayroll()">Print</button>
			<p>Payroll Range: <b><?php echo date("M d, Y", strtotime($pay['date_from'])) . " - " . date("M d, Y", strtotime($pay['date_to'])) ?></b></p>
			<p>Payroll Type: <b><?php
								if ($pay['type'] == 1) {
									echo "Monthly";
								} elseif ($pay['type'] == 2) {
									echo "Semi-Monthly";
								}
								?></b></p>
		</div>
		<hr>
	</div>
	<div class="data">
		<table>
			<tr>
				<th>Employee Id</th>
				<th>Name</th>
				<th>Days Absent</th>
				<th>Days Late</th>
				<th>Total Allowance</th>
				<th>Total Deduction</th>
				<th>Net</th>
				<th>Action</th>
			</tr>

			<?php
			$payroll = mysqli_query($conn, "SELECT p.*,concat(e.lastname,', ',e.firstname,' ',e.middlename) as ename,e.employee_no FROM payroll_items p inner join employee e on e.id = p.employee_id");
			while ($row = mysqli_fetch_assoc($payroll)) {
			?>
				<tr>
					<td><?php echo $row['employee_no'] ?></td>
					<td><?php echo ucwords($row['ename']) ?></td>
					<td><?php echo $row['absent'] ?></td>
					<td><?php echo $row['late'] ?></td>
					<td><?php echo number_format($row['allowance_amount'], 2) ?></td>
					<td><?php echo number_format($row['deduction_amount'], 2) ?></td>
					<td><?php echo number_format($row['net'], 2) ?></td>
					<td><button class="view-btn" data-employee-id="<?php echo $row['employee_no'] ?>"><img src='./icons/watch.png' alt='View'></button></td>
				</tr>
			<?php }  ?>
		</table>
	</div>
<?php } ?>
<div id="viewPayslipModal" class="modal">
	<span class="close">&times;</span>
	<div class="modal-content">
	</div>
</div>
<script>
	function printPayroll() {
		var printWindow = window.open("print_payroll.php?id=<?php echo $id ?>", "_blank", "height=500,width=800");
		printWindow.onload = function() {
			printWindow.print();
		};
	}

	var modal = document.getElementById('viewPayslipModal');
	var btn = document.getElementsByClassName("view-btn");
	var span = document.getElementsByClassName("close")[0];

	for (var i = 0; i < btn.length; i++) {
		btn[i].onclick = function() {
			modal.style.display = "block";
			var payrollId = <?php echo json_encode($_SESSION['payroll']); ?>;
			modal.querySelector('.modal-content').innerHTML = '<iframe src="view_payslip.php?id=' + payrollId + '" width="100%" height="100%"></iframe>';
		}
	}

	span.onclick = function() {
		modal.style.display = "none";
	}

	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
</script>