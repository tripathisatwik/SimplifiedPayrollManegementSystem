<!DOCTYPE html>
<html lang="en">

<head>
  <title>Simplified Payroll Management System</title>
  <style>
    #view-panel {
      padding-left: 15rem;
      padding-top: 5rem;
      max-width: 82%;
    }

    .navbar,
    .sidebar {
      position: fixed;
      width: 100%;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://kit.fontawesome.com/d902124516.js" crossorigin="anonymous"></script>
</head>
<?php
session_start();
if (!isset($_SESSION['login_id']))
  header('location:login.php');
include 'topbar.php';
include 'navbar.php';
?>

<body>
  <main id="view-panel">
    <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home'; ?>
    <?php include $page . '.php' ?>
  </main>

  <script>
    window.start_load = function() {
      $('body').prepend('<di id="preloader2"></di>')
    }
    window.end_load = function() {
      $('#preloader2').fadeOut('fast', function() {
        $(this).remove();
      })
    }
  </script>

</html>