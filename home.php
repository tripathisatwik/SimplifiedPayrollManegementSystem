<?php include 'dbconnect.php' ?>
<html>
<head>
    <style>
        .text{
            background-color: lightgray;
            padding: 1rem;
            border-radius: 5%;
        }
    </style>
</head>
<body>
    <div class="text">
        <?php 
        echo "Welcome back " . $_SESSION['login_name'] . "!"  ;
        echo '<br>';
        echo "What are you gonna do today?"
        ?>
    </div>
</body>
</html>