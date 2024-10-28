<?php
include '../head.php';
include '../init.php';

// Retrieve the values from the AJAX request
$remark = $_POST['remark'];
$mark = $_POST['mark'];
$studentId = $_POST['student_id'];
$examId = $_POST['exam_id'];
$halakahId = $_POST['halakah_id'];
$halakahName = $_POST['halakah_name'];

$stmt = $conn->prepare("UPDATE grades SET mark = ?, remark = ? WHERE student_id = ? AND exam_id = ?");
$stmt->bind_param("ssii", $mark, $remark, $studentId, $examId);
$stmt->execute();

$stmt->close();
$conn->close();

// Return a response to the AJAX request
echo 'Success';