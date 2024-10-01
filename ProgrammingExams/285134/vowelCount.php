<?php
//Count the vowels in the text file
function countVowels($word) {
    return preg_match_all('/[aeiouAEIOU]/', $word, $matches);
}

//Read the file and count vowels for each word
$words = file("words.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$vowelCountMap = [];
foreach ($words as $word) {
    $vowels = countVowels($word);
    if (!isset($vowelCountMap[$vowels])) {
        $vowelCountMap[$vowels] = [];
    }
    $vowelCountMap[$vowels][] = $word;
}

//Sort the lists
foreach ($vowelCountMap as &$wordList) {
    usort($wordList, function($a, $b) {
        return strlen($a) - strlen($b);
    });
}

//Send the list
header('Content-Type: application/json');
echo json_encode($vowelCountMap);
?>