<?php
require_once 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Transformers\WordCountVectorizer;
use Rubix\ML\Transformers\TfIdfTransformer;
use Rubix\ML\Pipeline;
use Rubix\ML\Classifiers\RandomForest;

echo "Bengali Math ML Model Trainer\n";
echo "================================\n\n";

echo "Loading dataset.csv...\n";
$data = array_map('str_getcsv', file('dataset_new.csv'));
array_shift($data); // remove header

$cleanData = array_filter($data, function($row) {
    return count($row) == 3 && !empty($row[0]) && !empty($row[1]) && $row[1] !== 'label';
});

$samples = [];
$labels = [];

echo "Loaded " . count($cleanData) . " problems\n";

foreach ($cleanData as $row) {
    $text = $row[0];
    $operation = $row[1];
    $samples[] = $text;
    $labels[] = $operation;
}

echo "Operations found: " . implode(', ', array_unique($labels)) . "\n\n";

// Build text classification pipeline:
// - WordCountVectorizer(1000, 2): top 1000 features using up to 2-grams
// - TfIdfTransformer(): TF-IDF weighting
// - RandomForest(n_estimators=100): robust baseline classifier

echo "Creating ML Pipeline...\n";
$pipeline = new Pipeline([
    new WordCountVectorizer(1000, 2),
    new TfIdfTransformer(),
], new RandomForest(null, 100));

$dataset = new Labeled($samples, $labels);

// Train the model on all available data
echo "Training model...\n";
$pipeline->train($dataset);

echo "Testing accuracy...\n";
$testSize = min(100, count($samples));
$correct = 0;

for ($i = 0; $i < $testSize; $i++) {
    $testSample = new Labeled([$samples[$i]], [$labels[$i]]);
    $predicted = $pipeline->predict($testSample)[0];
    if ($predicted === $labels[$i]) {
        $correct++;
    } else if ($i < 5) {
        echo "Error $i: Expected '{$labels[$i]}', Got '$predicted'\n";
        echo "   Text: {$samples[$i]}\n";
    }
}

$accuracy = ($correct / $testSize) * 100;
echo "\nModel Accuracy: " . number_format($accuracy, 2) . "% ($correct/$testSize)\n\n";

// Persist model only if the quick check passes an acceptable threshold
if ($accuracy > 90) {
    echo "Saving model...\n";
    $serialized = serialize($pipeline);
    file_put_contents('bengali_math_model.dat', $serialized);
    echo "Model saved successfully!\n\n";
    echo "Training completed! Model ready to solve Bengali math problems.\n";
    echo "Final Accuracy: " . number_format($accuracy, 2) . "%\n";
} else {
    echo "Model accuracy too low. Consider adding more training data.\n";
}
?>