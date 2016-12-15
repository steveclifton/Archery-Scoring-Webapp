<form class="form-horizontal" action="/userprofile" method="POST">
    <fieldset>
        <div id="legend">
            <legend>Update Details</legend>
        </div>
        <div class="control-group">
            <label class="control-label">ANZ Number</label>
            <div class="controls">
                <input type="text" id="anz_num" name="anz_num" class="input-xlarge" value="<?= $viewData['user']['anz_num'] ?>" disabled>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">First Name</label>
            <div class="controls">
                <input type="text" id="first_name" name="first_name" placeholder="" class="input-xlarge" value="<?= $viewData['user']['first_name'] ?>" required>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Last Name</label>
            <div class="controls">
                <input type="text" id="last_name" name="last_name" placeholder="" class="input-xlarge" value="<?= $viewData['user']['last_name'] ?>" required>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Email</label>
            <div class="controls">
                <input type="email" id="email" name="email" placeholder="" class="input-xlarge" value="<?= $viewData['user']['email'] ?>" required>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Club</label>
            <div class="controls">
                <input type="text" id="club" name="club" class="input-xlarge" value="<?= $viewData['club'] ?>" required>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Date of Birth (dd/mm/yyyy)</label>
            <div class="controls">
                <input type="text" id="dob" name="dob" class="input-xlarge" value="<?= (isset($viewData['dob']) ? $viewData['dob'] : ""); ?>" required>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Phone Number</label>
            <div class="controls">
                <input type="text" id="phone" name="phone" class="input-xlarge" value="<?= (isset($viewData['user']['phone']) ? $viewData['user']['phone'] : ""); ?>" required>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Address</label>
            <div class="controls">
                <textarea name="address" class="input-xlarge" rows="4" cols="30"><?= (isset($viewData['user']['address']) ? $viewData['user']['address'] : ""); ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Gender</label><br>
            <select name="gender" id="gender" class="selectpicker show-menu-arrow">
                <option value=""></option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div class="control-group">
            <!-- Prefered Bow Type-->
            <label class="control-label">Prefered Bow Type</label><br>
            <select name="prefered_type" id="prefered_type" class="selectpicker show-menu-arrow">
                <option value="compound">Compound</option>
                <option value="recurve">Recurve</option>
                <option value="recurve_bb">Recurve Barebow</option>
                <option value="longbow">Longbow</option>
                <option value="crossbow">Crossbow</option>
            </select>
        </div>
        <br><br>
        <div class="control-group">
            <div class="controls">
                <button class="btn btn-success" id="register">Register</button>
            </div>
        </div>
        <?php
        if (isset($viewData['success'])) {
            if ($viewData['success'] === true) {
                echo "<p style='color: green;;'>Success</p>";
            } else {
                echo "<p style='color: red'>Account Creation Failed, please check details and try again</p>";
            }

        }
        ?>
    </fieldset>
</form>
<br><br>
