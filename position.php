<?php include 'dbconnect.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Position</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .action-buttons button,
        form {
            display: inline-block;
            vertical-align: middle;
        }
    </style>
    <script>
        function reset() {
            $('#manage-position').get(0).reset();
        }

        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }

        $(document).ready(function() {
            $('button[data-id]').click(function() {
                start_load();
                var cat = $('#manage-position');
                cat.get(0).reset();
                cat.find("[name='id']").val($(this).attr('data-id'));
                cat.find("[name='name']").val($(this).attr('data-name'));
                cat.find("[name='department']").val($(this).attr('data-dep'));
                end_load();
            });
        });
    </script>
</head>

<body>
    <div class="depmain">
        <div class="depleft">
            <form action="http://localhost/final/index.php?page=position" method="post" id="manage-position">
                <div class="depleftup">Position</div>
                <div class="depleftmid">
                    <input type="hidden" name="id">
                    <label class="control-label">Department</label><br>
                    <select name="department" required>
                        <?php
                        $dept = $conn->query("SELECT * from department order by dname asc");
                        while ($row = $dept->fetch_assoc()) :
                        ?>
                            <option value="<?php echo $row['id'] ?>"><?php echo $row['dname'] ?></option>
                        <?php endwhile; ?>
                    </select><br>
                    <label class="control-label">Name</label><br>
                    <input type="text" name="name" required>
                </div>
                <div class="depleftdown">
                    <input type="submit" name="submit">
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
                $sql = "SELECT position.id, position.name, department.dname, position.department_id FROM `position` INNER JOIN department ON position.department_id = department.id; ";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                $sno = 1;
                if ($num > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $sno++ . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                ?>
                        <td class="action-buttons">
                            <button type="button" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name'] ?>" data-dep="<?php echo $row['department_id']; ?>"><img src="./icons/editing-modified.png" alt="Edit"></button>
                            <form method="post" onsubmit="return confirmDelete()">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete"><img src="./icons/delete-modified.png" alt="Delete"></button>
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
if (isset($_POST['submit'])) {
    $edit_id = $_POST['id'];
    $name = $_POST['name'];
    $dept = $_POST['department'];
    if (empty($name)) {
        echo '<script>alert("All fields required")</script>';
        echo '<script>window.location="http://localhost/final/index.php?page=position"</script>';
    }else{
        if (!empty($edit_id)) {
            $sql_update = "UPDATE position SET department_id='$dept', name='$name' WHERE id='$edit_id'";
            $result_update = mysqli_query($conn, $sql_update);
            if ($result_update) {
                echo '<script>alert("Position Updated")</script>';
                echo '<script>window.location="http://localhost/final/index.php?page=position"</script>';
            } else {
                echo '<script>console.log("Error updating record!");</script>';
                echo '<script>window.location="http://localhost/final/index.php?page=position"</script>';
            }
        } else {
            $sql_insert = "INSERT INTO position (department_id, name) VALUES ('$dept', '$name')";
            $result_insert = mysqli_query($conn, $sql_insert);
            if ($result_insert) {
                echo '<script>alert("New Position Added")</script>';
                echo '<script>window.location="http://localhost/final/index.php?page=position"</script>';
            } else {
                echo '<script>console.log("Error inserting record!");</script>';
                echo '<script>window.location="http://localhost/final/index.php?page=position"</script>';
            }
        }
    }
}

if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM position WHERE id='$delete_id'";
    $result_delete = mysqli_query($conn, $sql_delete);
    if (!$result_delete) {
        echo '<script>console.log("Error deleting record!");</script>';
        echo '<script>window.location="http://localhost/final/index.php?page=position"</script>';
    } else {
        echo '<script>alert("Position Deleted")</script>';
        echo '<script>window.location="http://localhost/final/index.php?page=position"</script>';
    }
}
?>