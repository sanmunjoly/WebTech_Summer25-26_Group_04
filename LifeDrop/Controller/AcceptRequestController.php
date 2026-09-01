<?php
/**
 * AcceptRequestController.php
 * AJAX endpoint called from JS/dashboard-ajax.js when a donor clicks "Accept".
 */

include "../Model/db.php";
include "../Model/DonorModel.php";

session_start();
header("Content-Type: application/json");

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "donor") {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Not logged in."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

$request_id = filter_input(INPUT_POST, "request_id", FILTER_VALIDATE_INT);

if (!$request_id) {
    echo json_encode(["success" => false, "message" => "Missing or invalid request id."]);
    exit;
}

$database = new db();
$connection = $database->connection();
$model = new DonorModel();

$profile = $model->getDonorProfile($connection, $_SESSION["user_id"]);

if (!$profile) {
    echo json_encode(["success" => false, "message" => "Donor profile not found."]);
    exit;
}

$result = $model->respondToRequest($connection, $request_id, $profile["donor_id"], "accepted");

echo json_encode($result);
