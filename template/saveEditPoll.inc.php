<?php
session_start();
if (isset($_POST['saveEditPoll'])) {
    include '../functions.inc.php';
    include '../globalVariables.inc.php';

    // Get the code for the pollKind to save to databse
    $question = $_POST['question'];
    $eventId = $_SESSION['event_id'];
    $poll_id = $_SESSION['poll_id'];

    // Create one string for the answers and the correctAnswers
    if (!empty($_POST['option1'])) {
        // Answer Text
        $answer = $_POST['option1'];
        // If the answer is correct
        if (isset($_POST['correctAnswer1'])) {
            $correctAnswers = "1";
        } else {
            $correctAnswers =  "0";
        }
        // Default zero
        $peopleAnswers = "0";
    }
    for ($i = 2; $i < 9; $i++) {
        if (!empty($_POST['option' .  $i])) {
            // Answer Text Loop
            $answer .= '/ ' . $_POST['option' .  $i];
            // If the answer is correct Loop
            if (isset($_POST['correctAnswer' . $i])) {
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

    // check if the fields are empty
    if (emptyCreatePoll($question, $_POST['option1'], $_POST['option2'])) {
        header("location: " . $url . "polls.php?poll=list&error=emptyinput");
        exit();
    }
    if (updatePoll($poll_id, $question, $answer, $correctAnswers)) {
        header("location: " . $url . "polls.php?poll=list&success=updatepoll");
    } else {
        header("location: " . $url . "polls.php?poll=list&error=noupdatepoll");
    }
} else {
    // If not set back to polls page
    header("location: ../polls.php?poll=list");
    exit();
};
