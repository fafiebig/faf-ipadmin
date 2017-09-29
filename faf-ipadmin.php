<?php
/*
Plugin Name: FAF IPAdmin
Plugin URI: https://github.com/fafiebig/faf-ipadmin
Description: WP Plugin to restrict IPs to grand access to WP Admin Sites.
Version: 1.0
Author: F.A. Fiebig
Author URI: http://fafworx.com
License: GNU GENERAL PUBLIC LICENSE
*/
defined('ABSPATH') or die('No direct script access allowed!');

/**
 *
 */
if (is_admin()) {

    // get remote ip
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // get ip whitelist
    $restrict   = get_option('restrict', false);
    $ips        = preg_split("/\\r\\n|\\r|\\n/", get_option('whitelist'));
    $whitelist  = array_merge(['127.0.0.1'], $ips);

    // bail out if ip is not whitelisted
    if ($restrict && !in_array($ip, $whitelist)) {
        header('HTTP/1.0 403 Forbidden');
        die('Access restricted!');
    }

    add_action('admin_menu', 'addIPAdminPage');
    add_action('admin_init', 'registerIPAdmin');
}

/**
 *
 */
function addIPAdminPage()
{
    add_options_page('IP Admin', 'IP Admin', 'manage_options', 'faf-ipadmin', 'addIPAdminPageForm');
}

/**
 *
 */
function registerIPAdmin()
{
    register_setting('faf-ipadmin', 'restrict');
    register_setting('faf-ipadmin', 'whitelist');
}

/**
 *
 */
function addIPAdminPageForm()
{
    ?>
    <div class="wrap exopress">
        <h1>IP Admin</h1>

        <form method="post" action="options.php">

            <?php
            settings_fields('faf-ipadmin');
            do_settings_sections('faf-ipadmin');
            ?>

            <table width="50%">
                <tr>
                    <td>
                        <p>Hier werden alle erlaubten IPs eingetragen. Alle anderen werden automatisch auf "403 Forbidden" weitergeleitet.</p>
                        <?php submit_button('Einstellungen speichern', 'primary alignright', 'settings'); ?>
                    </td>
                </tr>
                <tr>
                    <td>

                        <dl>
                            <dt>
                                IP Restriktion
                            </dt>
                            <dd>
                                <input type="checkbox" name="restrict" value="yes" <?php if (get_option('restrict') === 'yes') { ?>checked<?php } ?>>
                                aktivieren
                            </dd>
                            <dt>IP Whitelist (eine IP pro Zeile)</dt>
                            <dd>
                                <textarea cols="80" rows="8" name="whitelist"><?php echo get_option('whitelist'); ?></textarea>
                            </dd>
                        </dl>

                    </td>
                </tr>
            </table>
        </form>

    </div>
    <?php
}