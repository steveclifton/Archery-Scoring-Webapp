<div class="col-md-2" id="sidebar" role="navigation" style="padding-top: 10px">

    <ul class="nav" style="padding-top: 14px">
        <?php
            $weeks = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15'];

            foreach ($weeks as $week) {
                echo "<li><a href=\"/week?week=$week\" style='text-decoration: underline; font-size: 12pt;'>Week $week</a></li>";
            }
        ?>
    </ul>
    <br><br>

</div>
