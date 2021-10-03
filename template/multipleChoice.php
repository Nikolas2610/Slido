<div class="mb-3">
    <input type="text" class="form-control" id="question" placeholder="What would you like to ask?" name="question">
</div>
<div class="form-check mb-3">
    <button class="btn btn-success" id="addAnswer" type="button">Add answer</button>
</div>
<!-- Oprions -->
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
</div>