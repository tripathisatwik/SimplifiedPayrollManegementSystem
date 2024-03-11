<?php include 'dbconnect.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employee</title>
    <link rel="stylesheet" href="style.css">
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
                var cat = $('#manage-employee');
                cat.get(0).reset();
                cat.find("[name='id']").val($(this).attr('data-id'));
                cat.find("[name='firstname']").val($(this).attr('data-firstname'));
                cat.find("[name='middlename']").val($(this).attr('data-middlename'));
                cat.find("[name='lastname']").val($(this).attr('data-lastname'));
                cat.find("[name='department']").val($(this).attr('data-department'));
                cat.find("[name='salary']").val($(this).attr('data-salary'));
                var departmentId = $(this).attr('data-department');
                $.ajax({
                    url: 'employee.php',
                    method: 'POST',
                    data: {
                        department_id: departmentId
                    },
                    success: function(response) {
                        $('#position').html(response);
                    }
                });
                cat.find("[name='position']").val($(this).attr('data-position'));
                end_load();
            });

            $('#department').change(function() {
                var departmentId = $(this).val();
                $.ajax({
                    url: 'employee.php',
                    method: 'POST',
                    data: {
                        department_id: departmentId
                    },
                    success: function(response) {
                        $('#position').html(response);
                    }
                });
            });
        });
    </script>
</head>

<body>
    <div class="depmain">
        <div class="depleft">
            <div class="depleftup">Employee</div>
            <form id="manage-employee" method="post" class="inputform">
                <div class="depleftmid">
                    <input type="hidden" name="id" required>
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" required>
                    <label for="middlename">Middle Name</label>
                    <input type="text" id="middlename" name="middlename" placeholder="(optional)">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" required>
                    <label for="department">Department</label>
                    <select id="department" name="department" required>
                        <?php
                        $dept = $conn->query("SELECT * from department order by dname asc");
                        while ($row = $dept->fetch_assoc()) :
                        ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['dname'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <label for="position">Position</label>
                    <select name="position" id="position" required>
                    </select>
                    <label for="salary">Salary</label>
                    <input type="number" name="salary" id="salary" required>
                </div>
                <div class="depleftdown">
                    <input type="submit" name="submit">
                    <button type="submit" onclick="reset()" name="Cancel">Cancel</button>
                </div>
            </form>
        </div>
        <br>
        <div class="depright">
            <table border="1">
                <tr>
                    <th>Employee No</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <?php
                    $data = $conn->query("SELECT e.id,e.employee_no,e.firstname,e.middlename,e.lastname,e.department_id,e.position_id,e.salary, d.dname,p.name FROM employee e INNER JOIN department d ON e.department_id = d.id INNER JOIN position p ON e.position_id = p.id;");
                    while ($row = $data->fetch_assoc()) {
                        echo  "<td>" . $row["employee_no"] . "</td>";
                        echo  "<td>" . $row["firstname"] . "</td>";
                        echo  "<td>" . $row["middlename"] . "</td>";
                        echo  "<td>" . $row["lastname"] . "</td>";
                        echo  "<td>" . $row["dname"] . "</td>";
                        echo  "<td>" . $row["name"] . "</td>";
                        echo  "<td>" . $row["salary"] . "</td>";
                    ?>
                        <td class="action">
                            <button name="edit" id="edit_empolyee" data-id="<?php echo $row['id']; ?>" data-employee_no="<?php echo $row['employee_no'] ?>" data-firstname="<?php echo $row['firstname'] ?>" data-middlename="<?php echo $row['middlename'] ?>" data-lastname="<?php echo $row['lastname'] ?>" data-department="<?php echo $row['department_id'] ?>" data-position="<?php echo $row['position_id'] ?>" data-salary="<?php echo $row['salary'] ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="manage_employee" id="manage_employee" type="button">
                                <a href="http://localhost/final/index.php?page=manage_employee"><i class="fa-solid fa-list-check"></i></a>
                                <?php
                                $_SESSION['view_id'] = $row['id'];
                                ?>
                            </button>
                            <form method="post" onsubmit="return confirmDelete()">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    <?php
                    }
                    ?>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
    $edit_id = $_POST['id'];
    $employee_no = $_POST['employee_no'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];

    if (!empty($edit_id)) {
        $sql_update = "UPDATE `employee` SET `firstname`='$firstname',`middlename`='$middlename',`lastname`='$lastname',`department_id`='$department',`position_id`='$position',`salary`='$salary' WHERE id=$edit_id";
        $result_update = mysqli_query($conn, $sql_update);
        if ($result_update) {
            echo '<script>window.location="http://localhost/final/index.php?page=employee"</script>';
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        $year = date("Y");
        $employee_no = $year . "-" . str_pad($department, 2, "0", STR_PAD_LEFT) . str_pad($position, 2, "0", STR_PAD_LEFT) . str_pad($edit_id, 2, "0", STR_PAD_LEFT);
        $sql_insert = "INSERT INTO `employee`(`employee_no`, `firstname`, `middlename`, `lastname`, `department_id`, `position_id`, `salary`) VALUES ('$employee_no','$firstname','$middlename','$lastname','$department','$position','$salary')";
        $result_insert = mysqli_query($conn, $sql_insert);
        if ($result_insert) {
            echo '<script>window.location="http://localhost/final/index.php?page=employee"</script>';
        } else {
            echo "Error inserting record: " . mysqli_error($conn);
        }
    }
}
if (isset($_POST['department_id'])) {
    $departmentId = $_POST['department_id'];
    $positionsQuery = $conn->query("SELECT * from position WHERE department_id = $departmentId order by name asc");
    $options = '';
    while ($row = $positionsQuery->fetch_assoc()) {
        $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }

    echo $options;
}

if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM employee WHERE id=$delete_id";
    $result_delete = mysqli_query($conn, $sql_delete);

    if (!$result_delete) {
        echo "Error deleting record: " . mysqli_error($conn);
    } else {
        echo '<script>window.location="http://localhost/final/index.php?page=employee"</script>';
    }
}
?>