<?php
if (isset($_SESSION['id'])) {
    if (!isset($userResults)) {
        include('Views/layouts/submitscore.php');
    }
}

?>


<div class="table-responsive">
    <div class="container">
        <h2>Week <?= $_GET['week'] ?> Results</h2>
        <p>Current weeks results</p>
        <table class="table table-condensed">
            <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Score</th>
                <th>X-Count</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($viewData as $data) {
                    echo "<tr>";
                    echo "<td>" . $data['first_name'] . "</td>";
                    echo "<td>" . $data['last_name'] . "</td>";
                    echo "<td>" . $data['score'] . "</td>";
                    echo "<td>" . $data['xcount'] . "</td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
    </div>
</div>