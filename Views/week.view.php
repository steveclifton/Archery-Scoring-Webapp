<div class="row">
    <?php include('layouts/weekselect.view.php') ?>
</div>


<?php if (isset($_SESSION['id'])) { ?>
<div class="container">
    <div class="row" id="subscores">
        <div class="container">
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
                        <td><span class="name"><?= $archer['first_name'] . " " . $archer['last_name'] ?></span></td>
                        <td class="hidden-xs hidden-sm"><input type="text" id="anz_num" class="form-control" value="<?= $archer['anz_num'] ?>" readonly></td>
                        <td><input type="text" id="score" class="form-control" placeholder="Score" ></td>
                        <td><input type="text" id="xcount" class="form-control" placeholder="X-Count" ></td>
                        <td>
                            <select class="selectpicker" id="div" data-width="50%">
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
    </div>


    <div class="row">
        <div class="col-xs col-md-1"">
        <button class="btn btn-success" id="submit">Submit</button>
    </div>
    <div class="col-xs col-md-2">
        <p><input type="checkbox" id="correctScores">Scores Correct</p>
    </div>



    <div class="row">
        <form class="form-inline" action="#" id="form<?=$i?>" onsubmit="return false" style="padding-top: 10px">
            <div class="form-group">
                <div class="col-xs col-sm-2 col-md-2">
                    <input class="form-control" type="text" placeholder="ANZ Num" id="searcharcher">
                </div>
            </div>
            <div class="form-group" id="addArcher">
                <div class="col-xs col-sm-2 col-md-2">
                    <button class="btn btn-warning " id="addArcherButton">Add Archer for Scoring</button>
                </div>
            </div>
        </form>
        <div class="validation">
        </div>
    </div>

<?php } ?>

<br><br>
<?php foreach ($viewData['scores'] as $key => $value) {?>

    <div class="row">
        <div class="container">
            <legend><?= ucwords($key); ?></legend>
            <div class="table">
                <table class="table table-bordered table-hover" id="table-<?= ucwords($key); ?>">
                    <thead>
                        <tr>
                            <th class="col-sm-1 col-md-1">#</th>
                            <th class="col-sm-1 col-md-2">Name</th>
                            <th class="col-sm-1 col-md-2">Average</th>
                            <th class="col-sm-1 col-md-2">Handicap Score</th>
                            <th class="col-sm-1 col-md-2">X</th>
                            <th class="col-sm-1 col-md-2">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        foreach ($value as $vKey => $vData) { ?>
                            <tr>
                                <td> <?= $i++; ?></td>
                                <td> <?= $vData['first_name'] . " " . $vData['last_name'] ?></td>
                                <td> <?= $vData['average'] ?></td>
                                <td> <?= ($vData['score'] + $vData['handicap']) ?></td>
                                <td> <?= $vData['xcount'] ?></td>
                                <td> <?= $vData['score'] ?></td>
                            </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php } ?>
</div>





