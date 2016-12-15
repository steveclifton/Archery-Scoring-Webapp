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
                <input type="text" id="club" name="club" class="input-xlarge" value="<?= $viewData['user']['club'] ?>" required>
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
