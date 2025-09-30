<?php

// Convert Bengali digits to English digits
function convertDigitsToEnglish(string $text): string
{
    $bengali = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    return str_replace($bengali, $english, $text);
}

// Convert Bengali word numbers to digits
function convertWordNumbersToDigits(string $text): string
{
    $bengaliNumberWords = [
        'শূন্য' => 0, 'এক'     => 1, 'দুই'  => 2, 'তিন'    => 3, 'চার'    => 4, 'পাঁচ'  => 5, 'ছয়'   => 6,
        'সাত'   => 7, 'আট'     => 8, 'নয়'  => 9, 'দশ'     => 10, 'এগারো' => 11, 'বারো' => 12, 'তেরো' => 13,
        'চৌদ্দ' => 14, 'পনেরো' => 15, 'ষোল' => 16, 'সতেরো' => 17, 'আঠারো' => 18, 'ঊনিশ' => 19, 'বিশ'  => 20,
    ];
    foreach ($bengaliNumberWords as $word => $num) {
        $text = preg_replace('/\b' . preg_quote($word, '/') . '\b/u', $num, $text);
    }
    return $text;
}

// Normalize text (trim + lowercase)
function normalizeText(string $text): string
{
    $text = trim($text);
    $text = preg_replace('/\s+/u', ' ', $text);
    return function_exists('mb_strtolower') ? mb_strtolower($text, 'UTF-8') : strtolower($text);
}

// Check if text contains any keywords
function containsAny(string $text, array $keywords): bool
{
    foreach ($keywords as $kw) {
        if (mb_strpos($text, $kw) !== false) {
            return true;
        }
    }

    return false;
}

// Extract numbers (integers or decimals)
function extractNumbers(string $text): array
{
    $converted = convertDigitsToEnglish($text);
    preg_match_all('/\d+(?:\.\d+)?/u', $converted, $m);
    return array_map('floatval', $m[0]);
}

// Extract fractions like "1/2"
function extractFractions(string $text): array
{
    $fractions = [];
    if (preg_match_all('/(\d+)\s*\/\s*(\d+)/u', $text, $m, PREG_SET_ORDER)) {
        foreach ($m as $f) {
            $fractions[] = floatval($f[1]) / floatval($f[2]);
        }

    }
    return $fractions;
}

// Extract explicit prices (numbers followed by "টাকা")
function extractExplicitPrices(string $text): array
{
    $converted = convertDigitsToEnglish($text);
    $prices    = [];
    if (preg_match_all('/(\d+(?:\.\d+)?)\s*টাকা/u', $converted, $m)) {
        foreach ($m[1] as $p) {
            $prices[] = (float) $p;
        }

    }
    return $prices;
}

// Extract single price if only one exists
function extractSinglePrice(string $text): ?float
{
    $prices = extractExplicitPrices($text);
    return count($prices) === 1 ? $prices[0] : null;
}

// Extract quantity with common Bengali classifiers
function extractQuantity(string $text): ?int
{
    $converted = convertDigitsToEnglish($text);
    if (preg_match('/(\d+)\s*(টি|জন|কেজি|লিটার|প্যাকেট|বাক্স|ডজন)/u', $converted, $m)) {
        return (int) $m[1];
    }
    return null;
}

// Convert number to Bengali digits
function convertToBengali($number): string
{
    $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $bengali = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    return str_replace($english, $bengali, (string) $number);
}
