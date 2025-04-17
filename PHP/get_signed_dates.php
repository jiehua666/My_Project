<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['signed_dates' => []]);
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT date FROM sign_ins WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$signed_dates = [];
while ($row = $result->fetch_assoc()) {
    $signed_dates[] = $row['date'];
}

echo json_encode(['signed_dates' => $signed_dates]);

$stmt->close();
$conn->close();
?>
    