<?php
if (isset($_SESSION['id'])) {
    if (!isset($userResults)) {
        include('Views/layouts/submitscore.php');
    }
}
?>
<div class="form-group">
    <form action="/week" method="post" name="scoreform" onsubmit="return validateForm()">
        <h3 style="margin-left: 14px">Submit <?= $_SESSION['first_name'] ?>'s score here!</h3>
        <div class="col-md-2">
            <input type="text" id="score" class="form-control" name="score" placeholder="Score" required>
        </div>
        <div class="col-md-2">
            <input type="text" id="xcount" class="form-control" name="xcount" placeholder="X-Count" required>
        </div>
        <div class="col-md-2">
            <input id="submit" type="submit" name="submit" class="btn btn-danger" value="Submit">
        </div>
        <input type="hidden" name="week" value="<?= $_GET['num'] ?>">
        <br>
    </form>
</div>
<div id="row">
    <p id="incorrect" style="color: red"></p>
</div>