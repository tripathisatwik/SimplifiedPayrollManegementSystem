<?php include 'dbconnect.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
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

        .depleftdown input {
            padding: 8px;
            margin-right: 10px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .depleftdown button {
            padding: 8px;
            margin-right: 10px;
            cursor: pointer;
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

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
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
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
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
    </script>
</head>

<body>
    <button id="myBtn">New Department</button>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="depleft">
                <form action="http://localhost/final/index.php?page=department" method="post" id="manage-department">
                    <div class="depleftup">Department</div>
                    <div class="depleftmid">
                        <input type="hidden" name="id">
                        <label class="control-label">Name</label><br>
                        <input type="text" name="name" required>
                    </div>
                    <div class="depleftdown">
                        <input type="submit" name="submit">
                        <button type="button" onclick="reset()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="depright">
        <table border=1>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            <?php
            $sql = "select * from department";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            $sno = 1;
            if ($num > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $sno++ . "</td>";
                    echo "<td>" . $row['dname'] . "</td>";
            ?>
                    <td>
                        <button type="button" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['dname'] ?>">Edit</button>
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

</body>

</html>

<?php
if (isset($_POST['submit'])) {
    $edit_id = $_POST['id'];
    $name = $_POST['name'];
    if (!empty($edit_id)) {
        $sql_update = "UPDATE department SET dname='$name' WHERE id=$edit_id";
        $result_update = mysqli_query($conn, $sql_update);
        if ($result_update) {
            echo '<script>window.location="http://localhost/final/index.php?page=department"</script>';
        }
    } else {
        $sql_insert = "INSERT INTO department (dname) VALUES ('$name')";
        $result_insert = mysqli_query($conn, $sql_insert);
        if ($result_insert) {
            echo '<script>window.location="http://localhost/final/index.php?page=department"</script>';
        }
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