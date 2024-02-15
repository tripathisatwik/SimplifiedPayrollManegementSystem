<?php include('dbconnect.php'); ?>
<html>
<head>
	<style>
		.container-fluid {
			width: 100%;
			margin-right: auto;
			margin-left: auto;
		}

		/* Column Styles */
		.col-lg-12 {
			width: 100%;
		}

		.col-md-4 {
			width: 33.33%;
			float: left;
		}

		.col-md-8 {
			width: 66.66%;
			float: left;
		}

		/* Card Styles */
		.card {
			border: 1px solid #ddd;
			border-radius: 8px;
			margin-bottom: 20px;
		}

		.card-header {
			background-color: #f8f9fa;
			padding: 15px;
			border-bottom: 1px solid #ddd;
			border-radius: 8px 8px 0 0;
		}

		.card-body {
			padding: 15px;
		}

		.card-footer {
			padding: 15px;
			border-top: 1px solid #ddd;
			border-radius: 0 0 8px 8px;
		}

		/* Form Styles */
		#manage-department {
			margin: 0;
		}

		.form-group {
			margin-bottom: 15px;
		}

		.control-label {
			font-weight: bold;
		}

		.form-control {
			width: 100%;
			padding: 8px;
			box-sizing: border-box;
		}

		/* Button Styles */
		.btn {
			cursor: pointer;
			display: inline-block;
			padding: 10px 15px;
			text-align: center;
			text-decoration: none;
			border-radius: 5px;
		}

		.btn-primary {
			background-color: #007bff;
			color: #fff;
		}

		.btn-default {
			background-color: #ced4da;
			color: #495057;
		}

		/* Table Styles */
		.table {
			width: 100%;
			margin-bottom: 1rem;
			color: #212529;
			border-collapse: collapse;
		}

		.table-bordered {
			border: 1px solid #ddd;
		}

		.table th,
		.table td {
			padding: 8px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}

		.table th {
			background-color: #f8f9fa;
		}

		/* Truncate Style */
		td p {
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		/* Script Styles */
		img {
			max-width: 100px;
			max-height: 150px;
		}

		/* Additional Styles */
		td {
			vertical-align: middle !important;
		}
	</style>
</head>

<body>
	<div class="container-fluid">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-4">
					<form action="" id="manage-department">
						<div class="card">
							<div class="card-header">
								Department Form
							</div>
							<div class="card-body">
								<input type="hidden" name="id">
								<div class="form-group">
									<label class="control-label">Name</label>
									<textarea name="name" id="" cols="30" rows="2" class="form-control"></textarea>
								</div>
							</div>
							<div class="card-footer">
								<div class="row">
									<div class="col-md-12">
										<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
										<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="_reset()"> Cancel</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-8">
					<div class="card">
						<div class="card-body">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th class="text-center">Department</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = 1;
									$department = $conn->query("SELECT * FROM department order by id asc");
									while ($row = $department->fetch_assoc()) :
									?>
										<tr>
											<td class="text-center"><?php echo $i++ ?></td>
											<td class="">
												<p> <b><?php echo $row['name'] ?></b></p>
											</td>
											<td class="text-center">
												<button class="btn btn-sm btn-primary edit_department" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>">Edit</button>
												<button class="btn btn-sm btn-danger delete_department" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
											</td>
										</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function _reset() {
			$('[name="id"]').val('');
			$('#manage-department').get(0).reset();
		}

		$('#manage-department').submit(function(e) {
			e.preventDefault()
			start_load()
			$.ajax({
				url: 'ajax.php?action=save_department',
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				success: function(resp) {
					if (resp == 1) {
						alert_toast("Data successfully added", 'success')
						setTimeout(function() {
							location.reload()
						}, 1500)

					} else if (resp == 2) {
						alert_toast("Data successfully updated", 'success')
						setTimeout(function() {
							location.reload()
						}, 1500)

					}
				}
			})
		})
		$('.edit_department').click(function() {
			start_load()
			var cat = $('#manage-department')
			cat.get(0).reset()
			cat.find("[name='id']").val($(this).attr('data-id'))
			cat.find("[name='name']").val($(this).attr('data-name'))
			end_load()
		})
		$('.delete_department').click(function() {
			_conf("Are you sure to delete this department?", "delete_department", [$(this).attr('data-id')])
		})

		function displayImg(input, _this) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#cimg').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}

		function delete_department($id) {
			start_load()
			$.ajax({
				url: 'ajax.php?action=delete_department',
				method: 'POST',
				data: {
					id: $id
				},
				success: function(resp) {
					if (resp == 1) {
						alert_toast("Data successfully deleted", 'success')
						setTimeout(function() {
							location.reload()
						}, 1500)

					}
				}
			})
		}
	</script>
</body>

</html>