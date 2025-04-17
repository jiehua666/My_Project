<?php
session_start();
require_once 'db_connection.php';

// 检查用户是否为管理员
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    echo "你没有权限进行此操作";
    exit;
}

// 日志记录函数
function log_error($message) {
    $log_file = 'upload_errors.log';
    $log_message = date('Y-m-d H:i:s') . " - " . $message . "\n";
    file_put_contents($log_file, $log_message, FILE_APPEND);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $image_filename = $_POST['image_filename'] ?? '';

    // 检查卡牌是否已存在
    $checkStmt = $conn->prepare("SELECT id FROM cards WHERE name = ?");
    $checkStmt->bind_param("s", $name);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $error_message = "卡牌已存在，无法重复上传: " . $name;
        log_error($error_message);
        echo $error_message;
        $checkStmt->close();
        exit;
    }
    $checkStmt->close();

    // 处理图片路径
    $image_url = '';
    if (!empty($image_filename)) {
        $target_dir = "C:/Users/Administrator/Desktop/KPP/main/PHP/uploads/cards/";
        // 确保目录存在
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . $image_filename;
        if (file_exists($target_file)) {
            // 修改为相对服务器根目录的路径
            $image_url = "uploads/cards/" . $image_filename; 
        } else {
            $error_message = "图片文件不存在: " . $target_file;
            log_error($error_message);
            echo $error_message;
            exit;
        }
    }

    // 插入卡牌信息到数据库
    try {
        $stmt = $conn->prepare("INSERT INTO cards (name, description, image_url) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $image_url);

        if ($stmt->execute()) {
            echo "卡牌信息添加成功";
        } else {
            $error_message = "卡牌信息添加失败: " . $stmt->error;
            log_error($error_message);
            echo $error_message;
        }
    } catch (Exception $e) {
        $error_message = "数据库操作出错: " . $e->getMessage();
        log_error($error_message);
        echo $error_message;
    }

    if (isset($stmt)) {
        $stmt->close();
    }
} else {
    echo "请通过表单提交卡牌信息";
}

$conn->close();
?>
    