<?php echo (isset($message)) ? $message : ''; ?>


<div class="row">

    <div class="col-xs-4">

        <h3>URL Shortener</h3>

        <div class="spacer"></div>

        <label for="exampleInputEmail1">New URL</label><br/>
        <a href='/hashed/<?php echo $url->hashed ?>' target="_blank">
            <?php echo URL::site('/', TRUE) ?>hashed/<?php echo $url->hashed ?>
        </a>

        <br/><br/>

        <a href='<?php echo URL::site('/') ?>'>Do another?</a>

    </div>
</div>


<div class="spacer"></div>