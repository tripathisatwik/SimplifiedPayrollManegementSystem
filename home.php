<?php include 'dbconnect.php' ?>
<html>

<head>
    <title>Home</title>
    <style>
        .time {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border-radius: 8px;
        }

        .text {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="time">
        Current Date/Time: <?php date_default_timezone_set('Asia/Kathmandu'); echo date("Y-m-d H:i", time()); ?></p>
    </div>
    <div class="text">
        <?php
        echo "Welcome back " . ucfirst($_SESSION['login_name']) . "!";
        echo '<br>';
        echo "What are we gonna do today?"
        ?>
    </div>
</body>

</html>