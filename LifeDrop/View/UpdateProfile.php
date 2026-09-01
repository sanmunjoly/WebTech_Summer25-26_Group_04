<?php
include "../Controller/UpdateProfileController.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LifeDrop | Update Profile</title>
    <link rel="stylesheet" href="../Design/login.css">
</head>
<body>
    <div class="login-card">
        <div class="login-brand">
            <span class="drop">&#128138;</span>
            <span class="brand-name">LifeDrop</span>
        </div>
        <h1 class="login-title">Update Profile</h1>
        <p class="login-subtitle">Keep your donor details current.</p>

        <?php if (!empty($message)) : ?>
            <div class="login-message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="post" action="" id="profileForm">
            <label for="blood_group">Blood Group</label>
            <select id="blood_group" name="blood_group">
                <?php foreach (["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"] as $bg) : ?>
                    <option value="<?php echo $bg; ?>" <?php echo $profile["blood_group"] === $bg ? "selected" : ""; ?>>
                        <?php echo $bg; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="address">Location</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($profile["address"] ?? ""); ?>">

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($profile["phone"] ?? ""); ?>">

            <button type="submit" class="login-btn">Save Changes</button>
            <p class="login-hint"><a href="DonorDashboard.php">Back to dashboard</a></p>
        </form>
    </div>
</body>
</html>
