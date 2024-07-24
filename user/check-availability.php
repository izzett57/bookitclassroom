<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';
require_once '../assets/check-user-type.php';

if (!isset($_SESSION['ID'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$date = $_POST['date'] ?? null;
$timeStart = $_POST['time_start'] ?? null;
$timeEnd = $_POST['time_end'] ?? null;

if (!$date || !$timeStart || !$timeEnd) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required parameters']);
    exit();
}

$pdo = dbConnect();

try {
    $query = "
        SELECT c.CName, 
               CASE WHEN b.ID IS NULL THEN 1 ELSE 0 END AS available
        FROM CLASSROOM c
        LEFT JOIN BOOKING b ON c.CName = b.Classroom
            AND b.Booking_Date = :date
        LEFT JOIN ENTRY e ON e.ID = b.Entry_ID
        WHERE b.ID IS NULL OR (
            e.Time_Start < :timeEnd AND e.Time_End > :timeStart
        )
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':date' => $date,
        ':timeStart' => $timeStart,
        ':timeEnd' => $timeEnd
    ]);
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $formattedResult = array_map(function($row) {
        return [
            'name' => $row['CName'],
            'available' => (bool)$row['available']
        ];
    }, $result);

    echo json_encode($formattedResult);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}
?>