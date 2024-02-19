<?php include 'dbconnect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>User</title>
	<style>
		.center {
			display: flex;
			justify-content: space-between;
			align-items: center;
			width: 80%;
			margin: auto;
			padding: 20px;
		}

		.inputform {
			display: flex;
			flex-direction: column;
			max-width: 400px;
			padding: 20px;
			border: 1px solid #ddd;
			border-radius: 10px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			background-color: #fff;
		}

		label {
			margin-bottom: 5px;
		}

		select,
		input[type="text"],
		input[type="number"] {
			margin-bottom: 10px;
			padding: 8px;
		}

		button[name="Cancel"],
		input[name="delete"] {
			background-color: #f44336;
		}

		input[name="submit"],
		button {
			background-color: #4caf50;
		}

		input[name="submit"],
		input[name="delete"],
		button {
			padding: 10px;
			cursor: pointer;
			color: white;
			border: none;
			border-radius: 5px;
			margin-right: 10px;
		}



		table {
			width: 100%;
			border-collapse: collapse;
			margin-left: 20px;
		}

		th,
		td {
			border: 1px solid #ddd;
			padding: 8px;
			text-align: left;
		}

		th {
			background-color: #4caf50;
			color: white;
		}

		tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		tr:hover {
			background-color: #ddd;
		}

		.action {
			display: flex;
			gap: 5px;
		}
	</style>

	</style>
	<script>
		function reset() {
			$('#manage-user').get(0).reset();
		}

		function confirmDelete() {
			return confirm("Are you sure you want to delete this record?");
		}

		$(document).ready(function() {
			$('button[data-id]').click(function() {
				start_load();
				var cat = $('#manage-user');
				cat.get(0).reset();
				cat.find("[name='id']").val($(this).attr('data-id'));
				cat.find("[name='name']").val($(this).attr('data-name'));
				cat.find("[name='username']").val($(this).attr('data-user'));
				cat.find("[name='password']").val($(this).attr('data-pass'));
				cat.find("[name='type']").val($(this).attr('data-type'));
				end_load();
			});
		});
	</script>
</head>

<body>
	<div class="center">
		<form id="manage-user" method="post">
			<input type="hidden" name="id">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" required>
			<label for="username">Username</label>
			<input type="text" name="username" id="username" required>
			<label for="password">Password</label>
			<input type="password" name="password" id="password" required>
			<label for="type">User Type</label>
			<select name="type" id="type" class="custom-select" required>
				<option value="1">Admin</option>
				<option value="2">Staff</option>
			</select>
			<input type="submit" name="submit">
			<button type="submit" onclick="reset()" name="Cancel">Cancel</button>
		</form>
		<br>
		<div class="row">
			<table border=1>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Username</th>
					<th>Action</th>
				</tr>
				<?php
				$sql = "select * from users";
				$result = mysqli_query($conn, $sql);
				$num = mysqli_num_rows($result);
				$sno = 1;
				if ($num > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td>" . $sno++ .  "</td>";
						echo "<td>" . $row['name'] . "</td>";
						echo "<td>" . $row['username'] . "</td>";
				?>
						<td class="action">
							<button name="edit" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name'] ?>" data-user="<?php echo $row['username']; ?>" data-pass="<?php echo $row['password']; ?>" data-type="<?php echo $row['type']; ?>" id="edit_user">Edit</button>

							<form method="post" onsubmit="return confirmDelete()">
								<input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
								<input type="submit" name="delete" value="Delete">
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
	$username = $_POST['username'];
	$password = $_POST['password'];
	$usertype = $_POST['type'];

	if (!empty($edit_id)) {
		if (!empty($password)) {
			$hash = md5($password);
			$sql_update = "UPDATE `users` SET `name`='$name', `username`='$username', `password`='$hash', `type`='$usertype' WHERE id=$edit_id";
		} else {
			$sql_update = "UPDATE `users` SET `name`='$name', `username`='$username', `type`='$usertype' WHERE id=$edit_id";
		}
		$result_update = mysqli_query($conn, $sql_update);

		if ($result_update) {
			echo '<script>window.location="http://localhost/final/index.php?page=users"</script>';
		} else {
			echo "Error updating record: " . mysqli_error($conn);
		}
	} else {
		// Inserting a new user
		$hash = md5($password);
		$sql_insert = "INSERT INTO `users`(`name`, `username`, `password`, `type`) VALUES ('$name', '$username', '$hash', '$usertype')";
		$result_insert = mysqli_query($conn, $sql_insert);

		if ($result_insert) {
			echo '<script>window.location="http://localhost/final/index.php?page=users"</script>';
		} else {
			echo "Error inserting record: " . mysqli_error($conn);
		}
	}
}

if (isset($_POST['delete'])) {
	$delete_id = $_POST['delete_id'];
	$sql_delete = "DELETE FROM users WHERE id=$delete_id";
	$result_delete = mysqli_query($conn, $sql_delete);

	if (!$result_delete) {
		echo "Error deleting record: " . mysqli_error($conn);
	} else {
		echo '<script>window.location="http://localhost/final/index.php?page=users"</script>';
	}
}
?>