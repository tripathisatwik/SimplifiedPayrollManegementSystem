<html>

<head>
<style>
		/* Reset some default styles */
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

		/* Basic styling for the sidebar */
		#sidebar {
			position: fixed;
			left: 0;
			top: 3.5rem;
			height: 100%;
			width: 200px;
			/* Adjust the width as needed */
			background-color: #333;
			/* Dark background color */
			color: #fff;
			/* Text color */
		}

		/* Styling for the sidebar list items */
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
			/* Hover color */
		}

		/* Styling for the active navigation item */
		.sidebar-list a.active {
			background-color: #007bff;
			/* Active item color */
		}

		/* Styling for icons within the navigation items */
		.icon-field {
			margin-right: 10px;
		}

		/* Optional: Adjustments for better readability */
		body {
			font-family: 'Arial', sans-serif;
		}
	</style>
</head>

<body>
    <nav id="sidebar">
        <div class="sidebar-list">
            <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
            <a href="index.php?page=attendance" class="nav-item nav-attendance"><span class='icon-field'><i class="fa fa-th-list"></i></span> Attendance</a>
            <a href="index.php?page=payroll" class="nav-item nav-payroll"><span class='icon-field'><i class="fa fa-columns"></i></span> Payroll List</a>
            <a href="index.php?page=employee" class="nav-item nav-employee"><span class='icon-field'><i class="fa fa-user-tie"></i></span> Employee List</a>
            <a href="index.php?page=department" class="nav-item nav-department"><span class='icon-field'><i class="fa fa-columns"></i></span> Depatment List</a>
            <a href="index.php?page=position" class="nav-item nav-position"><span class='icon-field'><i class="fa fa-user-tie"></i></span> Position List</a>
            <a href="index.php?page=allowances" class="nav-item nav-allowances"><span class='icon-field'><i class="fa fa-list"></i></span> Allowance List</a>
            <a href="index.php?page=deductions" class="nav-item nav-deductions"><span class='icon-field'><i class="fa fa-money-bill-wave"></i></span> Deduction List</a>

            <?php if ($_SESSION['login_type'] == 1) : ?>
                <a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
            <?php endif; ?>
        </div>
    </nav>
    <script>
        $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
    </script>
</body>

</html>