# HealthMonitor — combined login + dashboard (no ESP32 required)

This merges your login/register system (PHP + MySQL) with the dashboard,
health-data, and profile pages. Instead of fetching from an ESP32 IP address,
all pages read from a `health_data` table in the database.

## 1. Requirements
- PHP 8+ with the `pdo_mysql` extension (XAMPP / MAMP / WAMP all work)
- MySQL / MariaDB

## 2. Setup
1. Copy the whole `health-monitor` folder into your server's web root
   (e.g. `htdocs/health-monitor` for XAMPP).
2. Import the schema:
   ```
   mysql -u root -p < schema.sql
   ```
   (adjust user/password to match your MySQL setup)
3. Open `config.php` and confirm `$DB_HOST`, `$DB_NAME`, `$DB_USER`,
   `$DB_PASS` match your MySQL setup (defaults: root / no password,
   database `health_monitor` — matching what schema.sql creates).
4. Start Apache + MySQL, then visit:
   ```
   http://localhost/health-monitor/home.php
   ```

## 3. Try it out
1. Click **Sign Up**, create an account. You're logged in automatically
   and sent to the dashboard.
2. The dashboard will say "No readings yet" — click
   **Generate demo data** to insert 30 days of sample BPM/SpO2 readings
   for your account (this replaces the ESP32 feed).
3. Visit **Health Data** to see the full table + chart, filterable by date.
4. Visit **Profile** to fill in your name, phone, age, height, weight.

## 4. Bringing in your own data instead of the demo generator
Insert directly into `health_data`:
```sql
INSERT INTO health_data (user_id, recorded_at, bpm, spo2)
VALUES (1, '2025-01-15 08:30:00', 72, 98);
```
Or write a small PHP/CSV import script using the same
`INSERT INTO health_data (...)` prepared statement shown in
`api/seed_data.php` — swap the random values for rows read from your CSV.

## 5. File map
- `config.php` — DB connection
- `schema.sql` — users + health_data tables
- `register.php` / `login.php` / `logout.php` / `forgotpwd.php` — auth
- `home.php` / `contact.php` — public pages
- `dashboard.php`, `healthdata.php`, `profile.php` — protected pages
  (guarded by `includes/auth_check.php`)
- `api/get_health_data.php` — JSON endpoint the dashboard/health-data
  JS calls instead of `fetch('http://<esp32-ip>/data')`
- `api/seed_data.php` — inserts 30 days of demo readings for the
  logged-in user
- `assets/css/style.css`, `assets/js/*.js` — combined styling and charting

## 6. Notes on what changed from your original files
- Passwords now use `password_hash()`/`password_verify()` instead of `md5()`.
- All SQL uses PDO prepared statements instead of `mysqli_real_escape_string`
  string concatenation.
- Every protected page starts with `includes/auth_check.php`, so visiting
  `dashboard.php`, `healthdata.php`, or `profile.php` without logging in
  redirects to `login.php` (like `index.php` did, but reusable everywhere).
- `main.html`, `home.html`, and `healthdata.js`'s ESP32 `fetch()` calls are
  replaced by `fetch('api/get_health_data.php')`, which reads from MySQL.
