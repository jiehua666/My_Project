<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => '请先登录']);
    exit;
}

$user_id = $_SESSION['user_id'];
$input = json_decode(file_get_contents('php://input'), true);
$date = $input['date'];

// 检查是否已经签到
$checkStmt = $conn->prepare("SELECT * FROM sign_ins WHERE user_id = ? AND date = ?");
$checkStmt->bind_param("is", $user_id, $date);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => '你已经签到过了']);
} else {
    // 插入签到记录
    $insertStmt = $conn->prepare("INSERT INTO sign_ins (user_id, date) VALUES (?, ?)");
    $insertStmt->bind_param("is", $user_id, $date);

    if ($insertStmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => '签到失败: ' . $insertStmt->error]);
    }
}

$checkStmt->close();
$insertStmt->close();
$conn->close();
?>
    