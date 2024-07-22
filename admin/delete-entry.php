<?php
require_once '../assets/db_conn.php';
require_once '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$entry_id = $_GET['id'] ?? null;

if (!$entry_id) {
    $_SESSION['error'] = "No entry ID provided.";
    header("Location: timetable.php");
    exit();
}

$pdo = dbConnect();

try {
    $pdo->beginTransaction();

    // Check if the entry belongs to the current user
    $stmt = $pdo->prepare("SELECT User_ID FROM ENTRY WHERE ID = ?");
    $stmt->execute([$entry_id]);
    $entry = $stmt->fetch();

    if (!$entry || $entry['User_ID'] != $_SESSION['ID']) {
        throw new Exception("You don't have permission to delete this entry.");
    }

    // Delete associated bookings
    $stmt = $pdo->prepare("DELETE FROM BOOKING WHERE Entry_ID = ?");
    $stmt->execute([$entry_id]);

    // Delete the entry
    $stmt = $pdo->prepare("DELETE FROM ENTRY WHERE ID = ?");
    $stmt->execute([$entry_id]);

    $pdo->commit();
    $_SESSION['success'] = "Entry and associated bookings successfully deleted.";
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Error during entry deletion process: " . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
}

header("Location: timetable.php");
exit();
?>