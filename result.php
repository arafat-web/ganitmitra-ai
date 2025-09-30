<?php
function generateSteps($operation, $numbers, $result)
{
    $resultBn  = convertToBengali($result);
    $numbersBn = array_map('convertToBengali', $numbers);

    $steps          = [];
    $operationNames = [
        'add'         => 'যোগ',
        'subtract'    => 'বিয়োগ',
        'multiply'    => 'গুণ',
        'divide'      => 'ভাগ',
        'divide_ceil' => 'ভাগ (উর্ধ্বমুখী)',
        'multi_step'  => 'বহুধাপ গণনা',
    ];

    $opName  = $operationNames[$operation] ?? $operation;
    $steps[] = "এমএল মডেল সনাক্ত করেছে: $opName";
    $steps[] = "প্রদত্ত সংখ্যা: " . implode(', ', $numbersBn);

    switch ($operation) {
        case 'add':
            $steps[] = "সংখ্যাগুলি যোগ করা হলো: " . implode(' + ', $numbersBn) . " = $resultBn";
            break;

        case 'subtract':
            if (count($numbersBn) >= 2) {
                $calc = $numbersBn[0];
                for ($i = 1; $i < count($numbersBn); $i++) {
                    $calc .= ' - ' . $numbersBn[$i];
                }
                $steps[] = "সংখ্যাগুলি বিয়োগ করা হলো: $calc = $resultBn";
            }
            break;

        case 'multiply':
            if (count($numbersBn) >= 2) {
                $steps[] = "সংখ্যাগুলি গুণ করা হলো: " . implode(' × ', $numbersBn) . " = $resultBn";
            }
            break;

        case 'divide':
        case 'divide_ceil':
            if (count($numbers) >= 2) {
                $larger  = max($numbers);
                $smaller = min($numbers);

                if ($smaller == 0) {
                    $steps[] = "ভাগ করা সম্ভব নয় (শূন্য দ্বারা ভাগ করা যায় না)";
                } else {
                    $largerBn  = convertToBengali($larger);
                    $smallerBn = convertToBengali($smaller);
                    $steps[]   = "বড় সংখ্যাটি ছোট সংখ্যা দ্বারা ভাগ: $largerBn ÷ $smallerBn = $resultBn";
                }
            }
            break;

        case 'multi_step':
            if (count($numbersBn) >= 2) {
                $expression = $numbersBn[0];
                for ($i = 1; $i < count($numbersBn); $i++) {
                    $expression .= ($i % 2 == 1 ? ' - ' : ' + ') . $numbersBn[$i];
                }
                $steps[] = "বহুধাপে গণনা করা হলো: $expression = $resultBn";
            }
            break;

        default:
            $steps[] = "গণনা: " . implode(' + ', $numbersBn) . " = $resultBn";
    }

    $steps[] = "চূড়ান্ত উত্তর: $resultBn";

    return $steps;
}
