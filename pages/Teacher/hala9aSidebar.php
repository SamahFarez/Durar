<?php

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

<div class="side-bar side_bar" style="font-size: 16px;" style="display: inline-block">
    <div class="teacher-info" style="align-items: center; text-align:center;">
        <a href="profile.php">
            <img style="width: 50%; border-radius:50%; border:1px solid var(--mainblue)" class="profilePicture" src="<?php echo '../../' . $_SESSION['profilePicture'] ?>" alt="teacher picture">
        </a>
        <p style="font-size: 18px; padding:0 10px" class="teacher-info_name"> <?php echo $_SESSION['fname'] . " " . $_SESSION['lname'] ?> </p>
        <p class="teacher-info_role"> أستاذ </p>
    </div>
    <div class=line>
    </div>
    <div class="teacher-info">
        <div>
            <p style="font-size: 18px;" class="teacher-info-title">
                الرئيسية
            </p>
        </div>
        <a href="index.php" class="teacher-info-logo-title sidebar_links">
            <img src="../../assets/images/icons/main - teacher episode icons.png" style="height: 13px; width: 24px;">
            <p style="font-size: 18px;" class="teacher-info-sub-title respons">الرئيسية</p>
        </a>
    </div>

    <div class=line></div>

    <div class="teacher-info">
        <div>
            <p style="font-size: 18px;" class="teacher-info-title sidebar_title">
                حصص الحلقة
            </p>
        </div>
        <a href="newEpisode.php?halakah_id=<?php echo $halakah_id; ?>&halakah_name=<?php echo urlencode($halakah_name); ?>" class="teacher-info-logo-title sidebar_links">
            <img src="../../assets/images/icons/new session - teacher episode icons.png">
            <p style="font-size: 18px;" class="teacher-info-sub-title respons">حصة جديدة</p>
        </a>
        <a href="episodeReportsAll.php?halakah_id=<?php echo $halakah_id; ?>&halakah_name=<?php echo urlencode($halakah_name); ?>" class="teacher-info-logo-title sidebar_links">
            <img src="../../assets/images/icons/sessions - teacher episode icons.png">
            <p style="font-size: 18px;" class="teacher-info-sub-title respons">تقارير الحصص السابقة</p>
        </a>
    </div>

    <div class=line></div>

    <div class="teacher-info">
        <div>
            <p style="font-size: 18px;" class="teacher-info-title sidebar_title">
                الامتحانات
            </p>
        </div>
        <a href="newExam.php?halakah_id=<?php echo $halakah_id; ?>&halakah_name=<?php echo urlencode($halakah_name); ?>" class="teacher-info-logo-title sidebar_links">
            <img src="../../assets/images/icons/add exam - teacher episode icons.png">
            <p style="font-size: 18px;" class="teacher-info-sub-title respons">اضافة امتحان</p>
        </a>
        <a href="examList.php?halakah_id=<?php echo $halakah_id; ?>&halakah_name=<?php echo urlencode($halakah_name); ?>" class="teacher-info-logo-title sidebar_links">
            <img src="../../assets/images/icons/exams list - teacher episode icons.png">
            <p style="font-size: 18px;" class="teacher-info-sub-title respons">قائمة الامتحانات</p>
        </a>
    </div>

    <div class=line></div>

    <div class="teacher-info">
        <div>
            <p style="font-size: 18px;" class="teacher-info-title sidebar_title">
                الإحصائيات
            </p>
        </div>
        <a href="absenceStats.php?halakah_id=<?php echo $halakah_id; ?>&halakah_name=<?php echo urlencode($halakah_name); ?>" class="teacher-info-logo-title sidebar_links">
            <img src="../../assets/images/icons/attendance stat - teacher episode icons.png">
            <p style="font-size: 18px;" class="teacher-info-sub-title respons">الحضور والغياب</p>
        </a>
        <a href="MemoRevision.php?halakah_id=<?php echo $halakah_id; ?>&halakah_name=<?php echo urlencode($halakah_name); ?>" class="teacher-info-logo-title sidebar_links">
            <img src="../../assets/images/icons/performance stat - teacher episode icons.png">
            <p style="font-size: 18px;" class="teacher-info-sub-title respons">الحفظ والمراجعة</p>
        </a>
        <a href="examStats.php?halakah_id=<?php echo $halakah_id; ?>&halakah_name=<?php echo urlencode($halakah_name); ?>" class="teacher-info-logo-title sidebar_links">
            <img src="../../assets/images/icons/exams stat - teacher episode icons.png">
            <p style="font-size: 18px;" class="teacher-info-sub-title respons">الامتحانات</p>
        </a>
    </div>
</div>