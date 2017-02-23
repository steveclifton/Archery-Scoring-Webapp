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
                        <th class="col-md-1">Join_Users ID</th>
                        <th class="col-md-1">User_ID</th>
                        <th class="col-md-1">Associate_ID</th>
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
                            <td><input type="text" value="<?= $user['user_id'] ?>" name="user_id"></td>
                            <td><input type="text" value="<?= $user['associate_id'] ?>" name="associate_id"></td>
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
                <div class="control-group">
                    <label class="control-label">Current Event</label>
                    <div class="controls">
                        <input type="text" id="currentevent" name="currentevent" placeholder="" class="input-xlarge"
                               value="<?= $viewData['current_event'] ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Current Round Distance</label>
                    <div class="controls">
                        <input type="text" id="currentround" name="currentround" placeholder="" class="input-xlarge"
                               value="<?= $viewData['current_round'] ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Max Score</label>
                    <div class="controls">
                        <input type="text" id="maxscore" name="maxscore" placeholder="" class="input-xlarge"
                               value="<?= $viewData['max_score'] ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Max X-Count</label>
                    <div class="controls">
                        <input type="text" id="maxxcount" name="maxxcount" placeholder="" class="input-xlarge"
                               value="<?= $viewData['max_xcount'] ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Database Table Name</label>
                    <div class="controls">
                        <input type="text" id="tablename" name="tablename" placeholder="" class="input-xlarge"
                               value="<?= $viewData['db_name'] ?>" required>
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

