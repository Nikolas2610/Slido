$(function () {
    // Save Last Page
    lastPaheUrl = getLastPageUrl();
    error = getParameter("error");
    success = getParameter("success");
    // contact.php
    if (lastPaheUrl == 'contact.php') {
        // Errors msgs
        if (error) {
            if (error == 'emptyFirstName') {
                $('.errors').html('First name is required!');
                showErrorMsg();
            }
            if (error == 'emptyEmail') {
                $('.errors').html('Email is required!');
                showErrorMsg();
            }
            if (error == 'emptyComments') {
                $('.errors').html('Comments is required to send message!');
                showErrorMsg();
            }
            if (error == 'max512') {
                $('.errors').html('Comments must at least 512 characters!');
                showErrorMsg();
            }
            if (error == 'stmtfail') {
                $('.errors').html('Something get wrong. Try again later!');
                showErrorMsg();
                // SAVE DATA
            }
        }
        // Success msgs
        if (success) {
            if (success == 'msgSend') {
                $('.success').html('Your message has send succesfully!');
                showSuccessMsg();
            }
        }
    }

    // login.php
    if (lastPaheUrl == 'login.php') {
        if (error) {
            if (error == 'stmtfailed') {
                $('.errors').html('Something get wrong. Try again later!');
                showErrorMsg();
                // SAVE DATA
            }
            if (error == 'emptyEmailOrUsername') {
                $('.errors').html('Email or username is required!');
                showErrorMsg();
            }
            if (error == 'emptyPassword') {
                $('.errors').html('Password is required!');
                showErrorMsg();
            }
            if (error == 'wronglogin') {
                $('.errors').html('Wrong password!');
                showErrorMsg();
            }
            if (error == 'notactivated') {
                $('.errors').html('Your account is not activated. Check your emails to activate your account!');
                showErrorMsg();
            }
            if (error == 'wrongEmailOrUsername') {
                $('.errors').html('Your email or username is incorrect!');
                showErrorMsg();
            }
            if (error == 'emailerror') {
                $('.errors').html('Something get wrong with email port. Try again later!');
                showErrorMsg();
            }
        }
        if (success) {
            if (success == 'activateemail') {
                $('.success').html('Thank you for the registation, you successfully activate your account. You can login now!');
                showSuccessMsg();
            }
            if (success == 'forgotPasswordMailSend') {
                $('.success').html('An email has sent to you, for reset your password!');
                showSuccessMsg();
            }
        }
    }

    // signUp.php
    if (lastPaheUrl == 'signUp.php') {
        if (error == 'stmtfailed') {
            $('.errors').html('Something get wrong. Try again later!');
            showErrorMsg();
            // SAVE DATA
        }
        if (error == 'emptyEmail') {
            $('.errors').html('Email is required!');
            showErrorMsg();
        }
        if (error == 'emptyUsername') {
            $('.errors').html('Username is required!');
            showErrorMsg();
        }
        if (error == 'emptyPassword') {
            $('.errors').html('Password is required!');
            showErrorMsg();
        }
        if (error == 'emptyConfirmPassword') {
            $('.errors').html('Confirm password is required!');
            showErrorMsg();
        }
        if (error == 'invalidUid') {
            $('.errors').html('Username is invalid! Must have only this symbols *$!');
            showErrorMsg();
        }
        if (error == 'diffPasswords') {
            $('.errors').html('The passwords are differend!');
            showErrorMsg();
        }
        if (error == 'usernametaken') {
            $('.errors').html('Username is exists! Try something else.');
            showErrorMsg();
        }
        if (error == 'invalidemail') {
            $('.errors').html('Your email is invalid. Check your email!');
            showErrorMsg();
        }
        if (error == 'notoken') {
            $('.errors').html('Token not exists!');
            showErrorMsg();
        }
        if (error == 'tokenexpire') {
            $('.errors').html('Token has expire. Create a new user!');
            showErrorMsg();
        }
        if (error == 'emailerror') {
            $('.errors').html('Something get wrong with email. Try again Later!');
            showErrorMsg();
            // SAVE DATA
        }
        // Success msgs
        if (success) {
            if (success == 'createUser') {
                $('.success').html('You successfully create user to our page. Check your email to activate your account!');
                showSuccessMsg();
            }
            if (success == 'activateemail') {
                $('.success').html('Your account has activated successfully!');
                showSuccessMsg();
            }
        }
    }
    // events.php
    if (lastPaheUrl == 'events.php') {
        if (error) {
            if (error == 'emptyEventName') {
                errorToast("Event name is required to create event!");
            }
            if (error == 'emptyStartDate') {
                errorToast("You need to choose the start date of the event!");
            }
            if (error == 'emptyEndDate') {
                errorToast("You need to choose the end date of the event!");
            }
            if (error == 'diffPasswords') {
                errorToast("The passwords of the private event are differend!");
            }
            if (error == 'stmtfailed') {
                errorToast("Something get wrong. Try again later!");
                // SAVE DATA
            }
            if (error == 'emptyEmail') {
                errorToast("Email is required to invite someone!");
            }
            if (error == 'passwordneeded') {
                errorToast("The event is private and needs password!");
            }
            if (error == 'sendEmailError') {
                errorToast("Something get wrong with email. Try again Later!");
                // SAVE DATA
            }
        }
        if (success) {
            if (success == 'createEvent') {
                successToast('Event created successfully!');
            }
            if (success == 'invitePeopleByEmail') {
                successToast('Your invite has send successfully!');
            }
        }
    }
    // polls.php
    if (lastPaheUrl == 'polls.php') {
        if (error) {
            if (error == 'stmtfailed') {
                errorToast("Something get wrong. Try again later!");
                // SAVE DATA
            }
        }
        if (success) {
            if (success == 'createPoll') {
                successToast('Poll created successfully!');
            }
            if (success == 'editpoll') {
                successToast('Poll edit successfully!');
            }
        }
    }
    // qa.php
    if (lastPaheUrl == 'qa.php') {
        if (error) {
            if (error == 'stmtfailed') {
                errorToast("Something get wrong. Try again later!");
                // SAVE DATA
            }
            if (error == 'emptyinput') {
                errorToast("Unvailable to edit message. The message is empty!");
            }
            if (error == 'emptyReplyInput') {
                errorToast("Your answer is empty!");
            }
        }
        if (success) {
            if (success == 'editmsg') {
                successToast('Edit message successfully!');
            }
            if (success == 'replymsg') {
                successToast('Reply has send successfully!');
            }
        }
    }
    // profile.php
    if (lastPaheUrl == 'profile.php') {
        if (error) {
            if (error == 'stmtfailed') {
                errorToast("Something get wrong. Try again later!");
                // SAVE DATA
            }
            if (error == 'emptyUsername') {
                errorToast("New username is required!");
            }
            if (error == 'emptyOldPassword') {
                errorToast("The old password is required!");
            }
            if (error == 'emptyNewPassword') {
                errorToast("The new password is required!");
            }
            if (error == 'emptyConfirmPassword') {
                errorToast("Confirm password is required!");
            }
            if (error == 'diffPasswords') {
                errorToast("The passwords are differend!");
            }
            if (error == 'emptyPassword') {
                errorToast("Password is required!");
            }
            if (error == 'nosession') {
                errorToast("Is better to login or register before come here!");
            }
            if (error == 'invalidUid') {
                errorToast("Your new username is not valid!");
            }
            if (error == 'usernametaken') {
                errorToast("Your new username is exists! try something else!");
            }
            if (error == 'wrongpassword') {
                errorToast("Your password is incorrect! Please try again!");
            }
            if (error == 'notupdateusername') {
                errorToast("Something get wrong. Try again later!");
            }
            if (error == 'notupdatepassword') {
                errorToast("Something get wrong. Try again later!");
            }
        }
        if (success) {
            if (success == 'editmsg') {
                successToast('Edit message successfully!');
            }
            if (success == 'replymsg') {
                successToast('Reply has send successfully!');
            }
            if (success == 'successupdateusername') {
                successToast('Username has updated successfully!');
            }
            if (success == 'successupdatepassword') {
                successToast('Password has updated successfully!');
            }
        }
    }

    // forgotPassword.php
    if (lastPaheUrl == 'forgotPassword.php') {
        if (error) {
            if (error == 'stmtfailed') {
                errorToast("Something get wrong. Try again later!");
                // SAVE DATA
            }
            if (error == 'emptyemail') {
                errorToast("Email is required!");
            }
            if (error == 'emptyusername') {
                errorToast("Username is required!");
            }
            if (error == 'invalidmail') {
                errorToast("Your email is not valid!");
            }
            if (error == 'wronginputs') {
                errorToast("Email or username are not exists!");
            }
            if (error == 'emailerror') {
                errorToast("Something get wrong with email port! Please try again later!");
                // Save data
            }
        }
        if (success) {
            if (success == 'forgotPasswordMailSend') {
                successToast('A reset password link has sent to toyr email!');
            }
        }
    }

    // event.php
    if (lastPaheUrl == 'event.php') {
        if (error) {
            if (error == 'stmtfailed') {
                errorToast("Something get wrong. Try again later!");
                // SAVE DATA
            }
            if (error == 'emptyinput') {
                errorToast("The message is empty!");
            }
            if (error == 'sendEmailError') {
                errorToast("Something get wrong with email port. Please try again later!");
            }
        }
        if (success) {
            if (success == 'msgsend') {
                successToast('Message send to the event!');
            }
            if (success == 'msgsendreview') {
                successToast('Message send to the admin to review the message!');
            }
            if (success == 'updatenickname') {
                successToast('You have change your nickname successfully!');
            }
            if (success == 'invitePeopleByEmail') {
                successToast('You have invite people by email successfully!');
            }
        }
    }

    // index.php
    if (lastPaheUrl == 'index.php') {
        if (error) {
            if (error == 'stmtfailed') {
                errorToast("Something get wrong. Try again later!");
                // SAVE DATA
            }
            if (error == 'eventHasDeleted') {
                errorToast("The event has deleted from admin of the event!");
            }
            if (error == 'emptyinput') {
                errorToast("Type the event id to join!");
            }
            if (error == 'noevent') {
                errorToast("This event is not exists to our database!");
            }
        }
    }

})

// Print error toast, Input is the message
function errorToast(msg) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-left",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "7000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr["error"](msg);
}
// Print success toast, Input is the message
function successToast(msg) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-left",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr["success"](msg)
}
// Show error msg with effects for 10 secs
function showErrorMsg() {
    $('.errors').fadeIn("slow");
    setTimeout(() => {
        $('.errors').fadeOut("slow");
    }, 20000);
}
// Show success msg with effects for 5 secs
function showSuccessMsg() {
    $('.success').fadeIn("slow");
    setTimeout(() => {
        $('.success').fadeOut("slow");
    }, 10000);
}
// Return the Last Page of the Url
function getLastPageUrl() {
    let urlPathname = window.location.pathname;
    let tempArray = [];
    let tempWord = '';
    let j = -1;
    urlPathname += '/';
    for (let i = 0; i < urlPathname.length; i++) {
        if (urlPathname[i] == '/') {
            tempArray.push(tempWord);
            tempWord = '';
            j++;
        } else {
            tempWord += urlPathname[i];
        }
    }
    return tempArray[j];
}
// Return the errors or success msgs
function getParameter(parameterName) {
    let parameter = new URLSearchParams(window.location.search);
    return parameter.get(parameterName);
}