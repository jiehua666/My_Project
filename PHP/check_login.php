<?php
session_start();
echo json_encode([
    'is_logged_in' => isset($_SESSION['user_id']),
    'is_admin' => isset($_SESSION['is_admin']) && (bool)$_SESSION['is_admin']
]);
?>