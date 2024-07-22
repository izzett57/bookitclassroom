<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

// Log errors instead of displaying them
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log'); // Change to a writable path
ini_set('display_errors', 0);

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$pdo = dbConnect();
if (!$pdo) {
    error_log('Database connection failed');
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $timeStart = $_POST['time_start'];
    $timeEnd = $_POST['time_end'];

    // Fetch all classrooms
    $stmt = $pdo->query("SELECT CName FROM CLASSROOM");
    if (!$stmt) {
        error_log('Failed to fetch classrooms: ' . implode(', ', $pdo->errorInfo()));
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch classrooms']);
        exit();
    }
    $classrooms = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $result = array();

    foreach ($classrooms as $classroom) {
        // Check if the classroom is booked for the given time range
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM BOOKING WHERE CName = ? AND Date = ? AND ((TimeStart <= ? AND TimeEnd > ?) OR (TimeStart < ? AND TimeEnd >= ?))");
        if (!$stmt) {
            error_log('Failed to prepare statement: ' . implode(', ', $pdo->errorInfo()));
            http_response_code(500);
            echo json_encode(['error' => 'Failed to prepare statement']);
            exit();
        }
        $stmt->execute([$classroom, $date, $timeStart, $timeStart, $timeEnd, $timeEnd]);
        if (!$stmt) {
            error_log('Failed to execute statement: ' . implode(', ', $pdo->errorInfo()));
            http_response_code(500);
            echo json_encode(['error' => 'Failed to execute statement']);
            exit();
        }
        $count = $stmt->fetchColumn();

        $result[] = array(
            'name' => $classroom,
            'available' => ($count == 0)
        );
    }

    header('Content-Type: application/json');
    echo json_encode($result);
    exit();
}

// If not a POST request, return an error
http_response_code(400);
echo json_encode(['error' => 'Invalid request method']);
exit();
?>
