<nav class="nav navbar-light bg-light">
  <ul class="nav me-auto m-1 mx-auto justify-content-center">
    <li class="nav-item">
      <a class="nav-link text-dark" aria-current="page" href="event.php?event=<?php
                                                                              echo $_SESSION['guest_event_id']; ?>&room=qa" id="qa">Q&A</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-dark" href="event.php?event=<?php echo $_SESSION['guest_event_id']; ?>&room=polls" id="polls">Polls <span class="badge bg-danger <?php if (isset($_SESSION['poll_id'])) {
                                                                                                                                                                  if ($_SESSION['poll_id'] == -1) {
                                                                                                                                                                    echo "noneDisplay";
                                                                                                                                                                  }
                                                                                                                                                                } else {
                                                                                                                                                                  echo "noneDisplay";
                                                                                                                                                                } ?>  " id="liveIcon">Live</span></a>
    </li>
  </ul>

</nav>