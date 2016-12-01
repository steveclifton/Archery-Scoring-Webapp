<div class="form-group" style="margin-left: 22px">
    <form action="/submitscore" method="POST" name="scoreform" onsubmit="return validateForm()">
        <h3 style="margin-left: 14px">Submit <?= $_SESSION['first_name'] ?>'s score here!</h3>
        <div class="col-md-2">
            <input type="text" id="score" class="form-control" name="score" placeholder="Score" required>
        </div>
        <div class="col-md-2">
            <input type="text" id="xcount" class="form-control" name="xcount" placeholder="X-Count" required>
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