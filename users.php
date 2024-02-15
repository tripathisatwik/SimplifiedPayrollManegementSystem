<html>

<head>
	<style>
		/* Resetting some default margin */
		body,
		h1,
		h2,
		h3,
		h4,
		p,
		ul,
		li {
			margin: 0;
			padding: 0;
		}

		/* Container Styles */
		.container-fluid {
			width: 100%;
			margin-right: auto;
			margin-left: auto;
		}

		/* Row Styles */
		.row {
			margin-right: -15px;
			margin-left: -15px;
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

		.float-right {
			float: right;
		}

		/* Card Styles */
		.card {
			border: 1px solid #ddd;
			border-radius: 8px;
			margin-bottom: 20px;
		}

		.card-body {
			padding: 15px;
		}

		/* Table Styles */
		table {
			width: 100%;
			margin-bottom: 1rem;
			color: #212529;
			border-collapse: collapse;
		}

		.table-striped {
			background-color: #f8f9fa;
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

		/* Dropdown Styles */
		.dropdown-menu {
			position: absolute;
			top: 100%;
			left: 0;
			z-index: 1000;
			display: none;
			float: left;
			min-width: 10rem;
			padding: 0.5rem 0;
			margin: 0.125rem 0 0;
			font-size: 1rem;
			color: #212529;
			text-align: left;
			list-style: none;
			background-color: #fff;
			background-clip: padding-box;
			border: 1px solid rgba(0, 0, 0, 0.15);
			border-radius: 0.25rem;
		}

		.dropdown-item {
			display: block;
			width: 100%;
			padding: 0.25rem 1.5rem;
			clear: both;
			font-weight: 400;
			color: #212529;
			text-align: inherit;
			white-space: nowrap;
			background-color: transparent;
			border: 0;
		}

		/* Script Styles */
		.center {
			text-align: center;
		}

		/* Additional Styles */
		td {
			vertical-align: middle !important;
		}

		/* Custom Styles */
		.btn-group {
			position: relative;
			display: inline-block;
			vertical-align: middle;
		}

		.btn-group .btn {
			border-radius: 0;
		}

		.btn-group .dropdown-toggle-split {
			padding-right: 0.5rem;
			padding-left: 0.5rem;
		}
	</style>
</head>
<body>
	<div class="container-fluid">

		<div class="row">
			<div class="col-lg-12">
				<button class="btn btn-primary float-right btn-sm" id="new_user"><i class="fa fa-plus"></i> New user</button>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="card col-lg-12">
				<div class="card-body">
					<table class="table-striped table-bordered col-md-12">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Name</th>
								<th class="text-center">Username</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							include 'db_connect.php';
							$users = $conn->query("SELECT * FROM users order by name asc");
							$i = 1;
							while ($row = $users->fetch_assoc()) :
							?>
								<tr>
									<td>
										<?php echo $i++ ?>
									</td>
									<td>
										<?php echo $row['name'] ?>
									</td>
									<td>
										<?php echo $row['username'] ?>
									</td>
									<td>
										<center>
											<div class="btn-group">
												<button type="button" class="btn btn-primary">Action</button>
												<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item edit_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Edit</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item delete_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Delete</a>
												</div>
											</div>
										</center>
									</td>
								</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script>
		$('#new_user').click(function() {
			uni_modal('New User', 'manage_user.php')
		})
		$('.edit_user').click(function() {
			uni_modal('Edit User', 'manage_user.php?id=' + $(this).attr('data-id'))
		})
		$('.delete_user').click(function() {
			_conf("Are you sure to delete this user?", "delete_user", [$(this).attr('data-id')])
		})

		function delete_user($id) {
			start_load()
			$.ajax({
				url: 'ajax.php?action=delete_user',
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