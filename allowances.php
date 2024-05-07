<?php include 'dbconnect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Allowances</title>
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
			$('#manage-allowance').get(0).reset();
		}

		function confirmDelete() {
			return confirm("Are you sure you want to delete this record?");
		}

		$(document).ready(function() {
			$('button[data-id]').click(function() {
				start_load();
				var cat = $('#manage-allowance');
				cat.get(0).reset();
				cat.find("[name='id']").val($(this).attr('data-id'));
				cat.find("[name='name']").val($(this).attr('data-name'));
				cat.find("[name='description']").val($(this).attr('data-des'));
				end_load();
			});
		});
	</script>
</head>

<body>
	<div class="depmain">
		<div class="depleft">
			<form action="http://localhost/final/index.php?page=allowances" method="post" id="manage-allowance">
				<div class="depleftup">Allowances</div>
				<div class="depleftmid">
					<div>
						<input type="hidden" name="id">
						<label>Name</label><br>
						<input type="text" name="name" required>
					</div>
					<div>
						<label>Description</label><br>
						<textarea name="description" required cols="30" rows="2"></textarea>
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
					<th>Id</th>
					<th>Name</th>
					<th>Action</th>
				</tr>
				<?php
				$sql = "select * from allowances";
				$result = mysqli_query($conn, $sql);
				$num = mysqli_num_rows($result);
				$sno = 1;
				if ($num > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td>" . $sno++ .  "</td>";
						echo "<td>";
						echo "<p>Name:" . $row['allowance'] . "</p>";
						echo "<p>Description:" . $row['description'] . "</p>";
						echo "</td>";

				?>
						<td class="action-buttons">
							<button type="button" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['allowance'] ?>" data-des="<?php echo $row['description']; ?>"><img src="./icons/editing-modified.png" alt="Edit"></button>

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
	$edit_id = $_POST['id'];
	$name = $_POST['name'];
	$description = $_POST['description'];
	if (empty($name) || empty($description)) {
		echo '<script>alert("All fields are required")</script>';
		echo '<script>window.location="http://localhost/final/index.php?page=allowances"</script>';
	} else {
		$sql = "select * from allowances  where id='$edit_id'";
		$result = mysqli_query($conn, $sql);
		$num = mysqli_num_rows($result);
		if ($num > 0) {
			$sql_update = "UPDATE `allowances` SET `allowance`='$name',`description`='$description' WHERE id='$edit_id' ";
			$result_update = mysqli_query($conn, $sql_update);
			if ($result_update) {
				echo '<script>alert("Allowance Data Updated")</script>';
				echo '<script>window.location="http://localhost/final/index.php?page=allowances"</script>';
			}
		} else {
			$sql_insert = "INSERT INTO `allowances`(`id`, `allowance`, `description`) VALUES ('','$name','$description')";
			$result_insert = mysqli_query($conn, $sql_insert);
			if ($result_insert) {
				echo '<script>alert("New Allowance Added")</script>';
				echo '<script>window.location="http://localhost/final/index.php?page=allowances"</script>';
			}
		}
	}
}

if (isset($_POST['delete'])) {
	$delete_id = $_POST['delete_id'];
	$sql_delete = "DELETE FROM allowances WHERE id=$delete_id";
	$result_delete = mysqli_query($conn, $sql_delete);

	if (!$result_delete) {
		echo "Error deleting record: " . mysqli_error($conn);
	} else {
		echo '<script>alert("Allowance Deleted")</script>';
		echo '<script>window.location="http://localhost/final/index.php?page=allowances"</script>'; 
	}
}
?>