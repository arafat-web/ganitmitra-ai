<?php
require 'vendor/autoload.php';
use League\Csv\Reader;

$csv = Reader::createFromPath('dataset_new.csv', 'r');
$csv->setHeaderOffset(0);

echo "Searching for patterns in dataset:\n";
echo str_repeat("=", 35) . "\n";

$count     = 0;
$add       = 0;
$subtract  = 0;
$multiply  = 0;
$divide    = 0;
$multiStep = 0;
$noLabel   = 0;

foreach ($csv as $row) {

    if (strpos($row['label'], 'add') !== false) {
        $add++;
    }
    if (strpos($row['label'], 'subtract') !== false) {
        $subtract++;
    } elseif (strpos($row['label'], 'multiply') !== false) {
        $multiply++;
    } elseif (strpos($row['label'], 'divide') !== false) {
        $divide++;
    }
    if (
        strpos($row['label'], 'add') === false &&
        strpos($row['label'], 'subtract') === false &&
        strpos($row['label'], 'multiply') === false &&
        strpos($row['label'], 'divide') === false
    ) {
        $multiStep++;

    }
    if (empty($row['label']) || $row['label'] === 'label') {
        $noLabel++;
    }
    if (strpos($row['label'], 'add') !== false || strpos($row['label'], 'subtract') !== false || strpos($row['label'], 'multiply') !== false || strpos($row['label'], 'divide') !== false || strpos($row['label'], 'multi_step') !== false) {
        $count++;
    }

}

echo "\nSummary:\n";
echo "Total problems: $count\n";
echo "Total 'add' problems: $add\n";
echo "Total 'subtract' problems: $subtract\n";
echo "Total 'multiply' problems: $multiply\n";
echo "Total 'divide' problems: $divide\n";
echo "Total 'multi_step' problems: $multiStep\n";
echo "Problems with no valid label: $noLabel\n";
