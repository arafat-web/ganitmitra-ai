<?php
header('Content-Type: application/json; charset=utf-8');
$count = isset($_GET['n']) ? (int) $_GET['n'] : 3;
if ($count < 1) {
    $count = 3;
}

$file = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'dataset.csv';
if (! file_exists($file)) {
    echo json_encode(['success' => false, 'error' => 'dataset not found']);
    exit;
}
$rows = array_map('str_getcsv', file($file));
if (count($rows) <= 1) {
    echo json_encode(['success' => false, 'error' => 'dataset empty']);
    exit;
}
array_shift($rows);
$texts = array_values(array_filter(array_map(function ($r) {return isset($r[0]) ? trim($r[0]) : '';}, $rows)));
if (empty($texts)) {
    echo json_encode(['success' => false, 'error' => 'no texts in dataset']);
    exit;
}
shuffle($texts);
$pick = array_slice($texts, 0, min($count, count($texts)));
echo json_encode(['success' => true, 'problems' => array_values($pick)]);
