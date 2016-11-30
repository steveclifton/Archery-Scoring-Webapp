<div class="col-md-2" id="sidebar" role="navigation" style="padding-top: 10px">

    <ul class="nav" style="padding-top: 14px">
        <?php
            if (isset($_SESSION['id'])) {
                echo "<a class=\"btn-success btn pull-left\" href='/submitscore' style=\"margin-left: 20px\">Submit Score!</a><br><br><br>";
            } else {
                echo "<br><br><br>";
            }


            $weeks = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '9', '10', '11', '12', '13', '14', '15'];

            foreach ($weeks as $week) {
                echo "<li><a href=\"/week?week=$week\" style='text-decoration: underline; font-size: 12pt;'>Week $week</a></li>";
            }
        ?>
    </ul>
    <br><br>

</div>
