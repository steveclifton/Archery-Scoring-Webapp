<div class="row">
    <?php include('layouts/weekselect.view.php') ?>
    <br>
</div>


<div class="container">

<!--    Button to show and hide the scoring-->
    <?php if (isset($_SESSION['id']) && ($_GET['week'] == $_SESSION['current_week'])) { ?>
        <div class="row">
            <div class="col-xs-2 col-xs-offset-4 col-sm-2 col-sm-offset-5 col-md-2 col-md-offset-5">
                <input type="button" value="Scoring" id="openScoring" class="btn btn-success" style="margin-left: 40%">
            </div>
        </div>
    <?php } ?>

<?php if (isset($_SESSION['id'])) { ?>
    <div class="hidden" id="scoringTable">
        <div class="row" id="subscores">
            <legend>Submit Scores</legend>
            <p>Only enter scores for those who shot this week</p>
            <div class="table" id="scoreTable">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="col-xs-3 col-sm col-md-1" id="name">Name</th>
                            <th class="hidden-xs hidden-sm col-md-1" id="anznum">ANZ Num</th>
                            <th class="col-xs-6 col-md-1" id="score">Score</th>
                            <th class="col-xs-6 col-md-1" id="xcount">X-Count</th>
                            <th class="col-xs-1 col-sm-1 col-md-1" id="division">Division</th>
                            <th class="hidden-xs hidden-sm hidden-md hidden-lg" id="name" hidden>Week</th>
                        </tr>
                    </thead>
                    <?php foreach ($viewData['archers'] as $archer) {?>
                    <tbody>
                        <tr class="archer">
                            <td><span class="name"><?= ucfirst($archer['first_name']) . " " . ucfirst($archer['last_name']) ?></span></td>
                            <td class="hidden-xs hidden-sm"><input type="text" id="anz_num" class="form-control" value="<?= $archer['anz_num'] ?>" readonly></td>
                            <td><input type="text" id="score" class="form-control" placeholder="Score" ></td>
                            <td><input type="text" id="xcount" class="form-control" placeholder="X" ></td>
                            <td>
                                <select class="selectpicker" id="div" data-width="fit">
                                    <option value="compound" <?php if ($archer['prefered_type'] == 'compound') echo "selected"; ?>>Compound</option>
                                    <option value="recurve" <?php if ($archer['prefered_type'] == 'recurve') echo "selected"; ?>>Recurve</option>
                                    <option value="recurve barebow" <?php if ($archer['prefered_type'] == 'recurve barebow') echo "selected"; ?>>Recurve Barebow</option>
                                    <option value="longbow" <?php if ($archer['prefered_type'] == 'longbow') echo "selected"; ?>>Longbow</option>
                                    <option value="crossbow" <?php if ($archer['prefered_type'] == 'crossbow') echo "selected"; ?>>Crossbow</option>
                                </select>
                            </td>
                            <td class="hidden-xs hidden-sm hidden-md hidden-lg"><span class="week"><?= $_GET['week'] ?></td>
                        </tr>
                    </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-xs col-xs col-md-1" style="padding-left: 0px">
                <button class="btn btn-success" id="submit">Submit</button>
            </div>
<!--            <div class="col-xs col-sm col-md-2">-->
<!--                <label>-->
<!--                    <input class="col-xs" type="checkbox" id="correctScores" style="margin-top: 10px"> Scores Correct-->
<!--                </label>-->
<!--            </div>-->
            <div class="col-xs col-sm col-md-2">
                <i class="fa fa-spinner fa-spin" style="font-size:40px" id="spinning"></i>
            </div>
        </div>

        <div class="row">
            <form class="form-inline" action="#" id="form<?=$i?>" onsubmit="return false" style="padding-top: 10px; ">
                <div class="form-group" >
                    <div class="col-xs col-sm-2 col-md-2" style="padding-left: 0px" >
                        <input class="form-control" type="text" placeholder="ANZ Num" id="searcharcher">
                    </div>
                </div>
                <div class="form-group" id="addArcher">
                    <div class="col-xs col-sm-2 col-md-2">
                        <button class="btn btn-warning " id="addArcherButton">Add Archer for Scoring</button>
                    </div>
                </div>
            </form>
            <div class="validation"></div>
        </div>
    </div>
<?php } ?>
    <br><br>
    <?php foreach ($viewData['scores'] as $key => $value) { ?>

    <div class="row">
        <legend><?= ucwords($key); if ($key == 'recurve barebow') {$key = 'recurvebb';}?></legend>
        <div class="table">
            <table class="table table-bordered table-hover table-responsive" id="table-<?= $key; ?>">
                <thead>
                    <tr>
                        <th class="col-sm-1 col-md-1">#</th>
                        <th class="col-sm-1 col-md-3">Name</th>
                        <th class="col-sm-1 col-md-3">Average</th>
                        <th class="col-sm-1 col-md-3">X</th>
                        <th class="col-sm-1 col-md-3">Score</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i = 1;
                    foreach ($value as $vKey => $vData) { ?>

                        <tr>
                            <td id="rank"> <?= $i++; ?></td>
                            <td> <?= ucfirst($vData['first_name']) . " " . ucfirst($vData['last_name']) ?></td>
                            <td> <?= $vData['average'] ?></td>
                            <td> <?= $vData['xcount'] ?></td>
                            <td> <?= $vData['score'] ?></td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php } ?>
</div>





