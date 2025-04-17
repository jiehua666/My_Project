<?php
session_start();
require_once 'db_connection.php';

// 检查用户是否为管理员
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    echo json_encode([]);
    exit;
}

// 查询已上传的卡牌信息
$stmt = $conn->prepare("SELECT id, name, description, image_url FROM cards");
$stmt->execute();
$result = $stmt->get_result();

$cards = [];
while ($row = $result->fetch_assoc()) {
    $cards[] = $row;
}

echo json_encode($cards);

$stmt->close();
$conn->close();
?>
    