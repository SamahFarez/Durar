<?php
function check_login($conn)
{
   if (isset($_SESSION['user_id'])) {
      $id = $_SESSION['user_id'];
      $query = "select * from users where user_id = '$id' limit 1";
      $result = mysqli_query($conn, $query);
      if ($result && mysqli_num_rows($result) > 0) {
         $user_data = mysqli_fetch_assoc($result);
         return $user_data;
      }
   }
   // else, redirect to index.php
   header("Location: index.php");
}

function get_admin_id($conn)
{
   $stmt = $conn->prepare("SELECT admin_id FROM administrator WHERE admin_email = ?");
   $stmt->bind_param("s", $_SESSION['email']);

   // Execute the query
   $stmt->execute();

   // Get the result
   $result = $stmt->get_result();

   // Check if there is a row returned
   if ($result->num_rows > 0) {
      // Get the ID from the first row
      $row = $result->fetch_assoc();
      $admin_id = $row['admin_id'];
   } else {
      // No user found with the given email
      $admin_id = null;
   }

   // Close the statement and the database connection
   $stmt->close();
   return $admin_id;
}

function get_student_id($conn)
{
   $stmt = $conn->prepare("SELECT student_id FROM student WHERE student_email = ?");
   $stmt->bind_param("s", $_SESSION['email']);

   // Execute the query
   $stmt->execute();

   // Get the result
   $result = $stmt->get_result();

   // Check if there is a row returned
   if ($result->num_rows > 0) {
      // Get the ID from the first row
      $row = $result->fetch_assoc();
      $student_id = $row['student_id'];
   } else {
      // No user found with the given email
      $student_id = null;
   }

   // Close the statement and the database connection
   $stmt->close();
   return $student_id;
}

function get_teacher_id($conn)
{
   $stmt = $conn->prepare("SELECT teacher_id FROM teacher WHERE teacher_email = ?");
   $stmt->bind_param("s", $_SESSION['email']);

   // Execute the query
   $stmt->execute();

   // Get the result
   $result = $stmt->get_result();

   // Check if there is a row returned
   if ($result->num_rows > 0) {
      // Get the ID from the first row
      $row = $result->fetch_assoc();
      $teacher_id = $row['teacher_id'];
   } else {
      // No user found with the given email
      $teacher_id = null;
   }

   // Close the statement and the database connection
   $stmt->close();
   return $teacher_id;
}
function get_school_id_from_user($conn, $email, $role)
{
   if ($role == "administrator") {
      $stmt = $conn->prepare("SELECT school_id FROM administrator WHERE admin_email = ?");
      $stmt->bind_param("s", $email);

      // Execute the query
      $stmt->execute();

      // Get the result
      $result = $stmt->get_result();

      // Check if there is a row returned
      if ($result->num_rows > 0) {
         // Get the ID from the first row
         $row = $result->fetch_assoc();
         $school_id = $row['school_id'];
      } else {
         // No user found with the given email
         $school_id = null;
      }

      // Close the statement and the database connection
      $stmt->close();
      return $school_id;
   }
   if ($role == "teacher") {
      $stmt = $conn->prepare("SELECT school_id FROM teacher WHERE teacher_email = ?");
      $stmt->bind_param("s", $email);

      // Execute the query
      $stmt->execute();

      // Get the result
      $result = $stmt->get_result();

      // Check if there is a row returned
      if ($result->num_rows > 0) {
         // Get the ID from the first row
         $row = $result->fetch_assoc();
         $school_id = $row['school_id'];
      } else {
         // No user found with the given email
         $school_id = null;
      }

      // Close the statement and the database connection
      $stmt->close();
      return $school_id;
   }
   if ($role == "student") {
      $stmt = $conn->prepare("SELECT school_id FROM student WHERE student_email = ?");
      $stmt->bind_param("s", $email);

      // Execute the query
      $stmt->execute();

      // Get the result
      $result = $stmt->get_result();

      // Check if there is a row returned
      if ($result->num_rows > 0) {
         // Get the ID from the first row
         $row = $result->fetch_assoc();
         $school_id = $row['school_id'];
      } else {
         // No user found with the given email
         $school_id = null;
      }

      // Close the statement and the database connection
      $stmt->close();
      return $school_id;
   }
}
function get_school_id($conn, $schoolemail)
{
   $stmt = $conn->prepare("SELECT school_id FROM school WHERE school_email = ?");
   $stmt->bind_param("s", $schoolemail);

   // Execute the query
   $stmt->execute();

   // Get the result
   $result = $stmt->get_result();

   // Check if there is a row returned
   if ($result->num_rows > 0) {
      // Get the ID from the first row
      $row = $result->fetch_assoc();
      $student_id = $row['school_id'];
   } else {
      // No user found with the given email
      $student_id = null;
   }

   // Close the statement and the database connection
   $stmt->close();
   return $student_id;
}

function studentTimeTable($conn)
{
   ?>
   <section class="timetable" id="timetable">
      <div class="title">
         <p> توقيتي </p>
      </div>
      <div class="timetable_elements">
         <?php

         $id = get_student_id($conn);

         $sql = "SELECT timetable_id, subquery.halakah_name, t.halakah_id, timetalbe_week_day, timetalbe_session_start_time, timetalbe_session_end_time 
         FROM timetable t
         JOIN (
            SELECT h.halakah_name, h.halakah_id
            FROM student_halakah sh
            JOIN halakah h ON sh.halakah_id = h.halakah_id
            WHERE sh.student_id = '$id'
         ) AS subquery
         ON t.halakah_id = subquery.halakah_id
         ORDER BY t.timetalbe_week_day, t.timetalbe_session_start_time";

         $result = mysqli_query($conn, $sql);

         // Group the schedule data by day
         $schedule = array();
         while ($row = mysqli_fetch_assoc($result)) {
            $day_name = $row['timetalbe_week_day'];
            $start_time = date('H:i', strtotime($row['timetalbe_session_start_time']));
            $end_time = date('H:i', strtotime($row['timetalbe_session_end_time']));
            $halakah_name = $row['halakah_name'];
            $schedule[$day_name][] = array('timetalbe_session_start_time' => $start_time, 'timetalbe_session_end_time' => $end_time, 'halakah_name' => $halakah_name);
         }

         // Arabic day names
         $arabic_days = array(
            'Saturday' => 'السبت',
            'Sunday' => 'الأحد',
            'Monday' => 'الاثنين',
            'Tueday' => 'الثلاثاء',
            'Wednesday' => 'الأربعاء',
            'Thursday' => 'الخميس',
            'Friday' => 'الجمعة'
         );

         // Generate the HTML table
         ?>
         <style>
            .timetable_container {
               width: 1440px;
               overflow-x: auto;
               display: flex;
               align-self: center;
            }

            table {
               border-collapse: separate;
               border-spacing: 10px;
               table-layout: fixed;

            }

            table>tbody {
               display: flex;
               flex-direction: row !important;
               gap: 1%;
               width: 1100px;

            }

            tr {
               display: flex;
               flex-direction: column;
               flex-grow: 1;
               gap: 10px;
            }

            th,
            td {
               text-align: center;
               border: none;
               padding: 8px;
               background-color: #fff;
               color: #000;
            }

            th {
               align-items: center;
               background-color: var(--mainblue);
               color: var(--whiteFFF);
               border-radius: 20px;
            }

            td {
               width: 90%;
               box-sizing: border-box;
               text-align: center;
               padding: 5px 10px;
               background: var(--whiteFFF);
               /* main blue */
               border: 1px solid var(--mainblue);
               border-radius: 20px;
               align-self: center;
            }

            .class {
               font-family: 'Reem Kufi';
               font-weight: 500;
               font-size: 24px;
               line-height: 36px;
               color: var(--mainblue);
               padding: 0px;
               margin: 0px;
            }
         </style>
         <div class="timetable_container">
            <table>
               <?php foreach ($arabic_days as $day_in_eng => $day): ?>
                  <tr>
                     <th>
                        <?php echo $day ?>
                     </th>
                     <?php
                     $day_schedule = isset($schedule[$day_in_eng]) ? $schedule[$day_in_eng] : array();
                     foreach ($day_schedule as $cell) {
                        echo ' 
                        <td class="time">
                           <p class="class"> الحلقة ' . $cell['halakah_name'] . ' </p>
                           <hr>
                           <p>
                              من: ' . $cell['timetalbe_session_start_time'] . ' <br>
                              الى: ' . $cell['timetalbe_session_end_time'] . ' 
                           </p>
                        </td>
                        ';
                     }
                     ?>
                  </tr>
               <?php endforeach; ?>
            </table>
         </div>
         <?php
         ?>
      </div>
   </section>
   <?php
}

function teacherTimeTable($conn)
{
   ?>
   <section class="timetable" id="timetable">
      <div class="title">
         <p> توقيتي </p>
      </div>
      <div class="timetable_elements">
         <?php

         $id = get_teacher_id($conn);

         $sql = "SELECT timetable_id, t.halakah_id, h.halakah_name, timetalbe_week_day, timetalbe_session_start_time, timetalbe_session_end_time
         FROM timetable t join halakah h ON t.halakah_id=h.halakah_id WHERE h.teacher_id = '$id'
         ORDER BY t.timetalbe_week_day, t.timetalbe_session_start_time";

         $result = mysqli_query($conn, $sql);

         // Group the schedule data by day
         $schedule = array();
         while ($row = mysqli_fetch_assoc($result)) {
            $day_name = $row['timetalbe_week_day'];
            $start_time = date('H:i', strtotime($row['timetalbe_session_start_time']));
            $end_time = date('H:i', strtotime($row['timetalbe_session_end_time']));
            $halakah_name = $row['halakah_name'];
            $schedule[$day_name][] = array('timetalbe_session_start_time' => $start_time, 'timetalbe_session_end_time' => $end_time, 'halakah_name' => $halakah_name);
         }

         // Arabic day names
         $arabic_days = array(
            'Saturday' => 'السبت',
            'Sunday' => 'الأحد',
            'Monday' => 'الاثنين',
            'Tueday' => 'الثلاثاء',
            'Wednesday' => 'الأربعاء',
            'Thursday' => 'الخميس',
            'Friday' => 'الجمعة'
         );

         // Generate the HTML table
         ?>
         <style>
            .timetable_container {
               width: 1440px;
               overflow-x: auto;
               display: flex;
               align-self: center;
            }

            table {
               border-collapse: separate;
               border-spacing: 10px;
               table-layout: fixed;

            }

            table>tbody {
               display: flex;
               flex-direction: row !important;
               gap: 1%;
               width: 1100px;

            }

            tr {
               display: flex;
               flex-direction: column;
               flex-grow: 1;
               gap: 10px;
            }

            th,
            td {
               text-align: center;
               border: none;
               padding: 8px;
               background-color: #fff;
               color: #000;
            }

            th {
               align-items: center;
               background-color: var(--mainblue);
               color: var(--whiteFFF);
               border-radius: 20px;
            }

            td {
               width: 90%;
               box-sizing: border-box;
               text-align: center;
               padding: 5px 10px;
               background: var(--whiteFFF);
               /* main blue */
               border: 1px solid var(--mainblue);
               border-radius: 20px;
               align-self: center;
            }

            .class {
               font-family: 'Reem Kufi';
               font-weight: 500;
               font-size: 24px;
               line-height: 36px;
               color: var(--mainblue);
               padding: 0px;
               margin: 0px;
            }
         </style>
         <div class="timetable_container">
            <table>
               <?php foreach ($arabic_days as $day_in_eng => $day): ?>
                  <tr>
                     <th>
                        <?php echo $day ?>
                     </th>
                     <?php
                     $day_schedule = isset($schedule[$day_in_eng]) ? $schedule[$day_in_eng] : array();
                     foreach ($day_schedule as $cell) {
                        echo ' 
                        <td class="time">
                           <p class="class"> الحلقة ' . $cell['halakah_name'] . ' </p>
                           <hr>
                           <p>
                              من: ' . $cell['timetalbe_session_start_time'] . ' <br>
                              الى: ' . $cell['timetalbe_session_end_time'] . ' 
                           </p>
                        </td>
                        ';
                     }
                     ?>
                  </tr>
               <?php endforeach; ?>
            </table>
         </div>
         <?php
         ?>
      </div>
   </section>
   <?php
}

function halakahTimeTable($conn)
{
   ?>
   <section class="timetable" id="timetable">
      <div class="timetable_elements">
         <?php

         $id = $_GET['halakah_id'];

         $sql = "SELECT timetable_id, timetalbe_week_day, timetalbe_session_start_time, timetalbe_session_end_time
         FROM timetable t WHERE halakah_id = '$id'
         ORDER BY t.timetalbe_week_day, t.timetalbe_session_start_time";
         $result = mysqli_query($conn, $sql);

         // Group the schedule data by day
         $schedule = array();
         while ($row = mysqli_fetch_assoc($result)) {
            $day_name = $row['timetalbe_week_day'];
            $start_time = date('H:i', strtotime($row['timetalbe_session_start_time']));
            $end_time = date('H:i', strtotime($row['timetalbe_session_end_time']));
            $schedule[] = array('timetalbe_week_day' => $day_name, 'timetalbe_session_start_time' => $start_time, 'timetalbe_session_end_time' => $end_time);
         }

         // Arabic day names
         $arabic_days = array(
            'Saturday' => 'السبت',
            'Sunday' => 'الأحد',
            'Monday' => 'الاثنين',
            'Tuesday' => 'الثلاثاء',
            'Wednesday' => 'الأربعاء',
            'Thursday' => 'الخميس',
            'Friday' => 'الجمعة'
         );

         // Generate the HTML table
         $counter = 0;
         ?>
         <style>
            .timetable_container {
               width: 1440px;
               overflow-x: auto;
               display: flex;
               align-self: center;
            }

            .timetable {
               border-collapse: separate;
               border-spacing: 10px;
               table-layout: fixed;

            }

            .timetable>tbody {
               display: flex;
               flex-direction: column !important;
               gap: 20px;
               width: 900px;
            }

            .timeRow {
               display: flex;
               flex-direction: row;
               gap: 15px;
               justify-content: start;

            }

            .time {
               width: 210px;
               box-sizing: border-box;
               text-align: center;
               padding: 5px 10px;
               background: var(--whiteFFF);
               /* main blue */
               border: 1px solid var(--mainblue);
               border-radius: 20px;
               align-self: center;
            }

            .class {
               font-family: 'Reem Kufi';
               font-weight: 500;
               font-size: 24px;
               line-height: 36px;
               color: var(--mainblue);
               padding: 0px;
               margin: 0px;
            }
         </style>
         <div class="timetable_container">
            <table class="timetable">
               <?php foreach ($schedule as $cell) {
                  if ($counter % 4 === 0) {
                     echo '<tr class="timeRow">';
                  }
                  echo ' 
                  <td class="time">
                  <p class="class">' . $arabic_days[$cell['timetalbe_week_day']] . ' </p>
                  <hr>
                  <p>
                  من: ' . $cell['timetalbe_session_start_time'] . ' <br>
                  الى: ' . $cell['timetalbe_session_end_time'] . ' 
                  </p>
                  </td>
                  ';
                  if ($counter % 4 === 3) {
                     echo '</tr>';
                  }
                  $counter++;
               } ?>
            </table>
         </div>
         <?php
         ?>
      </div>
   </section>
   <?php
}

function showNumberOfStudents($conn, $halakah_id)
{
   $sql = "SELECT count(*) AS numberOfStudents FROM student_halakah WHERE halakah_id='$halakah_id'";
   $result = mysqli_query($conn, $sql);
   if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $numberOfStudents = $row['numberOfStudents'];
   } else {
      $numberOfStudents = 0;
   }
   echo $numberOfStudents;
}
function schoolTimeTable($conn, $choice)
{
   ?>
   <section id="timetable">

         <?php

         $admin_id = get_admin_id($conn);
         $sql = "SELECT admin_email FROM administrator WHERE admin_id = '$admin_id'";
         $result = mysqli_query($conn, $sql);

         if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $admin_email = $row['admin_email'];
         } else {
            $admin_email = null;
         }
         $school_id = get_school_id_from_user($conn, $admin_email, "administrator");

         $sql = "SELECT timetable_id, subquery.halakah_name, t.halakah_id, timetalbe_week_day, timetalbe_session_start_time, timetalbe_session_end_time, teacher_lname, teacher_fname 
         FROM timetable t
         JOIN (
            SELECT h.halakah_name, h.halakah_id, te.teacher_id, teacher_lname, teacher_fname
            FROM teacher te
            JOIN halakah h ON te.teacher_id = h.teacher_id
            WHERE h.school_id = '$school_id'
         ) AS subquery
         ON t.halakah_id = subquery.halakah_id
         ORDER BY t.timetalbe_week_day, t.timetalbe_session_start_time";

         $result = mysqli_query($conn, $sql);

         // Group the schedule data by day
         $schedule = array();
         while ($row = mysqli_fetch_assoc($result)) {
            $timetable_id = $row['timetable_id'];
            $day_name = $row['timetalbe_week_day'];
            $start_time = date('H:i', strtotime($row['timetalbe_session_start_time']));
            $end_time = date('H:i', strtotime($row['timetalbe_session_end_time']));
            $halakah = $row['halakah_name'];
            $teacher_fname = $row['teacher_fname'];
            $teacher_lname = $row['teacher_lname'];
            $schedule[$day_name][] = array(
               'timetable_id' => $timetable_id,
               'timetalbe_session_start_time' => $start_time,
               'timetalbe_session_end_time' => $end_time,
               'halakah_name' => $halakah,
               'teacher_fname' => $teacher_fname,
               'teacher_lname' => $teacher_lname
            );
         }

         // Arabic day names
         $arabic_days = array(
            'Saturday' => 'السبت',
            'Sunday' => 'الأحد',
            'Monday' => 'الاثنين',
            'Tuesday' => 'الثلاثاء',
            'Wednesday' => 'الأربعاء',
            'Thursday' => 'الخميس',
            'Friday' => 'الجمعة'
         );

         // Generate the HTML table
         ?>
         <style>
            .timetable_container {
                overflow-x: scroll;
                max-width: 80%;
                margin-right: 5%;
            }

            table {
               border-collapse: separate;
               border-spacing: 10px;
            }

            table>tbody {
               display: flex;
               flex-direction: row !important;
               gap: 1%;
            }

            tr {
               display: flex;
               flex-direction: column;
               flex-grow: 1;
               gap: 10px;
            }

            th,
            td {
               text-align: center;
               border: none;
               padding: 8px;
               background-color: #fff;
               color: #000;
               min-width: 128px;
            }

            th {
               display: flex;
               justify-content: center;
               align-items: center;
               background-color: var(--darkblue);
               color: var(--whiteFFF);
               font-family: "Cairo", sans-serif;
               font-size: 20px;
               border-radius: 5px;
               text-align: center;
               height: 60px;
               padding-top: 8px;
               font-weight: 500;
            }

            td {
               width: 100%;
               box-sizing: border-box;
               text-align: center;
               padding: 5px 10px;
               background: var(--whiteFFF);
               border: none;
               border-radius: 5px;
               align-self: center;
               display: flex;
               flex-direction: column;
               gap: 5px;
               height: 110px
            }

            .class {
               font-family: 'Reem Kufi';
               font-weight: 500;
               font-size: 24px;
               line-height: 36px;
               color: var(--mainblue);
               padding: 0px;
               margin: 0px;
            }

            .teachersTiming {
               height: fit-content;
               display: flex;
               flex-direction: row;
               justify-content: space-between;
               gap: 20px;
            }

            .Timings {
               display: flex;
               flex-direction: column;
               gap: 20px;
            }
         </style>
         <?php if ($choice == "byHalakah") { ?>
            <div class="timetable_container">
               <table>
                  <?php foreach ($arabic_days as $day_in_eng => $day): ?>
                     <tr>
                        <th>
                           <?php echo $day ?>
                        </th>
                        <?php
                        $day_schedule = isset($schedule[$day_in_eng]) ? $schedule[$day_in_eng] : array();
                        foreach ($day_schedule as $cell) {
                           echo ' 
                           <td class="time">
                              <p class="class"> الحلقة ' . $cell['halakah_name'] . ' </p>
                              <hr>
                              <p>
                                 من: ' . $cell['timetalbe_session_start_time'] . ' <br>
                                 الى: ' . $cell['timetalbe_session_end_time'] . ' 
                              </p>
                           </td>
                           ';
                        }
                        ?>
                     </tr>
                  <?php endforeach; ?>
               </table>
            </div>
         <?php } elseif ($choice == "byTeacher") {
            foreach ($arabic_days as $day_in_eng => $day): ?>
               <div class="dayProgram">
                  <div class="techersTime">
                     <div class="textContainer">
                        <p>
                           <?php echo $day ?>
                        </p>
                     </div>
                  </div>
                  <div class="Timings">

                     <?php
                     $day_schedule = isset($schedule[$day_in_eng]) ? $schedule[$day_in_eng] : array();
                     foreach ($day_schedule as $cell) {
                        echo ' 
                     <div class="teachersTiming">
                     <div class="textContainer">
                     <p>' . $cell['teacher_fname'] . ' ' . $cell['teacher_lname'] . '</p>
                     </div>
                     <div class="textContainer">
                     <p>من ' . $cell['timetalbe_session_start_time'] . ' إلى ' . $cell['timetalbe_session_end_time'] . '</p>
                     </div>
                     </div>
                     ';
                     }
                     ?>
                  </div>
               </div>
            <?php endforeach;
         }
         ?>

   </section>
   <?php
}

function EditschoolTimeTable($conn, $choice)
{
   ?>
   <section id="timetable">
      <div class="timetable_elements">
         <?php

         $admin_id = get_admin_id($conn);
         $sql = "SELECT admin_email FROM administrator WHERE admin_id = '$admin_id'";
         $result = mysqli_query($conn, $sql);

         if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $admin_email = $row['admin_email'];
         } else {
            $admin_email = null;
         }
         $school_id = get_school_id_from_user($conn, $admin_email, "administrator");

         $sql = "SELECT timetable_id, t.halakah_id, h.halakah_name, timetalbe_week_day, timetalbe_session_start_time, timetalbe_session_end_time
         FROM timetable t join halakah h ON t.halakah_id=h.halakah_id WHERE h.school_id = '$school_id'
         ORDER BY t.timetalbe_week_day, t.timetalbe_session_start_time";

         $result = mysqli_query($conn, $sql);

         // Group the schedule data by day
         $schedule = array();
         while ($row = mysqli_fetch_assoc($result)) {
            $timetable_id = $row['timetable_id'];
            $day_name = $row['timetalbe_week_day'];
            $start_time = date('H:i', strtotime($row['timetalbe_session_start_time']));
            $end_time = date('H:i', strtotime($row['timetalbe_session_end_time']));
            $halakah = $row['halakah_name'];

            $schedule[$day_name][] = array(
               'timetable_id' => $timetable_id,
               'timetalbe_session_start_time' => $start_time,
               'timetalbe_session_end_time' => $end_time,
               'halakah_name' => $halakah
            );
         }

         // Arabic day names
         $arabic_days = array(
            'Saturday' => 'السبت',
            'Sunday' => 'الأحد',
            'Monday' => 'الاثنين',
            'Tuesday' => 'الثلاثاء',
            'Wednesday' => 'الأربعاء',
            'Thursday' => 'الخميس',
            'Friday' => 'الجمعة'
         );

         // Generate the HTML table
         ?>
         <style>
            .timetable_container {
               overflow-x: auto;
               max-width: 80%;
               margin-right: 5%;
            }

            table {
               border-collapse: separate;
               border-spacing: 10px;
            }

            table>tbody {
               display: flex;
               flex-direction: row !important;
               gap: 1%;
               width: 900px;

            }

            tr {
               display: flex;
               flex-direction: column;
               flex-grow: 1;
               gap: 10px;
            }

            th,
            td {
               text-align: center;
               border: none;
               padding: 8px;
               background-color: #fff;
               color: #000;
            }

            th {
               display: flex;
               justify-content: center;
               align-items: center;
               background-color: var(--darkblue);
               color: var(--whiteFFF);
               font-family: "Cairo", sans-serif;
               font-size: 20px;
               border-radius: 5px;
               text-align: center;
               height: 60px;
               padding-top: 8px;
               box-sizing: border-box;
               min-width: 115px;
               width: 100%;
               font-weight: 500;
            }

            td {
               box-sizing: border-box;
               text-align: center;
               padding: 5px 10px;
               background: var(--whiteFFF);
               border: none;
               border-radius: 5px;
               align-self: center;
               display: flex;
               flex-direction: column;
               gap: 5px;
               /* height: 110px */
               position: relative;
            }

            .time {
               height: 110px
            }

            .class {
               font-family: 'Reem Kufi';
               font-weight: 500;
               font-size: 24px;
               line-height: 36px;
               color: var(--mainblue);
               padding: 0px;
               margin: 0px;
            }

            button {
               width: 100%;
               height: 100%;
            }

            .time:hover {
               background-color: var(--mainblue);
            }

            td:hover>p {
               visibility: hidden;
            }

            .remove_button {
               visibility: hidden;
               width: 110px;
               height: 100px;
               background-color: var(--mainblue);
               position: absolute;
               align-self: center;
               border: none;
            }

            .remove_button:click {
               background-color: var(--darkblue)
            }

            .remove_button>img {
               width: 30%;
            }

            td:hover .remove_button {
               visibility: visible;
            }

            .add_timing_button {
               width: 110px;
               height: 100px;
               background-color: var(--whiteFFF);
               position: relative;
               align-self: center;
               border: none;
            }
         </style>
         <div class="timetable_container">
            <table>
               <?php foreach ($arabic_days as $day_in_eng => $day): ?>
                  <tr>

                     <th>
                        <?php echo $day ?>
                     </th>
                     <?php
                     $day_schedule = isset($schedule[$day_in_eng]) ? $schedule[$day_in_eng] : array();
                     foreach ($day_schedule as $cell) {
                        echo ' 
                        <td class="time" id="' . $cell['timetable_id'] . '">
                           <button class="remove_button" onclick="removeTiming(' . $cell['timetable_id'] . ')">
                              <img src="../../assets/images/icons/delete_white.png">
                           </button>
                           <p class="class"> الحلقة ' . $cell['halakah_name'] . ' </p>
                           <hr>
                           <p>
                              من: ' . $cell['timetalbe_session_start_time'] . ' <br>
                              الى: ' . $cell['timetalbe_session_end_time'] . ' 
                           </p>
                        </td>
                        ';
                     }
                     ?>
                     <td>
                        <button class="add_timing_button" onclick="insert_new_timing(this, '<?php echo $day_in_eng; ?>')">
                           <img src="../../assets/images/icons/plus.png">
                        </button>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </table>
         </div>
         <?php
         ?>
      </div>
   </section>
   <?php
}

function get_user_row($email, $role, $conn)
{

   if ($role == 'student') {
      $studentProfile = mysqli_prepare($conn, "SELECT * FROM student WHERE student_email = ?");
      mysqli_stmt_bind_param($studentProfile, "s", $email);
      mysqli_stmt_execute($studentProfile);
      $studProfResults = mysqli_stmt_get_result($studentProfile);
      $studentRow = mysqli_fetch_assoc($studProfResults);

      return $studentRow;
   }

   if ($role == 'teacher') {
      $teacherProfile = mysqli_prepare($conn, "SELECT * FROM teacher WHERE teacher_email = ?");
      mysqli_stmt_bind_param($teacherProfile, "s", $email);
      mysqli_stmt_execute($teacherProfile);
      $teachProfResults = mysqli_stmt_get_result($teacherProfile);
      $teacherRow = mysqli_fetch_assoc($teachProfResults);

      return $teacherRow;
   }

   if ($role == 'administrator') {
      $adminProfile = mysqli_prepare($conn, "SELECT * FROM administrator WHERE admin_email = ?");
      mysqli_stmt_bind_param($adminProfile, "s", $email);
      mysqli_stmt_execute($adminProfile);
      $adProfResults = mysqli_stmt_get_result($adminProfile);
      $adminRow = mysqli_fetch_assoc($adProfResults);

      return $adminRow;
   }


   // If the role is not recognized or supported
   return null;
}

function count_episodes($email, $role, $conn)
{
   if ($role == 'student') {
      $studentClassCount = mysqli_prepare($conn, "SELECT count(P.halakah_id) as total_classes 
                                             FROM student S JOIN student_halakah P
                                             ON S.student_id = P.student_id
                                             WHERE S.student_email = ?
                                             group by P.student_id;");
      mysqli_stmt_bind_param($studentClassCount, "s", $email);
      mysqli_stmt_execute($studentClassCount);
      $classCountResult = mysqli_stmt_get_result($studentClassCount);
      $epsCountRow = mysqli_fetch_assoc($classCountResult);

      return $epsCountRow;
   }
}

function generate_confirmation_code()
{
   $confirmationCode = substr(uniqid('', true), -6);
   return $confirmationCode;
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_new_email($receiver_email, $subject, $body, $alt_body)
{
   // setting up the sender and the reciever
   require '../PHPMailer/src/Exception.php';
   require '../PHPMailer/src/PHPMailer.php';
   require '../PHPMailer/src/SMTP.php';
   try {
      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;
      $mail->Username = 'YottaMindCo@gmail.com';
      $mail->Password = 'okmcmkxicniodrfz';
      $mail->setFrom('YottaMindCo@gmail.com', 'YottaMind');
      $mail->addAddress($receiver_email);
      $mail->addReplyTo('no-reply@gmail.com', 'No-Reply');
      $mail->isHTML(true);

      // Filling the email
      $mail->Subject = $subject;
      $mail->Body = $body;
      $mail->AltBody = $alt_body;

      // Send the email
      $mail->send();
      return true;
   } catch (Exception $e) {
      echo 'Error: ' . $mail->ErrorInfo;
      return false;
   }
}

function get_school_row($school_id, $conn)
{
   $schoolProfile = mysqli_prepare($conn, "SELECT * FROM school WHERE school_id = ?");
   mysqli_stmt_bind_param($schoolProfile, "s", $school_id);
   mysqli_stmt_execute($schoolProfile);
   $schProfResults = mysqli_stmt_get_result($schoolProfile);
   $schoolRow = mysqli_fetch_assoc($schProfResults);

   return $schoolRow;
}

function get_school_name($conn, $school_id)
{
   $schoolRow = get_school_row($school_id, $conn);
   return $schoolRow['school_name'];
}

function showNumOfSchoolStudents($conn, $school_id)
{
   $sql = "SELECT count(*) AS numberOfStudents FROM student WHERE school_id='$school_id'";
   $result = mysqli_query($conn, $sql);
   if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $numberOfStudents = $row['numberOfStudents'];
   } else {
      $numberOfStudents = 0;
   }
   echo $numberOfStudents;
}

function showNumbOfHalakat($conn, $school_id)
{
   $sql = "SELECT count(*) AS numberOfhalakat FROM halakah WHERE school_id='$school_id'";
   $result = mysqli_query($conn, $sql);
   if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $numberOfhalakat = $row['numberOfhalakat'];
   } else {
      $numberOfhalakat = 0;
   }
   echo $numberOfhalakat;
}

function showNumbOfAdmins($conn, $school_id)
{
   $sql = "SELECT count(*) AS numberOfAdmins FROM administrator WHERE school_id='$school_id'";
   $result = mysqli_query($conn, $sql);
   if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $numberOfAdmins = $row['numberOfAdmins'];
   } else {
      $numberOfAdmins = 0;
   }
   echo $numberOfAdmins;
}

function showNumOfSchoolTeachers($conn, $school_id)
{
   $sql = "SELECT count(*) AS numberOfTeachers FROM teacher WHERE school_id='$school_id'";
   $result = mysqli_query($conn, $sql);
   if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $numberOfTeachers = $row['numberOfTeachers'];
   } else {
      $numberOfTeachers = 0;
   }
   echo $numberOfTeachers;
}
function removeSchoolHalakah($conn, $halakah_id)
{
   // Disable foreign key checks
   $disableForeignKeySQL = 'SET FOREIGN_KEY_CHECKS = 0';
   $disableStmt = $conn->prepare($disableForeignKeySQL);
   $disableStmt->execute();
   //remove all student progress from halakah
   $removeStudentProgress = mysqli_prepare($conn, "DELETE from student_progress WHERE halakah_id = ?;");
   mysqli_stmt_bind_param($removeStudentProgress, "i", $halakah_id);
   mysqli_stmt_execute($removeStudentProgress);
   // remove all students halakat
   $removeStudentHalakat = mysqli_prepare($conn, "DELETE from student_halakah WHERE halakah_id = ?;");
   mysqli_stmt_bind_param($removeStudentHalakat, "i", $halakah_id);
   mysqli_stmt_execute($removeStudentHalakat);
   // remove all exams of the halakah
   removeAllGradesInHalakahExams($conn, $halakah_id);
   $removeExamHalakat = mysqli_prepare($conn, "DELETE FROM exams WHERE halakah_id = ?;");
   mysqli_stmt_bind_param($removeExamHalakat, "i", $halakah_id);
   mysqli_stmt_execute($removeExamHalakat);
   // remove all timetable rows associated with the halakah
   $removeTimetableHalakat = mysqli_prepare($conn, "DELETE from timetable WHERE halakah_id = ?;");
   mysqli_stmt_bind_param($removeTimetableHalakat, "i", $halakah_id);
   mysqli_stmt_execute($removeTimetableHalakat);
   // remove teachers attendance related to the halakah
   $removeattendanceHalakat = mysqli_prepare($conn, "DELETE from teacher_attendance WHERE halakah_id = ?;");
   mysqli_stmt_bind_param($removeattendanceHalakat, "i", $halakah_id);
   mysqli_stmt_execute($removeattendanceHalakat);
   // remove sessions of the halakah
   $removesessionHalakat = mysqli_prepare($conn, "DELETE from session WHERE halakah_id = ?;");
   mysqli_stmt_bind_param($removesessionHalakat, "i", $halakah_id);
   mysqli_stmt_execute($removesessionHalakat);
   // delete halakah enfin
   $removeHalakat = mysqli_prepare($conn, "DELETE from halakah WHERE halakah_id = ?;");
   mysqli_stmt_bind_param($removeHalakat, "i", $halakah_id);
   mysqli_stmt_execute($removeHalakat);
   // Re-enable foreign key checks
   $enableForeignKeySQL = 'SET FOREIGN_KEY_CHECKS = 1';
   $enableStmt = $conn->prepare($enableForeignKeySQL);
   $enableStmt->execute();


}
function removeAllSchoolHalakah($conn, $school_id)
{

   $sql = "SELECT halakah_id from halakah WHERE school_id = '$school_id'";
   $result = mysqli_query($conn, $sql);
   while ($row = mysqli_fetch_assoc($result)) {
      $halakah_id = $row['halakah_id'];
      removeSchoolHalakah($conn, $halakah_id);
   }
}

function removeGradesInExam($conn, $exam_id)
{

   $removeGradesEXam = mysqli_prepare($conn, "DELETE from grades WHERE exam_id = ?;");
   mysqli_stmt_bind_param($removeGradesEXam, "i", $exam_id);
   mysqli_stmt_execute($removeGradesEXam);

}


function removeAllGradesInHalakahExams($conn, $halakah_id)
{
   $sql = "SELECT exam_id from exams WHERE halakah_id = '$halakah_id'";
   $result = mysqli_query($conn, $sql);
   while ($row = mysqli_fetch_assoc($result)) {
      $exam_id = $row['exam_id'];
      removeGradesInExam($conn, $exam_id);
   }

}