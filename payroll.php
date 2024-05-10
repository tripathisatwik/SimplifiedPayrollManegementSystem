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

		function calculatePayroll(id) {
			$.ajax({
				url: 'calculate_payroll.php',
				type: 'POST',
				data: {
					id: id
				},
				success: function(response) {
					alert('Payroll calculation successful');
					location.reload();
				},
				error: function(xhr, status, error) {
					alert('Error calculating payroll: ' + error);
				}
			});
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
							echo "<button onclick='calculatePayroll(";
							echo $row['id'];
							echo ")'><img src='./icons/accounting.png' alt='Calculate'></button>";
						} else if ($row['status'] == 1) {
							echo "<button><a href='http://localhost/final/index.php?page=payroll_items'><img src='./icons/watch.png' alt='View'>";
							$_SESSION["payroll"] = $p_id;
							echo "</a></button>";
							
						};
				?>
						<button type="button" data-id="<?php echo $row['id']; ?>" data-datefrom="<?php echo $row['date_from'] ?>" data-dateto="<?php echo $row['date_to']; ?>" data-type="<?php echo $row['type']; ?>"><img src="./icons/editing-modified.png" alt="Edit"></button>
						<form method="post">
							<input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
							<button type="submit" name="delete" onclick="confirmDelete()"><img src="./icons/delete-modified.png" alt="Delete"></button>
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
	$refno = date('Y') . '-' . mt_rand(1, 9999);
	$date_from = $_POST['datefrom'];
	$date_to = $_POST['dateto'];
	$type = $_POST["type"];
	$datenow = date("Y-m-d H:i", time());

	if (empty($date_to) || empty($date_from) || empty($type)) {
		echo '<script>alert("All fields are required")</script>';
		echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
	} else {
		$sql = "select * from payroll  where id='$edit_id'";
		$result = mysqli_query($conn, $sql);
		$num = mysqli_num_rows($result);
		if ($num > 0) {
			$sql_update = "UPDATE `payroll` SET `date_from`='$date_from',`date_to`='$date_to',`type`='$type',`status`='0' WHERE id='$edit_id' ";
			$result_delete0 = mysqli_query($conn, "DELETE FROM payroll_items WHERE payroll_id=$edit_id");
			$result_update = mysqli_query($conn, $sql_update);
			if ($result_update && $result_delete0) {
				echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
				echo '<script>alert("Payroll Data Updated")</script>';
			}
		} else {
			$sql_insert = "INSERT INTO `payroll`(`id`, `ref_no`, `date_from`,`date_to`,`type`,`status`,`date_created`) VALUES ('','$refno','$date_from','$date_to','$type','0','$datenow')";			// Set status to 'New' explicitly
			$result_insert = mysqli_query($conn, $sql_insert);
			if ($result_insert) {
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
		echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
	}
}


?>