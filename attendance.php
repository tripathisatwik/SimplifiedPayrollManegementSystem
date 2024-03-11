<?php include 'dbconnect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Attendance</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function reset() {
            $('#manage-attendance').get(0).reset();
        }

        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }

        $(document).ready(function() {
            $('button[data-id]').click(function() {
                start_load();
                var cat = $('#manage-attendance');
                cat.get(0).reset();
                cat.find("[name='id']").val($(this).attr('data-id'));
                cat.find("[name='name']").val($(this).attr('data-name'));
                cat.find("[name='log_type']").val($(this).attr('data-logtype'));
                cat.find("[name='datetime_time']").val($(this).attr('data-datetime'));
                end_load();
            });
        });
    </script>
</head>

<body>
    <div class="depmain">
        <div class="depleft">
            <div class="depleftup">Attendance</div>
            <form id="manage-attendance" method="post" name="data">
                <div class="depleftmid">
                    <input type="hidden" name="id">
                    <label for="name">Name</label>
                    <select name="name" id="name">
                        <?php
                        $query = "SELECT employee.id, CONCAT(employee.lastname, ', ', employee.firstname, ' ', employee.middlename) AS ename FROM employee;";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row['id'] . "'>" . $row['ename'] . "</option>";
                        }
                        ?>
                    </select>
                    <label for="log_type">Type</label>
                    <select name="log_type" id="log_type">
                        <option value="1">Arrival Time</option>
                        <option value="2">Departure Time</option>
                    </select>
                    <label for="datetime_time">Date and Time</label>
                    <input type="datetime-local" name="datetime_time" id="datetime_time" required>
                </div>
                <div class="depleftdown">
                    <input type="submit" name="submit">
                    <button type="button" onclick="reset()" name="Cancel">Cancel</button>
                </div>
            </form>
        </div>
        <br>
        <div class="depright">
            <table border="1">
                <tr>
                    <th>Date</th>
                    <th>Employee No</th>
                    <th>Name</th>
                    <th>Time Record</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <?php
                    $sql = "SELECT a.employee_id, e.employee_no, CONCAT(e.lastname, ', ', e.firstname, ' ', e.middlename) AS ename, DATE_FORMAT(a.datetime_log, '%Y-%m-%d') AS date, DATE_FORMAT(a.datetime_log, '%h:%i:%s') AS time, a.log_type, a.id FROM attendance a INNER JOIN employee e ON a.employee_id = e.id ORDER BY UNIX_TIMESTAMP(a.datetime_log) ASC;";
                    $result1 = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result1)) {
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['employee_no'] . "</td>";
                        echo "<td>" . $row['ename'] . "</td>";
                        echo "<td>";
                        if ($row['log_type'] == 1) {
                            echo "Arrived at: " . $row['time'];
                        } else {
                            echo "Left at: " . $row['time'];
                        }
                    ?>
                        </td>
                        <td class="action-buttons">
                            <button data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['id']; ?>" data-logtype="<?php echo $row['log_type']; ?>" data-datetime="<?php echo $row['date']; ?>" id='edit_attendance'><i class="fa-solid fa-pen-to-square"></i></button>
                            <form method="post" onsubmit="return confirmDelete()">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                </tr>
            <?php
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
    $log_type = $_POST['log_type'];
    $datetime_time = $_POST['datetime_time'];
    if (!empty($edit_id)) {
        $sql_update = "UPDATE `attendance` SET `employee_id`='$name', `log_type`='$log_type', `datetime_log`='$datetime_time' WHERE id=$edit_id";
        $result_update = mysqli_query($conn, $sql_update);
        if ($result_update) {
            echo '<script>window.location="http://localhost/final/index.php?page=attendance"</script>';
        }
    } else {
        $sql_insert = "INSERT INTO `attendance`(`employee_id`, `log_type`, `datetime_log`) VALUES ('$name','$log_type','$datetime_time')";
        $result_insert = mysqli_query($conn, $sql_insert);
        if ($result_insert) {
            echo '<script>window.location="http://localhost/final/index.php?page=attendance"</script>';
        }
    }
}
if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM attendance WHERE id=$delete_id";
    $result_delete = mysqli_query($conn, $sql_delete);
    if (!$result_delete) {
        echo "Error deleting record: " . mysqli_error($conn);
    } else {
        echo '<script>window.location="http://localhost/final/index.php?page=attendance"</script>';
    }
}
?>