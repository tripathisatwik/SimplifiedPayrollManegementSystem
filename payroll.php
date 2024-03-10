<?php include "dbconnect.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Payroll</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .card {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            padding: 15px;
            background-color: #007bff;
            color: #fff;
            border-radius: 10px 10px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-body {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        td.text-center {
            text-align: center;
        }

        button {
            padding: 8px 12px;
            margin: 2px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        button.calculate_payroll {
            background-color: #28a745;
            color: #fff;
        }

        button.view_payroll,
        button.edit_payroll,
        button.remove_payroll {
            background-color: transparent;
            color: #fff;
        }

        i {
            margin-right: 5px;
        }

        i.fa-eye {
            color: #28a745;
        }

        i.fa-pen-to-square {
            color: #007bff;
        }

        i.fa-trash-can {
            color: #dc3545;
        }

        center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Center the modal */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            width: 60%;
            max-width: 400px;
            background-color: #fefefe;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-content {
            text-align: center;
        }

        /* Add a close button */
        .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: 10px;
            cursor: pointer;
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }
        var modal = document.getElementById("payrollModal");

        // Get the button that opens the modal
        var addPayrollBtn = document.getElementById("new_payroll_btn");
        var editPayrollBtns = document.querySelectorAll(".edit_payroll");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        addPayrollBtn.onclick = function() {
            modal.style.display = "block";
            document.getElementById("payrollForm").reset();
            document.getElementById("payrollSubmit").innerText = "Add Payroll";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Function to handle edit payroll
        function editPayroll(id, fromDate, toDate, type) {
            modal.style.display = "block";
            document.getElementById("payrollId").value = id;
            document.getElementById("fromDate").value = fromDate;
            document.getElementById("toDate").value = toDate;
            document.getElementById("type").value = type;
            document.getElementById("payrollSubmit").innerText = "Update Payroll";
        }

        // Attach event listeners to edit buttons
        editPayrollBtns.forEach(function(btn) {
            btn.addEventListener("click", function() {
                var id = this.getAttribute("data-id");
                var fromDate = this.getAttribute("data-fromDate");
                var toDate = this.getAttribute("data-toDate");
                var type = this.getAttribute("data-type");
                editPayroll(id, fromDate, toDate, type);
            });
        });
    </script>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <span><b>Payroll List</b></span>
            <button class="add_payroll" type="button" id="new_payroll_btn"><i class="fa-solid fa-plus"></i> Add Payroll</button>
        </div>
        <div class="card-body">
            <table id="table">
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
                    $payroll = $conn->query("SELECT * FROM payroll order by date(date_from) desc");
                    while ($row = $payroll->fetch_array()) :
                    ?>
                        <tr>
                            <td><?php echo $row['ref_no'] ?></td>
                            <td><?php echo date("M d, Y", strtotime($row['date_from'])) ?></td>
                            <td><?php echo date("M d, Y", strtotime($row['date_to'])) ?></td>
                            <td class="text-center">
                                <?php echo ($row['status'] == 0) ? '<span>New</span>' : '<span>Calculated</span>'; ?>
                            </td>
                            <td>
                                <center>
                                    <?php if ($row['status'] == 0) : ?>
                                        <button class="calculate_payroll" data-id="<?php echo $row['id'] ?>">Calculate</button>
                                    <?php else : ?>
                                        <button class="view_payroll" data-id="<?php echo $row['id'] ?>"><i class="fa-regular fa-eye"></i></button>
                                    <?php endif ?>
                                    <button class="edit_payroll" data-id="<?php echo $row['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <form method="POST" onsubmit="return confirmDelete()">
                                        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete" class="remove_payroll">
                                            <i class="fa-solid fa-trash-can"></i>Delete
                                        </button>
                                    </form>
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
    <!-- Add this code inside the <body> tag, after the existing code -->
    <div id="payrollModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form method="POST" id="payrollForm">
                <input type="hidden" name="id" id="payrollId">
                <label for="fromDate">Date From:</label>
                <input type="date" name="fromDate" id="fromDate" required>
                <label for="toDate">Date To:</label>
                <input type="date" name="toDate" id="toDate" required>
                <label for="type">Type:</label>
                <select name="type" id="type" required>
                    <option value="monthly">Monthly</option>
                    <option value="semi-monthly">Semi-Monthly</option>
                </select>
                <button type="submit" name="submit" id="payrollSubmit">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>

<?php
if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM payroll WHERE id=$delete_id";
    $result_delete = mysqli_query($conn, $sql_delete);

    if (!$result_delete) {
        echo "Error deleting record: " . mysqli_error($conn);
    } else {
        echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
    }
}

if (isset($_POST['submit'])) {
    $edit_id = $_POST['id'];
    if (!empty($edit_id)) {
        $sql_update = "UPDATE `payroll` SET `date_from`='$date_from',`date_to`='$date_to',`type`='$type' WHERE  id=$edit_id";
        $result_update = mysqli_query($conn, $sql_update);
        if ($result_update) {
            echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
        }
    } else {
        $ref_no = date('Y') . '-' . mt_rand(1, 9999);
        $date = date("Y/m/d");
        $sql_insert = "INSERT INTO `payroll`(`ref_no`, `date_from`, `date_to`, `type`, `status`, `date_created`) VALUES ('$ref_no','$date_from','$date_to','$type',0,'$date')";
        $result_insert = mysqli_query($conn, $sql_insert);
        if ($result_insert) {
            echo '<script>window.location="http://localhost/final/index.php?page=payroll"</script>';
        }
    }
}
?>