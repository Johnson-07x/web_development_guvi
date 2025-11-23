<?php
require "db.php";
require "redis.php";

$data = json_decode(file_get_contents("php://input"), true);

$username = $data["username"];
$password = $data["password"];

$stmt = $conn->prepare("SELECT id, password FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $hash);
$stmt->fetch();

if ($stmt->num_rows > 0 && password_verify($password, $hash)) {

    $token = bin2hex(random_bytes(32));

    $redis->set($token, $id);
    $redis->expire($token, 3600);

    echo json_encode(["status" => "success", "token" => $token]);
} else {
    echo json_encode(["status" => "invalid"]);
}
?>
