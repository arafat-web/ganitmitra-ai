<?php
require 'vendor/autoload.php';
use League\Csv\Reader;

$csv = Reader::createFromPath('dataset.csv', 'r');
$csv->setHeaderOffset(0);

echo "Searching for 'দিল' patterns in dataset:\n";
echo str_repeat("=", 50) . "\n";

$count = 0;
$giveAwayCount = 0;
$receiveCount = 0;

foreach ($csv as $row) {
    if (strpos($row['text'], 'দিল') !== false) {
        $count++;
        
        // Check if it's giving away (subtract) or receiving (add)
        if (preg_match('/(বন্ধুকে|কাউকে|কে).*দিল/u', $row['text'])) {
            $giveAwayCount++;
            echo "GIVE AWAY: " . $row['text'] . " -> " . $row['answer'] . "\n";
        } else {
            $receiveCount++;
            echo "RECEIVE: " . $row['text'] . " -> " . $row['answer'] . "\n";
        }
    }
}

echo "\nSummary:\n";
echo "Total 'দিল' problems: $count\n";
echo "Give away (subtract): $giveAwayCount\n";  
echo "Receive (add): $receiveCount\n";