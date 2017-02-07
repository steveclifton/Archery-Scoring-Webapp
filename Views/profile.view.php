<div class="container">
    <div class="row">
    <legend>Update Details</legend>
    <input type="button" value="Show" id="profileformbutton" class="btn btn-warning">
    <hr>
    <form class="form-horizontal hidden" action="/#" method="POST" id="userprofileform" onsubmit="return checkProfileUpdate()">
        <fieldset>
            <div class="control-group">
                <label class="control-label">ANZ Number</label>
                <div class="controls">
                    <input type="text" id="anz_num" name="anz_num" class="input-xlarge"
                           value="<?= $viewData['user']['anz_num'] ?>" readonly>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">First Name</label>
                <div class="controls">
                    <input type="text" id="first_name" name="first_name" placeholder="" class="input-xlarge"
                           value="<?= $viewData['user']['first_name'] ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Last Name</label>
                <div class="controls">
                    <input type="text" id="last_name" name="last_name" placeholder="" class="input-xlarge"
                           value="<?= $viewData['user']['last_name'] ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                    <input type="email" id="email" name="email" placeholder="" class="input-xlarge"
                           value="<?= $viewData['user']['email'] ?>" required>
                </div>
            </div>

<!--            Update Password-->
            <div class="control-group">
                <!-- Password-->
                <label class="control-label">Update Password</label>
                <div class="controls">
                    <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <!-- Password-->
                <label class="control-label">Confirm Password</label>
                <div class="controls">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="" class="input-xlarge">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Club</label>
                <div class="controls">
                    <input type="text" id="club" name="club" class="input-xlarge" value="<?= $viewData['user']['club'] ?>"
                           required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Phone Number</label>
                <div class="controls">
                    <input type="text" id="phone" name="phone" class="input-xlarge"
                           value="<?= (isset($viewData['user']['phone']) ? $viewData['user']['phone'] : ""); ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Address</label>
                <div class="controls">
                    <textarea name="address" class="input-xlarge" rows="4"
                              cols="30"><?= (isset($viewData['user']['address']) ? $viewData['user']['address'] : ""); ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <!-- Prefered Bow Type-->
                <label class="control-label">Prefered Bow Type</label><br>
                <div class="bow">
                    <select name="prefered_type" id="division">
                        <option value="compound" id="Compound">Compound</option>
                        <option value="recurve" id="Recurve">Recurve</option>
                        <option value="recurve barebow" id="Recurve_bb">Recurve Barebow</option>
                        <option value="longbow" id="Longbow">Longbow</option>
                        <option value="crossbow" id="Crossbow">Crossbow</option>
                    </select>
                </div>
                <input type="hidden" id="prefered_type" value="<?= $_SESSION['prefered_type'] ?>">
            </div>
            <br>
            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-success" id="updateProfile">Update</button>
                </div>
            </div>
        </fieldset>
    </form>
    </div>
    <div class="row">
    <legend>Associated Archers</legend>
    <form class="form-inline" action="/updateassociateduser" method="POST" name="addassocusers">
        <div class="form-group">
            <input type="text" class="form-control" name="anz_num" placeholder="Anz Number">
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Request Access"></input>
    </form>
    </div>
    <hr>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm">
                <thead>
                <tr>
                    <th style="text-align: center">ANZ #</th>
                    <th style="text-align: center">Name</th>
                    <th style="text-align: center">Club</th>
                    <th style="text-align: center">Access</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($viewData['access_users'] as $user) { ?>
                        <tr>
                            <form action="/updateassociateduser" method="post">
                                <td><input style="text-align: center" class="form-control" type="text" value="<?= $user['anz_num'] ?>" name="anz_num" readonly></td>
                                <td><input style="text-align: center" class="form-control" type="text" value="<?= ucwords($user['first_name']) . " " . ucwords($user['last_name']) ?>" name="full_name" readonly></td>
                                <td><input style="text-align: center" class="form-control" type="text" value="<?= $user['club'] ?>" name="club" readonly></td>
                                <td style="text-align: center"><input type="submit" name="submit" class="btn btn-danger" value="Remove"></td>
                            </form>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>