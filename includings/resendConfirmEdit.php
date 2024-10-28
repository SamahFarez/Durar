<?php
session_start();

include '../head.php';
include '../init.php';
include 'functions.php';

$_SESSION['confirmationCode'] = generate_confirmation_code();

$subject = 'Durar Confirmation Code';
$body = '<p dir="ltr">:لقد قمتم بتغيير بريدكم الالكتروني، يرجى استخدام الرمز التالي للتحقق من حسابكم</p>';
$body .= '<p dir="ltr">:رمز التحقق ' . $_SESSION['confirmationCode'] . '</p>';
$body .= '<p dir="ltr">شكرًا لكم على اختيار موقعنا، نتمنى لكم تجربة ممتعة ومفيدة.</p>';
$body .= '<p dir="ltr">تحياتنا،<br>فريق دُرَر</p>';
$alt_body = 'ادخل هنا لتأكيد عملية تغيير بريدك الاكتروني';


if (!send_new_email($_SESSION['newEmail'], $subject, $body, $alt_body)) {
    echo "<script>alert('حدث خطأ خلال عملية إرسال بريدكم الالكتروني'); history.go(-1);</script>";
    die;
}
if ($_SESSION['role'] == 'administrator')
    header("Location: ../pages/Admin/confirmChange.php");
if ($_SESSION['role'] == 'teacher')
    header("Location: ../pages/Teacher/confirmChange.php");
if ($_SESSION['role'] == 'student')
    header("Location: ../pages/Student/confirmChange.php");
die;

?>