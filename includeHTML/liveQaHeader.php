<!-- With tabs -->
<ul class="nav nav-tabs navbar-light bg-light">
  <li class="nav-item">
    <a class="nav-link text-dark" aria-current="page" href="?qa=review">For review <span class="badge bg-danger countNotifications<?php
                                                                                                                                  if (isset($_SESSION['count_notifications_Qa'])) {
                                                                                                                                    if ($_SESSION['count_notifications_Qa'] == 0) {
                                                                                                                                      echo ' noneDisplay">4';
                                                                                                                                    } else {
                                                                                                                                      echo '">' . $_SESSION['count_notifications_Qa'];
                                                                                                                                    }
                                                                                                                                  }
                                                                                                                                  ?></span></a>
  </li>
  <li class=" nav-item">
        <a class="nav-link text-dark" href="?qa=live">Live</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-dark" href="?qa=archive">Archive</a>
  </li>
</ul>