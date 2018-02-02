<?php
include('queryFunctions.php');
include('connection.php');
include('head.php');
?>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php
        echo showUserWorkedTimeInRange($_POST['usernamePaga'], $_POST['startTimePaga'], $_POST['endTimePaga'], $link);
         ?>
      </div>
    </div>
  </div>

</body>
