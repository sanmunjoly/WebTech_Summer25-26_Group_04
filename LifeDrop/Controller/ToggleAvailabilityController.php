<?php
/**
 * ToggleAvailabilityController.php
 * AJAX endpoint called from JS/dashboard-ajax.js.
 * Never trusts a donor_id from the client — always uses the session.
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

$database = new db();
$connection = $database->connection();
$model = new DonorModel();

$profile = $model->getDonorProfile($connection, $_SESSION["user_id"]);

if (!$profile) {
    echo json_encode(["success" => false, "message" => "Donor profile not found."]);
    exit;
}

$newStatus = $model->toggleAvailability($connection, $profile["donor_id"]);

echo json_encode([
    "success" => true,
    "availability" => $newStatus
]);
