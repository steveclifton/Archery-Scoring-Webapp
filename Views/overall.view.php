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


    <div class="row" id="overall">
        <div class="col-xs-2 col-xs-offset-3 col-sm-2 col-sm-offset-5 col-md-2 col-md-offset-5">
            <select class="selectpicker" id="overallSelector">
                <option value="compound">Compound</option>
                <option value="recurve">Recurve</option>
                <option value="recurvebb">Recurve Barebow</option>
                <option value="longbow">Longbow</option>
            </select>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div id="legend">
                <legend class="">Averages</legend>
            </div>
            <div class="table">
                <table class="table table-bordered table-hover table-responsive" id="tableAverages">
                    <thead>
                        <tr>
                            <th class="col-sm-1 col-md-1">#</th>
                            <th class="col-sm-1 col-md-3">Name</th>
                            <th class="col-sm-1 col-md-3">Score</th>
                            <th class="col-sm-1 col-md-2">X-Count</th>
                            <th class="col-sm-1 col-md-2">Top 10 Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        foreach ($viewData['averages'] as $archer) { ?>
                            <tr>
                                <td id="rank"> <?= $i++; ?></td>
                                <td> <?= ucwords($archer['first_name']) . " " . ucwords($archer['last_name']) ?></td>
                                <td> <?= $archer['average_score'] ?></td>
                                <td> <?= $archer['average_x'] ?></td>
                                <td> <?= $archer['top10'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-sm-6 col-md-6">
            <div id="legend">
                <legend class="">Points</legend>
            </div>
            <div class="table">
                <table class="table table-bordered table-hover table-responsive" id="tablePoints">
                    <thead>
                        <tr>
                            <th class="col-sm-1 col-md-1">#</th>
                            <th class="col-sm-1 col-md-3">Name</th>
                            <th class="col-sm-1 col-md-3">Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($viewData['points'] as $archer) { ?>
                            <tr>
                                <td id="rank"> <?= $i++; ?></td>
                                <td> <?= ucwords($archer['first_name']) . " " . ucwords($archer['last_name']) ?></td>
                                <td> <?= $archer['top_ten_points'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<br><br><br><br>




