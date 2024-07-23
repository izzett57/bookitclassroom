<?php
require_once '../assets/db_conn.php';
require_once '../assets/IsLoggedIn.php';
require_once '../assets/check-user-type.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$booking_id = $_GET['id'] ?? null;
$type = $_GET['type'] ?? 'booking';

if (!$booking_id) {
    $_SESSION['error'] = "No booking ID provided.";
    header("Location: timetable.php");
    exit();
}

$pdo = dbConnect();

try {
    $pdo->beginTransaction();

    // First, get the booking details
    $stmt = $pdo->prepare("SELECT b.*, e.User_ID, e.ID as Entry_ID FROM BOOKING b JOIN ENTRY e ON b.Entry_ID = e.ID WHERE b.ID = ?");
    $stmt->execute([$booking_id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$booking || $booking['User_ID'] != $_SESSION['ID']) {
        throw new Exception("You don't have permission to unreserve this booking.");
    }

    // Delete the booking
    $stmt = $pdo->prepare("DELETE FROM BOOKING WHERE ID = ?");
    $stmt->execute([$booking_id]);

    // If it's a semester booking, delete all related bookings
    if ($booking['Type'] == 'SEMESTER') {
        $stmt = $pdo->prepare("DELETE FROM BOOKING WHERE Entry_ID = ? AND Semester_ID = ? AND Type = 'SEMESTER'");
        $stmt->execute([$booking['Entry_ID'], $booking['Semester_ID']]);
    }

    // Check if there are any remaining bookings for this entry
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM BOOKING WHERE Entry_ID = ?");
    $stmt->execute([$booking['Entry_ID']]);
    $remainingBookings = $stmt->fetchColumn();

    // If no remaining bookings, update the ENTRY table
    if ($remainingBookings == 0) {
        $stmt = $pdo->prepare("UPDATE ENTRY SET Assigned_Class = NULL WHERE ID = ?");
        $stmt->execute([$booking['Entry_ID']]);
    }

    $pdo->commit();
    $_SESSION['success'] = "Reservation successfully cancelled.";
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Error during unreserve process: " . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
}

header("Location: timetable.php");
exit();
?>