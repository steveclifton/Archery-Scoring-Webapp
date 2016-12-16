<!DOCTYPE html>
<html>
    <head>
        <title>Archery League Series - <?= $pageTitle; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="../Views/js/my.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="Views/css/custom.css">


        <!-- Select Picker -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <?php include('/var/www/archery/Views/layouts/header.php'); ?>
            </div>
        </div>

        <div class="page-container">
            <div class="container-fluid">

                <?php include('/var/www/archery/Views/layouts/leftside.php'); ?>

                <div class="col-sm-6 col-md-10">
                    <?= "<h2 style=\"font-family: 'Droid Sans', sans-serif; text-align: center; \">2016 Outdoor League Series</h2>" ?>
                    <?php include($viewName . '.php'); ?>
                </div>
            </div>
        </div>

        <div class="container">
            <?php include('/var/www/archery/Views/layouts/footer.php')?>
        </div>
    </body>
</html>
