#  PHP 7 Event Booking System by rexx

This is a lightweight event booking system built with PHP 7 and MySQL (or MariaDB). It allows you to:

- Import event booking data from a JSON file
- View bookings with filter/search
- Calculate total participation fees
- Auto-create the schema on first run

---

## 📂 Project Structure

### 📄 index.php
 Main entry point (routing logic)

### 📄 dbconnection.php
 Database connection setup

### 📄 schema.php
 Schema of tables that shoud created at once

### 📁 Controllers/
 Contains controller classes

#### 📄 BookingController.php
 Handles importing, filtering, and rendering of view

### 📁 views/
 Contains UI of filtering record and importing json file

#### 📄 booking-view.php
 HTML table and form for booking display and search

