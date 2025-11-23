<?php
require "db.php";
require "redis.php";

$data = json_decode(file_get_contents("php://input"), true);

$action = $data["action"];
$token  = $data["token"];

$userId = $redis->get($token);

if (!$userId) {
    echo json_encode(["status" => "invalid"]);
    exit;
}

if ($action === "get") {

    $stmt = $conn->prepare("SELECT username, age, dob, contact FROM users WHERE id=?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    $res = $stmt->get_result()->fetch_assoc();

    echo json_encode(["status" => "success", "data" => $res]);
    exit;
}

if ($action === "update") {

    $age     = $data["age"];
    $dob     = $data["dob"];
    $contact = $data["contact"];

    $stmt = $conn->prepare("UPDATE users SET age=?, dob=?, contact=? WHERE id=?");
    $stmt->bind_param("issi", $age, $dob, $contact, $userId);
    $stmt->execute();

    echo json_encode(["status" => "updated"]);
    exit;
}
?>
