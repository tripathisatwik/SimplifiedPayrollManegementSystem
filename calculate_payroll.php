<?php
$id = $_POST['id'];
calculate_payroll($id);

function calculate_payroll($id)
{
    include 'dbconnect.php';

    // Deleting past instances of the same payroll
    mysqli_query($conn,"DELETE FROM `payroll_items` WHERE payroll_id = $id");

    // Fetching payroll information
    $pay_result = mysqli_query($conn, "SELECT * FROM payroll WHERE id = $id");
    $pay = mysqli_fetch_assoc($pay_result);
    $date_from = $pay['date_from'];
    $date_to = $pay['date_to'];

    $duration = (strtotime($date_to) - strtotime($date_from)) / (60 * 60 * 24); // Calculating duration in days (Duration of payroll in days)

    // Standard time-in and time-out
    $timein = '07:45';
    $timeout = '15:45';

    // Initialize array to store payroll data
    $payroll_data = [];

    // Fetching employee information
    $employee_result = mysqli_query($conn, "SELECT * FROM employee");
    while ($row = mysqli_fetch_assoc($employee_result)) {
        $employee_id = $row['id'];
        $salary = $row['salary'];
        $daily_salary = $salary / 26; // 26 working days in a month
        $absent_days = 0;
        $late_days = 0;
        $consecutive_late_days = 0;
        $late_penalty = 0;
        $allowance_amount = 0;
        $deduction_amount = 0;

        // Initialize arrays to store daily attendance
        $attendance = [];

        // Fetching attendance for the employee within the specified date range
        $att_result = mysqli_query($conn, "SELECT * FROM attendance WHERE employee_id = $employee_id AND datetime_log BETWEEN '$date_from' AND '$date_to' ORDER BY datetime_log");

        while ($att_row = mysqli_fetch_assoc($att_result)) {
            $date = date("Y-m-d", strtotime($att_row['datetime_log']));
            $time = date("H:i", strtotime($att_row['datetime_log']));
            $log_type = $att_row['log_type'];

            // Store attendance data by date
            $attendance[$date][$log_type] = $time;
        }

        foreach ($attendance as $date => $logs) {
            if (!isset($logs[1]) && !isset($logs[2])) {
                // No entry for the date (absent)
                $absent_days++;
                $consecutive_late_days = 0;
            } else {
                // Check if late arrival
                if (isset($logs[1])) {
                    // Calculate minutes difference from standard time
                    $arrival_time = strtotime($logs[1]);
                    $standard_time = strtotime($timein);
                    $minutes_difference = ($arrival_time - $standard_time) / 60;

                    if ($minutes_difference >= 45) {
                        $late_days++;
                        $consecutive_late_days++;
                        // Penalty for 3 consecutive late arrived days
                        if ($consecutive_late_days >= 3) {
                            $late_penalty += 0.01 * $salary;
                        }
                    } else {
                        $consecutive_late_days = 0;
                    }
                }
            }
        }

        // Fetching allowances for the employee
        $allow_result = mysqli_query($conn, "SELECT * FROM employee_allowances WHERE employee_id = $employee_id AND effective_date >= '$date_to'");
        while ($allow_row = mysqli_fetch_assoc($allow_result)) {
            $allowance_type = $allow_row['type'];
            $allowance_amount += calculate_allowance($allowance_type, $duration, $allow_row['amount']);
        }

        // Fetching deductions for the employee
        $ded_result = mysqli_query($conn, "SELECT * FROM employee_deductions WHERE employee_id = $employee_id AND effective_date >= '$date_to'");
        while ($ded_row = mysqli_fetch_assoc($ded_result)) {
            $deduction_type = $ded_row['type'];
            $deduction_amount += calculate_deduction($deduction_type, $duration, $ded_row['amount']);
        }

        // Calculate net salary
        $gross_salary = $salary + $allowance_amount - $deduction_amount;
        $net_salary = $gross_salary - ($absent_days * $daily_salary) - $late_penalty;

        // Store payroll data
        $payroll_data[] = [
            'payroll_id' => $pay['id'],
            'employee_id' => $row['id'],
            'absent' => $absent_days,
            'present' => $duration - $absent_days,
            'late' => $late_days,
            'salary' => $salary,
            'allowance_amount' => $allowance_amount,
            'deduction_amount' => $deduction_amount,
            'net' => $net_salary
        ];
    }

    foreach ($payroll_data as $data) {
        $fields = implode(', ', array_keys($data));
        $values = "'" . implode("', '", $data) . "'";
        $query = "INSERT INTO payroll_items ($fields) VALUES ($values)";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            // Handle insertion error
            echo "<script>alert('Error inserting payroll data: " . mysqli_error($conn) . "')</script>";
            return;
        }
    }

    // Update payroll status
    $update_query = "UPDATE payroll SET status = 1 WHERE id = $id";
    $update_result = mysqli_query($conn, $update_query);
    if (!$update_result) {
        // Handle update error
        echo "<script>alert('Error updating payroll status: " . mysqli_error($conn) . "')</script>";
        return;
    }

    // Notify success
    echo "<script>alert('Payroll calculation completed successfully')</script>";
    return;
}

function calculate_allowance($type, $duration, $amount)
{
    switch ($type) {
        case 1: // Monthly
            return $amount * floor($duration / 30);
        case 2: // Semi-monthly
            return $amount * floor($duration / 15);
        case 3: // Once
            return $amount;
        default:
            return 0;
    }
}

function calculate_deduction($type, $duration, $amount)
{
    switch ($type) {
        case 1: // Monthly
            return $amount * floor($duration / 30);
        case 2: // Semi-monthly
            return $amount * floor($duration / 15);
        case 3: // Once
            return $amount;
        default:
            return 0;
    }
}