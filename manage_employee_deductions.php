<?php
include 'dbconnect.php';
if (!isset($_SESSION['view_id'])) {
    header("Location: http://localhost/final/index.php?page=employee");
    exit();
}
$id = $_SESSION['view_id'];

if (isset($_POST['submit'])) {
    $deductionid = $_POST['name'];
    $deductiontype = $_POST['type'];
    $deductionamount = $_POST['amount'];

    if (empty($deductionamount && $deductionid && $deductiontype)) {
        echo '<script>alert("All fields are required")</script>';
        echo '<script>window.location="http://localhost/final/index.php?page=manage_employee_deductions"</script>';
        exit();
    }

    $edit_id = $_POST['id'];
    if ($edit_id) {
        $sql_update = "UPDATE `employee_deductions` SET `deduction_id`='$deductionid', `type`='$deductiontype', `amount`='$deductionamount', `effective_date`=NOW() WHERE ed_id='$edit_id'";
        $result_update = mysqli_query($conn, $sql_update);
        if ($result_update) {
            echo '<script>alert("Deductions Data Updated")</script>';
            echo '<script>window.location="http://localhost/final/index.php?page=manage_employee_deductions"</script>';
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        $sql_insert = "INSERT INTO `employee_deductions`(`employee_id`, `deduction_id`, `type`, `amount`, `effective_date`, `date_created`) VALUES ('$id', '$deductionid', '$deductiontype', '$deductionamount', NOW(), NOW())";
        $result_insert = mysqli_query($conn, $sql_insert);
        if ($result_insert) {
            echo '<script>window.location="http://localhost/final/index.php?page=manage_employee_deductions"</script>';
            exit();
        } else {
            echo "Error inserting record: " . mysqli_error($conn);
        }
    }
}

if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM `employee_deductions` WHERE ed_id = '$delete_id'";
    $result_delete = mysqli_query($conn, $sql_delete);
    if (!$result_delete) {
        echo "Error deleting record: " . mysqli_error($conn);
    } else {
        echo '<script>window.location="http://localhost/final/index.php?page=manage_employee_deductions"</script>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Deductions</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .action-buttons button,
        form {
            display: inline-block;
            vertical-align: middle;
        }

        .back-btn {
            background-color: #007bff;
            border-radius: 4px;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border: none;
        }
    </style>
    <script>
        function reset() {
            $('#manage-manage_employee_deductions').get(0).reset();
        }

        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }

        $(document).ready(function() {
            $('button[data-id]').click(function() {
                start_load();
                var cat = $('#manage-manage_employee_deductions');
                cat.get(0).reset();
                cat.find("[name='id']").val($(this).attr('data-id'));
                cat.find("[name='deduction']").val($(this).attr('data-name'));
                cat.find("[name='type']").val($(this).attr('data-type'));
                cat.find("[name='amount']").val($(this).attr('data-amount'));
                end_load();
            });
        });
    </script>
</head>

<body>
    <button class="back-btn"><a href='http://localhost/final/index.php?page=employee'>Back</a></button>
    <div class="depmain">
        <?php
        $result1 = mysqli_query($conn, "SELECT * FROM `deductions`");
        ?>
        <div class="depleft">
            <form id="manage-manage_employee_deductions" method="post" action="http://localhost/final/index.php?page=manage_employee_deductions">
                <div class="depleftup">Deductions</div>
                <div class="depleftmid">
                    <input type="hidden" id="id" name="id">
                    <label for="deduction">Deduction</label>
                    <select name="name" id="deduction" required>
                        <?php while ($allq = $result1->fetch_assoc()) { ?>
                            <option value="<?php echo $allq['id'] ?>"><?php echo $allq['deduction'] ?></option>
                        <?php } ?>
                    </select>
                    <label for="type">Type</label>
                    <select name="type" id="type" required>
                        <option value="1">Monthly</option>
                        <option value="2">Semi-Monthly</option>
                        <option value="3">Once</option>
                    </select>
                    <label for="amount">Amount:</label>
                    <input type="number" name="amount" id="amount" required>
                </div>
                <div class="depleftdown">
                    <input type="submit" name="submit" value="Add Deduction">
                    <button onclick="reset()">Cancel</button>
                </div>
            </form>
        </div>
        <div class="depright">
            <table>
                <tr>
                    <th>S.no.</th>
                    <th>Name</th>
                    <th>Type of Deductions</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                <?php
                $sno = 1;
                $result2 = mysqli_query($conn, "SELECT * FROM `employee_deductions` INNER JOIN deductions on deduction_id=deductions.id where employee_id = " . $id);
                while ($row = $result2->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $sno++ ?></td>
                        <td><?php echo $row['deduction'] ?></td>
                        <td>
                            <?php
                            if ($row['type'] == 1) {
                                echo 'Monthly';
                            } else if ($row['type'] == 2) {
                                echo 'Semi-Monthly';
                            } else if ($row['type'] == 1) {
                                echo 'Once';
                            }
                            ?>
                        </td>
                        <td><?php echo $row['amount'] ?></td>
                        <td>
                            <button name="edit" id="edit_deduction" data-id="<?php echo $row['ed_id'] ?>" data-name="<?php echo $row['deduction'] ?>" data-type="<?php echo $row['type']; ?>" data-amount="<?php echo $row['amount']; ?>"><img src="./icons/editing-modified.png" alt="Edit"></button>
                            <form method="post" onsubmit="return confirmDelete()">
                                <input type="hidden" name="delete_id" value="<?php echo $row['ed_id']; ?>">
                                <button type="submit" name="delete"><img src="./icons/delete-modified.png" alt="Delete"></button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>