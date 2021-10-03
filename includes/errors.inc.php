<?php

function printErrors($error)
{
    $begDivErrMsg = '<div class="row"><div class="col"></div><div class="col-md-6 alert alert-danger" role="alert"><p class="text-center1">';
    $endDivErrMsg = '</p></div><div class="col"></div></div>';
    $begDivSucMsg = '<div class="row"><div class="col"></div><div class="col-md-6 alert alert-success" role="alert"><p class="text-center1">';
    $endDivSucMsg = '</p></div><div class="col"></div></div>';

    if ($error == "emptyinput") {
        return $begDivErrMsg . 'Fill in all fields!' . $endDivErrMsg;
    } 
    else if ($error == "invalidUid") {
        return $begDivErrMsg . 'Choose a valid username!' . $endDivErrMsg;
    } 
    else if ($error == "diffPasswords") {
        return $begDivErrMsg .  "Passwords doesn't match!" . $endDivErrMsg;
    } 
    else if ($error == "usernametaken") {
        return $begDivErrMsg . 'Choose a unique username or email!' . $endDivErrMsg;
    } 
    else if ($error == "invalidemail") {
        return $begDivErrMsg . 'Choose a valid email!' . $endDivErrMsg;
    } 
    else if ($error == "stmtfailed") {
        return $begDivErrMsg . 'Something went wrong, try again!' . $endDivErrMsg;
    } 
    else if ($error == "emailerror") {
        return $begDivErrMsg . 'No email send!' . $endDivErrMsg;
    } 
    else if ($error == "nosession") {
        return $begDivErrMsg . 'Something get wrong with session.' . $endDivErrMsg;
    }
    else if ($error == "none") {
        // Success Sign Up Message
        return $begDivSucMsg . 'Thank you for your registring! A confirmation email has been sent to your email! Please click on the activation link to activate your acount.' . $endDivSucMsg;
    } 
    else if ($error == "activate") {
        // Success Sign Up Message
        return $begDivSucMsg . 'Your account has been activated.' . $endDivSucMsg;
    } 
    else if ($error == "nokey") {
        return $begDivErrMsg . 'There was an error. Please click on the activation link you received by email!' . $endDivErrMsg;
    }
    else if ($error == "wrongpassword") {
        return $begDivErrMsg . 'Wrong Password!' . $endDivErrMsg;
    }
    else if ($error == "wrongpassword") {
        return $begDivErrMsg . 'Wrong Password!' . $endDivErrMsg;
    }
    else if ($error == "successupdateusername") {
        // Success Sign Up Message
        return $begDivSucMsg . 'Your username has succesfully update!' . $endDivSucMsg;
    }
    else if ($error == "notupdateusername") {
        return $begDivErrMsg . 'Somwthing get wrong with username update. Please try again!' . $endDivErrMsg;
    }
    else if ($error == "successupdatepassword") {
        // Success Sign Up Message
        return $begDivSucMsg . 'Your password has succesfully update!' . $endDivSucMsg;
    }
    else if ($error == "notupdatepassword") {
        return $begDivErrMsg . 'Somwthing get wrong with password update. Please try again!' . $endDivErrMsg;
    }
}