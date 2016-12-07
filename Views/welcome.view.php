<h2>Welcome <?= $viewData['first_name'] ?></h2>
<h4>Current submitted scores</h4>
<div class="table-responsive">
    <div class="container">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Week</th>
                    <th>Score</th>
                    <th>X-Count</th>
                    <th>Division</th>
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
