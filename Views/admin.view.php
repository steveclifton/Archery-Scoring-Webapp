<h3>Pending Users : <?= count($viewData['pending_users'])?></h3>
<input type="button" value="Show" id="pendingbutton" class="btn btn-danger">
<hr>

<div class="table-responsive" id="pendingusers">
    <div class="container">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Anz Num</th>
                <th>Email</th>
                <th>Club</th>
                <th>Authorise</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($viewData['pending_users'] as $user) { ?>
                    <tr>
                        <form action="/confirmusers" method="POST" name="usersconfirm">
                            <td><input type="text" value="<?= $user['first_name'] ?>" name="first_name"></td>
                            <td><input type="text" value="<?= $user['last_name'] ?>" name="last_name"></td>
                            <td><input type="text" value="<?= $user['anz_num'] ?>" name="anz_num"></td>
                            <td><input type="text" value="<?= $user['email'] ?>" name="email"></td>
                            <td><input type="text" value="<?= $user['club'] ?>" name="club"></td>
                            <td><input id="submit" type="submit" name="submit" class="btn btn-success" value="Authorise">
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

