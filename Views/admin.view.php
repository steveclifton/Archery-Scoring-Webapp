<div class="container">
    <div class="row">
        <h3><a href="/create_event">Create Event</a></h3>
    </div>
    <hr>
    <div class="row">
        <h3>Edit users score</h3>

    </div>
    <hr>

    <div class="row">
        <h3>Pending Users : <?= count($viewData['pending_users']) ?></h3>
        <input type="button" value="Show" id="pendingbutton" class="btn btn-danger">
        <br><br>
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
    <hr>
    <div class="row">
        <h3>List of current users</h3>
        <div class="table">
            <table class="table table-bordered table-hover table-responsive" id="currentusers" >
                <thead>
                <tr>
                    <th class="col-xs-1 col-sm-1 col-md-2">ID</th>
                    <th class="col-xs-1 col-sm-1 col-md-2">ANZ Number</th>
                    <th class="col-xs-1 col-sm-1 col-md-2">Firstname</th>
                    <th class="col-xs-1 col-sm-1 col-md-2">Lastname</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($viewData['users'] as $data) { ?>
                    <tr>
                        <td><?= $data['id'] ?></td>
                        <td><?= $data['anz_num'] ?></td>
                        <td><?= ucfirst($data['first_name']) ?></td>
                        <td><?= ucfirst($data['last_name']) ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
    </div>
    <hr>





    <div class="row">
        <select class="selectpicker" id="adminEvents">
            <?php foreach ($viewData['events'] as $event) {?>
                <option value="<?= $event['id'] ?>"><?= $event['name'] ?></option>
            <?php } ?>
        </select>
        <br><br>


        <form class="form-horizontal" action="/updatesetup" method="POST">
            <div>
                <legend class="">Archery System Setup</legend>
            </div>
            <fieldset>
                <div class="control-group">
                    <label class="control-label">Current Week Number</label>
                    <div class="controls">
                        <input type="text" id="currentEventWeek" name="currentEventWeek" class="input-xlarge" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Number of Weeks</label>
                    <div class="controls">
                        <input type="text" id="currentEventNumWeeks" name="currentEventNumWeeks" placeholder="" class="input-xlarge" required>
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
                        } ?>
                    </h5>
                </div>
            </fieldset>
        </form>
    </div>
</div>

