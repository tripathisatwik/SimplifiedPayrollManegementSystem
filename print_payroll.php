<style>
table{
    width:100%;
    border-collapse:collapse;
}
tr,td,th{
    border:1px solid black
}
.text-center{
    text-align:center;
}
.text-right{
    text-align:right;
}
</style>
<?php include('dbconnect.php') ?>
<?php
		$pay = $conn->query("SELECT * FROM payroll where id = ".$_GET['id'])->fetch_array();
		$pt = array(1=>"Monhtly",2=>"Semi-Monthly");
?>
<div>
<h2 >Payroll - <?php echo $pay['ref_no'] ?></h2>
<hr>
</div>
<table>
    <thead>
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
    </thead>
    <tbody>
    <?php
									
        $payroll=$conn->query("SELECT p.*,concat(e.lastname,', ',e.firstname,' ',e.middlename) as ename,e.employee_no,e.salary FROM payroll_items p inner join employee e on e.id = p.employee_id ");
        while($row=$payroll->fetch_array()){
    ?>
    <tr>
        <td><?php echo $row['employee_no'] ?></td>
        <td><?php echo ucwords($row['ename']) ?></td>
        <td><?php echo number_format($row['salary'],2) ?></td>
        <td><?php echo $row['absent'] ?></td>
        <td><?php echo $row['late'] ?></td>
        <td><?php echo number_format($row['allowance_amount'],2) ?></td>
        <td><?php echo number_format($row['deduction_amount'],2) ?></td>
        <td><?php echo number_format($row['net'],2) ?></td>
    </tr>
    <?php
        }
    ?>
    </tbody>
</table>