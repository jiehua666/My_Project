<?php
// 引入数据库连接文件
require_once 'db_connection.php';
session_start();

// 检查是否为 POST 请求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单提交的用户名和密码
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // 使用预处理语句查询用户信息
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $inputUsername, $inputPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // 登录成功
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $inputUsername;
        $_SESSION['is_admin'] = (bool)$row['is_admin']; // 存储 is_admin 信息到会话中
        header("Location: ../index.html");
    } else {
        // 登录失败
        echo "用户名或密码错误";
    }

    // 关闭预处理语句
    $stmt->close();
} else {
    echo "请通过表单提交登录信息";
}

// 关闭数据库连接
$conn->close();
?>