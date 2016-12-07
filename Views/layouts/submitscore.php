<?php if(isset($viewData['error'])) {echo "HERE";}?>

<div class="form-group" style="margin-left: 22px">
    <form action="/submitscore" method="POST" name="scoreform" onsubmit="return validateForm(this)">
        <h3 style="margin-left: 14px">Submit <?= $_SESSION['first_name'] ?>'s score here!</h3>

        <div class="col-md-2">
            <input type="text" id="score" class="form-control" name="score" placeholder="Score" required>
        </div>

        <div class="col-md-2">
            <input type="text" id="xcount" class="form-control" name="xcount" placeholder="X-Count" required>
        </div>

        <div class="col-md-3">
            <div class="bow">
            <select name="division" id="division">
                <option value="compound" id="Compound">Compound</option>
                <option value="recurve" id="Recurve">Recurve</option>
                <option value="recurve_bb" id="Recurve_bb">Recurve Barebow</option>
                <option value="longbow" id="Longbow">Longbow</option>
                <option value="crossbow" id="Crossbow">Crossbow</option>
            </select>
            </div>
        </div>

        <div class="col-md-2">
            <input id="submit" type="submit" name="submit" class="btn btn-success" value="Submit">
        </div>
        <input type="hidden" name="week" value="<?= $_GET['week'] ?>">
        <input type="hidden" id="prefered_type" value="<?= $_SESSION['prefered_type'] ?>">

        <br>
    </form>
</div>
<div id="row">
    <p id="incorrect" style="color: red"></p>
</div>
<br>