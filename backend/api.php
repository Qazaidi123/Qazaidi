<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$conn = new mysqli("mysql-service", "root", "password", "travel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    $reg_id = "REG" . strtoupper(substr(md5(time()), 0, 6));

    $stmt = $conn->prepare("INSERT INTO registrations (reg_id, name, mobile, destination, members) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi",
        $reg_id,
        $data['name'],
        $data['mobile'],
        $data['destination'],
        $data['members']
    );

    $stmt->execute();

    echo json_encode(["reg_id" => $reg_id]);
}
?>
