<?php
defined('MOODLE_INTERNAL') || die();

function local_rememberme_extend_navigation(global_navigation $nav) {
    global $PAGE;

    if ($PAGE->pagetype === 'login-index') {
        $PAGE->requires->js_call_amd('local_rememberme/rememberme', 'init');
    }
}

function local_rememberme_loginpage_hook() {
    global $CFG, $USER, $DB;

    if (isloggedin() && !isguestuser()) {
        return;
    }

    if (!isset($_COOKIE['moodle_rememberme'])) {
        return;
    }

    $cookieData = json_decode(openssl_decrypt($_COOKIE['moodle_rememberme'], 'AES-256-CBC', $CFG->cookiekey, 0, $CFG->cookieiv), true);

    if (empty($cookieData['userid']) || empty($cookieData['token'])) {
        return;
    }

    $userid = $cookieData['userid'];
    $token = $cookieData['token'];

    $record = $DB->get_record('rememberme_tokens', ['userid' => $userid]);

    if (!$record || !password_verify($token, $record->tokenhash) || $record->expires < time()) {
        return;
    }

    // Automatically log in the user.
    complete_user_login($DB->get_record('user', ['id' => $userid]));
}
