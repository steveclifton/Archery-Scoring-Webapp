<div class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="login">Archery League Series</a>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li><a></a></li>
                <li><a href="#">Results</a></li>
                <li><a href="#">Rules</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Register</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if (isset($_SESSION['id'])) {
                        $username = "Steve Clifton"; //$_SESSION['first_name'] . " " . $_SESSION['last_name'];
                        echo "
                                <li class='dropdown'>
                                    <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">$username <b class=\"caret\"></b></a>
                                    <ul class=\"dropdown-menu\">
                                        <li><a href='#'>Profile</a></li>
                                        <li><a href='logout'>Logout</a></li>
                                    </ul>
                                </li>
                        ";
                    } else {
                        echo "
                                <form class=\"navbar-form navbar-right\" method='post' ' action=\"login\">
                                <div class=\"form-group\">
                                <input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"Username\">
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