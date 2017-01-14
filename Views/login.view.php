<h2 style="font-family: 'Droid Sans', sans-serif; text-align: center; ">Week <?= $viewData['current_week']?> Results</h2>
<div class="container">
    <?php foreach ($viewData['scores'] as $key => $value) {?>
        <div class="table-responsive">
            <h3 style="text-align: center;"><?= ucwords($key); ?></h3>
            <table class="table table-bordered table-hover table-condensed">
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
                        <td><?= $vData['average'] ?></td>
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
