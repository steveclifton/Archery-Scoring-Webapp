<div class="container">
    <div class="row" id="testing">
        <div class="col-xs-2 col-xs-offset-3 col-sm-2 col-sm-offset-5 col-md-2 col-md-offset-5">
            <select class="selectpicker">
                <?php
                    $weeks = new \Archery\Configurations\Event();
                    $weeks = $weeks->getCurrentWeek();
                    if (isset($_SESSION['id'])) { ?>
                        <option value="welcome">My Scores</option>
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