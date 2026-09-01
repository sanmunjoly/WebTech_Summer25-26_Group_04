<?php


class DonorModel
{
    
    function verifyLogin($connection, $email, $password, $role)
    {
        $sql = "SELECT * FROM users WHERE email = ? AND role = ? LIMIT 1";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if (!$user) {
            return null;
        }
        if ($user["account_status"] !== "active") {
            return null;
        }
        if (!password_verify($password, $user["password"])) {
            return null;
        }
        return $user;
    }

    function getUserById($connection, $user_id)
    {
        $sql = "SELECT * FROM users WHERE user_id = ? LIMIT 1";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user;
    }

   
    function getDonorProfile($connection, $user_id)
    {
        $sql = "SELECT u.user_id, u.full_name, u.email, u.phone, u.address, u.blood_group,
                       d.donor_id, d.age, d.last_donation_date, d.availability, d.total_donation
                FROM users u
                INNER JOIN donor_profile d ON d.user_id = u.user_id
                WHERE u.user_id = ?
                LIMIT 1";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $profile = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $profile;
    }

    function getDonationHistory($connection, $donor_id, $limit = 10)
    {
        $sql = "SELECT donation_id, blood_group, donation_date, hospital_name, location, status
                FROM donation_history
                WHERE donor_id = ?
                ORDER BY donation_date DESC
                LIMIT ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ii", $donor_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();
        return $rows;
    }

    
    function getBloodRequests($connection, $donor_id, $limit = 10)
    {
        $sql = "SELECT br.request_id, br.blood_group, br.hospital_name, br.location,
                       br.priority, br.status, br.message, br.created_at,
                       dr.response AS my_response
                FROM blood_requests br
                LEFT JOIN donor_requests dr
                       ON dr.request_id = br.request_id AND dr.donor_id = ?
                WHERE br.status = 'pending'
                ORDER BY FIELD(br.priority,'emergency','urgent','normal'), br.created_at DESC
                LIMIT ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ii", $donor_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();
        return $rows;
    }

   
    function toggleAvailability($connection, $donor_id)
    {
        $sql = "UPDATE donor_profile
                SET availability = IF(availability = 'available', 'unavailable', 'available')
                WHERE donor_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $donor_id);
        $stmt->execute();
        $stmt->close();

        $sql2 = "SELECT availability FROM donor_profile WHERE donor_id = ?";
        $stmt2 = $connection->prepare($sql2);
        $stmt2->bind_param("i", $donor_id);
        $stmt2->execute();
        $row = $stmt2->get_result()->fetch_assoc();
        $stmt2->close();
        return $row ? $row["availability"] : null;
    }

   
    function respondToRequest($connection, $request_id, $donor_id, $response)
    {
        $check = $connection->prepare(
            "SELECT request_id, blood_group FROM blood_requests WHERE request_id = ? AND status = 'pending' LIMIT 1"
        );
        $check->bind_param("i", $request_id);
        $check->execute();
        $requestRow = $check->get_result()->fetch_assoc();
        $check->close();

        if (!$requestRow) {
            return ["success" => false, "message" => "This request is no longer available."];
        }

        $existing = $connection->prepare(
            "SELECT id FROM donor_requests WHERE request_id = ? AND donor_id = ? LIMIT 1"
        );
        $existing->bind_param("ii", $request_id, $donor_id);
        $existing->execute();
        $existingRow = $existing->get_result()->fetch_assoc();
        $existing->close();

        if ($existingRow) {
            $update = $connection->prepare(
                "UPDATE donor_requests SET response = ?, response_date = NOW() WHERE id = ?"
            );
            $update->bind_param("si", $response, $existingRow["id"]);
            $update->execute();
            $update->close();
        } else {
            $insert = $connection->prepare(
                "INSERT INTO donor_requests (request_id, donor_id, response) VALUES (?, ?, ?)"
            );
            $insert->bind_param("iis", $request_id, $donor_id, $response);
            $insert->execute();
            $insert->close();
        }

        return ["success" => true, "message" => "Response recorded."];
    }

    function updateDonorProfile($connection, $user_id, $phone, $address, $blood_group)
    {
        $sql = "UPDATE users SET phone = ?, address = ?, blood_group = ? WHERE user_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssi", $phone, $address, $blood_group, $user_id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

  
    function calculateEligibility($last_donation_date)
    {
        $reasons = [];

        if (empty($last_donation_date)) {
            $eligible = true;
            $reasons[] = "No previous donation on record.";
        } else {
            $last = new DateTime($last_donation_date);
            $today = new DateTime();
            $daysSince = (int) $today->diff($last)->days;

            if ($daysSince >= 90) {
                $eligible = true;
                $reasons[] = "Last donation was more than 3 months ago.";
            } else {
                $eligible = false;
                $daysLeft = 90 - $daysSince;
                $reasons[] = "Last donation was $daysSince day(s) ago. Eligible again in $daysLeft day(s).";
            }
        }

        $reasons[] = $eligible ? "Current status: Eligible." : "Current status: Not eligible yet.";

        return ["eligible" => $eligible, "reasons" => $reasons];
    }
}
