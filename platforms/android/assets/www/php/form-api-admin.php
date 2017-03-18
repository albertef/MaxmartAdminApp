<?php
$username = "max_mobile_user";
$password = "max_mobile_user";
$database = "max_mobile";
$hostname = "localhost";

$con = mysql_connect($hostname,$username,$password) or die('Could not connect: ' . mysql_error());
mysql_select_db($database, $con) or die('Unable to select database ' . mysql_error());

function sendEmail(){
	$message .="<table width=70%  border=0 cellspacing=0 cellpadding=0 style='background:#FFF; border: 1px solid #8fba2c;'>
		<tr>
		<td colspan=2 align=center ><img src='http://maxmarttrading.com/images/logo.jpg' width='150'></td>
		</tr>
		<tr>
		<td colspan=2 align=center style='background:#8fba2c; height:5px;' ></td>
		</tr>
		<tr style='background:#F0F0F0;'>
		<td style='padding:10px;'>Name : </td>
		<td style='padding:10px;' colspan=2>$name</td>
		</tr>
		<tr>
		<td style='padding:10px;' >Address : </td>
		<td style='padding:10px;' colspan=2>$address</td>
		</tr>
		<tr style='background:#F0F0F0;'>
		<td style='padding:10px;' >E-mail : </td>
		<td style='padding:10px;' colspan=2>$email</td>
		</tr>
		<tr>
		<td style='padding:10px;' >Phone No : </td>
		<td style='padding:10px;' colspan=2>$phone</td>
		</tr>
		<tr style='background:#F0F0F0;'>
		<td style='padding:10px;' >Company : </td>
		<td style='padding:10px;' colspan=2>$company</td>
		</tr>
		
		<tr>
		<td colspan=2 align=center style='background:#244386; padding:10px; text-align:center; color: #FFF;' >© Maxmart Trading 2016.</td>
		</tr>


		</table>
		";
		//$tomail="sales@maxmarttrading.com";
		$tomail="albertef@gmail.com";

		$subject="Maxmart Mobile App Enquiry Details";
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From:".$email;



		if(mail($tomail, $subject, $message, $headers))
		 {
		 //echo '<script type="text/javascript">alert("Feedback sent successfully. Thank You.. "); </script>';
			echo '<p class="bg-success">Enquiry sent successfully. Thank You..!</p>';
		  }
		else
		{
			 //echo '<script type="text/javascript">alert("Email sending failed.Try again... "); </script>';
			echo '<p class="bg-danger">Email sending failed. Try again..!</p>';

		}
}
    
if(isset($_GET['view'])){
    	
	$query = "SELECT * FROM main_entry WHERE slno=" . $_GET['view'];
    $result = mysql_query($query);
	
	echo '<tr class="success"><th colspan="2">Detailed View</th></tr>';
	
	while($row = mysql_fetch_array($result)) {
		$source = $row["date"];
		$date = new DateTime($source);
		
		echo '<tr><td>Sl.No: </td><td>' . $row["slno"] . '</td></tr>';
		echo '<tr><td>Ref.No: </td><td>' . $row["refno"] . '</td></tr>';
		echo '<tr><td>Date: </td><td>' . $date->format('d.m.Y') . '</td></tr>';
		echo '<tr><td>Name: </td><td>' . $row["name"] . '</td></tr>';
		echo '<tr><td>Email: </td><td>' . $row["email"] . '</td></tr>';
		echo '<tr><td>Phone: </td><td>' . $row["phone"] . '</td></tr>';
		echo '<tr><td>Company: </td><td>' . $row["company"] . '</td></tr>';
		echo '<tr><td>Category: </td><td>' . $row["category"] . '</td></tr>';
	}
	
	
	$query1 = "UPDATE main_entry SET admin_read='yes' WHERE slno=" . $_GET['view'];
    mysql_query($query1);
	
}
elseif(isset($_GET['notification'])){
    $query = "SELECT * FROM main_entry WHERE admin_read='no' ORDER BY date DESC LIMIT 1";
    $result = mysql_query($query);
   
    while($row = mysql_fetch_array($result)) {
        $source = $row["date"];
        $date = new DateTime($source);
        
        echo $row["slno"] . ' / ' . $date->format('d.m.Y') . ' / ' . $row["name"];
    }
}
elseif(isset($_GET['statusvalue'])){
	$status = $_GET['statusvalue'];
	$statusrefno = $_GET['refno'];
	
	if($_GET['refno'] == "" || $_GET['refno'] == NULL){
		echo "Please enter Ref.No";
	}
	else {
		$query = "SELECT * FROM main_entry WHERE refno='" . $statusrefno . "'";
		$result = mysql_query($query);
		$num_rows = mysql_num_rows($result);
		if($num_rows == 0) {
			echo "Invalid Ref.No";
		}
		else {
			$query1 = "UPDATE main_entry SET status='". $status ."' WHERE refno='" . $statusrefno . "'";
			mysql_query($query1);
			echo "Status Updated Successfully";
		}
	}
}
elseif(isset($_GET['read'])){
	$query = "SELECT * FROM main_entry WHERE admin_read='yes' ORDER BY date DESC";
    $result = mysql_query($query);
	
	$num_rows = mysql_num_rows($result);
	
	if($num_rows == 0) {
		echo '<tr class="success"><th>Date</th><th>Name</th><th>Action</th>';
		echo '<tr><td colspan="3" align="center">No data found</td></tr>';
	}
	else {
    
		echo '<tr class="success"><th>Date</th><th>Name</th><th>Action</th>';

		while($row = mysql_fetch_array($result)) {
			$source = $row["date"];
			$date = new DateTime($source);
			
			echo '<tr><td>' . $date->format('d.m.Y') . '</td><td>' . $row["name"] . '</td><td><a href="javascript:void(0)" class="btn btn-xs btn-info" role="button" onclick="detailView(' . $row["slno"] . ');">View</a></td></tr>';
		}
	}
}

else {
	$query = "SELECT * FROM main_entry WHERE admin_read='no' ORDER BY date DESC";
    $result = mysql_query($query);
	
	$num_rows = mysql_num_rows($result);
	
	if($num_rows == 0) {
		echo '<tr class="success"><th>Date</th><th>Name</th><th>Action</th>';
		echo '<tr><td colspan="3" align="center">No data found</td></tr>';
	}
	else {
    
		echo '<tr class="success"><th>Date</th><th>Name</th><th>Action</th>';

		while($row = mysql_fetch_array($result)) {
			$source = $row["date"];
			$date = new DateTime($source);
			
			echo '<tr><td>' . $date->format('d.m.Y') . '</td><td>' . $row["name"] . '</td><td><a href="javascript:void(0)" class="btn btn-xs btn-info" role="button" onclick="detailView(' . $row["slno"] . ');">View</a></td></tr>';
		}
	}
}

?>