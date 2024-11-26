<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_rememberme', get_string('pluginname', 'local_rememberme'));

    $settings->add(new admin_setting_configtext(
        'local_rememberme/token_lifetime',
        get_string('token_lifetime', 'local_rememberme'),
        get_string('token_lifetime_desc', 'local_rememberme'),
        30 * DAYSECS, // Default: 30 days.
        PARAM_INT
    ));

    $ADMIN->add('localplugins', $settings);
}
