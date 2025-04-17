<?php
// 引入数据库连接文件
require_once 'db_connection.php';
session_start();

// 检查是否为 POST 请求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单提交的用户名和密码
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // 检查用户名是否已存在
    $checkStmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $checkStmt->bind_param("s", $inputUsername);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // 用户名已存在
        echo "用户名已存在，请选择其他用户名";
    } else {
        // 插入新用户信息
        $insertStmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $insertStmt->bind_param("ss", $inputUsername, $inputPassword);

        if ($insertStmt->execute()) {
            // 注册成功
            echo "注册成功，请 <a href='../login.html'>登录</a>";
        } else {
            // 注册失败
            echo "注册失败: " . $insertStmt->error;
        }

        $insertStmt->close();
    }

    $checkStmt->close();
} else {
    echo "请通过表单提交注册信息";
}

// 关闭数据库连接
$conn->close();
?>
    