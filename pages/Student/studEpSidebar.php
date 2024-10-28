<?php

//session_start();
include '../../head.php';
include '../../init.php';
// getting the halakah_id to be used for sidebar links
if (isset($_GET['halakah_id'])) {
    $halakah_id = $_GET['halakah_id'];
}
if (isset($_GET['halakah_name'])) {
    $halakah_name = $_GET['halakah_name'];
}
if (isset($_GET['halakah_bio'])) {
    $halakah_bio = $_GET['halakah_bio'];}

?>
<link rel="stylesheet" href="../../assets/CSS/User/profilepicture.css">

<div style="line-height: 1.5; height: 100vh; font-size: 16px;" class="side_bar">
    <div class="sidebar_elements">
        <div align="center" class="profile">
            <a href="profile.php?halakah_id=<?php echo $halakah_id; ?>&halakah_name=<?php echo urlencode($halakah_name); ?>&halakah_bio=<?php echo urlencode($halakah_bio); ?>">
                <img class="profilePicture" src="<?php echo '../../' . $_SESSION['profilePicture'] ?>"
                    alt="student picture">
            </a>
            <p style="font-size: 18px; padding: 0 10px" class="teacher_name">
                <?php echo $_SESSION['fname'] . " " . $_SESSION['lname'] ?>
            </p>
            <p style="margin-top: 10px;" class="teacher_role"> طالب </p>
        </div><br>

        <hr>

        <div class="school">
            <p style="font-size: 18px;" class="sidebar_title"> الرئيسية </p>
            <a href="index.php" class="sidebar_links">
                <img src="../../assets/images/icons/main - teacher episode icons.png" alt="icon">
                <p class="respons"> الرئيسية </p>
            </a>
        </div><br>

        <hr>

        <div class="episodes">
            <p style="font-size: 18px;" class="sidebar_title"> حصص الحلقة </p>
            <a href="previousProg.php?halakah_id=<?php echo $halakah_id; ?>&halakah_name=<?php echo urlencode($halakah_name); ?>&halakah_bio=<?php echo urlencode($halakah_bio); ?>" class="sidebar_links">
                <img src="../../assets/images/Student/lastEps.png" alt="icon">
                <p class="respons"> أدائي في الحصص السابقة </p>
            </a>
        </div><br>

        <hr>

        <div class="settings">
            <p style="font-size: 18px;" class="sidebar_title"> الامتحانات </p>
            <a href="nextExams.php?halakah_id=<?php echo $halakah_id; ?>&halakah_name=<?php echo urlencode($halakah_name); ?>&halakah_bio=<?php echo urlencode($halakah_bio); ?>" class="sidebar_links">
                <img src="../../assets/images/Student/nextExam.png" alt="icon">
                <p class="respons"> الامتحانات المقبلة </p>
            </a>
            <a href="myGrades.php?halakah_id=<?php echo $halakah_id; ?>&halakah_name=<?php echo urlencode($halakah_name); ?>&halakah_bio=<?php echo urlencode($halakah_bio); ?>" class="sidebar_links">
                <img src="../../assets/images/Student/grades.png" alt="icon">
                <p class="respons"> علاماتي </p>
            </a>
        </div>
    </div>
</div>