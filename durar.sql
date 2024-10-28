-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 27, 2023 at 10:32 PM
-- Server version: 10.11.2-MariaDB
-- PHP Version: 8.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `durar`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `admin_id` int(11) NOT NULL,
  `admin_fname` varchar(20) DEFAULT NULL,
  `admin_lname` varchar(20) DEFAULT NULL,
  `admin_gender` varchar(10) DEFAULT NULL,
  `admin_email` varchar(64) DEFAULT NULL,
  `admin_phone` varchar(20) DEFAULT NULL,
  `admin_password` varchar(255) DEFAULT NULL,
  `admin_country` varchar(60) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `admin_creationdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_bio` varchar(500) DEFAULT NULL,
  `admin_pic` varchar(1000) NOT NULL DEFAULT 'profile_picture/admin/admin.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_name`) VALUES
('قسم تحفيظ القرآن الكريم');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'أفغانستان'),
(2, 'الجزائر'),
(3, 'البحرين'),
(4, 'بنغلاديش'),
(5, 'بروناي'),
(6, 'جزر القمر'),
(7, 'جيبوتي'),
(8, 'مصر'),
(9, 'إيران'),
(10, 'العراق'),
(11, 'الأردن'),
(12, 'الكويت'),
(13, 'لبنان'),
(14, 'ليبيا'),
(15, 'ماليزيا'),
(16, 'جزر المالديف'),
(17, 'موريتانيا'),
(18, 'المغرب'),
(19, 'عُمان'),
(20, 'باكستان'),
(21, 'فلسطين'),
(22, 'قطر'),
(23, 'المملكة العربية السعودية'),
(24, 'الصومال'),
(25, 'السودان'),
(26, 'سوريا'),
(27, 'تونس'),
(28, 'الإمارات العربية المتحدة'),
(29, 'اليمن');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_title` varchar(100) NOT NULL,
  `school_id` int(11) NOT NULL,
  `event_description` varchar(1000) DEFAULT NULL,
  `event_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `event_location` varchar(500) DEFAULT NULL,
  `event_nb_participants` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `exam_id` int(11) NOT NULL,
  `exam_name` varchar(50) NOT NULL,
  `halakah_id` int(11) NOT NULL,
  `exam_date` date DEFAULT NULL,
  `exam_period` varchar(50) DEFAULT NULL,
  `exam_description` varchar(800) DEFAULT NULL,
  `exam_time` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `exam_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `mark` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `halakah`
--

CREATE TABLE `halakah` (
  `halakah_id` int(11) NOT NULL,
  `class_name` varchar(30) DEFAULT NULL,
  `school_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `halakah_nbstudents` int(11) DEFAULT NULL,
  `halakah_creationdate` date DEFAULT NULL,
  `halakah_bio` varchar(500) DEFAULT NULL,
  `halakah_name` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `school_id` int(11) NOT NULL,
  `school_name` varchar(100) DEFAULT NULL,
  `school_email` varchar(64) DEFAULT NULL,
  `school_phone` varchar(15) DEFAULT NULL,
  `school_range` varchar(20) DEFAULT NULL,
  `school_type` varchar(50) DEFAULT NULL,
  `school_address` varchar(200) DEFAULT NULL,
  `school_nbteachers` int(11) DEFAULT 0,
  `school_nbhalakah` int(11) DEFAULT 0,
  `school_nbadmin` int(11) DEFAULT 0,
  `school_creationdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `school_bio` varchar(500) DEFAULT NULL,
  `school_cover` varchar(1000) NOT NULL DEFAULT 'SchoolCover/Default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `session_id` int(11) NOT NULL,
  `halakah_id` int(11) NOT NULL,
  `session_date` date DEFAULT NULL,
  `session_report` varchar(800) DEFAULT NULL,
  `session_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `student_fname` varchar(20) DEFAULT NULL,
  `student_lname` varchar(20) DEFAULT NULL,
  `student_gender` varchar(10) DEFAULT NULL,
  `student_email` varchar(64) DEFAULT NULL,
  `student_phone` varchar(20) DEFAULT NULL,
  `student_password` varchar(255) DEFAULT NULL,
  `student_country` varchar(60) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `student_creationdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `student_bio` varchar(500) DEFAULT NULL,
  `student_pic` varchar(1000) NOT NULL DEFAULT 'profile_picture/student/studentPic.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_halakah`
--

CREATE TABLE `student_halakah` (
  `student_id` int(11) NOT NULL,
  `halakah_id` int(11) NOT NULL,
  `total_memorized` double NOT NULL DEFAULT 0,
  `total_revised` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_progress`
--

CREATE TABLE `student_progress` (
  `session_id` int(11) NOT NULL,
  `halakah_id` int(11) NOT NULL,
  `class_name` varchar(30) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `student_state` varchar(20) DEFAULT NULL,
  `quran_memorized` double DEFAULT NULL,
  `quran_revised` double DEFAULT NULL,
  `student_evaluation` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL,
  `teacher_fname` varchar(20) DEFAULT NULL,
  `teacher_lname` varchar(20) DEFAULT NULL,
  `teacher_gender` varchar(10) DEFAULT NULL,
  `teacher_email` varchar(64) DEFAULT NULL,
  `teacher_phone` varchar(20) DEFAULT NULL,
  `teacher_password` varchar(255) DEFAULT NULL,
  `teacher_country` varchar(60) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `teacher_creationdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `teacher_bio` varchar(500) DEFAULT NULL,
  `teacher_pic` varchar(1000) NOT NULL DEFAULT 'profile_picture/teacher/teacherpic.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_attendance`
--

CREATE TABLE `teacher_attendance` (
  `teacher_id` int(11) NOT NULL,
  `halakah_id` int(11) NOT NULL,
  `absence_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `timetable_id` int(11) NOT NULL,
  `halakah_id` int(11) NOT NULL,
  `timetalbe_week_day` enum('Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday') NOT NULL,
  `timetalbe_session_start_time` time DEFAULT NULL,
  `timetalbe_session_end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_email` (`admin_email`),
  ADD KEY `fk_admin_school` (`school_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_name`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_title`,`school_id`),
  ADD KEY `fk_event_school` (`school_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`exam_id`) USING BTREE,
  ADD KEY `fk_exams_halakah` (`halakah_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`exam_id`,`student_id`) USING BTREE,
  ADD KEY `fk_grades_student` (`student_id`);

--
-- Indexes for table `halakah`
--
ALTER TABLE `halakah`
  ADD PRIMARY KEY (`halakah_id`) USING BTREE,
  ADD KEY `fk_halakah_class` (`class_name`),
  ADD KEY `fk_halakah_school` (`school_id`),
  ADD KEY `fk_halakat_teacher` (`teacher_id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`school_id`),
  ADD UNIQUE KEY `school_email` (`school_email`) USING BTREE;

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`session_id`) USING BTREE,
  ADD KEY `fk_session_halakah` (`halakah_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_email` (`student_email`),
  ADD KEY `fk_student_school` (`school_id`);

--
-- Indexes for table `student_halakah`
--
ALTER TABLE `student_halakah`
  ADD KEY `fk_sh_student` (`student_id`),
  ADD KEY `fk_sh_halakah` (`halakah_id`);

--
-- Indexes for table `student_progress`
--
ALTER TABLE `student_progress`
  ADD PRIMARY KEY (`session_id`,`halakah_id`,`student_id`),
  ADD KEY `fk_progress_state` (`student_state`),
  ADD KEY `fk_progress_student` (`student_id`),
  ADD KEY `fk_progress_halakah` (`halakah_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `teacher_email` (`teacher_email`),
  ADD KEY `fk_teacher_school` (`school_id`);

--
-- Indexes for table `teacher_attendance`
--
ALTER TABLE `teacher_attendance`
  ADD PRIMARY KEY (`teacher_id`,`halakah_id`,`absence_date`),
  ADD KEY `fk_teacherAttendance_halakah` (`halakah_id`),
  ADD KEY `fk_teacherAttendance_teacher` (`teacher_id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`timetable_id`),
  ADD KEY `fk_timetable_halakah` (`halakah_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `halakah`
--
ALTER TABLE `halakah`
  MODIFY `halakah_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `timetable_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `fk_admin_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_event_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`);

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `fk_exams_halakah` FOREIGN KEY (`halakah_id`) REFERENCES `halakah` (`halakah_id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `fk_grades_exam` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`),
  ADD CONSTRAINT `fk_grades_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `halakah`
--
ALTER TABLE `halakah`
  ADD CONSTRAINT `fk_halakah_class` FOREIGN KEY (`class_name`) REFERENCES `class` (`class_name`),
  ADD CONSTRAINT `fk_halakah_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`),
  ADD CONSTRAINT `fk_halakat_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Constraints for table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `fk_session_halakah` FOREIGN KEY (`halakah_id`) REFERENCES `halakah` (`halakah_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`);

--
-- Constraints for table `student_halakah`
--
ALTER TABLE `student_halakah`
  ADD CONSTRAINT `fk_sh_halakah` FOREIGN KEY (`halakah_id`) REFERENCES `halakah` (`halakah_id`),
  ADD CONSTRAINT `fk_sh_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `student_progress`
--
ALTER TABLE `student_progress`
  ADD CONSTRAINT `fk_progress_halakah` FOREIGN KEY (`halakah_id`) REFERENCES `halakah` (`halakah_id`),
  ADD CONSTRAINT `fk_progress_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `fl_progress_session` FOREIGN KEY (`session_id`) REFERENCES `session` (`session_id`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `fk_teacher_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`);

--
-- Constraints for table `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `fk_timetable_halakah` FOREIGN KEY (`halakah_id`) REFERENCES `halakah` (`halakah_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
