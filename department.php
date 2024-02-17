<!DOCTYPE html>
<html lang="en">

<head>

	<script>
		function reset() {
			$('#manage-department').get(0).reset();
		}

		function confirmDelete() {
			return confirm("Are you sure you want to delete this record?");
		}
		$(document).ready(function() {
			$('button[data-id]').click(function() {
				start_load();
				var cat = $('#manage-department');
				cat.get(0).reset();
				cat.find("[name='id']").val($(this).attr('data-id'));
				cat.find("[name='name']").val($(this).attr('data-name'));
				end_load();
			});
		});
	</script>
 <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .depmain {
            display: flex;
            justify-content: space-between;
            margin: 20px;
        }

        .depleft,
        .depright {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd; /* Add border around depleft */
        }

        .depleftup {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .depleftmid,
        .depleftdown {
            margin-bottom: 10px;
        }

        .depleftmid textarea {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .depleftdown {
            display: flex;
            align-items: center;
        }

        .depleftdown input {
            padding: 8px;
            margin-right: 10px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
        }
		
        .depleftdown button{
			padding: 8px;
            margin-right: 10px;
            cursor: pointer;
            background-color: red;
            color: white;
            border: none;
		}

 
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin: 0;
        }
    </style>
</head>

<body>
	<div class="depmain">
		<div class="depleft">
			<form action="http://localhost/final/index.php?page=department" method="post" id="manage-department">
				<div class="depleftup">Department</div>
				<div class="depleftmid">
					<input type="hidden" name="id" value="<?php echo isset($edit_id) ? $edit_id : ''; ?>">
					<label class="control-label">Name</label><br>
					<input type="text" name="name" required>
				</div>
				<div class="depleftdown">
					<input type="submit" name="submit" value="<?php echo isset($edit_id) ? 'Update' : 'Save'; ?>">
					<button type="button" onclick="reset()">Cancel</button>
				</div>
			</form>
		</div>
		<div class="depright">
			<table border=1>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Action</th>
				</tr>
				<?php
				include 'dbconnect.php';
				$sql = "select * from department";
				$result = mysqli_query($conn, $sql);
				$num = mysqli_num_rows($result);
				$sno = 1;
				if ($num > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td>" . $sno++ . "</td>";
						echo "<td>" . $row['dname'] . "</td>";
				?>
						<td>
							<button type="button" data-id="<?php echo $row['id'];
															$edit_id = $row['id']; ?>" data-name="<?php echo $row['dname'] ?>">Edit</button>
							
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
include 'dbconnect.php';
if (isset($_POST['submit'])) {
	$edit_id = $_POST['id'];
	$name = $_POST['name'];
	$sql = "select * from department  where id='$edit_id'";
	$result = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($result);
	if ($num > 0) {
		$sql_update = "UPDATE department SET dname='$name' WHERE id=$edit_id";
		$result_update = mysqli_query($conn, $sql_update);
		if ($result_update) {
			echo '<script>window.location="http://localhost/final/index.php?page=department"</script>';
		}
	} else {
		$sql_insert = "INSERT INTO department (dname) VALUES ('$name')";
		$result_insert = mysqli_query($conn, $sql_insert);
		if ($result_insert) {
			echo '<script>window.location="http://localhost/final/index.php?page=department"</script>';
		}
	}
}

if (isset($_POST['delete'])) {
	$delete_id = $_POST['delete_id'];
	$sql_delete = "DELETE FROM department WHERE id=$delete_id";
	$result_delete = mysqli_query($conn, $sql_delete);

	if (!$result_delete) {
		echo "Error deleting record: " . mysqli_error($conn);
	} else {
		echo '<script>window.location="http://localhost/final/index.php?page=department"</script>';
	}
}
?>