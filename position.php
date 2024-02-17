<?php include 'dbconnect.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .depmain {
            display: flex;
            justify-content: space-between;
            margin: 20px;
        }

        .depleft,
        .depright {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            /* Add border around depleft */
        }

        .depleftup {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .depleftmid,
        .depleftdown {
            margin-bottom: 10px;
        }

        .depleftmid textarea {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .depleftdown {
            display: flex;
            align-items: center;
        }

        .depleftdown input,
        .depleftdown button {
            padding: 8px;
            margin-right: 10px;
            cursor: pointer;
        }

        .depleftdown input {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .depleftdown button {
            background-color: red;
            color: white;
            border: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="depmain">
        <div class="depleft">
            <form action="http://localhost/final/index.php?page=position" method="post" id="manage-position">
                <div class="depleftup">Position</div>
                <div class="depleftmid">
                    <input type="hidden" name="id" value="<?php echo isset($edit_id) ? $edit_id : ''; ?>">
                    <label class="control-label">Department</label><br>
                    <select name="department">
                        <option value=""></option>
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
                    <input type="submit" name="submit" value="<?php echo isset($edit_id) ? 'Update' : 'Save'; ?>">
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
                        <td>
                            <button type="button" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name'] ?>" data-dep="<?php echo $row['department_id']; ?>">Edit</button>
                            <form method="post" onsubmit="return confirmDelete()">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                <input type="submit" name="delete" value="Delete">
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
    if ($edit_id != '') {
        $sql_update = "UPDATE position SET department_id='$dept', name='$name' WHERE id='$edit_id'";
        $result_update = mysqli_query($conn, $sql_update);
        if ($result_update) {
            echo '<script>window.location="http://localhost/final/index.php?page=position"</script>';
        } else {
            echo '<script>console.log("Error updating record!");</script>';
        }
    } else {
        $sql_insert = "INSERT INTO position (department_id, name) VALUES ('$dept', '$name')";
        $result_insert = mysqli_query($conn, $sql_insert);
        if ($result_insert) {
            echo '<script>window.location="http://localhost/final/index.php?page=position"</script>';
        } else {
            echo '<script>console.log("Error inserting record!");</script>';
        }
    }
}

if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM position WHERE id='$delete_id'";
    $result_delete = mysqli_query($conn, $sql_delete);
    if (!$result_delete) {
        echo '<script>console.log("Error deleting record!");</script>';
    } else {
        echo '<script>window.location="http://localhost/final/index.php?page=position"</script>';
    }
}
?>
