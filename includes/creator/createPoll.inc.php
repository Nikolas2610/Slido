<?php
session_start();
// Includes files
include '../functions.inc.php';
include '../globalVariables.inc.php';

$formData = explode('&', $_POST['data']);
$buttons = $_POST['buttons'];
$formData = convertStringToArray($formData);


// Get the code for the pollKind to save to databse
$pollKind =  codePollKind($formData['pollKind']);
$question = $formData['question'];
$eventId = $_SESSION['event_id'];
// Timestamp
$time = date("Y-m-d H:i:s", time());

if (isset($formData['stars'])) {
    $stars = $formData['stars'];
}


// Default zero
$peopleAnswers = "0";

// Set live if we live the Poll
if ($buttons['launchPoll'] == 1) {
    $status = "live";
} else {
    $status = "off";
}

// Check the sentence if it has space
if (strpos($question, '%')) {
    $question = stringSetSpaces($question);
}


if ($pollKind == "MP") {
    // Create one string for the answers and the correctAnswers
    if (!empty($formData['option1'])) {
        // echo "hi";
        // Answer Text
        if (strpos($formData['option1'], '%')) {
            $answer = stringSetSpaces($formData['option1']);
        } else {
            $answer = $formData['option1'];
        }
        // If the answer is correct
        if (isset($formData['correctAnswer1'])) {
            $correctAnswers = "1";
        } else {
            $correctAnswers =  "0";
        }
    }
    for ($i = 2; $i < 9; $i++) {
        if (!empty($formData['option' .  $i])) {
            // Answer Text Loop
            if (strpos($formData['option' . $i], '%')) {
                $formData['option' . $i] = stringSetSpaces($formData['option' . $i]);
            }
            $answer .= '/ ' . $formData['option' .  $i];
            // If the answer is correct Loop
            if (isset($formData['correctAnswer' . $i])) {
                $correctAnswers .= '/ ' . "1";
            } else {
                $correctAnswers .= '/ ' . "0";
            }
            // Default zero
            $peopleAnswers .= '/ ' . "0";
        } else {
            break;
        }
    }
    // Check the question if is empty
    if (empty($question)) {
        echo "emptyQuestion";
        exit();
    }
    // Check if answers are empty
    if (empty($formData['option1']) || empty($formData['option2'])) {
        echo "emptyAnwers";
        exit();
    }

    // create poll
    if (createPoll($eventId, $question, $answer, $peopleAnswers, $time, $pollKind, $status, $correctAnswers)) {
        echo "createPoll";
    } else {
        echo "queryProblem";
    }
    exit();
} elseif ($pollKind == "RG") {
    if (empty($question)) {
        echo "emptyQuestion";
        exit();
    }
    $correctAnswers = -1;
    for ($i = 1; $i < $stars; $i++) {
        $peopleAnswers .= '/ ' . "0";
    }
    $answers = '1';
    for ($i = 2; $i <= $stars; $i++) {
        $answers .= '/' . $i;
    }
    if (createPoll($eventId, $question, $answers, $peopleAnswers, $time, $pollKind, $status, $correctAnswers)) {
        echo "createPoll";
    } else {
        echo "queryProblem";
    }
    exit();
}


exit();
