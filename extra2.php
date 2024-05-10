<?php
$type = 1;
$duration = 60;
$amount = 500;
$total_allowance = 0;
$total_deductions = 0;
for($i=0;$i<=9;$i++){
    $total_allowance +=  calculate_allowance($type, $duration, $amount);
    $total_deductions +=  calculate_deduction($type, $duration, $amount);
}
echo $total_allowance;
echo $total_deductions;
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
?>