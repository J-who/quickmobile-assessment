<?php echo (isset($message)) ? $message : ''; ?>

<div class="row">
    <div class="col-xs-4">
        <h3>URL Shortener</h3>
        <br/>
        You may also use <?php echo URL::site('/', TRUE);?>hash/YOUR URL HERE
        <div class="spacer"></div>
        <div class="spacer"></div>

        <?php echo Form::open('crunch', array('role' => 'form', 'method' => 'POST')) ?>
        <form role="form">
            <div class="form-group">
                <label for="exampleInputEmail1">URL to Shorten</label>
                <div class="input-group">
                    <span class="input-group-addon">http://</span>
                    <?php echo Form::input('url', '', array('class' => 'form-control', 'id' => 'url',
                        'placeholder' => 'URL to shorten'));?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Crunch!</button>
            <?php Form::close(); ?>
    </div>
</div>



<div class="spacer"></div>