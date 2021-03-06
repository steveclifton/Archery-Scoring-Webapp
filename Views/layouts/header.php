<div class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
            $weeks = new \Archery\Controllers\Admin();
            // TODO
            $weeks = $weeks->getCurrentWeek(3);
            echo "<a class=\"navbar-brand\" href=\"/week?week=$weeks\">Archery OSA<a>";
            ?>

        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li><a></a></li>

<!--                <li class='dropdown'>-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Events<b class="caret"></b></a>-->
<!--                    <ul class="dropdown-menu">-->
                        <?php
                            $weeks = new \Archery\Controllers\Admin();
                            // TODO
                            $weeks = $weeks->getCurrentWeek(3);
                            echo "<li><a href='/week?week=$weeks'>2017 Indoor League</a></li>";
                        ?>
<!--                    </ul>-->
<!--                </li>-->

<!--                <li class='dropdown'>-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Results<b class="caret"></b></a>-->
<!--                    <ul class="dropdown-menu">-->
<!--                        <li><a href='/competitions'>Competitions</a></li>-->
<!--                        <li><a href='#'>Archer Stats</a></li>-->
<!--                    </ul>-->
<!--                </li>-->


<!--                <li class='dropdown'>-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Records<b class="caret"></b></a>-->
<!--                    <ul class="dropdown-menu">-->
<!--                        <li><a href="#">Archery NZ</a></li>-->
<!--                        <li><a href="#">NZFAA NZ</a></li>-->
<!--                    </ul>-->
<!--                </li>-->
                <li><a href="/register">Register</a></li>
<!--                <li class='dropdown'>-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Account<b class="caret"></b></a>-->
<!--                    <ul class="dropdown-menu">-->
<!--                        <li><a href="/register">Register</a></li>-->
<!--<!--                        <li><a href="#">Password Reset</a></li>-->
<!--                    </ul>-->
<!--                </li>-->

                <li><a href='/rules'>League Rules</a></li>
                <li><a href="/contact">Contact</a></li>

                <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') { ?>
                    <li><a href="/admin">Admin</a></li>
                <?php } ?>

            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php
                    if (isset($_SESSION['id'])) {
                        $username = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
                        echo "
                            <li class='dropdown'>
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">$username <b class=\"caret\"></b></a>
                                <ul class=\"dropdown-menu\">
                                    <li><a href='/userprofile'>Profile</a></li>
                                    <li><a href='/logout'>Logout</a></li>
                                </ul>
                            </li>
                        ";
                    } else {
                        echo "
                            <form class=\"navbar-form navbar-right navbar-fixed\" id=\"loginForm\" method='post' action=\"#\" onsubmit=\"return checkLogin()\">
                                <div class=\"form-group\">
                                    <input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"Email\">
                                </div>
                                <div class=\"form-group\">
                                    <input type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"Password\">
                                </div>
                                <button type=\"submit\" class=\"btn btn-default\">Sign In</button>
                            </form>
                        ";
                    }
                ?>
            </ul>
        </div>
    </div>
</div>
