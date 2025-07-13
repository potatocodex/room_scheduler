<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database file path
$dbFile = 'schedule_data.json';

// Initialize database file if it doesn't exist - START WITH EMPTY DATA
if (!file_exists($dbFile)) {
    $initialData = [];  // Empty object - no sample data
    file_put_contents($dbFile, json_encode($initialData, JSON_PRETTY_PRINT));
}

// Helper function to format date
function formatDate($date) {
    return date('Y-m-d', is_string($date) ? strtotime($date) : $date);
}

// Helper function to read database
function readDatabase() {
    global $dbFile;
    if (!file_exists($dbFile)) {
        return [];
    }
    $data = file_get_contents($dbFile);
    return json_decode($data, true) ?: [];
}

// Helper function to write database
function writeDatabase($data) {
    global $dbFile;
    return file_put_contents($dbFile, json_encode($data, JSON_PRETTY_PRINT));
}

// Helper function to send JSON response
function sendResponse($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data);
    exit();
}

// Get request method and path
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'];
$input = json_decode(file_get_contents('php://input'), true);

// Route handling
switch ($method) {
    case 'GET':
        // Get all schedule data or specific date
        $scheduleData = readDatabase();
        
        if (isset($_GET['date'])) {
            $date = $_GET['date'];
            $events = isset($scheduleData[$date]) ? $scheduleData[$date] : [];
            sendResponse(['date' => $date, 'events' => $events]);
        } else {
            sendResponse($scheduleData);
        }
        break;
        
    case 'POST':
        // Add or update events for a specific date
        if (!isset($input['date']) || !isset($input['events'])) {
            sendResponse(['error' => 'Date and events are required'], 400);
        }
        
        $date = $input['date'];
        $events = $input['events'];
        
        $scheduleData = readDatabase();
        $scheduleData[$date] = $events;
        
        if (writeDatabase($scheduleData)) {
            sendResponse(['success' => true, 'message' => 'Schedule updated successfully']);
        } else {
            sendResponse(['error' => 'Failed to save data'], 500);
        }
        break;
        
    case 'DELETE':
        // Delete events for a specific date
        if (!isset($_GET['date'])) {
            sendResponse(['error' => 'Date is required'], 400);
        }
        
        $date = $_GET['date'];
        $scheduleData = readDatabase();
        
        if (isset($scheduleData[$date])) {
            unset($scheduleData[$date]);
            if (writeDatabase($scheduleData)) {
                sendResponse(['success' => true, 'message' => 'Schedule deleted successfully']);
            } else {
                sendResponse(['error' => 'Failed to delete data'], 500);
            }
        } else {
            sendResponse(['error' => 'Date not found'], 404);
        }
        break;
        
    default:
        sendResponse(['error' => 'Method not allowed'], 405);
        break;
}
?>
