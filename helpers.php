<?php

$this->on('admin.init', function() use($helpers) {

    if (!empty($helpers['locked_entries_disabled'])) {

        // delete all keys, that start with "locked:"
        $keys = $this->memory->keys('locked:*');
        if (!empty($keys)) {
            $this->memory->del(...$keys);
        }

    }

});

if (!empty($helpers['log_exceptions'])) {
    // TODO: stack trace (but for now it's better than before)
    $this->on('error', function($error, $exception) {
        $message = "Caught Exception: {$error['message']} in {$error['file']}:{$error['line']}";
        \error_log($message);
    });
}
