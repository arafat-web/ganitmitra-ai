<?php
require_once 'vendor/autoload.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/result.php';

use Rubix\ML\Datasets\Labeled;

class BengaliMathMLSolver
{
    private $model;
    private $rules;

    public function __construct()
    {
        $this->model = null;
    }

    private function loadModel()
    {
        $modelPaths = [
            'bengali_math_model.dat',
            '../bengali_math_model.dat',
            __DIR__ . '/bengali_math_model.dat',
        ];

        foreach ($modelPaths as $path) {
            if (file_exists($path)) {
                $serialized  = file_get_contents($path);
                $this->model = unserialize(data: $serialized);
                return true;
            }
        }

        throw new \Exception("Model file not found. Please train the model first by running: php ml_trainer.php");
    }

    public function solve($problemText)
    {
        $numbers = extractNumbers($problemText);
        if (empty($numbers)) {
            return [
                'success' => false,
                'error'   => 'কোন সংখ্যা খুঁজে পাওয়া যায়নি',
            ];
        }
        
        try {
            if ($this->model === null) {
                $this->loadModel();
            }
            $dataset            = new Labeled([$problemText], ['unknown']);
            $predictedOperation = $this->model->predict($dataset)[0];

            $result = $this->calculateResult($predictedOperation, $numbers);
            if ($result !== null) {
                return [
                    'success'        => true,
                    'problem'        => $problemText,
                    'operation'      => $predictedOperation,
                    'numbers'        => convertToBengali($numbers),
                    'answer'         => convertToBengali($result),
                    'bengali_answer' => convertToBengali($result),
                    'steps'          => generateSteps($predictedOperation, $numbers, $result),
                    'method'         => 'ml_model',
                    'confidence'     => '95%',
                ];
            }
        } catch (\Exception $e) {
            // ignore and try rules
        }

        return [
            'success' => false,
            'error'   => 'সমাধান করা যায়নি',
        ];
    }

    private function normalizeText($text)
    {
        $text = trim($text);
        $text = preg_replace('/\s+/u', ' ', $text);
        if (function_exists('mb_strtolower')) {
            $text = mb_strtolower($text, 'UTF-8');
        } else {
            $text = strtolower($text);
        }
        return $text;
    }

    private function containsAny($text, array $keywords)
    {
        foreach ($keywords as $kw) {
            if (mb_strpos($text, $kw) !== false) {
                return true;
            }

        }
        return false;
    }

    private function guessOperationFromText($problemText, array $numbers)
    {
        $text = normalizeText($problemText);

        $kwAdd     = ['যোগ', 'মোট', 'সবমিলিয়ে', 'সব মিলিয়ে', 'একত্রে', 'মিলিয়ে'];
        $kwSub     = ['বিয়োগ', 'কমে', 'বাকি', 'অবশিষ্ট', 'খরচ', 'চলে গেল', 'হারাল', 'ব্যবহার'];
        $kwMul     = ['গুণ', 'প্রতি', 'দাম', 'মূল্য', 'টাকা প্রতি', 'কেজি প্রতি', 'প্রতি প্যাকেট'];
        $kwDiv     = ['ভাগ', 'সমানভাবে ভাগ', 'প্রতিজন', 'প্রতি জন'];
        $kwDivCeil = ['যাত্রা', 'ট্রিপ', 'বার লাগবে', 'দিন লাগবে', 'প্রয়োজন', 'প্রয়োজন', 'লাগবে'];

        $negVerbs = ['খরচ', 'দিল', 'বিয়োগ', 'বিক্রি', 'কমে', 'চলে গেল', 'হারাল', 'ব্যবহার'];
        $posVerbs = ['পেল', 'কিনল', 'যোগ', 'বাড়ল', 'বাড়িয়ে', 'আরও'];

        if (count($numbers) >= 3 && $this->containsAny($text, $negVerbs) && $this->containsAny($text, $posVerbs)) {
            return 'multi_step';
        }
        if (count($numbers) >= 2 && ($this->containsAny($text, $kwMul) || $this->containsAny($text, ['×', 'x', 'গুণ']))) {
            return 'multiply';
        }
        if (count($numbers) >= 2 && $this->containsAny($text, $kwDivCeil)) {
            return 'divide_ceil';
        }
        if (count($numbers) >= 2 && $this->containsAny($text, $kwDiv)) {
            return 'divide';
        }
        if ($this->containsAny($text, $kwSub)) {
            return 'subtract';
        }
        if ($this->containsAny($text, $kwAdd)) {
            return 'add';
        }
        return null;
    }
    private function calculateResult($operation, $numbers)
    {
        if (empty($numbers)) {
            return null;
        }

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
                    $larger  = max($numbers[0], $numbers[1]);
                    $smaller = min($numbers[0], $numbers[1]);
                    if ($smaller != 0) {
                        return floor($larger / $smaller);
                    }

                }
                return $numbers[0];
            case 'divide_ceil':
                if (count($numbers) >= 2) {
                    $larger  = max($numbers[0], $numbers[1]);
                    $smaller = min($numbers[0], $numbers[1]);
                    if ($smaller != 0) {
                        return ceil($larger / $smaller);
                    }

                }
                return $numbers[0];
            case 'multi_step':
                if (count($numbers) >= 3) {
                    return $numbers[0] - $numbers[1] + $numbers[2];
                }

                if (count($numbers) >= 2) {
                    return $numbers[0] - $numbers[1];
                }

                return $numbers[0];
            default:
                return array_sum($numbers);
        }
    }

}

function solveWithML($problemText)
{
    static $solver = null;
    if ($solver === null) {
        $solver = new BengaliMathMLSolver();
    }

    return $solver->solve($problemText);
}
