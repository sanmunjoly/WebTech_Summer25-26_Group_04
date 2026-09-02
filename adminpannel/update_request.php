<?php
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION["admin"])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$id = $data["id"] ?? "";
$status = $data["status"] ?? "";

if (!$id || !in_array($status, ["Approved", "Rejected"], true)) {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit();
}

$file = __DIR__ . "/data/requests.json";
$requests = json_decode(file_get_contents($file), true);

$found = false;
foreach ($requests as &$request) {
    if ($request["id"] === $id) {
        $request["status"] = $status;
        $found = true;
        break;
    }
}

if ($found) {
    file_put_contents($file, json_encode($requests, JSON_PRETTY_PRINT));
    echo json_encode(["success" => true, "status" => $status]);
} else {
    echo json_encode(["success" => false, "message" => "Request not found"]);
}
?>
