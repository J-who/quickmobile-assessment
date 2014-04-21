<?php
if (strtolower($message->type) == 'success') {
    $image = HTML::image('/images/icon/check.png', array('height' => '30px'));
} else {
    $message->type = 'danger';
    $image = HTML::image('/images/icon/x.png', array('height' => '30px'));
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-<?php echo $message->type; ?>  alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

            <?php echo $image?>&nbsp;
            <?php
            if (is_array($message->message)):
                foreach ($message->message as $msg): ?>
                    <?php if (is_array($msg)):
                        foreach ($msg as $msgs): ?>
                            <?php echo $msgs; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php echo $msg; ?>
                    <?php endif; ?>
                <?php endforeach;
            else: ?>
                <?php echo $message->message; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

