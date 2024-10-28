<?php

session_start();

include '../head.php';
include '../init.php';
include 'functions.php';

$_SESSION["confirm_code"] = generate_confirmation_code();


$subject = 'Durar Confirmation Code';
$body = '<p dir="rtl">:نشكركم على التسجيل في موقعنا، يرجى استخدام الرمز التالي للتحقق من حسابك</p>';
$body .= '<p dir="rtl">:رمز التحقق ' . $_SESSION["confirm_code"]  . '</p>';
$body .= '<p dir="rtl">شكرًا لكم على اختيار موقعنا، نتمنى لكم تجربة ممتعة ومفيدة.</p>';
$body .= '<p dir="rtl">تحياتنا،<br>فريق دُرَر</p>';
$alt_body = 'ادخل هنا لتأكيد عملية تسجيلكم';


if (!send_new_email($_SESSION["email"], $subject, $body, $alt_body)) {
    echo "<script>alert('حدث خطأ خلال عملية إرسال البريد الالكتروني'); history.go(-1);</script>";
    die;
}
header("Location: ../confirmSignup.php");

?>