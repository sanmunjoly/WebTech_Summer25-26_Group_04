<?php
/**
 * DonorDashboardController.php
 * Controller layer: guards the page with the session, then pulls together
 * every piece of data View/DonorDashboard.php needs to render.
 */

include "../Model/db.php";
include "../Model/DonorModel.php";

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "donor") {
    header("Location: login.php");
    exit;
}

$database = new db();
$connection = $database->connection();
$model = new DonorModel();

$user_id = $_SESSION["user_id"];

$profile = $model->getDonorProfile($connection, $user_id);

if (!$profile) {
    // User exists but has no donor_profile row yet.
    session_destroy();
    header("Location: login.php");
    exit;
}

$donor_id = $profile["donor_id"];
$donationHistory = $model->getDonationHistory($connection, $donor_id);
$bloodRequests = $model->getBloodRequests($connection, $donor_id);
$eligibility = $model->calculateEligibility($profile["last_donation_date"]);

$profileUpdated = isset($_GET["updated"]) && $_GET["updated"] === "1";
