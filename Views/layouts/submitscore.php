
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/i18n/defaults-*.min.js"></script>

<div class="form-group" style="margin-left: 22px">
    <form action="/submitscore" method="POST" name="scoreform" onsubmit="return validateForm()">
        <h3 style="margin-left: 14px">Submit <?= $_SESSION['first_name'] ?>'s score here!</h3>
        <div class="col-md-2">
            <input type="text" id="score" class="form-control" name="score" placeholder="Score" required>
        </div>
        <div class="col-md-2">
            <input type="text" id="xcount" class="form-control" name="xcount" placeholder="X-Count" required>
        </div>
        <div class="col-md-3">
            <select name="division" id="division" class="selectpicker show-menu-arrow">
                <option value="compound">Compound</option>
                <option value="recurve">Recurve</option>
                <option value="recurve_bb">Recurve Barebow</option>
                <option value="longbow">Longbow</option>
                <option value="crossbow">Crossbow</option>
            </select>
        </div>
        <div class="col-md-2">
            <input id="submit" type="submit" name="submit" class="btn btn-success" value="Submit">
        </div>
        <input type="hidden" name="week" value="<?= $_GET['week'] ?>">
        <br>
    </form>
</div>
<div id="row">
    <p id="incorrect" style="color: red"></p>
</div>
<br>
<hr>