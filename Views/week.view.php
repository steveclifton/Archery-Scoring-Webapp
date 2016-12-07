<h2 style="text-align: center;">Week <?= $_GET['week']; ?> Results</h2>
<hr>

<?php
if (isset($_SESSION['id'])) {
    include('Views/layouts/submitscore.php');
    echo "<hr>";
}

?>


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