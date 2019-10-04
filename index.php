<?php
$host='ec2-54-83-9-169.compute-1.amazonaws.com';
$dbname='d5rut4lfvlp4ar';
$user='isnivawtdytcrl';
$pass='fab82d419311ad5a75b8c1719c6acc014ee88e6f7954c3bfe7f134401d838587';
$connection=new PDO("pgsql:dbname=$dbname;host=$host", $user, $pass);
$result=$connection->query("select * from appiontment");

if ($result!=null){
	echo $result->rowCount();
}

