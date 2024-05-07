<style>
     table {
         width: 100%;
         border-collapse: collapse;
         font-family: Arial, sans-serif;
     }

     th, td {
         border: 1px solid #dddddd;
         text-align: left;
         padding: 8px;
     }

     th {
         background-color: #f2f2f2;
         font-weight: bold;
     }

     tr:nth-child(even) {
         background-color: #f9f9f9;
     }
     .text-right {
         text-align: right;
     }
 </style>
<?php
include 'dbconnect.php';
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM payroll where id ='$id'");
while ($pay = mysqli_fetch_assoc($result)) {
?>
<center>
<h4><b>Payroll : <?php echo $pay['ref_no'] ?></b></h4>
<p><b>Payroll Type: <?php if ($pay['type'] == 1) { echo "Monthly";} 
elseif ($pay['type'] == 2) { echo "Semi-Monthly";}?></b></p>
<p><b>Payroll Range:<?php echo date("M d, Y", strtotime($pay['date_from'])) . " - " . date("M d, Y", strtotime($pay['date_to'])) ?></b></p>
</center>
    <table>
        <tr>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Monthly Salary</th>
            <th>Absent</th>
            <th>Tardy/Undertime(mins)</th>
            <th>Total Allowance</th>
            <th>Total Deduction</th>
            <th>Net Pay</th>
        </tr>

        <?php
        $payroll = mysqli_query($conn, "SELECT p.*,concat(e.lastname,', ',e.firstname,' ',e.middlename) as ename,e.employee_no FROM payroll_items p inner join employee e on e.id = p.employee_id");
        while ($row = mysqli_fetch_assoc($payroll)) {
        ?>
            <tr>
                <td><?php echo $row['employee_no'] ?></td>
                <td><?php echo ucwords($row['ename']) ?></td>
                <td class="text-right"><?php echo number_format($row['salary'], 2) ?></td>
                <td class="text-right"><?php echo $row['absent'] ?></td>
                <td class="text-right"><?php echo $row['late'] ?></td>
                <td class="text-right"><?php echo number_format($row['allowance_amount'], 2) ?></td>
                <td class="text-right"><?php echo number_format($row['deduction_amount'], 2) ?></td>
                <td class="text-right"><?php echo number_format($row['net'], 2) ?></td>
            </tr>
        <?php }  ?>
    </table>
    </div>
<?php } ?>