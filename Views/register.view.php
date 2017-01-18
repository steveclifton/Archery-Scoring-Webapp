<br>
<div class="row">
    <div class="col-sm-5 col-md-5">
        <form class="form-horizontal" action="/register" method="POST" id="formAccount" onsubmit="return false">
            <fieldset>
                <div id="legend">
                    <legend class="">Request A New Account</legend>
                    <p>Accounts are usually approved within 24-Hours</p>
                </div>
                <div class="control-group">
                    <label class="control-label">First Name</label>
                    <div class="controls">
                        <input type="text" id="first_name" name="first_name" placeholder="" class="input-xlarge" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Last Name</label>
                    <div class="controls">
                        <input type="text" id="last_name" name="last_name" placeholder="" class="input-xlarge" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Email</label>
                    <div class="controls">
                        <input type="email" id="email" name="email" placeholder="" class="input-xlarge" required>
                    </div>
                </div>
                <div class="control-group">
                    <!-- Password-->
                    <label class="control-label">Password</label>
                    <div class="controls">
                        <input type="password" id="password" name="password" placeholder="" class="input-xlarge" required>
                    </div>
                </div>
                <div class="control-group">
                    <!-- Password-->
                    <label class="control-label">Confirm Password</label>
                    <div class="controls">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="" class="input-xlarge" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">ANZ Number</label>
                    <div class="controls">
                        <input type="text" id="anz_num" name="anz_num" class="input-xlarge" required>
                    </div>
                </div>
                <div class="control-group">
                    <!-- Club-->
                    <label class="control-label">Club</label>
                    <div class="controls">
                        <input type="text" id="club" name="club" class="input-xlarge" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Gender</label><br>
                    <select name="gender" id="gender" class="selectpicker show-menu-arrow">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="control-group">
                    <!-- Prefered Bow Type-->
                    <label class="control-label">Prefered Bow Type</label><br>
                    <select name="prefered_type" id="prefered_type" class="selectpicker show-menu-arrow" required>
                        <option disabled selected value> -- select bow type -- </option>
                        <option value="compound">Compound</option>
                        <option value="recurve">Recurve</option>
                        <option value="recurve barebow">Recurve Barebow</option>
                        <option value="longbow">Longbow</option>
                        <option value="crossbow">Crossbow</option>
                    </select>
                </div>
                <br><br>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-success" id="registerAccount">Register</button>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['success'])) {
                    if ($_SESSION['success'] === true) {
                        echo "<p style='color: green;'>Success</p>";
                        unset($_SESSION['success']);
                    } else {
                        echo "<p style='color: red'>Account Creation Failed, please check details and try again</p>";
                    }
                }
                ?>
            </fieldset>
        </form>
    </div>
    <div class="col-sm-5 col-md-5">
        <form class="form-horizontal" action="/registerprofile" method="POST">
            <fieldset>
                <div id="legend">
                    <legend class="">Request A New Profile</legend>
                    <p>Profiles enable you to compete in the league series</p>
                </div>
                <div class="control-group">
                    <label class="control-label">First Name</label>
                    <div class="controls">
                        <input type="text" id="first_name" name="first_name" placeholder="" class="input-xlarge" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Last Name</label>
                    <div class="controls">
                        <input type="text" id="last_name" name="last_name" placeholder="" class="input-xlarge" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Email</label>
                    <div class="controls">
                        <input type="email" id="email" name="email" placeholder="" class="input-xlarge" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">ANZ Number</label>
                    <div class="controls">
                        <input type="text" id="anz_num" name="anz_num" class="input-xlarge" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Gender</label><br>
                    <select name="gender" id="gender" class="selectpicker show-menu-arrow">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="control-group">
                    <!-- Prefered Bow Type-->
                    <label class="control-label">Prefered Bow Type</label><br>
                    <select name="prefered_type" id="prefered_type" class="selectpicker show-menu-arrow" required>
                        <option disabled selected value> -- select bow type -- </option>
                        <option value="compound">Compound</option>
                        <option value="recurve">Recurve</option>
                        <option value="recurve barebow">Recurve Barebow</option>
                        <option value="longbow">Longbow</option>
                        <option value="crossbow">Crossbow</option>
                    </select>
                </div>
                <br><br>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-success" id="registerProfile">Register</button>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['successProfile'])) {
                    if ($_SESSION['successProfile'] === true) {
                        echo "<p style='color: green;'>Success</p>";
                        unset($_SESSION['successProfile']);
                    } else {
                        echo "<p style='color: red'>Account Creation Failed, please check details and try again</p>";
                    }
                }
                ?>
            </fieldset>
        </form>
    </div>
</div>
