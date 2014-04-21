<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel='shortcut icon' href='favicon.ico' type='image/x-icon'/>
    <meta name="description" content="<?php echo str_replace("\"", "'", $site['meta_description']) ?>">
    <title>
        <?php echo $site['title'] ?><?php echo $site['seo'] ?>
    </title>

    <?php echo HTML::style("css/bootstrap.min.css"); ?>
    <?php echo HTML::style("css/css.css"); ?>
    <?php echo HTML::style("css/message.css"); ?>
    <?php echo HTML::style("css/signin.css"); ?>

    <?php echo HTML::script("js/jquery-1.10.2.min.js"); ?>
    <?php echo HTML::script("js/bootstrap.min.js"); ?>
    <?php echo HTML::script("js/jquery.form.js"); ?>


</head>
<body>
<?php echo $content; ?>
</body>
</html>