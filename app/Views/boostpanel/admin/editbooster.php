<?php $view = new App\Library\Template\Template('boostpanel.layouts.app', [
    'title' 	 => 'Edit a booster',
    'page_title' => 'Edit a booster'
]); ?>

<?php $view->start('content'); ?>
    <form action="<?php echo App\Router\Router::url('booster.edit.post', ['id' => $booster_details['id']]); ?>" method="POST">
        <div class="form-group">
            <label>PayPal E-mail</label>
            <input class="form-control" type="email" name="paypal" value="<?php if(isset($booster_details['paypal']) && !empty($booster_details['paypal'])) {
                echo $booster_details['paypal'];
            } ?>">
        </div>
        <div class="form-group">
            <label>Percentage</label>
            <input class="form-control" type="number" min="0" max="100" name="percentage" value="<?php if(isset($booster_details['percentage']) && !empty($booster_details['percentage'])) {
                echo $booster_details['percentage'];
            } ?>">
        </div>
        <div class="form-group">
            <label>Server(s)</label>
            <select name="servers_played[]" class="form-control select2" multiple="multiple" data-placeholder="Select server(s)">
                <?php foreach (\App\Config::SERVERS as $server) {
                    $option = "<option value='";
                    $option .= $server . "' ";

                    if (App\Repository\BoosterRepository::getInstance()->playOnServer($server, $booster_details['id'])) {
                        $option .= "selected>";
                    } else {
                        $option .= ">";
                    }

                    $option .= $server . "</option>";
                    echo $option;
                } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
<?php $view->stop(); ?>

<?php $view->start('script'); ?>
<script type="text/javascript">
    //Initialize Select2 Elements
    $('.select2').select2()
</script>
<?php $view->stop(); ?>

<?php echo $view->render(); ?>
