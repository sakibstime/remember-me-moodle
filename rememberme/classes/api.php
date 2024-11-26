<?php
namespace local_rememberme;

defined('MOODLE_INTERNAL') || die();

class api {
    public static function generate_token($userid) {
        global $DB;

        $token = bin2hex(random_bytes(32));
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        $expires = time() + get_config('local_rememberme', 'token_lifetime');

        // Remove existing tokens for the user.
        $DB->delete_records('rememberme_tokens', ['userid' => $userid]);

        // Save new token.
        $DB->insert_record('rememberme_tokens', [
            'userid' => $userid,
            'tokenhash' => $hashedToken,
            'expires' => $expires,
            'created' => time(),
        ]);

        return $token;
    }

    public static function validate_token($userid, $token) {
        global $DB;

        $record = $DB->get_record('rememberme_tokens', ['userid' => $userid]);
        if (!$record || $record->expires < time()) {
            return false;
        }

        return password_verify($token, $record->tokenhash);
    }
}
