<?php
require_once 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Transformers\WordCountVectorizer;
use Rubix\ML\Transformers\TfIdfTransformer;
use Rubix\ML\Pipeline;
use Rubix\ML\Classifiers\RandomForest;

echo "🤖 Bengali Math ML Model Trainer\n";
echo "================================\n\n";

// Load dataset
echo "📊 Loading dataset.csv...\n";
$data = array_map('str_getcsv', file('dataset.csv'));
array_shift($data); // Remove header

// Clean data
$cleanData = array_filter($data, function($row) {
    return count($row) == 3 && !empty($row[0]) && !empty($row[1]) && $row[1] !== 'label';
});

$samples = [];
$labels = [];

echo "✅ Loaded " . count($cleanData) . " problems\n";

// Prepare training data
foreach ($cleanData as $row) {
    $text = $row[0];
    $operation = $row[1];
    
    $samples[] = $text;
    $labels[] = $operation;
}

echo "📈 Operations found: " . implode(', ', array_unique($labels)) . "\n\n";

// Create ML pipeline
echo "🧠 Creating ML Pipeline...\n";
$pipeline = new Pipeline([
    new WordCountVectorizer(1000, 2), // max 1000 features, 2-grams
    new TfIdfTransformer(),
], new RandomForest(null, 100)); // 100 estimators

// Create labeled dataset
$dataset = new Labeled($samples, $labels);

// Train the model
echo "⏳ Training model...\n";
$pipeline->train($dataset);

// Test accuracy with a subset
echo "🧪 Testing accuracy...\n";
$testSize = min(100, count($samples));
$correct = 0;

for ($i = 0; $i < $testSize; $i++) {
    $testSample = new Labeled([$samples[$i]], [$labels[$i]]);
    $predicted = $pipeline->predict($testSample)[0];
    
    if ($predicted === $labels[$i]) {
        $correct++;
    } else if ($i < 5) { // Show first 5 errors
        echo "❌ Error $i: Expected '{$labels[$i]}', Got '$predicted'\n";
        echo "   Text: {$samples[$i]}\n";
    }
}

$accuracy = ($correct / $testSize) * 100;
echo "\n📊 Model Accuracy: " . number_format($accuracy, 2) . "% ($correct/$testSize)\n\n";

// Save model if accuracy is acceptable
if ($accuracy > 60) {
    echo "💾 Saving model...\n";
    
    // Serialize and save the model
    $serialized = serialize($pipeline);
    file_put_contents('bengali_math_model.dat', $serialized);
    
    echo "✅ Model saved successfully!\n\n";
    echo "🎉 Training completed! Model ready to solve Bengali math problems.\n";
    echo "📈 Final Accuracy: " . number_format($accuracy, 2) . "%\n";
} else {
    echo "⚠️ Model accuracy too low. Consider adding more training data.\n";
}
?>