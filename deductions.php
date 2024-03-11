<?php include 'dbconnect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Deductions</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function reset() {
            $('#manage-deduction').get(0).reset();
        }

        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }

        $(document).ready(function () {
            $('button[data-id]').click(function () {
                start_load();
                var cat = $('#manage-deduction');
                cat.get(0).reset();
                cat.find("[name='id']").val($(this).attr('data-id'));
                cat.find("[name='name']").val($(this).attr('data-name'));
                cat.find("[name='description']").val($(this).attr('data-des'));
                end_load();
            });
        });
    </script>
</head>

<body>
    <div class="depmain">
        <div class="depleft">
            <form action="http://localhost/final/index.php?page=deductions" method="post" id="manage-deduction">
                <div class="depleftup">Deductions</div>
                <div class="depleftmid">
                    <div>
                        <input type="hidden" name="id">
                        <label for="name">Name</label><br>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div>
                        <label for="description">Description</label><br>
                        <textarea name="description" id="description" required cols="30" rows="2"></textarea>
                    </div>
                </div>
                <div class="depleftdown">
                    <input type="submit" name="submit" value="Submit">
                    <button type="button" onclick="reset()">Cancel</button>
                </div>
            </form>
        </div>
        <div class="depright">
            <table>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                <?php
                $sql = "select * from deductions";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                $sno = 1;
                if ($num > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $sno++ .  "</td>";
                        echo "<td>";
                        echo "<p>Name:" . $row['deduction'] . "</p>";
                        echo "<p>Description:" . $row['description'] . "</p>";
                        echo "</td>";

                ?>
                        <td class="action-buttons">
                            <button type="button" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['deduction'] ?>" data-des="<?php echo $row['description']; ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                            <form method="post" onsubmit="return confirmDelete()">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete"><i class="fa-solid fa-trash-can"></i></button>
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
    $description = $_POST['description'];
    $sql = "select * from deductions  where id='$edit_id'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        $sql_update = "UPDATE `deductions` SET `deduction`='$name',`description`='$description' WHERE id='$edit_id' ";
        $result_update = mysqli_query($conn, $sql_update);
        if ($result_update) {
            echo '<script>window.location="http://localhost/final/index.php?page=deductions"</script>';
        }
    } else {
        $sql_insert = "INSERT INTO `deductions`(`id`, `deduction`, `description`) VALUES ('','name','$description')";
        $result_insert = mysqli_query($conn, $sql_insert);
        if ($result_insert) {
            echo '<script>window.location="http://localhost/final/index.php?page=deductions"</script>';
        }
    }
}

if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM deductions WHERE id=$delete_id";
    $result_delete = mysqli_query($conn, $sql_delete);

    if (!$result_delete) {
        echo "Error deleting record: " . mysqli_error($conn);
    } else {
        echo '<script>window.location="http://localhost/final/index.php?page=deductions"</script>';
    }
}
?>
