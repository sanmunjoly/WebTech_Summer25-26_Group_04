# LifeDrop - Donor Dashboard

Built on top of the `bloodbridge_db` schema you provided. Only the **Donor**
role is implemented (Admin/Recipient show a "coming soon" stub after login).

## Folder format

```
LifeDrop/
├── Controller/   -> validation + session logic (login, logout, dashboard guard,
│                    update profile, and the two AJAX endpoints)
├── Model/        -> db.php (connection) + DonorModel.php (every SQL query,
│                    all via prepared statements)
├── View/         -> the actual PHP/HTML pages, each includes its Controller
│                    file at the top before rendering
├── Design/       -> plain CSS (no Bootstrap) for the login page and dashboard
├── JS/           -> client-side form validation + AJAX (vanilla XMLHttpRequest,
│                    no fetch wrapper libraries, no third-party API)
└── Database/
    ├── bloodbridge_database.sql   -> your schema, unmodified
    └── seed_demo_data.php         -> run once in the browser to create a
                                       working demo login + sample rows
```

## Setup on XAMPP

1. Copy the `LifeDrop` folder into `htdocs`.
2. Start Apache + MySQL in XAMPP.
3. In phpMyAdmin, import `Database/bloodbridge_database.sql` (creates
   `bloodbridge_db` and all 8 tables, plus the admin row and empty blood
   stock rows from your original file).
4. Visit `http://localhost/LifeDrop/Database/seed_demo_data.php` once in
   your browser. This hashes the admin password properly and creates a
   demo donor account plus sample donation history / blood requests so
   the dashboard has something to show.
5. Visit `http://localhost/LifeDrop/View/login.php` and log in as:
   - **Login As:** Donor
   - **Email:** donor@gmail.com
   - **Password:** donor123

## What's wired up to the database (not hardcoded)

- Login checks `users` by email + role, verifies the bcrypt password hash.
- Dashboard stat cards, "My Profile", and the eligibility check all read
  from `users` + `donor_profile` for the logged-in donor.
- "Donation History" reads from `donation_history`.
- "Blood Donation Requests" reads pending rows from `blood_requests`,
  left-joined against `donor_requests` to know if this donor already
  responded.
- **Mark as Available/Unavailable** button -> AJAX call to
  `Controller/ToggleAvailabilityController.php` -> flips
  `donor_profile.availability` in the DB, no page reload.
- **Accept** button on a matching-blood-group request -> AJAX call to
  `Controller/AcceptRequestController.php` -> re-validates the request
  server-side and writes a row into `donor_requests`, then swaps the
  button for "Accepted ✓" without a page reload.
- **Update Profile** -> real form, validated in
  `Controller/UpdateProfileController.php`, saves phone/address/blood
  group back to `users`.

## Known simplifications (worth knowing about)

- "Accept" vs "View" is decided by an exact blood-group match between the
  request and the donor's own blood group. Real blood-type compatibility
  (e.g. O- as a universal donor) isn't modeled - flag this if your
  assignment needs it.
- The eligibility rule is a simple "90+ days since last donation" check,
  since no other rule was specified in the schema or video.
