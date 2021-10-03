$(function () {
    // Declare Variables
    let textarea = false;

    // Nav bar add class
    const getLastItem = thePath => thePath.substring(thePath.lastIndexOf('/') + 1);
    let pathname = getLastItem(window.location.pathname);
    $(' .navbar-nav > li > a[href="' + pathname + '"]').addClass('active');


    var options = {
        max_value: 10,
        step_size: 1,
        initial_value: 5
    }

    $(document).on('mouseover', '.starGuest',function () {
        let countStars = $('.starGuest').length;
        let starId = $(this).attr('id');
        for (let i = 0; i < countStars; i++) {
            if (i < starId) {
                $('#' + (i+1)).css('color', 'yellow');
                $('#' + (i+1)).addClass('check');
            } else {
                $('#' + (i+1)).css('color', 'white');
                $('#' + (i+1)).removeClass('check');
            }
        }
    })
  
    $(document).on('click', '.formStar', function(){
        starid = $(this).attr('id');
        for (let i = 1; i < 11; i++) {
            if (i < starid) {
                $('#' + (i+1)).removeClass('bi-star');
                $('#' + (i+1)).addClass('bi-star-fill');
                $('#' + (i+1)).addClass('check');
            } else {
                $('#' + (i+1)).removeClass('bi-star-fill');
                $('#' + (i+1)).addClass('bi-star');
                $('#' + (i+1)).removeClass('check');
            }
        }
    });

    const RATING = `<div class="mb-3">
            <input type="text" class="form-control" id="question" placeholder="What would you like to ask for rating?" name="question">
        </div>
        <div class="mb-3 text-center">
            <p class="starsText">Choose how many stars (Max stars: 10)</p>
        </div>
        <div class="mb-3 text-center">
            <div class="text-dark" id="stars">
                <i class="bi bi-star-fill formStar check" id="2"></i>
                <i class="bi bi-star-fill formStar check" id="3"></i>
                <i class="bi bi-star-fill formStar check" id="4"></i>
                <i class="bi bi-star-fill formStar check" id="5"></i>
                <i class="bi bi-star-fill formStar check" id="6"></i>
                <i class="bi bi-star formStar" id="7"></i>
                <i class="bi bi-star formStar" id="8"></i>
                <i class="bi bi-star formStar" id="9"></i>
                <i class="bi bi-star formStar" id="10"></i>
                <i class="bi bi-star formStar" id="11"></i>
            </div>
        </div>
        <div class="mb-3 text-center">
            <div class="alert alert-danger noneDisplay" role="alert" id="errors">Empty Question</div>
        </div>
        </div>`;

    const MULTIPLE_CHOICE = `
    <div class="mb-3">
        <input type="text" class="form-control" id="question" placeholder="What would you like to ask?" name="question">
    </div>
    <div class="form-check mb-3">
        <button class="btn btn-success" id="addAnswer" type="button">Add answer</button>
    </div>
    <div id="pollAnswers">
        <div class="form-check mb-3">
            <div class="row align-items-center">
                <div class="col-1">
                    <input class="form-check-input markAnswer" type="checkbox" id="flexSwitchCheckDefault" name="correctAnswer1" disabled>
                </div>
                <div class="col-11">
                    <input type="text" class="form-control option" placeholder="Add option" name="option1">
                </div>
            </div>
        </div>
        <div class="form-check mb-3">
            <div class="row align-items-center">
                <div class="col-1">
                    <input class="form-check-input markAnswer" type="checkbox" id="flexSwitchCheckDefault" name="correctAnswer2" disabled>
                </div>
                <div class="col-11">
                    <input type="text" class="form-control option" placeholder="Add option" name="option2">
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="markAnswers" name="markAnswers">
            <label class="form-check-label" for="markAnswers">
                Mark Correct Answers
            </label>
        </div>
    </div>
    </div>`; 

    // Choose Poll Kind
    $(document).on('click', '#pollKind', function () {
        pollKind = $('#pollKind').val();
        if (pollKind == 1) {
            $('#printPollForm').html(MULTIPLE_CHOICE)
        } else if (pollKind == 4) {
            $('#printPollForm').html(RATING);
            // $('#stars').rate(options);
        }
    })

    // Datepicker for start date
    $("#startDate").datepicker({
        showAnim: "fadeIn",
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd-mm-yy",
        minDate: 0,
        onClose: function (selectedDate) {
            // Set the start date for the endDate calendar
            $("#endDate").datepicker("option", "minDate", selectedDate);
        }
    });
    // Datepicker for end date
    $("#endDate").datepicker({
        dateFormat: "dd-mm-yy"
    });
    // Create private event
    $("#privateEvent").click(function () {
        if (document.getElementById('privateEvent').checked) {
            $('#eventPassword').removeAttr('disabled');
            $('#eventConfirmPassword').removeAttr('disabled');
        } else {
            $('#eventPassword').prop('disabled', true);
            $('#eventConfirmPassword').prop('disabled', true);
        }
    })



    // Create Poll MODAL
    // Mark answers For create poll
    $("#markAnswers").click(function () {
        if ($('#markAnswers').is(":checked")) {
            $('.markAnswer').removeAttr('disabled');
            $('.markAnswer').removeAttr('disabled');
        } else {
            $('.markAnswer').prop('disabled', true);
            $('.markAnswer').prop('disabled', true);
        }
    })
    // Mark answers For edit poll
    $(document).on('click', '#markEditAnswers', function () {
        if (document.getElementById('markEditAnswers').checked) {
            $('.markEditAnswer').removeAttr('disabled');
            $('.markEditAnswer').removeAttr('disabled');
        } else {
            $('.markEditAnswer').prop('disabled', true);
            $('.markEditAnswer').prop('disabled', true);
        }
    })
    // Enable Next answer label for Edit Poll
    $(document).on('click', '#addEditAnswer', function () {
        hasAnswers = $('.markEditAnswer').length;
        if (hasAnswers < 8) {
            hasAnswers++;
            if (document.getElementById('markEditAnswers').checked) {
                checked = '';
            } else {
                checked = 'disabled';
            }
            $('#pollEditAnswers').append(`<div class="form-check mb-3">
                        <div class="row align-items-center">
                            <div class="col-1">
                                <input class="form-check-input markEditAnswer" type="checkbox" id="flexSwitchCheckDefault" name="correctAnswer`+ hasAnswers + `" ` + checked + `>
                            </div>
                            <div class="col-11">
                                <input type="text" class="form-control option" placeholder="Add option" name="option`+ hasAnswers + `">
                            </div>
                        </div>
                    </div>`);
        } else {
            $('#pollEditAnswers').append(`<div class="form-check mb-3">
                    <div class="row align-items-center">
                        <div class="col alert alert-danger">
                            Max 8 answers
                        </div>
                    </div>
                </div>`);
            $('#addEditAnswer').prop('disabled', true);
        }
    });






    // Enable Next answer label for Create Poll
    answers = 2;
    $(document).on('click', '#addAnswer', function () {
        if (answers < 8) {
            answers++;
            $('#pollAnswers').append(`<div class="form-check mb-3">
                <div class="row align-items-center">
                    <div class="col-1">
                        <input class="form-check-input markAnswer" type="checkbox" id="flexSwitchCheckDefault" name="correctAnswer`+ answers + `" disabled>
                    </div>
                    <div class="col-11">
                        <input type="text" class="form-control option" placeholder="Add option" name="option`+ answers + `">
                    </div>
                </div>
            </div>`);
        } else {
            $('#pollAnswers').append(`<div class="form-check mb-3">
            <div class="row align-items-center">
                <div class="col alert alert-danger">
                    Max 8 answers
                </div>
            </div>
        </div>`);
            $('#addAnswer').prop('disabled', true);
        }
    });

    // Enable Next email label
    let emails = 1;
    $('#addEmail').click(function () {
        if (emails < 4) {
            emails++;
            $('#addEmails').append(`
                    <div class="row align-items-center mb-3">
                        <div class="col">
                            <input type="text" class="form-control option" placeholder="Add email" name="email`+ emails + `">
                        </div>
                    </div>`);
        } else {
            $('#addEmails').append(`
                <div class="row align-items-center mb-3">
                    <div class="col alert alert-danger">
                        Max 4 answers
                    </div>
                </div>`);
            $('#addAnswer').prop('disabled', true);
        }
    });





    

});

