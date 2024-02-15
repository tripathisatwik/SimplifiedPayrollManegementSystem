<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <div class="main">
        <div class="left">
            <form action="" method="post" id="manage-department">
                <div class="up">Department</div>
                <div class="mid">
                    <label for="dept_name">Department Name: </label><br>
                    <textarea name="depname" id="" cols="30" rows="2"></textarea>
                </div>
                <div class="down">
                    <input type="submit" name="submit">
                    <button onclick="reset()">Cancel</button>
                </div>
            </form>
        </div>
        <div class="right">
            <table border="1px solid black">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <?php
                    include 'dbconnect.php';
                    $sql = "select * form department";
                    $result = mysqli_query($conn, $sql);
                    $num = mysqli_num_rows($result);
                    if($num>0){
                        while($row = mysqli_fetch_assoc( $result)){
                            echo "<td>".$row['id']."</td>";
                            echo "<td>".$row['name']."</td>";
                            ?>
                            <td>
                                <input type="submit" value="Edit">
                                <input type="submit" value="Delete">
                            </td>
                            <?php
                        }
                    }
                    ?>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
<script>
    function reset() {
        $('#manage-department').get(0).reset();
    }
</script>
<?php
if(isset($_POST['submit']))
{
    $name = $_POST['depname'];
    $sql ="select * form department where name = $name";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if($num==0){
        $sql1 = "insert into department values (null,'$name')";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
    }else{
        $sql1 = "UPDATE `department` SET `name`='$name' WHERE `name`='$oldname' ";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
    }
}
?>