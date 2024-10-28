<?php
// redirect.php
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
} else {
    header("Location: default-page.php");
    exit;
}
?>
