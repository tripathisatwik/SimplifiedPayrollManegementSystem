<?php 
$id = $_POST['id'];
calculate_payroll($id);

function calculate_payroll($id) {
    include 'dbconnect.php';

    // Fetching payroll information
    $pay_result = mysqli_query($conn, "SELECT * FROM payroll where id = " . $id);
    $pay = mysqli_fetch_array($pay_result);

    // Fetching employee information
    $employee_result = mysqli_query($conn, "SELECT * FROM employee");

    // Initialize save array for database insertion
    $save = [];

    while ($row = mysqli_fetch_assoc($employee_result)) {
        $salary = $row['salary'];
        $daily = $salary / 22;
        $min = (($salary / 22) / 8) / 60;
        $absent = 0;
        $late = 0;
        $present = 0;
        $net = 0;
        $allow_amount = 0;
        $ded_amount = 0;

        // Fetching attendance for the employee within the specified date range
        $att_result = mysqli_query($conn, "SELECT * FROM attendance where date(datetime_log) BETWEEN '" . $pay['date_from'] . "' AND '" . $pay['date_to'] . "' AND employee_id = " . $row['id']);

        while ($att_row = mysqli_fetch_assoc($att_result)) {
            $date = date("Y-m-d", strtotime($att_row['datetime_log']));
            $time = date("H:i", strtotime($att_row['datetime_log']));

            // Calculate lateness
            if ($time > $am_in) {
                $att_mn = abs(strtotime($time)) - strtotime($am_in);
                $att_mn = floor($att_mn / 60);
                $late += $att_mn;
            }

            $present += 1;
        }

        // Calculate absenteeism
        $working_days = (strtotime($pay['date_to']) - strtotime($pay['date_from'])) / (60 * 60 * 24) + 1;
        $absent = $working_days - $present;

        // Calculate net amount considering allowances and deductions
        // (Assuming allowances and deductions are fixed amounts)
        $net = $salary + $allow_amount - $ded_amount;

        // Prepare data for insertion into database
        $data = " payroll_id = '" . $pay['id'] . "', ";
        $data .= " employee_id = '" . $row['id'] . "', ";
        $data .= " absent = '$absent', ";
        $data .= " present = '$present', ";
        $data .= " late = '$late', ";
        $data .= " salary = '$salary', ";
        $data .= " allowance_amount = '$allow_amount', ";
        $data .= " deduction_amount = '$ded_amount', ";
        $data .= " net = '$net' ";

        // Insert data into payroll_items table
        $save[] = mysqli_query($conn, "INSERT INTO payroll_items SET " . $data);
    }

    // Update payroll status
    mysqli_query($conn, "UPDATE payroll SET status = 1 WHERE id = " . $pay['id']);

    return 1;
}
?>
