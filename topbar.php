<html>

<head>
    <style>
        /* Style for the fixed-top navbar */
        .navbar {
            background-color: #87CEEB;
            padding: 0;
            min-height: 3.5rem;
        }

        .main {
            margin-top: 0;
            margin-bottom: 2rem;
        }

        a {
            text-decoration: none;
            color: #fff;
        }
        .float{
            display: flex;
            padding: 0.5rem;
        }
        .left {
            float: left;
            padding-left: 1rem;
        }

        .right {
            float: right;
            padding-right: 4rem;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="main">
            <div class="col-lg-12">
                <div class="float" style="display: flex;">
                </div>
                <div class="left">
                    <large><b>Simplified Payroll Management System</b></large>
                </div>
                <div class="right">
                    <a href="logout.php" > <?php echo ucfirst($_SESSION['login_name']) ?> <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                </div>
            </div>
        </div>
    </nav>
</body>

</html>