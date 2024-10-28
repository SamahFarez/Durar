<?php

include '../../init.php';

$stmt = mysqli_prepare($conn, "SELECT S.school_name from school S
                        join administrator A on A.school_id=S.school_id
                        where A.admin_email=?");
mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$name = mysqli_fetch_assoc($res);
if (isset($name['school_name'])) {
  $school_name = $name['school_name'];
} else {
  $school_name = "غير منضم";
}
