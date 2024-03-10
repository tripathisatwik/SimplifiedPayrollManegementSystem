<?php include "dbconnect.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Payroll</title>
    <style>
        .container-fluid {
            margin: 0;
            padding: 0;
            width: 100%;
            box-sizing: border-box;
        }

        .col-lg-12 {
            width: 100%;
            box-sizing: border-box;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 0.2rem;
            margin-bottom: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 0.75rem;
            border-bottom: 1px solid #ccc;
        }

        .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
            cursor: pointer;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border: 1px solid #007bff;
        }

        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border: 1px solid #dc3545;
        }

        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.2rem;
        }

        .badge-primary {
            color: #fff;
            background-color: #007bff;
        }

        .badge-success {
            color: #fff;
            background-color: #28a745;
        }

        table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        /* Example styling for custom modal */
        .custom-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            position: relative;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <span><b>Payroll List</b></span>
            <button class="btn btn-primary btn-sm btn-block col-md-3 float-right" type="button" id="new_payroll_btn">Add Payroll</button>
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Ref No</th>
                        <th>Date From</th>
                        <th>Date To</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $payroll = $conn->query("SELECT * FROM payroll order by date(date_from) desc") or die(mysqli_error($conn));
                    while ($row = $payroll->fetch_array()) :
                    ?>
                        <tr>
                            <td><?php echo $row['ref_no'] ?></td>
                            <td><?php echo date("M d, Y", strtotime($row['date_from'])) ?></td>
                            <td><?php echo date("M d, Y", strtotime($row['date_to'])) ?></td>
                            <td class="text-center">
                                <?php if ($row['status'] == 0) : ?>
                                    <span>New</span>
                                <?php else : ?>
                                    <span>Calculated</span>
                                <?php endif ?>
                            </td>
                            <td>
                                <center>
                                    <?php if ($row['status'] == 0) : ?>
                                        <button class="calculate_payroll" data-id="<?php echo $row['id'] ?>">Calculate</button>
                                    <?php else : ?>
                                        <button class="view_payroll" data-id="<?php echo $row['id'] ?>">View</button>
                                    <?php endif ?>
                                    <button class="edit_payroll" data-id="<?php echo $row['id'] ?>">Edit</button>
                                    <button class="remove_payroll" data-id="<?php echo $row['id'] ?>">Delete</button>
                                </center>
                            </td>
                        </tr>
                    <?php
                    endwhile;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
<div role="document" class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Edit Employee</h5>
      </div>
      <div class="modal-body"><div class="container-fluid">
	<div class="col-lg-12">
		<form id="manage-payroll">
				<input type="hidden" name="id" value="">
				<div class="form-group">
					<label for="" class="control-label">Date From :</label>
					<input type="date" class="form-control" name="date_from">
				</div>
				<div class="form-group">
					<label for="" class="control-label">Date To :</label>
					<input type="date" class="form-control" name="date_to">
				</div>
				<div class="form-group">
					<label for="" class="control-label">Payroll Type :</label>
					<select name="type" class="custom-select browser-default" id="">
						<option value="1">Monthly</option>
						<option value="2">Semi-Monthly</option>
					</select>
				</div>
		</form>
	</div>
</div>

<script>
	$('#manage-payroll').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
		url:'ajax.php?action=save_payroll',
		method:"POST",
		data:$(this).serialize(),
		error:err=>console.log(),
		success:function(resp){
				if(resp == 1){
					alert_toast("Payroll successfully saved","success");
					setTimeout(function(){
								location.reload()
							},1000)
				}
		}
	})
	})
</script></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="submit" onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>