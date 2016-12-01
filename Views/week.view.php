<?php
if (isset($_SESSION['id'])) {
    if (!isset($userResults)) {
        include('Views/layouts/submitscore.php');
    }
}

?>


<div class="table-responsive">
    <div class="container">
        <h2>Results</h2>
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
            <tr>
                <td>Mary</td>
                <td>Moe</td>
                <td>359</td>
                <td>31</td>
            </tr>
            <tr>
                <td>July</td>
                <td>Dooley</td>
                <td>358</td>
                <td>31</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>