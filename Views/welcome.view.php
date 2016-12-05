<h2>Welcome <?= $viewData['first_name'] ?></h2>
<h4><li>Current submitted scores</li></h4>
<div class="table-responsive">
    <div class="container">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Week</th>
                    <th>Score</th>
                    <th>X-Count</th>
                </tr>
        </thead>
        <tbody>
            <?php
            foreach ($viewData['scores'] as $data) {
                echo "<tr>";
                    echo "<td>" . $data['week'] . "</td>";
                    echo "<td>" . $data['score'] . "</td>";
                    echo "<td>" . $data['xcount'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

