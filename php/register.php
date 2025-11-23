<?php
require "db.php";
require "redis.php";

$data = json_decode(file_get_contents("php://input"), true);

$username = $data["username"];
$password = password_hash($data["password"], PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
