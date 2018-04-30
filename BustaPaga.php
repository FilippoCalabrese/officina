<?php
include 'queryFunctions.php';
include 'connection.php';
include 'head.php';
?>

<script type="text/javascript">
    $(document).ready( function () {
    $('#usertable').dataTable({
      "pageLength": 60,
        responsive: true,
        "scrollX": true,
        dom: "Bfrtip",
        buttons: [
            'excel',
            'print',
            'pdf'
        ]
    });
    } );
  </script>

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
