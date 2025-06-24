<?php
require_once './Controllers/BookingController.php';

require_once 'schema.php';

// Setup DB schema once on first run
createSchemaIfNotExists(getPDO());

$booking = new BookingController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['import'])) {
    if (isset($_FILES['json_file']) && $_FILES['json_file']['error'] === UPLOAD_ERR_OK) {
        $tmpPath = $_FILES['json_file']['tmp_name'];
        // Optional: validate file type
        $fileType = mime_content_type($tmpPath);
        if ($fileType !== 'application/json' && pathinfo($_FILES['json_file']['name'], PATHINFO_EXTENSION) !== 'json') {
            die("Invalid file type. Please upload a valid JSON file.");
        }
        $booking->importFromJson($tmpPath);
        exit;
    } else {
        die(" Error uploading file.");
    }
}else{
    $filters = [
        'search_keyword' => $_GET['search_keyword'] ?? ''
    ];
    $bookings = $booking->getFilteredBookings($filters);
    // Provide $filters and $bookings to view
    include 'views/booking-view.php';
}
