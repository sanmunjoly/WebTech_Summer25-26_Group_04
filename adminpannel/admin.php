<?php
session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

$adminName = $_SESSION["admin_name"] ?? "Admin";
$stockFile = __DIR__ . "/data/blood_stock.json";
$requestFile = __DIR__ . "/data/requests.json";
$usersFile = __DIR__ . "/data/users.json";

function readJson($file) {
    if (!file_exists($file)) return [];
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? $data : [];
}

$stock = readJson($stockFile);
$requests = readJson($requestFile);
$users = readJson($usersFile);

$totalUsers = count($users);
$totalDonors = count(array_filter($users, fn($u) => ($u["role"] ?? "") === "Donor"));
$pendingRequests = count(array_filter($requests, fn($r) => ($r["status"] ?? "") === "Pending"));
$totalUnits = array_sum(array_column($stock, "units"));

setcookie("bloodbridge_admin", "logged_in", time() + 86400, "/");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodBridge - Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<aside class="sidebar">
    <div class="brand">
        <div class="logo">🩶</div>
        <div>
            <h2>BloodBridge</h2>
            <span>Admin Panel</span>
        </div>
    </div>

    <nav>
        <button class="nav-item active" data-section="dashboard"><span>Dashboard</span></button>
        <button class="nav-item" data-section="users">👳 <span>Users</span></button>
        <button class="nav-item" data-section="donors">🩶 <span>Donors</span></button>
        <button class="nav-item" data-section="requests">👤 <span>Blood Requests</span></button>
        <button class="nav-item" data-section="stock"> <span>Blood Stock</span></button>
        <button class="nav-item" data-section="reports"><span>Reports</span></button>
    </nav>

    <a class="logout" href="logout.php" onclick="return confirm('Are you sure you want to logout?')">
         <span>Logout</span>
    </a>
</aside>

<main class="main">
<header class="topbar">
    <div>
        <h1 id="pageTitle">Dashboard</h1>
        <p>Blood Donation Management System</p>
    </div>
    <div class="admin-user">
        <div class="avatar">A</div>
        <div><strong><?= htmlspecialchars($adminName) ?></strong><small>Administrator</small></div>
    </div>
</header>

<section id="dashboard" class="page-section active-section">
    <div class="welcome">
        <div><h2>Welcome, <?= htmlspecialchars($adminName) ?>!</h2><p>Here is the overview of the BloodBridge system.</p></div>
        <span class="date" id="today"></span>
    </div>

    <div class="cards">
        <div class="card"><div class="card-icon users">👳</div><div><span>Total Users</span><h3><?= $totalUsers ?></h3></div></div>
        <div class="card"><div class="card-icon donors">🩶</div><div><span>Total Donors</span><h3><?= $totalDonors ?></h3></div></div>
        <div class="card"><div class="card-icon requests">👤</div><div><span>Pending Requests</span><h3><?= $pendingRequests ?></h3></div></div>
        <div class="card"><div class="card-icon stock"></div><div><span>Blood Units</span><h3><?= $totalUnits ?></h3></div></div>
    </div>

    <div class="grid-2">
        <div class="panel">
            <div class="panel-head"><h3>Blood Stock Overview</h3><button onclick="showSection('stock')">View Stock</button></div>
            <table><thead><tr><th>Blood Group</th><th>Units</th><th>Status</th></tr></thead>
            <tbody>
            <?php foreach ($stock as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item["group"]) ?></td>
                    <td><?= (int)$item["units"] ?></td>
                    <td><span class="badge <?= $item["units"] <= 15 ? "pending" : "approved" ?>"><?= htmlspecialchars($item["status"]) ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody></table>
        </div>

        <div class="panel">
            <div class="panel-head"><h3>Recent Blood Requests</h3><button onclick="showSection('requests')">View All</button></div>
            <table><thead><tr><th>Request</th><th>Blood</th><th>Status</th></tr></thead>
            <tbody>
            <?php foreach (array_slice($requests, 0, 5) as $request): ?>
                <tr>
                    <td><?= htmlspecialchars($request["id"]) ?></td>
                    <td><?= htmlspecialchars($request["blood_group"]) ?> / <?= (int)$request["units"] ?> Unit(s)</td>
                    <td><span class="badge <?= strtolower($request["status"]) ?>"><?= htmlspecialchars($request["status"]) ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody></table>
        </div>
    </div>
</section>

<section id="users" class="page-section">
    <div class="section-head"><div><h2>Manage Users</h2><p>Manage donor and recipient accounts.</p></div></div>
    <div class="panel">
        <table><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th></tr></thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user["id"]) ?></td>
                <td><?= htmlspecialchars($user["name"]) ?></td>
                <td><?= htmlspecialchars($user["email"]) ?></td>
                <td><?= htmlspecialchars($user["role"]) ?></td>
                <td><span class="badge approved"><?= htmlspecialchars($user["status"]) ?></span></td>
            </tr>
        <?php endforeach; ?>
        </tbody></table>
    </div>
</section>

<section id="donors" class="page-section">
    <div class="section-head"><div><h2>Donor Management</h2><p>View donor information and availability.</p></div></div>
    <div class="panel">
        <table><thead><tr><th>Name</th><th>Blood Group</th><th>Location</th><th>Availability</th></tr></thead>
        <tbody>
        <?php foreach ($users as $user): if (($user["role"] ?? "") === "Donor"): ?>
            <tr>
                <td><?= htmlspecialchars($user["name"]) ?></td>
                <td><?= htmlspecialchars($user["blood_group"]) ?></td>
                <td><?= htmlspecialchars($user["location"]) ?></td>
                <td><span class="badge <?= $user["available"] ? "approved" : "pending" ?>"><?= $user["available"] ? "Available" : "Unavailable" ?></span></td>
            </tr>
        <?php endif; endforeach; ?>
        </tbody></table>
    </div>
</section>

<section id="requests" class="page-section">
    <div class="section-head"><div><h2>Blood Requests</h2><p>Review, approve, reject and monitor blood requests.</p></div></div>
    <div class="panel">
        <table><thead><tr><th>Request ID</th><th>Patient</th><th>Blood</th><th>Units</th><th>Location</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($requests as $request): ?>
            <tr>
                <td><?= htmlspecialchars($request["id"]) ?></td>
                <td><?= htmlspecialchars($request["patient"]) ?></td>
                <td><?= htmlspecialchars($request["blood_group"]) ?></td>
                <td><?= (int)$request["units"] ?></td>
                <td><?= htmlspecialchars($request["location"]) ?></td>
                <td class="request-status"><span class="badge <?= strtolower($request["status"]) ?>"><?= htmlspecialchars($request["status"]) ?></span></td>
                <td>
                    <?php if ($request["status"] === "Pending"): ?>
                        <button class="approve" onclick="updateRequest('<?= htmlspecialchars($request["id"]) ?>','Approved',this)">Approve</button>
                        <button class="reject" onclick="updateRequest('<?= htmlspecialchars($request["id"]) ?>','Rejected',this)">Reject</button>
                    <?php else: ?><button class="small">View</button><?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody></table>
    </div>
</section>

<section id="stock" class="page-section">
    <div class="section-head"><div><h2>Blood Stock</h2><p>Blood groups, available units and stock status.</p></div></div>
    <div class="stock-grid">
    <?php foreach ($stock as $item): ?>
        <div class="stock-card">
            <h3><?= htmlspecialchars($item["group"]) ?></h3>
            <div class="units"><?= (int)$item["units"] ?></div>
            <p>Available units</p>
            <span class="badge <?= $item["units"] <= 15 ? "pending" : "approved" ?>"><?= htmlspecialchars($item["status"]) ?></span>
        </div>
    <?php endforeach; ?>
    </div>
</section>

<section id="reports" class="page-section">
    <div class="section-head"><div><h2>Reports</h2><p>Basic system reports and overall dashboard statistics.</p></div><button class="primary" onclick="window.print()">Print Report</button></div>
    <div class="report-cards">
        <div class="report"><h3>Total Users</h3><strong><?= $totalUsers ?></strong><p>Registered users</p></div>
        <div class="report"><h3>Total Donors</h3><strong><?= $totalDonors ?></strong><p>Registered donors</p></div>
        <div class="report"><h3>Pending Requests</h3><strong><?= $pendingRequests ?></strong><p>Requests waiting for action</p></div>
        <div class="report"><h3>Blood Units</h3><strong><?= $totalUnits ?></strong><p>Total available units</p></div>
    </div>
</section>
</main>
<script src="admin.js"></script>
</body>
</html>
