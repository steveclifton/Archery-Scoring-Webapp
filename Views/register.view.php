<form class="form-horizontal" action="/register" method="POST">
    <fieldset>
        <div id="legend">
            <legend class="">Request A New Account</legend>
            <p>Accounts are usually approved within 24-Hours</p>
        </div>
        <div class="control-group">
            <label class="control-label" for="first_name">First Name</label>
            <div class="controls">
                <input type="text" id="first_name" name="first_name" placeholder="" class="input-xlarge" required>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="last_name">Last Name</label>
            <div class="controls">
                <input type="text" id="last_name" name="last_name" placeholder="" class="input-xlarge" required>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="password">Email</label>
            <div class="controls">
                <input type="email" id="email" name="email" placeholder="" class="input-xlarge" required>
            </div>
        </div>
        <div class="control-group">
            <!-- Password-->
            <label class="control-label" for="password">Password</label>
            <div class="controls">
                <input type="password" id="password" name="password" placeholder="" class="input-xlarge" required>
            </div>
        </div>
        <div class="control-group">
            <!-- Password-->
            <label class="control-label" for="password">Confirm Password</label>
            <div class="controls">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="" class="input-xlarge" required>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"  for="student_id">ANZ Number</label>
            <div class="controls">
                <input type="text" id="anz_num" name="anz_num" class="input-xlarge" required>
            </div>
        </div>
        <div class="control-group">
            <!-- Club-->
            <label class="control-label" for="password">Club</label>
            <div class="controls">
                <input type="text" id="club" name="club" class="input-xlarge" required>
            </div>
        </div>
        <div class="control-group">
            <!-- Prefered Bow Type-->
            <label class="control-label" for="password">Prefered Bow Type</label><br>
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
