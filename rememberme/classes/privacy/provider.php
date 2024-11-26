<?php
namespace local_rememberme\privacy;

use core_privacy\local\metadata\collection;

class provider implements \core_privacy\local\metadata\provider, \core_privacy\local\request\plugin\provider {
    public static function get_metadata(collection $collection) : collection {
        $collection->add_database_table('rememberme_tokens', [
            'userid' => 'privacy:metadata:rememberme_tokens:userid',
            'expires' => 'privacy:metadata:rememberme_tokens:expires',
        ], 'privacy:metadata:rememberme_tokens');
        return $collection;
    }

    public static function delete_data_for_user($context, $userid) {
        global $DB;
        $DB->delete_records('rememberme_tokens', ['userid' => $userid]);
    }
}
