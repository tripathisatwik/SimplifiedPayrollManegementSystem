<html>

<head>
<style>
		body,
		h1,
		h2,
		h3,
		p,
		ul,
		li {
			margin: 0;
			padding: 0;
		}

		#sidebar {
			position: fixed;
			left: 0;
			top: 3.5rem;
			height: 100%;
			width: 200px;
			background-color: #333;
			color: #fff;
		}

		.sidebar-list {
			padding: 20px;
		}

		.sidebar-list a {
			display: block;
			padding: 10px;
			text-decoration: none;
			color: #fff;
			transition: background-color 0.3s;
			display: flex;
            align-items: center;
		}

		.sidebar-list a:hover {
			background-color: #555;
			border-radius: 8px;
		}

		.sidebar-list a.active {
			background-color: #007bff;
			border-radius: 8px;
		}

		.icon-field {
			margin-right: 10px;
		}

		body {
			font-family: 'Arial', sans-serif;
		}

		.footer{
			position: fixed;
            bottom: 0;
			padding: 15px;
		}

		img{
			height: 20px;
			width: 20px;
			text-align: center;
		}
	</style>
</head>

<body>
    <nav id="sidebar">
        <div class="sidebar-list">
            <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><img src="./icons/home.png" alt=""></span> Home</a>
            <a href="index.php?page=attendance" class="nav-item nav-attendance"><span class='icon-field'><img src="./icons/attendance.png" alt=""></span> Attendance</a>
            <a href="index.php?page=payroll" class="nav-item nav-payroll"><span class='icon-field'><img src="./icons/salary.png" alt=""></span> Payroll</a>
            <a href="index.php?page=employee" class="nav-item nav-employee"><span class='icon-field'><img src="./icons/employee.png" alt=""></span> Employee</a>
            <a href="index.php?page=department" class="nav-item nav-department"><span class='icon-field'><img src="./icons/structure.png" alt=""></span>Department</a>
            <a href="index.php?page=position" class="nav-item nav-position"><span class='icon-field'><img src="./icons/market-positioning.png" alt=""></span> Position List</a>
            <a href="index.php?page=allowances" class="nav-item nav-allowances"><span class='icon-field'><img src="./icons/profits.png" alt=""></span> Allowance</a>
            <a href="index.php?page=deductions" class="nav-item nav-deductions"><span class='icon-field'><img src="./icons/profits.png" alt=""></span> Deduction</a>

            <?php if ($_SESSION['login_type'] == 1) : ?>
                <a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><img src="./icons/group.png" alt=""></span> Users</a>
            <?php endif; ?>
        </div>
		<div class="footer">&copy; Satwik Tripathi - <?php echo date("Y");?></div>
    </nav>
    <script>
        $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
    </script>
</body>

</html>