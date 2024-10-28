<?php

session_start();

include '../head.php';
include '../init.php';
include 'functions.php';

if(get_school_id_from_user($conn, $_SESSION['email'], $_SESSION['role'])){
    $school_id =get_school_id_from_user($conn, $_SESSION['email'], $_SESSION['role']);
 }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /***********************************UpdateName*************************************/
    if ($_POST["school_name"]) {
        $name = mysqli_real_escape_string($conn, $_POST["school_name"]);
        // Update the name in the database
        $update_name_query = "UPDATE school SET school_name = '$name' WHERE school_id = $school_id";
        $result = mysqli_query($conn, $update_name_query);
        if ($result) {
            // Redirect to the page where the name was updated
            header("Location: ../pages/School/index.php");
            exit(); // Add this line to stop further execution

        } else {
            // Display an error message if the update query failed
            echo "حدث خطأ في تغيير اسم مدرستكم";
        }
    }

        /***********************************Updatephonemunber*************************************/
        if ($_POST["school_num"]) {
            $phone = mysqli_real_escape_string($conn, $_POST["school_num"]);
            // Update the name in the database
            $update_phone_query = "UPDATE school SET school_phone = '$phone' WHERE school_id = $school_id";
            $result = mysqli_query($conn, $update_phone_query);
            if ($result) {
                // Redirect to the page where the name was updated
                header("Location: ../pages/School/index.php");
                exit(); // Add this line to stop further execution
    
            } else {
                // Display an error message if the update query failed
                echo "حدث خطأ في تغيير رقم مدرستكم";
            }
        }
        if ($_POST["school_num"]) {
            $phone = mysqli_real_escape_string($conn, $_POST["school_num"]);
            // Update the name in the database
            $update_phone_query = "UPDATE school SET school_phone = '$phone' WHERE school_id = $school_id";
            $result = mysqli_query($conn, $update_phone_query);
            if ($result) {
                // Redirect to the page where the name was updated
                header("Location: ../pages/School/index.php");
                exit(); // Add this line to stop further execution
    
            } else {
                // Display an error message if the update query failed
                echo "حدث خطأ في تغيير رقم مدرستكم";
            }
        }

        if ($_POST["school_address"]) {
            $address = mysqli_real_escape_string($conn, $_POST["school_address"]);
            // Update the name in the database
            $update_address_query = "UPDATE school SET school_address = '$address' WHERE school_id = $school_id";
            $result = mysqli_query($conn, $update_address_query);
            if ($result) {
                // Redirect to the page where the name was updated
                header("Location: ../pages/School/index.php");
                exit(); // Add this line to stop further execution
    
            } else {
                // Display an error message if the update query failed
                echo "حدث خطأ في تغيير مقر مدرستكم";
            }
        }

        if ($_POST["school_type"]) {
            $type = mysqli_real_escape_string($conn, $_POST["school_type"]);
            // Update the name in the database
            $update_type_query = "UPDATE school SET school_type = '$type' WHERE school_id = $school_id";
            $result = mysqli_query($conn, $update_type_query);
            if ($result) {
                // Redirect to the page where the name was updated
                header("Location: ../pages/School/index.php");
                exit(); // Add this line to stop further execution
    
            } else {
                // Display an error message if the update query failed
                echo "حدث خطأ في تغيير نوع مدرستكم";
            }
        }
        
        if ($_POST["school_range"]) {
            $range = mysqli_real_escape_string($conn, $_POST["school_range"]);
            // Update the name in the database
            $update_range_query = "UPDATE school SET school_range = '$range' WHERE school_id = $school_id";
            $result = mysqli_query($conn, $update_range_query);
            if ($result) {
                // Redirect to the page where the name was updated
                header("Location: ../pages/School/index.php");
                exit(); // Add this line to stop further execution
    
            } else {
                // Display an error message if the update query failed
                echo "حدث خطأ في تغيير نطاق مدرستكم";
            }
        }
}


?>