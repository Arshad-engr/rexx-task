#  PHP 7 Event Booking System by rexx

This is a lightweight event booking system built with PHP 7 and MySQL (or MariaDB). It allows you to:

- Import event booking data from a JSON file
- View bookings with filter/search
- Calculate total participation fees
- Auto-create the schema on first run

---

## 📂 Project Structure
/rexx-task/
│
├── index.php # Main entry point (routing logic)
├── dbconnection.php # Database connection
├── schema.php # Auto-create DB tables i.e users,events and bookings
├── Controllers/
   ├── BookingController.php # Core logic. Backend fuctionality (importing, filtering, rendering)
├── views/
   ├── booking-view.php # HTML table for showing imported/fitlered records and form UI for importing json file and search record

