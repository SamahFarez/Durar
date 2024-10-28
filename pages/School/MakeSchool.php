<?php

include '../../head.php';
include_once '../../init.php';
include '../../includings/functions.php';
// for other categories of users not authorized here
include '../../includings/adminRedirection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $schoolname = $_POST["schoolname"];
    $schoolemail = $_POST["schoolemail"];
    $schoolrange = $_POST["schoolrange"];
    $schooltype = $_POST["schooltype"];
    $schooladdress = $_POST["schooladdress"];
    $schoolPhoneNumber = $_POST["schoolPhoneNumber"];

    $errors = array();

    // Validating input
    if (empty($schoolname) || empty($schoolemail) || empty($schoolrange) || empty($schooltype) || empty($schooladdress) || empty($schoolPhoneNumber)) {
        array_push($errors, "لقد أدخلت معلومات ناقصة");
    }
    if (!preg_match("/^(?=.[^ ])[a-zA-Z ء-يًٌٍ ]*[a-zA-Z ء-يًٌٍ]$/u", $schoolname)) {
        array_push($errors, "هناك خطأ في اسم المدرسة");
    }
    if (!filter_var($schoolemail, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "البريد الإلكتروني غير صالح");
    }
    if (!filter_var($schoolPhoneNumber, FILTER_SANITIZE_NUMBER_INT)) {
        array_push($errors, "رقم الهاتف غير صالح");
    }

    // Check if school email already exists
    if (!empty($schoolemail)) {
        $stmt = mysqli_prepare($conn, "SELECT school_email FROM school WHERE school_email = ?");
        mysqli_stmt_bind_param($stmt, "s", $schoolemail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rowCount = mysqli_num_rows($result);
        if ($rowCount > 0) {
            array_push($errors, "البريد الالكتروني موجود من قبل");
        }
        mysqli_stmt_close($stmt);
    }

    // Display all errors
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div style='margin: 20px auto; display: flex; justify-content: center; font-size: 24px;' class='alert alert-danger'>$error</div>";
        }
    } else {
        session_start();
        $_SESSION['school_email'] = $schoolemail;
        $sql = "INSERT INTO school (school_name, school_email, school_phone, school_range, school_type, school_address) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $schoolname, $schoolemail, $schoolPhoneNumber, $schoolrange, $schooltype, $schooladdress);
        mysqli_stmt_execute($stmt);

        //update the general administrator row
        $_SESSION['school_id'] = get_school_id($conn, $_SESSION['school_email']);
        $sql = "UPDATE administrator SET school_id = ? WHERE admin_email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $_SESSION['school_id'], $_SESSION["email"]);
        mysqli_stmt_execute($stmt);

        //update the nbadmin
        $stmt = mysqli_prepare($conn, "UPDATE school SET school_nbadmin = school_nbadmin + 1 WHERE school_id = ?");
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['school_id']);
        mysqli_stmt_execute($stmt);
        header("Location: index.php");
    }
}
?>

<title>Make School</title>
<link rel="icon" href="assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/authentication.css">
<link rel="stylesheet" href="../../assets/CSS/School/schoolCards.css">
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">

<style>
    @media (max-width: 800px) {
        .signup .right {
            display: none;
        }

        .signup .left {
            width: 90%;
            margin: 0 auto;
        }
    }
</style>
</head>

<body dir="rtl">
    <div class="all signup">
        <div class="right">
            <div class="right_elements">
                <img style="width: 28%; padding-bottom: 20px;" class="auth_icon" src="../../assets/images/logo/Durar - Dark blue logo.png" alt="">
                <img style="width: 100%; padding-bottom: 10px;" src="../../assets/images/signUp/Layer_1.png" alt="">
                <p style="font-size: 20px; padding-bottom: 10px;">أنشئ مدرستك الخاصة الآن</p>
            </div>
        </div>
        <div class="left left_extra" style="padding-top: 30px">
            <form method="post" id="form1">
                <p class="form_title"> إنشاء المدرسة </p>
                <label for="schoolname">
                    <input type="text" name="schoolname" id="schoolname" placeholder="أدخل اسم مدرستك" required>
                </label>
                <label for="schoolemail">
                    <input type="email" name="schoolemail" id="schoolemail" placeholder="أدخل البريد الالكتروني للمدرسة" required>
                </label>
                <label for="schoolrange">
                    <select name="schoolrange" id="schoolrange" required>
                        <option value="" disabled selected> اختر نطاق مدرستك </option>
                        <option value="عالمي"> عالمي </option>
                        <option value="اقليمي"> اقليمي </option>
                        <option value="محلي"> محلي </option>
                    </select>
                </label>
                <label for="schooltype">
                    <select name="schooltype" id="schooltype" required>
                        <option value="" disabled selected> اختر نوع مدرستك (الكترونية/ميدانية) </option>
                        <option value="الكترونية"> الكترونية </option>
                        <option value="ميدانية"> ميدانية </option>
                    </select>
                </label>
                <label for="schooladdress">
                    <input type="text" name="schooladdress" id="schooladdress" placeholder="أدخل عنوان المدرسة" required>
                </label>
                <label for="SchoolPhoneNumber">
                    <input type="tel" name="schoolPhoneNumber" id="schoolPhoneNumber" placeholder=" أدخل رقم هاتف المدرسة " required style="width: 100%;">
                </label>
                <div class="buttons">
                    <a href="index.php" style="font-family: 'Cairo'; padding: 16px;" class="return_btn" type="reset">
                        السابق
                    </a>
                    <button name="submit" style="font-family: 'Cairo';" class="next_btn">
                        التالي
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>