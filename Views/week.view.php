<h2 style="text-align: center;">Week <?= $_GET['week']; ?> Results</h2>

<?php
//if (isset($_SESSION['id'])) {
//    include('Views/layouts/submitscore.php');
//    echo "<hr>";
//}
//
//?>

<div id="legend">
    <legend>Submit Scores</legend>
</div>
<form class="form-inline" action="/submitscore" method="POST" name="scoreform" onsubmit="return validateForm(this)">
    <div class="form-group">
        <input class="form-control" type="text" value="<?= $_SESSION['first_name'] ?> <?= $_SESSION['last_name'] ?>" name="full_name" readonly>
    </div>

        <div class="form-group">
        <input type="text" id="score" class="form-control" name="score" placeholder="Score" required>
    </div>
    <div class="form-group">
        <input type="text" id="xcount" class="form-control" name="xcount" placeholder="X-Count" required>
    </div>
    <div class="form-group">
        <div class="bow">
            <select name="division" id="division">
                <option value="compound" id="Compound">Compound</option>
                <option value="recurve" id="Recurve">Recurve</option>
                <option value="recurve_bb" id="Recurve_bb">Recurve Barebow</option>
                <option value="longbow" id="Longbow">Longbow</option>
                <option value="crossbow" id="Crossbow">Crossbow</option>
            </select>
        </div>
        <input type="hidden" name="anz_num" id="anz_num" value="<?= $_SESSION['anz_num'] ?>">
        <input type="hidden" name="week" id="week_num" value="<?= $_GET['week'] ?>">
        <input type="hidden" id="prefered_type" value="<?= $_SESSION['prefered_type'] ?>">
    </div>

    <input type="submit" class="btn btn-primary" name="submit" value="Submit"></input>
    <div id="row">
        <p id="incorrect" style="color: red; padding-left: 36px"></p>
    </div>
</form>

<hr>


<div class="table-responsive">
    <div class="container">

        <h3 style="text-align: center;">Compound</h3>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Score</th>
                    <th>X-Count</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $i = 1;
                foreach ($viewData as $data) { ?>
                    <?php if ($data['division'] == 'compound') {?>
                    <tr>
                        <th scope="row"> <?php echo $i; $i++; ?></th>
                        <td> <?= $data['first_name'] ?></td>
                        <td> <?=$data['last_name'] ?></td>
                        <td> <?=$data['score'] ?></td>
                        <td> <?=$data['xcount'] ?></td>
                    </tr>
                        <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <h3 style="text-align: center;">Recurve</h3>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Score</th>
                <th>X-Count</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($viewData as $data) { ?>
                <?php if ($data['division'] == 'recurve') {?>
                    <tr>
                        <th scope="row"> <?php echo $i; $i++; ?></th>
                        <td> <?= $data['first_name'] ?></td>
                        <td> <?=$data['last_name'] ?></td>
                        <td> <?=$data['score'] ?></td>
                        <td> <?=$data['xcount'] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
        </table>
        <h3 style="text-align: center;">Recurve Barebow</h3>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Score</th>
                <th>X-Count</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($viewData as $data) { ?>
                <?php if ($data['division'] == 'recurve-bb') {?>
                    <tr>
                        <th scope="row"> <?php echo $i; $i++; ?></th>
                        <td> <?= $data['first_name'] ?></td>
                        <td> <?=$data['last_name'] ?></td>
                        <td> <?=$data['score'] ?></td>
                        <td> <?=$data['xcount'] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
        </table>
        <h3 style="text-align: center;">Longbow</h3>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Score</th>
                <th>X-Count</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($viewData as $data) { ?>
                <?php if ($data['division'] == 'longbow') {?>
                    <tr>
                        <th scope="row"> <?php echo $i; $i++; ?></th>
                        <td> <?= $data['first_name'] ?></td>
                        <td> <?=$data['last_name'] ?></td>
                        <td> <?=$data['score'] ?></td>
                        <td> <?=$data['xcount'] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>