<?php
require_once './dbconnection.php';

class BookingController {
    private $pdo;

    public function __construct() {
        $this->pdo = getPDO();
    }

    public function importFromJson($filePath) {
        $data = json_decode(file_get_contents($filePath), true);
       
        foreach ($data as $entry) {
            $userId = $this->getOrCreateUser($entry['employee_name'], $entry['employee_mail']);
            $eventId = $this->getOrCreateEvent($entry['event_name'], $entry['event_date']);
            $this->insertBooking($userId, $eventId, $entry['participation_fee']);
        }
        header("Location: index.php");
        exit;
      
    }

    /* 
     * First import employees/Users from json file
    */
    private function getOrCreateUser($name, $email) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $id = $stmt->fetchColumn();
        if (!$id) {
            $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            $stmt->execute([$name, $email]);
            return $this->pdo->lastInsertId();
        }
        return $id;
    }
    
    /* 
     * secondly ,create event by extracting event name and event date from json file
    */
    private function getOrCreateEvent($name, $date) {
        $stmt = $this->pdo->prepare("SELECT id FROM events WHERE name = ? AND event_date = ?");
        $stmt->execute([$name, $date]);
        $id = $stmt->fetchColumn();
        if (!$id) {
            $stmt = $this->pdo->prepare("INSERT INTO events (name, event_date) VALUES (?, ?)");
            $stmt->execute([$name, $date]);
            return $this->pdo->lastInsertId();
        }
        return $id;
    }

    /* 
     * Lastly create booking by linking employee_id i.e participant_id and event_id in bookings table
    */
    private function insertBooking($userId, $eventId, $fee) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM bookings WHERE participation_id = ? AND event_id = ?");
        $stmt->execute([$userId, $eventId]);
        if (!$stmt->fetchColumn()) {
            $stmt = $this->pdo->prepare("INSERT INTO bookings (participation_id, event_id, participation_fee) VALUES (?, ?, ?)");
            $stmt->execute([$userId, $eventId, $fee]);
        }
    }

    /* 
     * filter view for employee name, event name, and event date
    */
    public function getFilteredBookings($filters = []) {
        $sql = "
            SELECT 
                b.id,
                u.name AS employee_name,
                u.email,
                e.name AS event_name,
                e.event_date,
                b.participation_fee
            FROM bookings b
            JOIN users u ON b.participation_id = u.id
            JOIN events e ON b.event_id = e.id
            WHERE 1=1
        ";
        $params = [];

        if (!empty($filters['search_keyword'])) {
            $sql .= " AND (
                u.name LIKE ?
                OR e.name LIKE ?
                OR e.event_date LIKE ?
            )";
    
            $like = '%' . $filters['search_keyword'] . '%';
            $params = [$like, $like, $like];
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
