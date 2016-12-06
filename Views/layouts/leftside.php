<div class="col-md-2" id="sidebar" role="navigation" style="padding-top: 10px">

    <ul class="nav" style="padding-top: 14px">
        <?php
            $weeks = new \Archery\Configurations\Event();
            $weeks = $weeks->getCurrentWeek();

            for ($i = 1; $i <= $weeks; $i++) {
                echo "<li><a href=\"/week?week=$i\" style='text-decoration: underline; font-size: 12pt;'>Week $i</a></li>";
            }
        ?>
    </ul>
    <br><br>

</div>
