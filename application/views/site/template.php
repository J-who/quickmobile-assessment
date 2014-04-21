<?php
/**
 * Copyright (c) 2014 All Rights Reserved - Leeka Media http://www.leeka.ca/
 *
 * @copyright Leeka Media 2014
 * @author Chris Hopewell <chris.hopewell@leeka.ca>
 */
?>

<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel='shortcut icon' href='favicon.ico?v2' type='image/x-icon'/>
    <meta name="description" content="Assessment">
    <title>
        QuickMobile Assessment
    </title>

    <?php echo HTML::style("css/bootstrap.min.css"); ?>
    <?php echo HTML::style("css/css.css"); ?>

    <?php echo HTML::script("js/jquery-1.10.2.min.js"); ?>
    <?php echo HTML::script("js/bootstrap.min.js"); ?>

</head>
<body>


<div class="container">
    <!-- Static navbar -->
    <div class="navbar navbar-default navbar-inverse" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class='<?php echo Library_Helper::menuActive($menu, 'home') ?>'>
                    <a href="<?php echo URL::site('/'); ?>">Home</a>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($breadcrumb)) echo $breadcrumb; ?>
            <?php echo $content; ?>
        </div>

    </div>

    <div class="row">
        <div class="col-xs-12">

            <div class="panel-footer main_footer">
                <p class="pull-right"><a href="#">Back to top</a></p>

                <small>
                    Quick Mobile Assessment &copy; <?php echo $site['start_year'] ?>
                    <?php if (date('Y') > $site['start_year']) {
                        echo ' - ' . date('Y');
                    }?>
                    <br/>All rights reserved.
                </small>
            </div>
        </div>
    </div>
</div>


</body>
