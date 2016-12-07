<?php
if (isset($_SESSION['id'])) {
    if (!isset($userResults)) {
        include('Views/layouts/submitscore.php');
    }
}
?>
<div class="table-responsive">
    <div class="container">
        <h2>Week <?= $_GET['week']; ?> Results</h2>
        <p>Current weeks results</p>
        <h2>Compound</h2>
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
        <h2>Recurve</h2>
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
    </div>
</div>