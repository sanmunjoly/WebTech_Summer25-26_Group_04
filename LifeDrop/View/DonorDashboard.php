<?php
include "../Controller/DonorDashboardController.php";

$fullName = htmlspecialchars($profile["full_name"]);
$bloodGroup = htmlspecialchars($profile["blood_group"] ?? "-");
$location = htmlspecialchars($profile["address"] ?? "-");
$phone = htmlspecialchars($profile["phone"] ?? "-");
$totalDonations = (int) $profile["total_donation"];
$availability = $profile["availability"];
$lastDonation = $profile["last_donation_date"]
    ? date("M d, Y", strtotime($profile["last_donation_date"]))
    : "No donations yet";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LifeDrop | Donor Dashboard</title>
    <link rel="stylesheet" href="../Design/dashboard.css">
</head>
<body>
    <header class="topbar">
        <div class="brand"><span class="drop">&#128138;</span> LifeDrop</div>
        <nav class="topnav">
            <a href="#requests">Donor</a>
            <a href="../Controller/LogoutController.php" class="logout-link">Logout</a>
        </nav>
    </header>

    <main class="page">
        <section class="page-heading">
            <p class="eyebrow">Blood Donor</p>
            <h1>Donor Dashboard</h1>
            <p class="subtitle">Manage your profile, donation history and availability.</p>
        </section>

        <?php if ($profileUpdated) : ?>
            <div class="banner success">Your profile was updated.</div>
        <?php endif; ?>

        <section class="stat-grid">
            <div class="stat-card">
                <p class="stat-label">Blood Group</p>
                <p class="stat-value"><?php echo $bloodGroup; ?></p>
                <p class="stat-note">Registered group</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Total Donations</p>
                <p class="stat-value"><?php echo $totalDonations; ?></p>
                <p class="stat-note stat-note-green">Successful</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Last Donation</p>
                <p class="stat-value stat-value-date"><?php echo htmlspecialchars($lastDonation); ?></p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Eligibility</p>
                <p class="stat-value"><?php echo $eligibility["eligible"] ? "Eligible" : "Not Yet"; ?></p>
                <p class="stat-note">Ready to donate</p>
            </div>
        </section>

        <section class="two-col">
            <div class="panel">
                <h2>My Profile</h2>
                <div class="profile-row">
                    <span class="profile-label">Name</span>
                    <span class="profile-value"><?php echo $fullName; ?></span>
                </div>
                <div class="profile-row">
                    <span class="profile-label">Blood Group</span>
                    <span class="profile-value"><?php echo $bloodGroup; ?></span>
                </div>
                <div class="profile-row">
                    <span class="profile-label">Location</span>
                    <span class="profile-value"><?php echo $location; ?></span>
                </div>
                <div class="profile-row">
                    <span class="profile-label">Phone</span>
                    <span class="profile-value"><?php echo $phone; ?></span>
                </div>
                <a href="UpdateProfile.php" class="btn btn-primary">Update Profile</a>
            </div>

            <div class="panel">
                <h2>Donation Status</h2>
                <div class="availability-banner" id="availabilityBanner">
                    <?php if ($availability === "available") : ?>
                        You are currently marked as available for blood donation.
                    <?php else : ?>
                        You are currently marked as unavailable for blood donation.
                    <?php endif; ?>
                </div>
                <button type="button" class="btn btn-primary" id="toggleAvailabilityBtn"
                        data-available="<?php echo $availability === 'available' ? '1' : '0'; ?>">
                    <?php echo $availability === "available" ? "Mark as Unavailable" : "Mark as Available"; ?>
                </button>

                <h3 class="eligibility-heading">Eligibility</h3>
                <ul class="eligibility-list">
                    <?php foreach ($eligibility["reasons"] as $reason) : ?>
                        <li>&#10003; <?php echo htmlspecialchars($reason); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <section class="panel list-panel">
            <h2>Donation History</h2>
            <?php if (empty($donationHistory)) : ?>
                <p class="empty-state">No donation history yet.</p>
            <?php endif; ?>
            <?php foreach ($donationHistory as $row) : ?>
                <div class="list-row">
                    <div>
                        <p class="list-title"><?php echo date("F d, Y", strtotime($row["donation_date"])); ?></p>
                        <p class="list-subtitle">
                            <?php echo htmlspecialchars($row["hospital_name"]); ?> &middot;
                            <?php echo htmlspecialchars($row["blood_group"]); ?> donation
                        </p>
                    </div>
                    <span class="pill pill-green"><?php echo ucfirst(htmlspecialchars($row["status"])); ?></span>
                </div>
            <?php endforeach; ?>
        </section>

        <section class="panel list-panel" id="requests">
            <h2>Blood Donation Requests</h2>
            <?php if (empty($bloodRequests)) : ?>
                <p class="empty-state">No pending requests right now.</p>
            <?php endif; ?>
            <?php foreach ($bloodRequests as $req) :
                $matches = $req["blood_group"] === $profile["blood_group"];
                $already = $req["my_response"] === "accepted";
            ?>
                <div class="list-row request-row">
                    <div class="request-left">
                        <span class="badge"><?php echo htmlspecialchars($req["blood_group"]); ?></span>
                        <div>
                            <p class="list-title">
                                <?php echo $req["priority"] === "normal"
                                    ? htmlspecialchars($req["hospital_name"]) . " request"
                                    : ucfirst($req["priority"]) . " request near " . htmlspecialchars($req["location"]); ?>
                            </p>
                            <p class="list-subtitle">
                                <?php echo htmlspecialchars($req["location"]); ?> &middot;
                                Patient needs <?php echo htmlspecialchars($req["blood_group"]); ?>
                            </p>
                        </div>
                    </div>

                    <?php if ($already) : ?>
                        <span class="btn btn-accepted" disabled>Accepted &#10003;</span>
                    <?php elseif ($matches) : ?>
                        <button type="button" class="btn btn-accept" data-request-id="<?php echo $req["request_id"]; ?>">
                            Accept
                        </button>
                    <?php else : ?>
                        <button type="button" class="btn btn-view" data-detail="<?php echo htmlspecialchars($req["message"] ?: 'No additional details provided.'); ?>">
                            View
                        </button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
    </main>

    <footer class="page-footer">
        <span class="drop">&#128138;</span> LifeDrop &mdash; Donor Dashboard
    </footer>

    <script src="../JS/dashboard-ajax.js"></script>
</body>
</html>
