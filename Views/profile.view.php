<div id="legend">
    <legend>Update Details</legend>
</div>
<input type="button" value="Hide" id="profileformbutton" class="btn btn-warning">
<hr>

<form class="form-horizontal" action="/userprofileupdate" method="POST" id="userprofileform">
    <fieldset>
        <div class="control-group">
            <label class="control-label">ANZ Number</label>
            <div class="controls">
                <input type="text" id="anz_num" name="anz_num" class="input-xlarge"
                       value="<?= $viewData['user']['anz_num'] ?>" disabled>
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
                    <option value="recurve_bb" id="Recurve_bb">Recurve Barebow</option>
                    <option value="longbow" id="Longbow">Longbow</option>
                    <option value="crossbow" id="Crossbow">Crossbow</option>
                </select>
            </div>
            <input type="hidden" id="prefered_type" value="<?= $_SESSION['prefered_type'] ?>">
        </div>
        <br>
        <div class="control-group">
            <div class="controls">
                <button class="btn btn-success" id="update">Update</button>
            </div>
        </div>
    </fieldset>
</form>
<br><br>

<div id="legend">
    <legend>Associated Archers</legend>
</div>
<form class="form-inline" action="/updateassociateduser" method="POST" name="addassocusers">
    <div class="form-group">
        <input type="text" class="form-control" name="name" placeholder="Full Name">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="anz_num" placeholder="Anz Number">
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="Request Access"></input>
</form>
<hr>

<div class="table-responsive" id="ffff">
    <table class="table table-bordered table-hover table-sm">
        <thead>
        <tr>
            <th style="text-align: center">ANZ #</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">Email</th>
            <th style="text-align: center">Club</th>
            <th style="text-align: center">Access</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($viewData['access_users'] as $user) { ?>
            <tr>
                <form action="/updateassociateduser" method="post">
                    <td><input class="form-control" type="text" value="<?= $user['anz_num'] ?>" name="anz_num" readonly></td>
                    <td><input class="form-control" type="text" value="<?= $user['first_name'] ?> <?= $user['last_name'] ?>" name="full_name" readonly></td>
                    <td><input class="form-control" type="text" value="<?= $user['email'] ?>" name="email" readonly></td>
                    <td><input class="form-control" type="text" value="<?= $user['club'] ?>" name="club" readonly></td>
                    <td style="text-align: center"><input type="submit" name="submit" class="btn btn-danger" value="Remove"></td>
                </form>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>