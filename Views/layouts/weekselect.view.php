<div class="container">
    <div class="row" id="testing">
        <div class="col-xs-2 col-xs-offset-3 col-sm-2 col-sm-offset-5 col-md-2 col-md-offset-5">
            <select class="selectpicker" id="archeryselect">
                <option value="overall">Overall Results</option>
                <?php
                    $weeks = new \Archery\Controllers\Admin();
                    // TODO
                    $weeks = $weeks->getCurrentWeek(3);
                    if (isset($_SESSION['id'])) { ?>
                        <option value="myscores">My Scores</option>
                    <?php } ?>
                    <?php
                    for ($i = 1; $i <= $weeks; $i++) { ?>
                        <option value='week=<?= $i ?>'>Week <?= $i ?></option>
                    <?php } ?>
            </select>
            <p hidden id="currentWeek">week=<?=$weeks ?></p>
        </div>
    </div>
</div>