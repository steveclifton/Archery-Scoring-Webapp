

<form action="/submitscore" method="post">
    <div class="form-group">
            <h3 style="margin-left: 14px">Submit <?= $_SESSION['first_name']?>'s score here!</h3>
            <div class="col-md-2">
                <input type="text" id="score" class="form-control" name="score" placeholder="Score" required>
            </div>
            <div class="col-md-2">
                <input type="text" id="xcount" class="form-control" name="xcount" placeholder="X-Count" required>
            </div>
            <div class="col-md-2">
                <input type="submit" name="submit" class="btn btn-danger" value="submit">
            </div>

    </div>
</form>
