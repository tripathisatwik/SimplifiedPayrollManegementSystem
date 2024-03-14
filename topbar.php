<html>

<head>
    <style>
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

        .float {
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

        .dropbtn {
            background-color: transparent;
            border: none;
            color: black;
            padding: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .dropbtn img {
            width: 14px; /* Adjust the size as needed */
            height: 14px;
            margin-right: 5px; /* Optional: add some space between the image and the text */
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 100px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .show {
            display: block;
        }

    </style>
    <script>
        function toggleDropdown() {
            var dropdownContent = document.getElementById("dropdownContent");
            dropdownContent.classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
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
                    <div class="dropdown">
                        <?php if ($_SESSION['login_type'] == 1) { ?>
                            <button onclick="toggleDropdown()" class="dropbtn"><img src="./icons/user.png" alt=""> <?php echo "Admin" ?> <i class="fa-solid fa-caret-down"></i></button>
                            <div id="dropdownContent" class="dropdown-content">
                                <a href="logout.php"> Logout <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                            </div>
                        <?php } else { ?>
                            <button onclick="toggleDropdown()" class="dropbtn"><i class="fa-solid fa-user"></i> <?php echo "User" ?> <i class="fa-solid fa-caret-down"></i></button>
                            <div id="dropdownContent" class="dropdown-content">
                                <a href="logout.php"> Logout <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</body>

</html>