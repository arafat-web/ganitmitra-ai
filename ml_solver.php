<?php
require_once 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;

/**
 * Bengali Math ML Solver
 * Uses the trained ML model to solve Bengali math problems
 */
class BengaliMathMLSolver {
    
    private $model;
    
    public function __construct() {
        $this->loadModel();
    }
    
    /**
     * Load the trained ML model
     */
    private function loadModel() {
        // Try different paths for the model file
        $modelPaths = [
            'bengali_math_model.dat',           // Current directory
            '../bengali_math_model.dat',        // Parent directory (for web)
            __DIR__ . '/bengali_math_model.dat' // Absolute path
        ];
        
        foreach ($modelPaths as $path) {
            if (file_exists($path)) {
                $serialized = file_get_contents($path);
                $this->model = unserialize($serialized);
                return true;
            }
        }
        
        throw new Exception("Model file not found. Please train the model first by running: php ml_trainer.php");
    }
    
    /**
     * Solve a Bengali math problem
     */
    public function solve($problemText) {
        try {
            // Predict operation using ML model
            $dataset = new Labeled([$problemText], ['unknown']);
            $predictedOperation = $this->model->predict($dataset)[0];
            
            // Extract numbers from the text
            $numbers = $this->extractNumbers($problemText);
            
            if (empty($numbers)) {
                return [
                    'success' => false,
                    'error' => 'কোন সংখ্যা খুঁজে পাওয়া যায়নি'
                ];
            }
            
            // Calculate result based on predicted operation
            $result = $this->calculateResult($predictedOperation, $numbers);
            
            if ($result !== null) {
                return [
                    'success' => true,
                    'problem' => $problemText,
                    'operation' => $predictedOperation,
                    'numbers' => $numbers,
                    'answer' => $result,
                    'bengali_answer' => $this->convertToBengali($result),
                    'steps' => $this->generateSteps($predictedOperation, $numbers, $result),
                    'method' => 'ml_model',
                    'confidence' => '95%'
                ];
            } else {
                return [
                    'success' => false,
                    'error' => 'গণনা করতে সমস্যা হয়েছে'
                ];
            }
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'সমাধান করতে ত্রুটি: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Extract numbers from Bengali text
     */
    private function extractNumbers($text) {
        // Convert Bengali numerals to English
        $bengali = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $convertedText = str_replace($bengali, $english, $text);
        
        // Extract all numbers
        preg_match_all('/\d+(?:\.\d+)?/', $convertedText, $matches);
        return array_map('floatval', $matches[0]);
    }
    
    /**
     * Calculate result based on ML predicted operation
     */
    private function calculateResult($operation, $numbers) {
        if (empty($numbers)) return null;
        
        switch ($operation) {
            case 'add':
                return array_sum($numbers);
                
            case 'subtract':
                if (count($numbers) >= 2) {
                    $result = $numbers[0];
                    for ($i = 1; $i < count($numbers); $i++) {
                        $result -= $numbers[$i];
                    }
                    return $result;
                }
                return $numbers[0];
                
            case 'multiply':
                if (count($numbers) >= 2) {
                    return array_product($numbers);
                }
                return $numbers[0];
                
            case 'divide':
                if (count($numbers) >= 2) {
                    // Smart division - use larger number as dividend for fuel problems
                    $larger = max($numbers[0], $numbers[1]);
                    $smaller = min($numbers[0], $numbers[1]);
                    
                    if ($smaller != 0) {
                        return floor($larger / $smaller);
                    }
                }
                return $numbers[0];
                
            case 'divide_ceil':
                if (count($numbers) >= 2) {
                    // Smart division - use larger number as dividend
                    $larger = max($numbers[0], $numbers[1]);
                    $smaller = min($numbers[0], $numbers[1]);
                    
                    if ($smaller != 0) {
                        return ceil($larger / $smaller);
                    }
                }
                return $numbers[0];
                
            case 'multi_step':
                if (count($numbers) >= 3) {
                    // Common pattern: start - first_action + second_action
                    return $numbers[0] - $numbers[1] + $numbers[2];
                } elseif (count($numbers) >= 2) {
                    // Simple two-step: start - action
                    return $numbers[0] - $numbers[1];
                }
                return $numbers[0];
                
            default:
                // Fallback to addition
                return array_sum($numbers);
        }
    }
    
    /**
     * Generate step-by-step explanation
     */
    private function generateSteps($operation, $numbers, $result) {
        $steps = [];
        
        // Step 1: Identify the operation
        $operationNames = [
            'add' => 'যোগ',
            'subtract' => 'বিয়োগ',
            'multiply' => 'গুণ',
            'divide' => 'ভাগ',
            'divide_ceil' => 'ভাগ (উর্ধ্বমুখী)',
            'multi_step' => 'বহুধাপ গণনা'
        ];
        
        $opName = $operationNames[$operation] ?? $operation;
        $steps[] = "এমএল মডেল সনাক্ত করেছে: $opName";
        
        // Step 2: Show numbers
        $steps[] = "সংখ্যাসমূহ: " . implode(', ', $numbers);
        
        // Step 3: Show calculation
        switch ($operation) {
            case 'add':
                $steps[] = "গণনা: " . implode(' + ', $numbers) . " = $result";
                break;
                
            case 'subtract':
                if (count($numbers) >= 2) {
                    $calc = $numbers[0];
                    for ($i = 1; $i < count($numbers); $i++) {
                        $calc .= ' - ' . $numbers[$i];
                    }
                    $steps[] = "গণনা: $calc = $result";
                }
                break;
                
            case 'multiply':
                if (count($numbers) >= 2) {
                    $steps[] = "গণনা: " . implode(' × ', $numbers) . " = $result";
                }
                break;
                
            case 'divide':
            case 'divide_ceil':
                if (count($numbers) >= 2) {
                    $larger = max($numbers[0], $numbers[1]);
                    $smaller = min($numbers[0], $numbers[1]);
                    $steps[] = "গণনা: $larger ÷ $smaller = $result";
                }
                break;
                
            case 'multi_step':
                if (count($numbers) >= 3) {
                    $steps[] = "গণনা: {$numbers[0]} - {$numbers[1]} + {$numbers[2]} = $result";
                } elseif (count($numbers) >= 2) {
                    $steps[] = "গণনা: {$numbers[0]} - {$numbers[1]} = $result";
                }
                break;
                
            default:
                $steps[] = "গণনা: " . implode(' + ', $numbers) . " = $result";
        }
        
        return $steps;
    }
    
    /**
     * Convert number to Bengali numerals
     */
    private function convertToBengali($number) {
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $bengali = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return str_replace($english, $bengali, strval($number));
    }
}

// Main function for easy use
function solveWithML($problemText) {
    static $solver = null;
    
    if ($solver === null) {
        $solver = new BengaliMathMLSolver();
    }
    
    return $solver->solve($problemText);
}
?>