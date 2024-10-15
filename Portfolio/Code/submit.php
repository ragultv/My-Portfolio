<?php
header('Content-Type: application/json');

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Handle Preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

// Process POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $name = $_POST['Name'];
    $email = $_POST['email'];
    $message = $_POST['Message'];

    // Example: send email
    $to = 'tragulragul@gmail.com';
    $subject = 'Contact Form Submission';
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    if (mail($to, $subject, $body)) {
        http_response_code(200);
        echo json_encode(array("success" => true));
    } else {
        http_response_code(500);
        echo json_encode(array("success" => false, "message" => "Failed to send message. Please try again."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("success" => false, "message" => "Method Not Allowed"));
}

