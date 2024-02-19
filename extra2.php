<!DOCTYPE html>
<html lang="en">

<head>
	<style>
		.action {
			display: flex;
		}
	</style>
	<script>
		function reset() {
			$('#manage-employee').get(0).reset();
		}

		function confirmDelete() {
			return confirm("Are you sure you want to delete this record?");
		}

		$(document).ready(function() {
			// Define positions for each department
			var departmentPositions = <?php echo json_encode(getDepartmentPositions()); ?>;

			$('#department').change(function() {
				var departmentId = $(this).val();
				updatePositionOptions(departmentId);
			});

			$('button[data-id]').click(function() {
				start_load();
				var cat = $('#manage-employee');
				cat.get(0).reset();
				cat.find("[name='id']").val($(this).attr('data-id'));
				cat.find("[name='employee_no']").val($(this).attr('data-employee_no'));
				cat.find("[name='firstname']").val($(this).attr('data-firstname'));
				cat.find("[name='middlename']").val($(this).attr('data-middlename'));
				cat.find("[name='lastname']").val($(this).attr('data-lastname'));
				cat.find("[name='department']").val($(this).attr('data-department'));
				cat.find("[name='position']").val($(this).attr('data-position'));
				cat.find("[name='salary']").val($(this).attr('data-salary'));
				end_load();
			});

			// Initial update of position options based on selected department
			updatePositionOptions($('#department').val());
		});

		function updatePositionOptions(departmentId) {
			var positions = departmentPositions[departmentId] || [];
			var positionDropdown = $('#position');
			positionDropdown.empty();

			positions.forEach(function(position) {
				positionDropdown.append($('<option>', {
					value: position.id,
					text: position.name
				}));
			});
		}

		function getDepartmentPositions() {
			return <?php echo json_encode(getAllDepartmentPositions()); ?>;
		}
	</script>
</head>

<body>
	<div class="center">
		<form id="manage-employee" method="post">
            <input type="hidden" name="id" required>
            <label for="employee_no">Employee_no</label>
            <input type="text" id="employee_no" name="employee_no" required>
            <label for="firstname">First Name</label>
            <input type="text" id="firstname" name="firstname" required>
            <label for="middlename">Middle Name</label>
            <input type="text" id="middlename" name="middlename" placeholder="(optional)">
            <label for="lastname">Last Name</label>
            <input type="text" id="lastname" name="lastname" required>
            <label for="department">Department</label>
                <?php
                $dept = $conn->query("SELECT * from department order by dname asc");
                while ($row = $dept->fetch_assoc()) :
                ?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['dname'] ?></option>
                <?php endwhile; ?>
            </select>

			<label for="department">Department</label>
			<select id="department" name="department" required>
				<?php
				$departments = $conn->query("SELECT * from department order by dname asc");
				while ($row = $departments->fetch_assoc()) :
				?>
					<option value="<?php echo $row['id'] ?>"><?php echo $row['dname'] ?></option>
				<?php endwhile; ?>
			</select>

			<label for="position">Position</label>
			<select name="position" id="position" required>
				<!-- Options will be dynamically populated using JavaScript -->
			</select>

			<!-- Your other form elements -->

			<input type="submit" name="submit">
			<button type="submit" onclick="reset()" name="Cancel">Cancel</button>
		</form>
		<!-- Your other HTML content -->
	</div>
</body>

</html>