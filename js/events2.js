const url = 'http://localhost/Dasygenis_project/Form/';

$(function () {
    // EVENTS ajax calls
    // Load events at events.php
    $.ajax({
        url: "includes/creator/loadevents.inc.php",
        success: function (data) {
            $('#loadEvents').html(data);
        }
    });

    // Get the id of div to set session[Event_id]
    $(document).on('click', '#eventDropMenu', function () {
        eventId = $(this).closest('.event').attr('id');
        $.ajax({
            url: "includes/creator/setSessionEventId.inc.php",
            method: "POST",
            data: { id: eventId }
        })
    });

    // Delete Event
    $(document).on('click', '#deleteButton', function () {
        eventId = $(this).closest('.event').attr('id');
        $.ajax({
            url: "includes/creator/deleteEvent.inc.php",
            method: "POST",
            data: { id: eventId },
            success: function (data) {
                if (data == 'queryProblem') {
                    errorToast("Something get wrong. Try again later!");
                }
                if (data == 'deleteEvent') {
                    $.ajax({
                        // Load new Events
                        url: "includes/creator/loadevents.inc.php",
                        success: function (data) {
                            $('#loadEvents').html(data);
                            successToast('Event has deleted!')
                        }
                    });
                }
            }
        })
    });
    // Duplicate Event
    $(document).on('click', '#duplicateButton', function () {
        eventId = $(this).closest('.event').attr('id');
        $.ajax({
            url: "includes/creator/duplicateEvent.inc.php",
            method: "POST",
            data: { id: eventId },
            success: function (data) {
                if (data == 'duplicateEvent') {
                    $.ajax({
                        // Load new Events
                        url: "includes/creator/loadevents.inc.php",
                        success: function (data) {
                            $('#loadEvents').html(data);
                            successToast("The event has duplicate successfully!");
                        }
                    });
                } else if (data == 'stmtfailed') {
                    // Print toast for the stmt failed
                    errorToast("Something get wrong. Try again later!");
                }
            }
        })
    });

    // Share Event
    $(document).on('click', '#shareButton', function () {
        eventId = $(this).closest('.event').attr('id');
        $('#successCopy').html("");
        $.ajax({
            url: "includes/creator/shareLink.inc.php",
            method: "POST",
            data: { id: eventId },
            success: function (data) {
                $('#shareLink').val(data);
            }
        })
    });

    $(document).on('click', '#copyLink', function (e) {
        copyLink()
    });

    // POLLS ajax calls
    // Load Poll Page
    get = getParameter('poll');
    if (get == 'list') {
        // Load List Poll
        $.ajax({
            url: "includes/creator/loadPolls.inc.php",
            success: function (data) {
                $('#loadPolls').html(data);
            }
        });
    } else if (get == 'live') {
        // Load Live Poll
        $.ajax({
            url: "includes/creator/loadLivePoll.inc.php",
            success: function (data) {
                $('#loadPolls').html(data);
            }
        });
    } else if (get == 'allresults') {
        $.ajax({
            url: "includes/creator/loadAllResultsPolls.inc.php",
            success: function (data) {
                $('#loadPolls').html(data);
            }
        });
    }

    // Delete Poll
    $(document).on('click', '#deletePollButton', function () {
        pollId = $(this).closest('.poll').attr('id');
        pollQuestion = $('#poll' + pollId).text();
        $.ajax({
            url: "includes/creator/deletePoll.inc.php",
            method: "POST",
            data: { id: pollId },
            success: function (data) {
                $.ajax({
                    // Load new Polls
                    url: "includes/creator/loadPolls.inc.php",
                    success: function (data) {
                        $('#loadPolls').html(data);
                        successToast("The poll '" + pollQuestion + "' has deleted!");
                    }
                });
            }
        })
    });
    // Duplicate Poll
    $(document).on('click', '#duplicatePollButton', function () {
        pollId = $(this).closest('.poll').attr('id');
        pollQuestion = $('#poll' + pollId).text();
        $.ajax({
            url: "includes/creator/duplicatePoll.inc.php",
            method: "POST",
            data: { id: pollId },
            success: function (data) {
                if (data == 'queryProblem') {
                    errorToast("Something get wrong. Try again later!");
                }
                if (data == 'duplicatePoll') {
                    $.ajax({
                        // Load new Polls
                        url: "includes/creator/loadPolls.inc.php",
                        success: function (data) {
                            $('#loadPolls').html(data);
                            successToast("The poll '" + pollQuestion + "' has duplicate!");
                        }
                    });
                }
            }
        })
    });

    // Join event - Creator
    $(document).on('click', '.eventName', function () {
        eventId = $(this).closest('.event').attr('id');
        goesTo = 'joinEvent';
        $.ajax({
            url: "includes/creator/getEventDetails.inc.php",
            method: "POST",
            data: { id: eventId, go: goesTo },
            success: function (data) {
                if (data == 'queryProblem') {
                    errorToast("Something get wrong. Try again later!");
                }
                if (data == 'privateEvent') {
                    window.location = url + "needPassword.php";
                }
                if (data == 'puplicEvent') {
                    window.location = url + "polls.php?poll=list";
                }
            }
        })
    })
    // Edit event - Creator
    $(document).on('click', '#editButton', function () {
        eventId = $(this).closest('.event').attr('id');
        goesTo = 'eventSettings';
        $.ajax({
            url: "includes/creator/getEventDetails.inc.php",
            method: "POST",
            data: { id: eventId, go: goesTo },
            success: function (data) {
                if (data == 'queryProblem') {
                    errorToast("Something get wrong. Try again later!");
                }
                if (data == 'privateEvent') {
                    window.location = url + "needPassword.php";
                }
                if (data == 'puplicEvent') {
                    window.location = url + "eventSettings.php";
                }
            }
        })
    });

    // Edit Poll
    $(document).on('click', '#editPollButton', function () {
        pollId = $(this).closest('.poll').attr('id');
        $.ajax({
            url: "includes/creator/loadEditPoll.inc.php",
            method: "POST",
            data: { id: pollId },
            success: function (data) {
                $('#editPollModal').html(data);
            }
        })
    });




    // Change playButton to stopButton
    $(document).on('click', '#playButton', function () {
        // Get pollID from div poll 
        pollId = $(this).closest('.poll').attr('id');
        // Get Question text
        pollQuestion = $('#poll' + pollId).text();
        $.ajax({
            url: "includes/creator/playPoll.inc.php",
            method: "POST",
            data: { id: pollId },
            success: function (data) {
                if (data == 'queryProblem') {
                    errorToast("Something get wrong to stop the poll. Try again later!");
                } else if (data == 'success') {
                    $.ajax({
                        // Load polls
                        url: "includes/creator/loadPolls.inc.php",
                        success: function (data) {
                            $('#loadPolls').html(data);
                            successToast("The poll '" + pollQuestion + "' poll is live!")
                        }
                    });
                }
            }
        });
    });
    // Change stopButton to playButton
    $(document).on('click', '#stopButton', function () {
        // Get pollID from div poll 
        pollId = $(this).closest('.poll').attr('id');
        // Get Question text
        pollQuestion = $('#poll' + pollId).text();
        $.ajax({
            url: "includes/creator/stopPoll.inc.php",
            method: "POST",
            data: { id: pollId },
            success: function (data) {
                if (data == 'queryProblem') {
                    errorToast("Something get wrong to stop the poll. Try again later!");
                }
                if (data == 'success') {
                    $.ajax({
                        // Load polls
                        url: "includes/creator/loadPolls.inc.php",
                        success: function (data) {
                            $('#loadPolls').html(data);
                            errorToast("The poll '" + pollQuestion + "' is not live!");
                        }
                    });
                }
            }
        })
    });

    // Show or Hide Answers
    $(document).on('click', '.showAnswers', function () {
        // Get pollID from div poll 
        pollId = $(this).closest('.poll').attr('id');
        // Get Question text
        pollQuestion = $('#poll' + pollId).text();
        value = $(this).attr('id');
        $.ajax({
            url: "includes/creator/showPollAnswers.inc.php",
            method: "POST",
            data: { id: pollId, value: value },
            success: function (data) {
                $.ajax({
                    // Load polls
                    url: "includes/creator/loadPolls.inc.php",
                    success: function (data) {
                        $('#loadPolls').html(data);
                        if (value == 0) {
                            successToast("The poll '" + pollQuestion + "' is showing the answers!");
                        } else {
                            successToast("The poll '" + pollQuestion + "' is hiding the answers!");
                        }
                    }
                });
            }
        })
    });

    // QA PAGE
    // Load Q&A Page
    getQA = getParameter('qa');
    if (getQA == 'review') {
        // Load List Poll
        $.ajax({
            url: "includes/creator/loadReviewQA.inc.php",
            success: function (data) {
                $('#loadQA').html(data);
            }
        });
    } else if (getQA == 'live') {
        // Load Live Poll
        $.ajax({
            url: "includes/creator/loadLiveQA.inc.php",
            success: function (data) {
                $('#loadQA').html(data);
            }
        });
    } else if (getQA == 'archive') {
        $.ajax({
            url: "includes/creator/loadArchiveQA.inc.php",
            success: function (data) {
                $('#loadQA').html(data);
            }
        });
    }

    $(document).on('click', '#acceptQuestion', function () {
        msgId = $(this).closest('.msgs').attr('id');
        msgContent = $('#messageLabel' + msgId).text();
        $.ajax({
            url: "includes/creator/acceptQuestion.inc.php",
            method: "POST",
            data: { id: msgId },
            success: function (data) {
                if (data == 'queryProblem') {
                    errorToast("Something get wrong. Try again later!");
                }
                if (data == 'accept') {
                    // Accept Question Complete
                    getQA = getParameter('qa');
                    if (getQA == 'archive') {
                        $.ajax({
                            url: "includes/creator/loadArchiveQA.inc.php",
                            success: function (data) {
                                $('#loadQA').html(data);
                                successToast("The message '" + msgContent + "' is live again!");
                            }
                        });
                    } else if (getQA == 'review') {
                        $.ajax({
                            url: "includes/creator/loadReviewQA.inc.php",
                            success: function (data) {
                                $('#loadQA').html(data);
                                successToast("The message '" + msgContent + "' is live!");
                            }
                        });
                    }
                }
            }
        });
    });

    // Delete Question Creator
    $(document).on('click', '#declineQuestion', function () {
        msgId = $(this).closest('.msgs').attr('id');
        msgContent = $('#messageLabel' + msgId).text();
        $.ajax({
            url: "includes/creator/declineQuestion.inc.php",
            method: "POST",
            data: { id: msgId },
            success: function (data) {
                if (data == 'queryProblem') {
                    errorToast("Something get wrong. Try again later!");
                }
                if (data == 'decline') {
                    // Accept Question Complete
                    getQA = getParameter('qa');
                    if (getQA == 'review') {
                        // Load List Poll
                        $.ajax({
                            url: "includes/creator/loadReviewQA.inc.php",
                            success: function (data) {
                                $('#loadQA').html(data);
                                successToast("The message '" + msgContent + "' has remove!");
                            }
                        });
                    } else if (getQA == 'live') {
                        // Load Live Poll
                        $.ajax({
                            url: "includes/creator/loadLiveQA.inc.php",
                            success: function (data) {
                                $('#loadQA').html(data);
                                successToast("The message '" + msgContent + "' has mark as answered!");
                            }
                        });
                    } else if (getQA == 'archive') {
                        $.ajax({
                            url: "includes/creator/loadArchiveQA.inc.php",
                            success: function (data) {
                                $('#loadQA').html(data);
                                successToast("The message '" + msgContent + "' has deleted!");
                            }
                        });
                    }
                }
            }
        });
    });

    // Highlight Question
    $(document).on('click', '#highlightQuestion', function () {
        msgId = $(this).closest('.msgs').attr('id');
        msgContent = $('#messageLabel' + msgId).text();
        let setValueForHighlight = $(this).closest('.msgs').hasClass("highlight");
        if (setValueForHighlight) {
            valueHighlight = 0;
        } else {
            valueHighlight = 1;
        }
        $.ajax({
            url: "includes/creator/highlightQuestion.inc.php",
            method: "POST",
            data: { id: msgId, valueHighlight: valueHighlight },
            success: function (data) {
                if (data == 'queryProblem') {
                    errorToast("Something get wrong. Try again later!");
                }
                if (data == 'highlight') {
                    $.ajax({
                        url: "includes/creator/loadLiveQA.inc.php",
                        success: function (data) {
                            $('#loadQA').html(data);
                            if (valueHighlight == 1) {
                                successToast("The message '" + msgContent + "' is highlight!");
                            } else {
                                successToast("The message '" + msgContent + "' is not highlight!");
                            }
                        }
                    });
                }
            }
        });
    });

    // Edit Message Modal
    // Send the values to Edit message Modal
    $(document).on('click', '#editCreatorQuestion', function () {
        msgId = $(this).closest('.msgs').attr('id');
        $('#msgId').hide();
        $('#msgId').val(msgId);
        $('#editMsgModal').removeData();
        message = $('#messageLabel' + msgId).text();
        message = message.replace('(edited)', '');
        $('#editMsgModal').text(message);
    })
    // Archive Question
    $(document).on('click', '#archiveQuestion', function () {
        msgId = $(this).closest('.msgs').attr('id');
        msgContent = $('#messageLabel' + msgId).text();
        $.ajax({
            url: "includes/creator/archiveQuestion.inc.php",
            method: "POST",
            data: { id: msgId },
            success: function (data) {
                if (data == 'queryProblem') {
                    errorToast("Something get wrong. Try again later!");
                }
                if (data == 'archive') {
                    $.ajax({
                        url: "includes/creator/loadLiveQA.inc.php",
                        success: function (data) {
                            $('#loadQA').html(data);
                            successToast("The message '" + msgContent + "' has moved to archived messages!")
                        }
                    });
                }
            }
        });
    });

    // Reply Creator to a Msg
    $(document).on('click', '#replyMsg, #replyQuestion', function () {
        msgId = $(this).closest('.msgs').attr('id');
        $.ajax({
            url: "includes/creator/showReplyMsgs.inc.php",
            method: "POST",
            data: { id: msgId },
            success: function (data) {
                $('#msgsForReply').html(data);
            }
        })
    })

    // Delete msg to Modal
    $(document).on('click', '#declineReplyQuestion', function () {
        mainMsgId = $('.mainMsg').attr('id');
        msgId = $(this).closest('.msgs').attr('id');
        msgContent = $('#messageLabel' + msgId).text();
        $.ajax({
            url: "includes/creator/deleteReplyMsg.inc.php",
            method: "POST",
            data: { id: msgId },
            success: function (data) {
                if (data == 'queryProblem') {
                    errorToast("Something get wrong. Try again later!");
                }
                if (data == 'delete') {
                    $.ajax({
                        url: "includes/creator/showReplyMsgs.inc.php",
                        method: "POST",
                        data: { id: mainMsgId },
                        success: function (data) {
                            $('#msgsForReply').html(data);
                            successToast("The message '" + msgContent + "' has deleted!")
                        }
                    })
                }
            }
        })
    })

    // Live QA Creator
    creatorQaGet = getParameter('qa');

    setInterval(() => {
        // LIVE liveQa - Creator
        if (creatorQaGet == 'live') {
            $.ajax({
                url: "includes/creator/liveQa.inc.php",
                success: function (data) {
                    if (data == 'queryProblem') {
                        errorToast("Something get wrong. Try again later!");
                    }
                    if (data == "diff") {
                        $.ajax({
                            url: "includes/creator/loadLiveQA.inc.php",
                            success: function (data) {
                                $('#loadQA').html(data);
                            }
                        });
                    }
                }
            });
        }
        // LIVE reviewQa - Creator
        if (creatorQaGet == 'review') {
            $.ajax({
                url: "includes/creator/loadLiveReviewQA.inc.php",
                success: function (data) {
                    if (data == 'queryProblem') {
                        errorToast("Something get wrong. Try again later!");
                    }
                    if (data == 'diff') {
                        $.ajax({
                            url: "includes/creator/loadReviewQA.inc.php",
                            success: function (data) {
                                $('#loadQA').html(data);
                            }
                        });
                    }
                }
            });
        }
        // LIVE archiveQa - Creator
        if (creatorQaGet == 'review') {
            $.ajax({
                url: "includes/creator/loadLiveArchiveQA.inc.php",
                success: function (data) {
                    if (data == 'queryProblem') {
                        errorToast("Something get wrong. Try again later!");
                    }
                    if (data == 'diff') {
                        $.ajax({
                            url: "includes/creator/loadArchiveQA.inc.php",
                            success: function (data) {
                                $('#loadQA').html(data);
                            }
                        });
                    }
                }
            });
        }
        // Notifivation for the review QA
        $.ajax({
            url: "includes/creator/notificationsQa.inc.php",
            success: function (data) {
                if (data == 'queryproblem') {
                    errorToast("Something get wrong. Try again later!");
                }
                if (data == 0) {
                    $('.countNotifications').hide();
                }
                if (data > 0) {
                    $('.countNotifications').html(data);
                    $('.countNotifications').show();
                }
            }
        })
        // Loop load polls at list polls
        $.ajax({
            url: "includes/creator/loadTimestampPolls.inc.php",
            success: function (data) {
                if (data == 'queryproblem') {
                    errorToast("Something get wrong. Try again later!");
                }
                if (data == 'diff') {
                    $.ajax({
                        url: "includes/creator/loadPolls.inc.php",
                        success: function (data) {
                            $('#loadPolls').html(data);
                        }
                    });
                }
            }
        })
    }, 1000);





    // Reply Guest to a Msg
    $(document).on('click', '#replyGuestMsg', function () {
        msgId = $(this).closest('.answers').attr('id');
        $.ajax({
            url: "includes/creator/showReplyMsgs.inc.php",
            method: "POST",
            data: { id: msgId },
            success: function (data) {
                $('#msgsGuests').html(data);
            }
        })
    })





    // GUEST 

    // Delete Question Guest
    $(document).on('click', '#deleteGuestQuestion', function () {
        msgId = $(this).closest('.answers').attr('id');

        $.ajax({
            url: "includes/creator/declineQuestion.inc.php",
            method: "POST",
            data: { id: msgId },
            success: function (data) {
                $.ajax({
                    url: "includes/guest/showMsgSend.inc.php",
                    success: function (data) {
                        $('#msgSend').html(data);
                    }
                })
                $.ajax({
                    url: "includes/guest/showQA.inc.php",
                    success: function (data) {
                        $('#loadPopularQA').html(data);
                    }
                })
            }
        });
    });



    guestGet = getParameter('room');
    if (guestGet == 'polls') {
        $.ajax({
            url: "includes/guest/showQueOrAns.inc.php",
            success: function (data) {
                if (data == "Q") {
                    $.ajax({
                        url: "includes/guest/loadLivePoll.inc.php",
                        success: function (data) {
                            $('#loadLivePoll').html(data);
                        }
                    });
                } else if (data == "A") {
                    $.ajax({
                        // Load poll answer
                        url: "includes/guest/loadPollAnswer.inc.php",
                        success: function (data) {
                            $('#loadLivePoll').html(data);
                        }
                    });
                }
                $('#loadLivePoll').html(data);
            }
        });
    } else if (guestGet == 'qa') {
        $.ajax({
            url: "includes/guest/showMsgSend.inc.php",
            success: function (data) {
                $('#msgSend').html(data);
            }
        })
        $.ajax({
            url: "includes/guest/showQA.inc.php",
            success: function (data) {
                $('#loadPopularQA').html(data);
            }
        })
    }

    $(document).on('click', '#nav-profile-tab', function () {
        $.ajax({
            url: "includes/guest/showRecentQA.inc.php",
            success: function (data) {
                $('#loadRecentQA').html(data);
            }
        })
    })

    // QA
    $(document).on('click', '#likeThumb', function () {
        msgId = $(this).closest('.answers').attr('id');
        replyId = $(this).closest('.reply').attr('id');
        if (replyId != undefined) {
            msgId = replyId;
        }
        likeValue = $('#likeValue' + msgId).text();
        hasLike = $(this).hasClass('blue');
        if (!hasLike) {
            $.ajax({
                url: "includes/guest/likeMsg.inc.php",
                method: "POST",
                data: { id: msgId, likes: likeValue },
                success: function (data) {
                    if (data == 0) {
                        $('#loadPopularQA').html("Problem with the Query. Try again later!");
                    }
                    if (data == 1) {
                        $.ajax({
                            url: "includes/guest/showQA.inc.php",
                            success: function (data) {
                                $('#loadPopularQA').html(data);
                            }
                        })
                    }
                }
            });
        } else {
            $.ajax({
                url: "includes/guest/unlikeMsg.inc.php",
                method: "POST",
                data: { id: msgId, likes: likeValue },
                success: function (data) {
                    if (data == 0) {
                        $('#loadPopularQA').html("Problem with the Query. Try again later!");
                    }
                    if (data == 1) {
                        $.ajax({
                            url: "includes/guest/showQA.inc.php",
                            success: function (data) {
                                $('#loadPopularQA').html(data);
                            }
                        })
                    }
                }
            });
        }
    });

    // Edit Message Modal
    // Send the values to Edit message Modal
    $(document).on('click', '#editGuestQuestion', function () {
        msgId = $(this).closest('.answers').attr('id');
        $('#msgId').hide();
        $('#msgId').val(msgId);
        $('#editMsgModal').removeData();
        message = $('#messageLabel' + msgId).text();
        message = message.replace('(edited)', '');
        $('#editMsgModal').text(message);
    })
    // Reset Modal
    $("#editMsg").on("hidden.bs.modal", function () {
        $(this).find('form').trigger('reset');
    });
    let userWriting = false;
    $(document).on('keyup', '#askQuestion', function () {
        let a = $('#askQuestion').val().length;
        if (a > 0) {
            userWriting = true;
        } else {
            userWriting = false;
        }
    })
    // Live QA Guest

    $(document).on('click', '#gusetSendMsg', function (event) {
        event.preventDefault();
        temp = 1;
        askQustion = $('#askQuestion').val();
        $.ajax({
            url: "includes/guest/sendMsg.inc.php",
            method: "POST",
            data: { msg: askQustion, sendMessage: temp },
            success: function (data) {
                if (data == 'queryProblem') {
                    errorToast("Something get wrong. Try again later!");
                }
                if (data == "msgSend") {
                    $.ajax({
                        url: "includes/guest/showMsgSend.inc.php",
                        success: function (data) {
                            if (data == 'queryProblem') {
                                errorToast("Something get wrong. Try again later!");
                            } else {
                                $('#msgSend').html(data).fadeIn();
                            }
                        }
                    })
                    $.ajax({
                        url: "includes/guest/showQA.inc.php",
                        success: function (data) {
                            if (data == 'queryProblem') {
                                errorToast("Something get wrong. Try again later!");
                            } else {
                                $('#loadPopularQA').html(data);
                            }
                        }
                    })
                    successToast("Message has send!");
                }
                if (data == 'msgReview') {
                    $('#askQuestion').val('');
                    successToast("Message has send to admin for review!");
                }
            }
        })
    })

    // GUEST - Poll / QA
    // Set Live Refresh for the guest
    guestQaGet = getParameter('room');
    if (guestGet == 'polls' || guestGet == 'qa') {
        eventId = getParameter('event');
        setInterval(() => {
            // Update All variables and move to live poll from QA
            $.ajax({
                url: "includes/guest/updateVariables.inc.php",
                success: function (data) {
                    if (data == 'eventNotExists') {
                        window.location = url + "index.php?error=eventHasDeleted";
                    }
                    // Code *1
                    if (data == 'queryProblem') {
                        errorToast("Something get wrong. Try again later!");
                    }

                    if (data == "newPoll") {
                        $('#liveIcon').show();
                        $.ajax({
                            url: "includes/guest/showQueOrAns.inc.php",
                            success: function (data) {
                                if (data == 'queryProblem') {
                                    errorToast("Something get wrong. Try again later!");
                                }
                                if (data == "Q") {
                                    $.ajax({
                                        url: "includes/guest/loadLivePoll.inc.php",
                                        success: function (data) {
                                            if (data == 'queryProblem') {
                                                errorToast("Something get wrong. Try again later!");
                                            } else {
                                                if (userWriting) {
                                                    successToast("There is a live poll!")
                                                } else {
                                                    window.location = url + "event.php?event=" + eventId + "&room=polls";
                                                }
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    }
                    if (data == "notActive") {
                        $('#liveIcon').hide();
                        if (guestGet == 'polls') {
                            window.location = url + "event.php?event=" + eventId + "&room=qa";
                        }
                    }

                    if (data == "activeSame") {
                        $('#liveIcon').show();
                    }
                }
            })
            // Load live QA
            if (guestQaGet == 'qa') {
                $.ajax({
                    url: "includes/creator/liveQa.inc.php",
                    success: function (data) {
                        console.log(data);
                        if (data == 'queryProblem') {
                            errorToast("Something get wrong. Try again later!");
                        }
                        if (data == "diff") {
                            $.ajax({
                                url: "includes/guest/showMsgSend.inc.php",
                                cache: false,
                                success: function (data) {
                                    if (data == 'queryProblem') {
                                        errorToast("Something get wrong. Try again later!");
                                    } else {
                                        $('#msgSend').html(data).fadeIn();
                                    }
                                }
                            })
                            $.ajax({
                                url: "includes/guest/showQA.inc.php",
                                cache: false,
                                success: function (data) {
                                    if (data == 'queryProblem') {
                                        errorToast("Something get wrong. Try again later!");
                                    } else {
                                        $('#loadPopularQA').html(data);
                                    }
                                }
                            })
                        }
                    }
                });
                // Check if not load msgs to load again
                checkTextError = $('#loadPopularQA').text();
                generalQuestions = $('#numQuestions').text();
                if (checkTextError == 0 && generalQuestions[0] != 0) {
                    $.ajax({
                        url: "includes/guest/showMsgSend.inc.php",
                        cache: false,
                        success: function (data) {
                            if (data == 'queryProblem') {
                                errorToast("Something get wrong. Try again later!");
                            } else {
                                $('#msgSend').html(data).fadeIn();
                            }
                        }
                    })
                    $.ajax({
                        url: "includes/guest/showQA.inc.php",
                        cache: false,
                        success: function (data) {
                            if (data == 'queryProblem') {
                                errorToast("Something get wrong. Try again later!");
                            } else {
                                $('#loadPopularQA').html(data);
                            }
                        }
                    })
                }
            }
            // Update Live Poll
            if (guestGet == 'polls') {
                $.ajax({
                    url: "includes/guest/pollTimestamp.inc.php",
                    success: function (data) {
                        if (data == 'queryProblem') {
                            errorToast("Something get wrong. Try again later!");
                        }
                        if (data == 'diff') {
                            $.ajax({
                                url: "includes/guest/showQueOrAns.inc.php",
                                success: function (data) {
                                    if (data == 'queryProblem') {
                                        errorToast("Something get wrong. Try again later!");
                                    }
                                    if (data == "Q") {
                                        $.ajax({
                                            url: "includes/guest/loadLivePoll.inc.php",
                                            success: function (data) {
                                                if (data == 'queryProblem') {
                                                    errorToast("Something get wrong. Try again later!");
                                                } else {
                                                    $('#loadLivePoll').html(data);
                                                }
                                            }
                                        });
                                    } else if (data == "A") {
                                        $.ajax({
                                            // Load poll answer
                                            url: "includes/guest/loadPollAnswer.inc.php",
                                            success: function (data) {
                                                if (data == 'queryProblem') {
                                                    errorToast("Something get wrong. Try again later!");
                                                } else {
                                                    $('#loadLivePoll').html(data);
                                                }
                                            }
                                        });
                                    }
                                    // $('#loadLivePoll').html(data);
                                }
                            });
                        }
                    }
                })
            }
        }, 3000);
    }
    // Select guest answer div
    $(document).on('click', '.pollAnswers', function () {
        // Get answerId 
        answerId = $(this).attr('id');
        $.ajax({
            url: "includes/guest/chooseAnswer.inc.php",
            method: "POST",
            data: { id: answerId },
            success: function (data) {
                $.ajax({
                    // Load poll answer
                    url: "includes/guest/loadPollAnswer.inc.php",
                    success: function (data) {
                        $('#loadLivePoll').html(data);
                    }
                });
                $('#loadLivePoll').html(data);
            }
        })
    });


    // Ajax Create Poll
    $("#savePoll").click(function () {
        saveButton = 1;
        launchButton = 0;
    })
    $("#launchPoll").click(function () {
        saveButton = 0;
        launchButton = 1;
    })
    $('#createPoll').submit(function (event) {
        let FormData;
        $('#errors').hide();
        event.preventDefault();
        poll_kind = $('#pollKind').val();
        stars = $('.check').length;

        const Buttons = {
            savePoll: saveButton,
            launchPoll: launchButton
        }
        if (poll_kind == 1) {
            FormData = $(this).serialize();
        } else if (poll_kind == 4) {
            FormData = $(this).serialize();
            FormData += '&stars=' + stars;

        }
        $.ajax({
            type: "POST",
            url: "includes/creator/createPoll.inc.php",
            data: { data: FormData, buttons: Buttons },
            success: function (data) {
                if (data == "emptyQuestion") {
                    errorToast("Question is required!");
                }
                if (data == "emptyAnwers") {
                    errorToast("You need at least 2 answers to create poll!");
                }
                if (data == "createPoll") {
                    window.location = url + "polls.php?poll=list&success=createPoll";
                }
                if (data == "queryProblem") {
                    window.location = url + "polls.php?poll=list&error=stmtfailed";
                }
            }
        });
    })

    // Edit Poll - Submit
    $('#editPollForm').submit(function (event) {
        event.preventDefault();
        let test = 0;
        $('#errors').hide();
        pollKindId = $('.title').attr('id');
        pollId = $(this).closest('.poll').attr('id');
        let formData = 'pollKind=' + pollKindId + '&';
        if (pollKindId == 'MP') {
            // Multiple Choice Data
            formData += $(this).serialize();
        } else if (pollKindId == 'RG') {
            // Raiting Data

            stars = $('.check').length;
            formData += $(this).serialize();
            formData += '&stars=' + stars;
        }

        $.ajax({
            type: "POST",
            url: "includes/creator/saveEditPoll.inc.php",
            data: { data: formData },
            success: function (data) {
                if (data == "emptyquestion") {
                    errorToast('Question is required!')
                }
                if (data == "answerNeedValue") {
                    errorToast('The Correct Answer is empty!');
                }
                if (data == "min2answers") {
                    errorToast('You must have at least 2 answers!');
                }
                if (data == "success") {
                    window.location = url + "polls.php?poll=list&success=editpoll";
                }
                if (data == "queryProblem") {
                    window.location = url + "polls.php?poll=list&error=stmtfailed";
                }
            }
        });
    })

    // Guest Send star answer
    $(document).on('click', '#sendStarAnswer', function (e) {
        let findAnswer = $('.check').length;
        pollId = $('.questionStar').attr('id');
        $.ajax({
            type: "POST",
            url: "includes/guest/chooseStarAnswer.inc.php",
            data: { id: pollId, answer: findAnswer },
            success: function (data) {
                if (data == 'queryProblem') {
                    errorToast("Something get wrong. Try again later!");
                }
                if (data == 'success') {
                    $.ajax({
                        url: "includes/guest/showQueOrAns.inc.php",
                        success: function (data) {
                            if (data == 'queryProblem') {
                                errorToast("Something get wrong. Try again later!");
                            }
                            if (data == "Q") {
                                $.ajax({
                                    url: "includes/guest/loadLivePoll.inc.php",
                                    success: function (data) {
                                        if (data == 'queryProblem') {
                                            errorToast("Something get wrong. Try again later!");
                                        } else {
                                            $('#loadLivePoll').html(data);
                                        }
                                    }
                                });
                            } else if (data == "A") {
                                $.ajax({
                                    // Load poll answer
                                    url: "includes/guest/loadPollAnswer.inc.php",
                                    success: function (data) {
                                        if (data == 'queryProblem') {
                                            errorToast("Something get wrong. Try again later!");
                                        } else {
                                            $('#loadLivePoll').html(data);
                                        }
                                    }
                                });
                            }
                        }
                    });
                }
            }
        })
    })

});




function getParameter(parameterName) {
    let parameter = new URLSearchParams(window.location.search);
    return parameter.get(parameterName);
}

function copyLink() {
    /* Get the text field */
    var copyText = document.getElementById("shareLink");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */

    /* Copy the text inside the text field */
    document.execCommand("copy");

    /* Alert the copied text */

    // $('#successCopy').html("Copied!")
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
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr["success"]('Share Link is copied!')
}



