# BloodBridge Admin Panel

## Run with XAMPP
1. Copy the `BloodBridge_Admin_Complete` folder into `C:\xampp\htdocs\`.
2. Start Apache in XAMPP.
3. Open: `http://localhost/BloodBridge_Admin_Complete/login.php`
4. Demo login:
   - Email: `admin@bloodbridge.com`
   - Password: `admin123`

## Technologies
PHP, HTML, CSS, JavaScript, Session, Cookie, JSON and AJAX.

The dashboard reads users, blood requests and blood stock from the JSON files in `data/`.
Approve/Reject on Blood Requests uses AJAX and updates `requests.json`.
