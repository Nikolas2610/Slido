    <!-- Share Link or Invite People Modal -->
    <div class="modal fade bg-dark bg-gradient" id="shareEvent" tabindex="-1" aria-labelledby="shareEventLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-info bg-gradient">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareEventLabel">Share Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="includes/creator/invitePeople.inc.php">
                        <div class="mb-3">
                            <label for="shareLink" class="form-label">Share link:</label>
                            <div class="row align-items-center">
                                <div class="col-11">
                                    <input type="text" class="form-control" id="shareLink" name="shareLink">
                                </div>
                                <div class="col-1">
                                    <i class="bi bi-clipboard" id="copyLink"></i>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col mb-3" id="successCopy"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-success" id="addEmail" type="button">Add new email</button>
                        </div>
                        <!-- Oprions -->
                        <div id="addEmails">
                            <div class="row align-items-center mb-3">
                                <div class="col">
                                    <input type="email" class="form-control option" placeholder="Add email" name="email1">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="inviteByEmail">Invite</button>
                </div>
                </form>
            </div>
        </div>
    </div>