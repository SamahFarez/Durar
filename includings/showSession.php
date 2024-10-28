<?php
include '../init.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['session_id'] = $_POST['session_id'];

    $sql = "SELECT session_report, session_number, session_date FROM session WHERE session_id= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_POST['session_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $_SESSION['session_date'] = $row['session_date'];
    $_SESSION['session_number'] = $row['session_number'];
    if ($row['session_report']!= null) {
        $_SESSION['session_report'] = $row['session_report'];
    } else {
        $_SESSION['session_report'] = "لا يوجد وصف لهذه الحصة";
    }

    http_response_code(200);
}
?>

