<?php
// Perform necessary database connection and error handling here
include '../head.php';
include '../init.php';
include 'functions.php';

session_start();
// update_halakah_bio.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the new halakah_bio value from the form and sanitize it
    $newHalakahBio = trim($_POST["halakah_bio"]);
    $newHalakahBio = htmlspecialchars($newHalakahBio, ENT_QUOTES, 'UTF-8');

    // Get the halakah_id from the form (hidden input)
    $halakahID = $_POST["halakah_id"];

    // Update the halakah_bio in the database
    $updateHalakahSQL = "UPDATE halakah SET halakah_bio = ? WHERE halakah_id = ?";
    $stmt = $conn->prepare($updateHalakahSQL);
    $stmt->bind_param("si", $newHalakahBio, $halakahID);
    $result = $stmt->execute();

    if ($result) {
        header('Location: ../pages/School/Episodes.php');
    } else {
        echo "Error updating halakah description: " . $stmt->error;
        header('Location: ../pages/School/editHalakah.php?halakahID='. $halakahID);

    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
