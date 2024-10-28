<?php

// episodes
$epsStmt = mysqli_prepare($conn, "SELECT halakah_id, halakah_nbstudents, halakah_bio, halakah_name
                                 from halakah 
                                 where school_id=? ");
mysqli_stmt_bind_param($epsStmt, "i", $schoolRow['school_id']);
mysqli_stmt_execute($epsStmt);
$epsResult = mysqli_stmt_get_result($epsStmt);