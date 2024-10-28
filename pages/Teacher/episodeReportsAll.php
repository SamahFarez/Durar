<?php

include '../../head.php';
include '../../init.php';
// unauthorized access
include '../../includings/teacherRedirection.php';
// non logged in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';
include '../../includings/sessionFunctions.php';

$halakah_id = $_GET['halakah_id'];
$halakah_name = $_GET['halakah_name'];

?>


<title>Episode</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/Teacher/hala9aMain.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<style>
    @media (max-width:900px) {
        .hala9at {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
        }

        .all_sessions {
            gap: 0;
        }

        .hala9at-hala9a {
            width: 100%;
            margin-bottom: 2px;
        }
    }
</style>
</head>

<body dir="rtl">
    <!--Nav bar-->
    <div class="main">
        <?php include '../Teacher/teacherNav.html' ?>

        <?php include 'hala9aSidebar.php' ?>
        <!--side bar toggler-->
        <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
        <div class="newEpisode" style="width: 75%; display:inline-block;">

            <div class="hala9a-num">
                <p class="text-1">
                    <?php echo "الحلقة: " . $halakah_name ?>
                </p>
                <p class="text-2">تحفيظ القران الكريم</p>
            </div>
            <div class="studentsList" style="margin-top: 10px">
                <div class="session-1">
                    <p class="session-1-text">تقارير الحصص السابقة</p>
                    <p class="session-1-text" style="font-weight: 400; font-size: 24px;">
                        <?php showNumberOfSessions($conn, $halakah_id) ?> حصة
                    </p>
                </div>

                <div class=session-3>
                    <div class="session-3-a-div" style="display: none;">
                        <a class="session-3-a" href="#" id="down" onclick="reverseOrder(event, 'down')">ترتيب تنازلي</a>
                        <img style="transform: rotateX(180deg);" src="../../assets/images/icons/arrowUp.png"
                            alt="Arrow Up">
                    </div>
                    <div class="session-3-a-div">
                        <a class="session-3-a" href="#" id="up" onclick="reverseOrder(event, 'up')">ترتيب تصاعدي</a>
                        <img src="../../assets/images/icons/arrowUp.png" alt="Arrow Up">
                    </div>
                </div>
                <div class="all_sessions" id=Sessions>
                    <?php showSessions($conn, $halakah_id); ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div id="footer">
        <?php include 'teacherFooter.html' ?>
    </div>

    <script src="../../js/sidebars.js"></script>

    <script>
        function reverseOrder(event, choice) {
            const Up = document.getElementById("up").parentNode;
            const Down = document.getElementById("down").parentNode;
            if (choice == 'up') {
                Up.style.display = "none";
                Down.style.display = "flex";
            } else if (choice == 'down') {
                Up.style.display = "flex";
                Down.style.display = "none";
            }
            event.preventDefault(); // Prevent default navigation behavior
            var sessionsContainer = document.getElementById("Sessions");
            var hala9atContainers = sessionsContainer.getElementsByClassName("hala9at");

            // Reverse the order of hala9at containers
            Array.from(hala9atContainers).reverse().forEach(function (container) {
                sessionsContainer.appendChild(container);
            });

            // Reverse the order of hala9at-hala9a elements inside each container
            Array.from(hala9atContainers).forEach(function (container) {
                var hala9aElements = container.getElementsByClassName("hala9at-hala9a");
                Array.from(hala9aElements).reverse().forEach(function (element) {
                    container.appendChild(element);
                });
            });
        }

        function goToSession(session_id) {
            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Set up the AJAX request
            xhr.open('POST', '../../includings/showSession.php', true);

            // Set the content type
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            var data = new URLSearchParams();
            data.append('session_id', session_id);

            // Define the function to be called when the request is complete
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    var currentUrl = window.location.href;
                    var currentParams = currentUrl.split('?')[1];
                    var redirectUrl = 'episodeReports.php';
                    // Check if there are any query parameters in the current URL
                    if (currentParams) {
                        // Append the current query parameters to the redirect URL
                        redirectUrl += '?' + currentParams;
                    }
                    window.location.href = redirectUrl;
                } else {
                    // Request failed, handle the error
                    console.log('Error: ' + xhr.status);
                }
            };

            // Send the request
            xhr.send(data.toString());
        }
    </script>
</body>