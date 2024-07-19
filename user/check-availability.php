<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Access denied');
}

$pdo = dbConnect();

$date = $_POST['date'] ?? null;
$time_start = $_POST['time_start'] ?? null;
$time_end = $_POST['time_end'] ?? null;

if (!$date || !$time_start || !$time_end) {
    header('HTTP/1.1 400 Bad Request');
    exit('Missing parameters');
}

$stmt = $pdo->prepare("SELECT CName FROM CLASSROOM");
$stmt->execute();
$classrooms = $stmt->fetchAll(PDO::FETCH_COLUMN);

$availability = [];

foreach ($classrooms as $classroom) {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM BOOKING b
        JOIN ENTRY e ON b.Entry_ID = e.ID
        WHERE b.Classroom = ? 
        AND b.Booking_Date = ? 
        AND ((e.Time_Start < ? AND e.Time_End > ?) 
        OR (e.Time_Start < ? AND e.Time_End > ?) 
        OR (e.Time_Start >= ? AND e.Time_End <= ?))
    ");
    $stmt->execute([$classroom, $date, $time_end, $time_start, $time_start, $time_end, $time_start, $time_end]);
    $count = $stmt->fetchColumn();
    
    $availability[] = [
        'name' => $classroom,
        'available' => ($count == 0)
    ];
}

header('Content-Type: application/json');
echo json_encode($availability);
?>