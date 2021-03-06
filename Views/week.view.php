<div class="container">
    <div class="row">
        <h2 style="font-family: 'Droid Sans', sans-serif; text-align: center;">2017 Indoor League Series</h2>
        <hr>
    </div>

    <div class="row">
        <?php include('layouts/weekselect.view.php') ?>
        <br>
    </div>
    <p hidden id="selectedWeek">week=<?php if (isset($viewData['weekRequested'])) {echo $viewData['weekRequested'];} else echo $viewData['current_week'] ?></p>

    <!--    Button to show and hide the scoring-->
    <?php if (isset($_SESSION['id']) && isset($viewData['canScore'])) { ?>
        <div class="row">
            <div class="col-xs-2 col-xs-offset-4 col-sm-2 col-sm-offset-5 col-md-2 col-md-offset-5">
                <input type="button" value="Scoring" id="openScoring" class="btn btn-success" style="margin-left: 40%">
            </div>
        </div>
        <?php if (isset($_SESSION['id']) && $_SESSION['user_type'] == 'admin') { ?>
            <br>
            <div class="row">
                <div class="col-xs-2 col-xs-offset-4 col-sm-2 col-sm-offset-5 col-md-2 col-md-offset-5">
                    <input type="button" value="Testing" id="testingButton" class="btn btn-success" style="margin-left: 40%">
                </div>
            </div>
            <br>
        <?php } ?>

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
                                <td><span class="name"><?= ucfirst($archer['first_name']) . " " . ucwords(  $archer['last_name']) ?></span></td>
                                <td class="hidden-xs hidden-sm"><input type="text" id="anz_num" class="form-control" value="<?= $archer['anz_num'] ?>" readonly></td>
                                <td><input type="text" id="score" class="form-control" placeholder="Score" ></td>
                                <td><input type="text" id="xcount" class="form-control" placeholder="X" ></td>
                                <td>
                                    <select class="selectpicker" id="div" data-width="70%">
                                        <option value="compound" <?php if ($archer['prefered_type'] == 'compound') echo "selected"; ?>>Compound</option>
                                        <option value="recurve" <?php if ($archer['prefered_type'] == 'recurve') echo "selected"; ?>>Recurve</option>
                                        <option value="recurve barebow" <?php if ($archer['prefered_type'] == 'recurve barebow') echo "selected"; ?>>Recurve BB</option>
                                        <option value="longbow" <?php if ($archer['prefered_type'] == 'longbow') echo "selected"; ?>>LongBow</option>
                                    </select>
                                </td>
                                <td class="hidden-xs hidden-sm hidden-md hidden-lg"><span class="week"><?= $viewData['current_week'] ?></td>
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
                <table class="table table-bordered table-hover table-responsive" id="table-<?= $key; ?>" >
                    <thead>
                        <tr>
                            <th class="col-xs-1 col-sm-1 col-md-1">#</th>
                            <th class="col-xs-1 col-sm-1 col-md-3">Name</th>
                            <th class="col-xs-1 col-sm-1 col-md-3">Score</th>
                            <th class="col-xs-1 col-sm-1 col-md-3">X</th>
                            <th class="col-xs-1 col-sm-1 col-md-1">Average</th>
                            <th class="hidden-xs hidden-sm col-xs-1 col-sm-1 col-md-1">Handicap</th>
                            <th class="hidden-xs hidden-sm col-xs-1 col-sm-1 col-md-1">Points</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        foreach ($value as $vKey => $vData) { ?>
                            <tr>
                                <td id="rank"> <?= $i++; ?></td>
                                <td> <?= ucfirst($vData['first_name']) . " " . ucfirst($vData['last_name']) ?></td>
                                <td> <?= $vData['score'] ?></td>
                                <td> <?= $vData['xcount'] ?></td>
                                <td> <?= $vData['average_score'] ?></td>
                                <td class="hidden-xs hidden-sm"> <?= $vData['handicap_score'] ?> </td>
                                <td class="hidden-xs hidden-sm"> <?= $vData['points'] ?> </td>
                            </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
</div>





