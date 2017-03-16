<div class="container">
    <h3><a href="/create_event">Create Event</a></h3>
    
    <h3>Pending Users : <?= count($viewData['pending_users']) ?></h3>
    <input type="button" value="Show" id="pendingbutton" class="btn btn-danger">
    <hr>
    <div class="row">
        <div class="table hidden" id="pendingusers">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="col-md-1">User_ID</th>
                        <th class="col-md-1">First Name</th>
                        <th class="col-md-1">Last Name</th>
                        <th class="col-md-1">Anz Num</th>
                        <th class="col-md-1">Email</th>
                        <th class="col-md-1">Authorise</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($viewData['pending_users'] as $user) { ?>
                    <tr>
                        <form action="/confirmusers" method="POST" name="usersconfirm">
                            <td><input type="text" value="<?= $user['id'] ?>" name="id"></td>
                            <td><input type="text" value="<?= $user['first_name'] ?>" name="first_name"></td>
                            <td><input type="text" value="<?= $user['last_name'] ?>" name="last_name"></td>
                            <td><input type="text" value="<?= $user['anz_num'] ?>" name="anz_num"></td>
                            <td><input type="text" value="<?= $user['email'] ?>" name="email"></td>
                            <td><input id="submit" type="submit" name="submit" class="btn btn-success"
                                       value="Authorise">
                            </td>
                        </form>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="row">
        <form class="form-horizontal" action="/updatesetup" method="POST">
            <div>
                <legend class="">Archery System Setup</legend>
            </div>
            <fieldset>
                <div class="control-group">
                    <label class="control-label">Current Week Number</label>
                    <div class="controls">
                        <input type="text" id="currentweek" name="currentweek" class="input-xlarge"
                               value="<?= $viewData['current_week'] ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Number of Weeks</label>
                    <div class="controls">
                        <input type="text" id="numweeks" name="numweeks" placeholder="" class="input-xlarge"
                               value="<?= $viewData['num_weeks'] ?>" required>
                    </div>
                </div>
                <br>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-success" id="update">Update</button>
                    </div>
                </div>
                <div>
                    <h5 style="color: red;"><?php if (isset($viewData['updated'])) {
                            echo "Updated Successfully";
                        } ?></h5>
                </div>
            </fieldset>
        </form>
    </div>
</div>

