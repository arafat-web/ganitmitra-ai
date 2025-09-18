<?php
// Prevent any HTML error output from interfering with JSON
error_reporting(0);
ini_set('display_errors', 0);

// Set proper headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// Capture any unwanted output
ob_start();

try {
    require '../ml_solver.php';

    // Clear any output buffer from includes
    ob_clean();

    if (isset($_POST['problem']) && !empty($_POST['problem'])) {
        $problem = trim($_POST['problem']);
        $result = solveWithML($problem);
        
        // Ensure proper UTF-8 encoding
        if ($result['success']) {
            $response = [
                'success' => true,
                'problem' => $problem,
                'answer' => $result['answer'],
                'bengali_answer' => $result['bengali_answer'],
                'steps' => $result['steps'],
                'method' => $result['method'],
                'accuracy' => $result['accuracy']
            ];
        } else {
            $response = [
                'success' => false,
                'error' => $result['error']
            ];
        }
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'গাণিতিক সমস্যা প্রদান করুন'
        ], JSON_UNESCAPED_UNICODE);
    }
} catch (Exception $e) {
    // Clear output buffer
    ob_clean();
    
    echo json_encode([
        'success' => false,
        'error' => 'সার্ভার ত্রুটি: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

// End output buffering
ob_end_flush();
