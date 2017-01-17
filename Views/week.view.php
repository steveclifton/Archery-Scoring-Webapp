<div class="row">
    <?php include('layouts/weekselect.view.php') ?>
</div>

<div class="container">
    <hr>
    <div id="subscores">
        <?php
        if (isset($_SESSION['id'])) {
            echo "<legend>Submit Scores</legend>";
            foreach ($viewData['archers'] as $archer) { ?>
                <form class="form-inline" action="/submitscore" method="POST" name="scoreform"
                      onsubmit="return validateForm(this)" style="padding-top: 10px">
                    <div class="form-group">
                        <input class="form-control" type="text"
                               value="<?= $archer['first_name'] ?> <?= $archer['last_name'] ?>" name="full_name"
                               readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" id="score" class="form-control" name="score" placeholder="Score" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="xcount" class="form-control" name="xcount" placeholder="X-Count"
                               required>
                    </div>
                    <!--Select Bow Division data-->
                    <div class="form-group">
                        <div class="bows">
                            <select name="division" id="division" required>
                                <option disabled selected value> -- select divison -- </option>
                                <option value="compound" id="Compound">Compound</option>
                                <option value="recurve" id="Recurve">Recurve</option>
                                <option value="recurve barebow" id="Recurve_bb">Recurve Barebow</option>
                                <option value="longbow" id="Longbow">Longbow</option>
                                <option value="crossbow" id="Crossbow">Crossbow</option>
                            </select>
                        </div>
                    </div>
                    <!--Hidden data-->
                    <div class="form-group">
                        <input type="hidden" name="anz_num" id="anz_num" value="<?= $archer['anz_num'] ?>">
                        <input type="hidden" name="week" id="week_num" value="<?= $_GET['week'] ?>">
                    </div>
                    <input type="submit" class="btn btn-success" name="submit" value="Submit"></input>
                    <div id="row">
                        <p id="incorrect" style="color: red; padding-left: 36px"></p>
                    </div>
                </form>
            <?php } ?>
        <?php } ?>
    </div>
    <p style="color: red"><?php if (isset($_SESSION['invalidscore'])) echo $_SESSION['invalidscore']; unset($_SESSION['invalidscore']);?></p>

    <?php if (isset($_SESSION['id'])) { ?>
        <form class="form-inline" action="/addtempuser" method="POST" name="scoreform" style="padding-top: 10px">
            <input type="button" value="Add Another Archer" id="addarcherbutton" class="btn btn-warning">
            <div class="form-group hidden" id="searcharcherform">
                <input type="text" name="anz_num" id="searcharcher" class="form-control"
                       placeholder="Search ANZ Number">
                <input type="submit" id="addsubmit" class="btn btn-success" name="submit" value="Add!"></input>
            </div>
            <input type="hidden" name="week" id="week_num" value="<?= $_GET['week'] ?>">
        </form>
    <?php } ?>
</div>

<div class="container">
    <?php foreach ($viewData['scores'] as $key => $value) {?>
    <div class="table">
        <h3 style="text-align: center;"><?= ucwords($key); ?></h3>
        <table class="table table-bordered table-hover" id="table-<?= ucwords($key); ?>">
            <thead>
                <tr>
                    <th class="col-sm-1 col-md-1">#</th>
                    <th class="col-sm-1 col-md-2">Name</th>
                    <th class="col-sm-1 col-md-2">Average</th>
                    <th class="col-sm-1 col-md-2">Handicap Score</th>
                    <th class="col-sm-1 col-md-2">X-Count</th>
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
    <?php } ?>
</div>
