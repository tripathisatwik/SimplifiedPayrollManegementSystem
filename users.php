<?php include 'dbconnect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>User</title>
	<link rel="stylesheet" href="style.css">

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
	<div class="depmain">
		<div class="depleft">
			<div class="depleftup">User</div>
			<form id="manage-user" method="post">
				<div class="depleftmid">
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
				</div>
				<div class="depleftdown">
					<input type="submit" name="submit">
					<button type="submit" onclick="reset()" name="Cancel">Cancel</button>
				</div>
			</form>
		</div>
		<br>
		<div class="depright">
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
						<td class="action-buttons">
							<button name="edit" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name'] ?>" data-user="<?php echo $row['username']; ?>" data-pass="<?php echo $row['password']; ?>" data-type="<?php echo $row['type']; ?>" id="edit_user"><img src="./icons/editing-modified.png" alt="Edit"></button>
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
			echo '<script>alert("User Updated")</script>';
		} else {
			echo "Error updating record: " . mysqli_error($conn);
		}
	} else {
		// Inserting a new user
		$hash = md5($password);
		$sql_insert = "INSERT INTO `users`(`name`, `username`, `password`, `type`) VALUES ('$name', '$username', '$hash', '$usertype')";
		$result_insert = mysqli_query($conn, $sql_insert);

		if ($result_insert) {
			echo '<script>alert("New User Added")</script>';
		} else {
			echo '<script>alert("User already exist")</script>';
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
		echo '<script>alert("User Deleted")</script>';
	}
}
?>