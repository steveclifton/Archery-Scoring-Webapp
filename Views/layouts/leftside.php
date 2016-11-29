<div class="col-md-2" id="sidebar" role="navigation" style="padding-top: 10px">

    <ul class="nav" style="padding-top: 14px">
        <?php
            if (isset($_SESSION['id'])) {
                echo "<a class=\"btn-success btn pull-left\" href='/submitscore'>Submit Score!</a><br><br><br>";
            } else {
                echo "<br><br><br>";
            }


            $weeks = ['1', '2', '3', '4', '5'];

            foreach ($weeks as $week) {
                print "<li><a href=\"#\">Week $week</a></li>";
            }
        ?>
    </ul>

</div>
