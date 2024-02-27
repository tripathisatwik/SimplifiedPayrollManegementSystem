<?php
include 'dbconnect.php';
if (!isset($_SESSION['view_id'])) {
    header("Location: http://localhost/final/index.php?page=employee");
    exit();
}
$id = $_SESSION['view_id'];
?>

<html>

<head>
    <style>
        .lower {
            display: flex;
            justify-content: space-around;
        }
    </style>

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
</head>

<body>
    <button class="back" onclick="window.location.href='http://localhost/final/index.php?page=employee'">Back</button>
    <div class="center">
        <div class="upper">
            <?php
            $empQuery = "SELECT e.*,d.name as dname,p.name as pname FROM employee e inner join department d on e.department_id = d.id inner join position p on e.position_id = p.id where e.id =" . $id;
            $result = mysqli_query($conn, $empQuery);
            if ($row = $result->fetch_assoc()) {
            ?>
                <h5><b>Employee ID :<?php echo $row["employee_no"]; ?></b></h5>
                <h4><b>Name:<?php echo ucwords($row['lastname'] . ', ' . $row['firstname'] . ' ' . $row['middlename']); ?></b></h4>
                <p><b>Department : <?php echo ucwords($row['dname']); ?></b></p>
                <p><b>Position : <?php echo ucwords($row['pname']); ?></b></p>
            <?php } ?>
        </div>
        <hr>
        <div class="lower">
            <div class="allowance">
                <div class="title">Allowance:</div>
                <?php
                $allowanceQuery = "SELECT * FROM employee_allowances ea INNER JOIN allowances a on ea.allowance_id = a.id WHERE employee_id =" . $id;
                $result1 = mysqli_query($conn, $allowanceQuery);
                ?>
                <div class="form">
                    <form action="" method="post">
                        <label for="allowance">Allowance</label>
                        <select name="allowance" id="allowance" required>
                            <?php
                            while ($row1 = $result1->fetch_assoc()) {
                                echo "<option value='{$row1['id']}'>{$row1['allowance']}</option>";
                            }
                            ?>
                        </select>
                        <label for="atype">Type</label>
                        <select name="atype" id="atype" required>
                            <option value="1">Monthly</option>
                            <option value="2">Semi-Monthly</option>
                            <option value="3">Once</option>
                        </select>
                        <label for="aamount">Amount:</label>
                        <input type="number" name="aamount" id="aamount" required>
                        <input type="submit" name="allowances">
                        <button type="button" onclick="reset()">Cancel</button>
                    </form>
                </div>
                <div class="data">
                    <?php
                    $asno = 1;
                    $result2 = mysqli_query($conn, $allowanceQuery);
                    while ($row2 = $result2->fetch_assoc()) {
                    ?>
                        <table>
                            <tr>
                                <th>S.no.</th>
                                <th>Type of Allowance</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><?php echo $asno++ ?></td>
                                <td>
                                    <?php
                                    if ($row2['type'] == 1) {
                                        echo 'Monthly';
                                    } else if ($row2['type'] == 2) {
                                        echo 'Semi-Monthly';
                                    } else if ($row2['type'] == 3) {
                                        echo 'Once';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row2['amount'] ?></td>
                                <td>
                                    <button type="button" data-id="<?php echo $row2['id']; ?>" data-name="<?php echo $row2['dname'] ?>">Edit</button>
                                    <form method="post" onsubmit="return confirmDelete()">
                                        <input type="hidden" name="delete_id" value="<?php echo $row2['id']; ?>">
                                        <input type="submit" name="delete" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        </table>
                    <?php } ?>
                </div>
            </div>
            <div class="deductions">
                <div class="title">Deductions:</div>
                <?php
                $deductionQuery = "SELECT * FROM employee_deductions ed INNER JOIN deductions d on ed.deduction_id = d.id WHERE employee_id =" . $id;
                $result3 = mysqli_query($conn, $deductionQuery);
                ?>
                <div class="form">
                    <form action="" method="post">
                        <label for="deduction">Deductions</label>
                        <select name="deduction" id="deduction">
                            <?php
                            while ($row3 = $result3->fetch_assoc()) {
                                echo "<option value='{$row3['id']}'>{$row3['deduction']}</option>";
                            }
                            ?>
                        </select>
                        <label for="dtype">Type</label>
                        <select name="dtype" id="dtype">
                            <option value="1">Monthly</option>
                            <option value="2">Semi-Monthly</option>
                            <option value="3">Once</option>
                        </select>
                        <label for="damount">Amount:</label>
                        <input type="number" name="damount" id="damount">
                        <input type="submit" name="deductions">
                        <button type="button" onclick="reset()">Cancel</button>
                    </form>
                </div>
                <div class="data">
                    <?php
                    $dsno = 1;
                    $result4 = mysqli_query($conn, $deductionQuery);
                    while ($row4 = $result4->fetch_assoc()) {
                    ?>
                        <table>
                            <tr>
                                <th>S.no.</th>
                                <th>Type of Deduction</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><?php echo $dsno++ ?></td>
                                <td>
                                    <?php
                                    if ($row4['type'] == 1) {
                                        echo 'Monthly';
                                    } else if ($row4['type'] == 2) {
                                        echo 'Semi-Monthly';
                                    } else if ($row4['type'] == 3) {
                                        echo 'Once';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row4['amount'] ?></td>
                                <td>
                                    <button type="button" data-id="<?php echo $row4['id']; ?>" data-name="<?php echo $row4['dname'] ?>">Edit</button>
                                    <form method="post" onsubmit="return confirmDelete()">
                                        <input type="hidden" name="delete_id" value="<?php echo $row4['id']; ?>">
                                        <input type="submit" name="delete" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
if (isset($_POST['allowances'])) {
    $allowanceid = $_POST['allowance'];
    $allowancetype = $_POST['atype'];
    $allowanceamount = $_POST['aamount'];
    $sql_insert = "INSERT INTO `employee_allowances`(`employee_id`, `allowance_id`, `type`, `amount`, `effective_date`, `date_created`) VALUES ($id, $allowanceid, $allowancetype, $allowanceamount, NOW(), NOW())";
    $result_insert = mysqli_query($conn, $sql_insert);
    if ($result_insert) {
        echo '<script>window.location="http://localhost/final/index.php?page=view_employee"</script>';
    } else {
        echo "Error inserting record: " . mysqli_error($conn);
    }
} elseif (isset($_POST['deductions'])) {
    $deductionid = $_POST['deduction'];
    $deductiontype = $_POST['dtype'];
    $deductionamount = $_POST['damount'];
    $sql_insert = "INSERT INTO `employee_deductions`(`employee_id`, `deduction_id`, `type`, `amount`, `effective_date`, `date_created`) VALUES ($id, $deductionid, $deductiontype, $deductionamount, NOW(), NOW())";
    $result_insert = mysqli_query($conn, $sql_insert);
    if ($result_insert) {
        echo '<script>window.location="http://localhost/final/index.php?page=view_employee"</script>';
    } else {
        echo "Error inserting record: " . mysqli_error($conn);
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