<?php include 'dbconnect.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>SignUp</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .formsheet {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        form {
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        hr {
            border: 1px solid #ccc;
        }

        .input-label {
            text-align: left;
            margin-left: 15px;
        }

        input[type="text"],
        input[type="number"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }

        a:hover {
            color: #0056b3;
        }

        .register-unsuccess {
            color: red;
            font-weight: bold;
        }

        .account-created {
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="formsheet">
        <form action="" method="POST">
            <h1>SignUp</h1>
            <hr>
            <label class="input-label">Name</label>
            <input type="text" name="name" required placeholder="Enter Name"><br>
            <label class="input-label">Username</label>
            <input type="text" name="username" required placeholder="Enter Username"><br>
            <label class="input-label">Password</label>
            <input type="password" name="password" required placeholder="Enter Password"><br>
            <select name="type" id="type">
                <option value="1">Admin</option>
                <option value="2">User</option>
            </select><br><br>
            <input type="submit" name="submit" value="SignUp">
        </form>
    </div>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
    $name = $_POST["name"];
    $username = $_POST["name"];
    $password = md5($_POST["password"]);
    $type = $_POST["type"];
    $sql = "INSERT INTO `users`(`id`, `name`, `username`, `password`, `type`)
        VALUES ('','$name','$username','$password','$type')";
    $result = mysqli_query($conn, $sql);
    echo "<p class='account-created'>Your Account has been Created. <br>Click on LogIn</p>";
    mysqli_close($conn);
}
?>