<?php

$this->on('admin.init', function() use ($cosmetics) {

    if (!empty($cosmetics['widgets_timer_disabled'])) {

        // disable time widget in dashboard
        $this->on('admin.dashboard.widgets', function($widgets) {

            foreach($widgets as $key => $widget) {
                if ($widget['name'] == 'time') {
                    unset($widgets[$key]);
                    break;
                }
            }

        }, 0);

    }

    if (!empty($cosmetics['entry_default_group_main'])) {

        // Set default group in entry view to "Main" (default: "All")
        // When the page loads, `this.group` is an empty string. After the first
        // call of `toggleGroup()` it is 'GroupName' or false.
        $this->on('collections.entry.aside', function() {
            echo '<span if="{ group === \'\' && !(group = \'Main\') }" class="">test</span>';
        });

    }

    if (!empty($cosmetics['entry_language_buttons'])) {

        // add big language buttons to action bar
        $this->on('collections.entry.aside', function() {
            include($this->path('rljutils:views/partials/entry_language_buttons.php'));
        });

    }

});
