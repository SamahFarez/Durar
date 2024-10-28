<?php

$schoolStmt = mysqli_prepare($conn, "SELECT S.school_name, T.school_id
                                    From school S join teacher T
                                    on S.school_id=T.school_id
                                    where T.teacher_email=?");
mysqli_stmt_bind_param($schoolStmt, "s", $_SESSION['email']);
mysqli_stmt_execute($schoolStmt);
$schoolResult = mysqli_stmt_get_result($schoolStmt);
$schoolRow = mysqli_fetch_assoc($schoolResult);