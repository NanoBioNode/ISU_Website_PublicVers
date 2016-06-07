<?php
include('OJLogin.php');
OJLogin::init();

$dbo = OJLogin::getDBO();
$userstmt = $dbo->prepare("SELECT oj_users.username from oj_users left join oj_hasRole on oj_hasRole.username=oj_users.username where oj_hasRole.role='Student' and oj_users.semester='spring2016'");
$userstmt->execute();
$users = $userstmt->fetchAll();

$popstmt = $dbo->prepare(
	"INSERT INTO experimentresults (username,plateregion,regionnum) 
	VALUES (:username,'A1',1),(:username,'A2',2),(:username,'A3',3),(:username,'A4',4),(:username,'A5',5),(:username,'A6',6),
	(:username,'B1',7),(:username,'B2',8),(:username,'B3',9),(:username,'B4',10),(:username,'B5',11),(:username,'B6',12),
	(:username,'C1',13),(:username,'C2',14),(:username,'C3',15),(:username,'C4',16),(:username,'C5',17),(:username,'C6',18),
	(:username,'D1',19),(:username,'D2',20),(:username,'D3',21),(:username,'D4',22),(:username,'D5',23),(:username,'D6',24),
	(:username,'E1',25),(:username,'E2',26),(:username,'E3',27),(:username,'E4',28),(:username,'E5',29),(:username,'E6',30),
	(:username,'F1',31),(:username,'F2',32),(:username,'F3',33),(:username,'F4',34),(:username,'F5',35),(:username,'F6',36)");

foreach ($users as $key => $user) {
	$popstmt->execute(['username'=>$user['username']]);
}
