<?php include '../../head.php' ?>
<title>Confirm Changes</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/User/confirmUser.css">
<style>
    @media (max-width:800px) {
        .conf .right {
            display: none;
        }

        .conf .left {
            width: 100%;
            margin: 0 auto;
        }
    }
</style>
</head>

<body dir=rtl>
    <div class="all conf signup">
        <div style="height: 100vh;" class="right">
            <div class="right_elements">
                <img style="width: 100%; padding-bottom: 10px;" src="../../assets/images/signUp/Layer_1.png"
                    alt="SignUp">
                <img style="width: 28%;" class="auth_icon" src="../../assets/images/logo/Durar - Dark blue logo.png"
                    alt="Durar">
                <p style="font-size: 36px;"> منصة درر لتسير الحلقات والمدارس الالكترونية</p>
            </div>
        </div>
        <div class="auth_container" style="margin-top: 50px;">
            <p style="color: var(--mainblue);" class="auth_title">
                تغيير البريد الالكتروني
            </p>
            <div style="margin-top: -100px" class=left>
                <div style="width: 100%;" class="auth_container">
                    <div style="border: 1px solid var(--mainblue); border-radius: 30px; padding: 10% 20%;">
                        <p style="font-size: 28px; line-height: 37px; text-align: center">
                            التحقق من أنك صاحب البريد
                        </p>
                        <p style="font-size: 20px; color:#636363; line-height: 37px; text-align: center">
                            أدخل رمز التحقق الذي أرسلناه في البريد الجديد:
                        </p><br><br>
                        <p style="text-align: center; color:#636363;">لم يصلك البريد؟ <a
                                href="../../includings/resendConfirmEdit.php" style="color: black">أرسل رمز التحقق
                                مجددا</a></p>
                        <form action="../../includings/confirmCodeChangeEmail.php" method="post">
                            <div dir="ltr" class="otp-bx">
                                <input style="width: 200px; font-family: 'Cairo'; margin-bottom: 20px" type="text"
                                    id="digit" name="otp" maxlength="6" required placeholder="مثل: 102145">
                            </div>
                            <br><br>
                            <div class="buttons">
                                <a style="font-size: 16px; padding: 16px; margin-left: 10px;" class="return_btn"
                                    href="javascript:history.back();">
                                    العودة
                                </a>
                                <button style="font-size: 16px" name="submit" style="margin-right: 10px;" type="submit">
                                    التالي
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>