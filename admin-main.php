<?php
defined('ABSPATH') or die('No access!');
?>
<style>
    #OHGoogleAnalytics_admin input[type="text"] {
        width: 100%;
    }
    #OHGoogleAnalytics_admin .error {
        color: #FF0000;
    }
</style>

<div id="OHGoogleAnalytics_admin" class="wrap">
    <h2><?php echo OHGoogleAnalytics::$name; ?> Options</h2>

    <?php if (isset($message) && $message != '') : ?>
        <p class="error"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <p>
            <b>Activate plugin:</b>
            <input type="checkbox" name="OHGoogleAnalytics_Enabled" value="1" <?php echo get_option('OHGoogleAnalytics_Enabled') ? 'checked' : ''; ?>>
        </p>
        <br>

        <p>
            <b>Google Analytics ID</b> (Example: UA-0000000-0)<br>
            <input type="text" name="OHGoogleAnalytics_Google_Analytics_ID" value="<?php echo form_option('OHGoogleAnalytics_Google_Analytics_ID'); ?>">
        </p>


        <p>
            <input type="hidden" name="action" value="save">
            <input type="submit" name="submit" class="button button-primary" value="Save changes">
        </p>
    </form>
</div>
