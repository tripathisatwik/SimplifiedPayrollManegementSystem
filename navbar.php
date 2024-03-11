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
	</style>
</head>

<body>
    <nav id="sidebar">
        <div class="sidebar-list">
            <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
            <a href="index.php?page=attendance" class="nav-item nav-attendance"><span class='icon-field'><i class="fa fa-th-list"></i></span> Attendance</a>
            <a href="index.php?page=payroll" class="nav-item nav-payroll"><span class='icon-field'><i class="fa fa-columns"></i></span> Payroll</a>
            <a href="index.php?page=employee" class="nav-item nav-employee"><span class='icon-field'><i class="fa fa-user-tie"></i></span> Employee</a>
            <a href="index.php?page=department" class="nav-item nav-department"><span class='icon-field'><i class="fa fa-columns"></i></span>Department</a>
            <a href="index.php?page=position" class="nav-item nav-position"><span class='icon-field'><i class="fa fa-user-tie"></i></span> Position List</a>
            <a href="index.php?page=allowances" class="nav-item nav-allowances"><span class='icon-field'><i class="fa fa-money-bill-wave"></i></span> Allowance</a>
            <a href="index.php?page=deductions" class="nav-item nav-deductions"><span class='icon-field'><i class="fa fa-money-bill-wave"></i></span> Deduction</a>

            <?php if ($_SESSION['login_type'] == 1) : ?>
                <a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
            <?php endif; ?>
        </div>
		<div class="footer">&copy; Satwik Tripathi - <?php echo date("Y");?></div>
    </nav>
    <script>
        $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
    </script>
</body>

</html>