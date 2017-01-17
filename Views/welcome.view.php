<h2>Welcome <?= $viewData['first_name'] ?></h2>
<div class="row">
    <?php include('layouts/weekselect.view.php') ?>
</div>
<h4>Current submitted scores</h4>
<div class="container">
    <div class="table">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="col-sm-1 col-md-1">Week</th>
                    <th class="col-sm-1 col-md-1">Score</th>
                    <th class="col-sm-1 col-md-1">X</th>
                    <th class="col-sm-1 col-md-1">Division</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($viewData['scores'] as $data) { ?>
                    <tr>
                        <td> <?= $data['week'] ?> </td>
                        <td> <?= $data['score'] ?> </td>
                        <td> <?= $data['xcount'] ?> </td>
                        <td> <?= ucfirst($data['division']) ?> </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
