<?php

include "../Model/db.php";

$database = new db();
$connection = $database->connection();

function userExists($connection, $email)
{
    $stmt = $connection->prepare("SELECT user_id FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $row ? $row["user_id"] : null;
}


$adminHash = password_hash("admin123", PASSWORD_DEFAULT);
$stmt = $connection->prepare("UPDATE users SET password = ? WHERE email = 'admin@gmail.com'");
$stmt->bind_param("s", $adminHash);
$stmt->execute();
$stmt->close();

$donorId = userExists($connection, "donor@gmail.com");

if (!$donorId) {
    $hash = password_hash("donor123", PASSWORD_DEFAULT);
    $stmt = $connection->prepare(
        "INSERT INTO users (full_name, email, password, phone, address, blood_group, gender, role, account_status)
         VALUES (?, 'donor@gmail.com', ?, '01700000000', 'Dhaka', 'B+', 'male', 'donor', 'active')"
    );
    $fullName = "Liyan Ahmed";
    $stmt->bind_param("ss", $fullName, $hash);
    $stmt->execute();
    $donorId = $stmt->insert_id;
    $stmt->close();

    $stmt = $connection->prepare(
        "INSERT INTO donor_profile (user_id, age, last_donation_date, availability, total_donation)
         VALUES (?, 24, DATE_SUB(CURDATE(), INTERVAL 4 MONTH), 'available', 4)"
    );
    $stmt->bind_param("i", $donorId);
    $stmt->execute();
    $donorProfileId = $stmt->insert_id;
    $stmt->close();

    $recHash = password_hash("recipient123", PASSWORD_DEFAULT);
    $stmt = $connection->prepare(
        "INSERT INTO users (full_name, email, password, phone, address, blood_group, gender, role, account_status)
         VALUES ('Sample Recipient', 'recipient@gmail.com', ?, '01800000000', 'Gazipur', 'B+', 'female', 'recipient', 'active')"
    );
    $stmt->bind_param("s", $recHash);
    $stmt->execute();
    $recipientUserId = $stmt->insert_id;
    $stmt->close();

    $stmt = $connection->prepare(
        "INSERT INTO recipient_profile (user_id, patient_age, disease_info, emergency_contact)
         VALUES (?, 40, 'Demo record', '01800000000')"
    );
    $stmt->bind_param("i", $recipientUserId);
    $stmt->execute();
    $recipientProfileId = $stmt->insert_id;
    $stmt->close();

    $history = [
        ["days_ago" => 82, "hospital" => "City Hospital", "location" => "Dhaka"],
        ["days_ago" => 180, "hospital" => "Red Crescent", "location" => "Dhaka"],
        ["days_ago" => 260, "hospital" => "General Hospital", "location" => "Dhaka"],
    ];
    foreach ($history as $h) {
        $stmt = $connection->prepare(
            "INSERT INTO donation_history (donor_id, recipient_id, blood_group, donation_date, hospital_name, location, status)
             VALUES (?, ?, 'B+', DATE_SUB(CURDATE(), INTERVAL ? DAY), ?, ?, 'completed')"
        );
        $stmt->bind_param("iiiss", $donorProfileId, $recipientProfileId, $h["days_ago"], $h["hospital"], $h["location"]);
        $stmt->execute();
        $stmt->close();
    }

    $stmt = $connection->prepare(
        "INSERT INTO blood_requests (recipient_id, blood_group, required_units, hospital_name, location, request_date, priority, message, status)
         VALUES (?, 'B+', 2, 'City Hospital', 'Dhaka', CURDATE(), 'urgent', 'Urgent need for surgery patient.', 'pending')"
    );
    $stmt->bind_param("i", $recipientProfileId);
    $stmt->execute();
    $stmt->close();

    $stmt = $connection->prepare(
        "INSERT INTO blood_requests (recipient_id, blood_group, required_units, hospital_name, location, request_date, priority, message, status)
         VALUES (?, 'O+', 1, 'General Hospital', 'Gazipur', CURDATE(), 'normal', 'Scheduled procedure, O+ needed.', 'pending')"
    );
    $stmt->bind_param("i", $recipientProfileId);
    $stmt->execute();
    $stmt->close();

    echo "Demo data created. Login with donor@gmail.com / donor123";
} else {
    echo "Demo donor already exists - nothing to do.";
}
