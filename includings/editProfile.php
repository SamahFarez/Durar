<?php

session_start();

include '../head.php';
include '../init.php';
include 'functions.php';



if (isset($_SESSION['email'])) {
    $userRow = get_user_row($_SESSION['email'], $_SESSION['role'], $conn);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        /***********************************refresh email *************************************/
        if (isset($_POST["email"])) {
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            // Check if user already exists
            if ($_SESSION['role'] == 'administrator')
                $stmt = mysqli_prepare($conn, "SELECT * FROM administrator WHERE admin_email = ?");
            if ($_SESSION['role'] == 'teacher')
                $stmt = mysqli_prepare($conn, "SELECT * FROM teacher WHERE teacher_email = ?");
            if ($_SESSION['role'] == 'student')
                $stmt = mysqli_prepare($conn, "SELECT * FROM student WHERE student_email = ?");

            $stmt->bind_param("s", $email);

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                echo "<script>alert('البريد الإلكتروني موجود من قبل'); history.go(-1);</script>";
                exit;
            }
            mysqli_stmt_close($stmt);

            $_SESSION['newEmail'] = $_POST["email"];
            $_SESSION['confirmationCode'] = generate_confirmation_code();

            $subject = 'Durar Confirmation Code';
            $body = '<p dir="ltr">:لقد قمتم بتغيير بريدكم الالكتروني، يرجى استخدام الرمز التالي للتحقق من حسابكم</p>';
            $body .= '<p dir="ltr">:رمز التحقق ' . $_SESSION['confirmationCode'] . '</p>';
            $body .= '<p dir="ltr">شكرًا لكم على اختيار موقعنا، نتمنى لكم تجربة ممتعة ومفيدة.</p>';
            $body .= '<p dir="ltr">تحياتنا،<br>فريق دُرَر</p>';
            $alt_body = 'ادخل هنا لتأكيد عملية تغيير بريدك الاكتروني';

            if (!send_new_email($_SESSION['newEmail'], $subject, $body, $alt_body)){
                echo "<script>alert('حدث خطأ خلال عملية تغيير بريدكم الالكتروني'); history.go(-1);</script>";
                die;
            }
            if ($_SESSION['role'] == 'administrator')
                header("Location: ../pages/Admin/confirmChange.php");
            if ($_SESSION['role'] == 'teacher')
                header("Location: ../pages/Teacher/confirmChange.php");
            if ($_SESSION['role'] == 'student')
                header("Location: ../pages/Student/confirmChange.php");
            die;
        }

        /***********************************refresh bio *************************************/
        // Get the bio value from the textarea
        if (isset($_POST["bio"])) {
            $bio = mysqli_real_escape_string($conn, $_POST["bio"]);
            // Update the bio in the database
            if ($_SESSION['role'] == 'administrator')
                $update_bio_query = "UPDATE administrator SET admin_bio = '$bio' WHERE admin_email = '{$_SESSION['email']}'";
            if ($_SESSION['role'] == 'teacher')
                $update_bio_query = "UPDATE teacher SET teacher_bio = '$bio' WHERE teacher_email = '{$_SESSION['email']}'";
            if ($_SESSION['role'] == 'student')
                $update_bio_query = "UPDATE student SET student_bio = '$bio' WHERE student_email = '{$_SESSION['email']}'";
            $result = mysqli_query($conn, $update_bio_query);
            if ($result) {
                // Redirect to the page where the bio was updated

                if ($_SESSION['role'] == 'administrator')
                    header("Location: ../pages/Admin/profile.php");
                if ($_SESSION['role'] == 'teacher')
                    header("Location: ../pages/Teacher/profile.php");
                if ($_SESSION['role'] == 'student')
                    header("Location: ../pages/Student/profile.php");
                exit();
            } else {
                // Display an error message if the update query failed
                echo "<script>alert('حدث خطأ في تغيير الوصف الخاص بكم'); history.go(-1);</script>";
                die;
            }
        }
        /***********************************refresh ID card *************************************/
        // Get the values entered by the user:
        if (isset($_POST["fname"])) {
            $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
        }
        if (isset($_POST["lname"])) {
            $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
        }
        if (isset($_POST["country"])) {
            $country = mysqli_real_escape_string($conn, $_POST["country"]);
        }
        if (isset($_POST["gender"])) {
            $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
        }
        if (isset($_POST["tel"])) {
            $tel = mysqli_real_escape_string($conn, $_POST["tel"]);
        }
        if ($_SESSION['role'] == 'student') {
            // Update the bio in the database
            if ($_POST["fname"] && preg_match("/^[a-zA-Z ء-ي]*$/u", $fname)) {
                $update_fname_query = "UPDATE student SET student_fname = '$fname' WHERE student_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_fname_query);
            }
            if ($_POST["lname"] && preg_match("/^[a-zA-Z ء-ي]*$/u", $lname)) {
                $update_lname_query = "UPDATE student SET student_lname = '$lname' WHERE student_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_lname_query);
            }
            if ($_POST["country"]) {
                $update_country_query = "UPDATE student SET student_country = '$country' WHERE student_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_country_query);
            }
            if ($_POST["gender"]) {
                $update_gender_query = "UPDATE student SET student_gender = '$gender' WHERE student_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_gender_query);
            }
            if ($_POST["tel"] > 0500000000) {
                $update_phone_query = "UPDATE student SET student_phone = '$tel' WHERE student_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_phone_query);
            }
        }

        if ($_SESSION['role'] == 'teacher') {
            // Update the bio in the database
            if ($_POST["fname"] && preg_match("/^[a-zA-Z ء-ي]*$/u", $fname)) {
                $update_fname_query = "UPDATE teacher SET teacher_fname = '$fname' WHERE teacher_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_fname_query);
            }
            if ($_POST["lname"] && preg_match("/^[a-zA-Z ء-ي]*$/u", $lname)) {
                $update_lname_query = "UPDATE teacher SET teacher_lname = '$lname' WHERE teacher_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_lname_query);
            }
            if ($_POST["country"]) {
                $update_country_query = "UPDATE teacher SET teacher_country = '$country' WHERE teacher_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_country_query);
            }
            if ($_POST["gender"]) {
                $update_gender_query = "UPDATE teacher SET teacher_gender = '$gender' WHERE teacher_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_gender_query);
            }
            if ($_POST["tel"] > 0500000000) {
                $update_phone_query = "UPDATE teacher SET teacher_phone = '$tel' WHERE teacher_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_phone_query);
            }
        }

        if ($_SESSION['role'] == 'administrator') {
            // Update the bio in the database
            if (isset($_POST["fname"]) && preg_match("/^[a-zA-Z ء-ي]*$/u", $fname)) {
                $update_fname_query = "UPDATE administrator SET admin_fname = '$fname' WHERE admin_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_fname_query);
            }
            if (isset($_POST["lname"]) && preg_match("/^[a-zA-Z ء-ي]*$/u", $lname)) {
                $update_lname_query = "UPDATE administrator SET admin_lname = '$lname' WHERE admin_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_lname_query);
            }
            if (isset($_POST["country"])) {
                $update_country_query = "UPDATE administrator SET admin_country = '$country' WHERE admin_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_country_query);
            }
            if (isset($_POST["gender"])) {
                $update_gender_query = "UPDATE administrator SET admin_gender = '$gender' WHERE admin_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_gender_query);
            }
            if (isset($_POST["tel"]) && $_POST["tel"] > 0500000000) {
                $update_phone_query = "UPDATE administrator SET admin_phone = '$tel' WHERE admin_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_phone_query);
            }
        }
        /*if ($result) {
            // Redirect to the page where the bio was updated
            if ($_SESSION['role'] && $_SESSION['role'] == 'administrator')
                header("Location: ../pages/Admin/profile.php");
            if ($_SESSION['role'] && $_SESSION['role'] == 'teacher')
                header("Location: ../pages/Teacher/profile.php");
            if ($_SESSION['role'] && $_SESSION['role'] == 'student')
                header("Location: ../pages/Student/profile.php");
        } else {
            // Display an error message if the update query failed
            echo "<script>alert('failed to update information'); history.go(-1);</script>";
            die;
        }*/
        // Get the bio value from the textarea
        //**************************************SchoolBio******************* */
        if ($_POST["schoolBio"]) {
            $schoolID = get_school_id_from_user($conn, $_SESSION['email'], $_SESSION['role']);
            $schoolBio = mysqli_real_escape_string($conn, $_POST["schoolBio"]);
            // Update the bio in the database
            $update_schoolBio_query = "UPDATE school SET school_bio = '$schoolBio' WHERE school_id = $schoolID";
            $result = mysqli_query($conn, $update_schoolBio_query);
            if ($result) {
                // Redirect to the page where the bio was updated
                header("Location: ../pages/School/index.php");
                exit();
            } else {
                // Display an error message if the update query failed
                echo "<script>alert('حدث خطأ في تغيير الوصف الخاص بكم'); history.go(-1);</script>";
                die;
            }
        }
    }

}

?>