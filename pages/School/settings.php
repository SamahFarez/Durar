<?php
session_start();
include '../../head.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';
?>


<title>Settings</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<link rel="stylesheet" href="../../assets/CSS/School/schoolMain.css">
<link rel="stylesheet" href="../../assets/CSS/School/school.css">
<link rel="stylesheet" href="../../assets/CSS/School/schoolCards.css">

</head>

<body dir="rtl">
    <!--Nav bar-->
    <?php include '../../includings/schoolNav.php' ?>

    <div class="main">
        <!-- SIDE BAR -->
        <?php include 'schoolSidebar.php' ?>

        <section class="main_elements">
            <!--side bar toggler-->
            <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
            <section style="display: block;" class="students_list panels_container main-section" id="studs_list">
                <div class="panel">
                    <div style="display: flex; justify-content: space-between; border-radius: 5px" class="title">
                        <p> الإعدادات </p>
                    </div><br>
                    <div class="content"
                        style="display: flex; flex-direction:column; padding: 30px; gap: 5px; margin-top: 15px">
                        <button class="schoolSettingsOption" onclick="showEditSchoolNameOverlay(event)">
                            <img src="../../assets/images/icons/change.png" alt="icon">
                            <p style="cursor:pointer;">تغيير اسم المدرسة</p>
                        </button>
                        <?php include 'editSchoolNameCard.php'; ?>
                        <button class="schoolSettingsOption" onclick="showEditSchoolNumberOverlay(event)">
                            <img src="../../assets/images/icons/phone.png" alt="icon">
                            <p style="cursor:pointer;">تغيير رقم هاتف المدرسة</p>
                        </button>
                        <?php include 'editSchoolNumberCard.php'; ?>
                        <button class="schoolSettingsOption" onclick="showEditSchoolCardOverlayOverlay(event)">
                            <img src="../../assets/images/icons/editFile.png" alt="icon">
                            <p style="cursor:pointer;">تعديل البطاقة التقنية للمدرسة</p>
                        </button>
                        <button class="schoolSettingsOption" onclick="showremoveSchoolOverlay(event)">
                            <img src="../../assets/images/icons/delete.png" alt="icon">
                            <p style="cursor:pointer;">حذف المدرسة</p>
                        </button>
                        <?php include 'removeSchoolCard.php'; ?>
                        <?php include 'editSchoolCardCard.php'; ?>

                    </div>
                </div><br>
            </section>

        </section>
    </div>

    <div id="footer">
        <!--footer-->
        <?php include '../../includings/schoolFooter.php' ?>
    </div>

    <script src="../../js/workers,studentManagement.js"></script>
    <script src="../../js/editSchoolNameCard.js"></script>
    <script src="../../js/editSchoolNumberCard.js"></script>
    <script src="../../js/editSchoolEmailCard.js"></script>
    <script src="../../js/removeSchoolCard.js"></script>
    <script src="../../js/editSchoolCard.js"></script>
    <script src="../../js/editSchoolCoverCard.js"></script>
    <script src="../../js/sidebars.js"></script>

</body>