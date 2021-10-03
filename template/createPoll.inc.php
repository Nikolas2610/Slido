<?php
session_start();
include '../functions.inc.php';
include '../globalVariables.inc.php';
$formData = explode('&',$_POST['data']);
$buttons = $_POST['buttons'];
// print_r($_POST['data']);
// print_r($_POST['buttons']);
$formData = convertStringToArray($formData);



if (isset($buttons['savePoll']) || isset($buttons['launchPoll'])) {

    // Get the code for the pollKind to save to databse
    $pollKind =  codePollKind($formData['pollKind']);
    $question = $formData['question'];
    $eventId = $_SESSION['event_id'];
    // Timestamp
    $time = date("Y-m-d H:i:s", time());

    if (isset($_POST['stars'])) {
        $stars = $_POST['stars'];
    }
    

    // Default zero
    $peopleAnswers = "0";

    // Set live if we live the Poll
    if ($buttons['launchPoll'] == 1) {
        $status = "live";
    } else {
        $status = "off";
    }


    if ($pollKind == "MP") {
        // Create one string for the answers and the correctAnswers
        if (!empty($formData['option1'])) {
            // echo "hi";
            // Answer Text
            $answer = $formData['option1'];
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
        echo $status;
        exit();

        // check if the fields are empty
        if (emptyCreatePoll($question, $formData['option1'], $formData['option2'])) {
            // header("location: " . $url . "events.php?error=emptyinput");
            echo "emptyInputs";
            exit();
        }
        // create poll
        createPoll($eventId, $question, $answer, $peopleAnswers, $time, $pollKind, $status, $correctAnswers);
    } elseif ($pollKind == "RK") {
        if (empty($question)) {
            echo "emptyInputs";
            exit();
        }
        $correctAnswers = -1;
        for ($i = 1; $i < $stars; $i++) {
            $peopleAnswers .= '/ ' . "0";
        }
        if (createPoll($eventId, $question, $stars, $peopleAnswers, $time, $pollKind, $status, $correctAnswers)) {
            echo "success";
        } else {
            echo "queryProblem";
        }
        exit();
    }
} else {
    // If not set back to events.php
    // header("location: " . $url . "events.php");
    exit();
};
