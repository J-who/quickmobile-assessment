<?php echo (isset($message)) ? $message : ''; ?>

<meta http-equiv="refresh" content="3; url=http://<?php echo $model->url?>" />


<div class="row">
    <div class="col-xs-4">

        <h3>URL Shortener</h3>
        <br/>

        Redirecting you to http://<?php echo $model->url?> in 3 seconds!

    </div>
</div>


<div class="spacer"></div>