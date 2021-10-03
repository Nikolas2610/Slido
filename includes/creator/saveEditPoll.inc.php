<?php
session_start();
// Include Files
include '../functions.inc.php';
include '../globalVariables.inc.php';

// Unserialize
$formData = explode('&', $_POST['data']);
$formData = convertStringToArray($formData);

// Declare Variables
$pollKind = $formData['pollKind'];
$question = $formData['editQuestion'];
$poll_id = $_SESSION['poll_id'];

// Check question if is empty
if (empty($question)) {
    echo "emptyquestion";
    exit();
}

// Check the sentence if it has space
if (strpos($question, '%')) {
    $question = stringSetSpaces($question);
}

// Check PollKind
if ($pollKind == 'MP') {
    // Create one string for the answers and the correctAnswers
    $answersArray = array();
    $peopleAnswers = '';
    for ($i = 1; $i < 9; $i++) {
        if (!empty($formData['option' .  $i])) {
            if (empty($formData['correctAnswer' .  $i])) {
                $formData['correctAnswer' .  $i] = 0;
            }
            if ($formData['correctAnswer' .  $i] === 'on') {
                $formData['correctAnswer' .  $i] = 1;
            }
            array_push($answersArray, array(
                'question' => $i,
                'correctAnswer' => $formData['correctAnswer' .  $i]
            ));
            // Set people answers deafault to zero  
            if ($peopleAnswers == '') {
                $peopleAnswers = '0';
            } else {
                $peopleAnswers .= '/ 0';
            }
        }
    }
    foreach ($answersArray as $array) {
        if (empty($answer)) {
            // Check the sentence if it has space
            if (strpos($formData['option' .  $array['question']], '%')) {
                $formData['option' .  $array['question']] = stringSetSpaces($formData['option' .  $array['question']]);
            }
            $answer = $formData['option' .  $array['question']];
            $correctAnswers = strval($array['correctAnswer']);
        } else {
            // Check the sentence if it has space
            if (strpos($formData['option' .  $array['question']], '%')) {
                $formData['option' .  $array['question']] = stringSetSpaces($formData['option' .  $array['question']]);
            }
            $answer .= '/ ' . $formData['option' .  $array['question']];
            $correctAnswers .= '/ ' . strval($array['correctAnswer']);
        }
    }

    // Check For Errors
    // Min 2 answers
    if (sizeof($answersArray) < 2) {
        echo "min2answers";
        exit();
    }

    // Check correct answer if has answer
    if (!empty($formData['markEditAnswers'])) {
        for ($i = 1; $i < 9; $i++) {
            if (!empty($formData['correctAnswer' . $i])) {
                if (empty($formData['option' . $i])) {
                    echo "answerNeedValue";
                    exit();
                }
            }
        }
    }
} elseif ($pollKind == 'RG') {
    // Create Answers for the stars
    $stars = $formData['stars'];
    // Set people answers deafault to zero  
    for ($i = 1; $i <= $stars; $i++) {
        if (empty($answer)) {
            $answer = '1';
            $peopleAnswers = '0';
        } else {
            $answer .= '/' . $i;
            $peopleAnswers .= '/ 0';
        }
    }
    // Defalut -1
    $correctAnswers = -1;
}
// Query
if (updatePoll($poll_id, $question, $answer, $correctAnswers, $peopleAnswers)) {
    echo "success";
} else {
    echo "queryProblem";
}
exit();




