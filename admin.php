<?php

$this->on('admin.init', function() use ($hardening) {

    if ($this->module('cockpit')->isSuperAdmin()) {

        // bind admin routes
        $this->bindClass('rljUtils\\Controller\\Admin', 'rljutils');

        // add settings entry
        $this->on('cockpit.view.settings.item', function () {
            $this->renderView('rljutils:views/partials/settings.php');
        });

    }
    
    // restrict built-in helper functions

    // deny request for `find` and `_find`
    if ($hardening['collections_find']) {

        $this->bind('/collections/find', function(){

            $collection = $this->param('collection');

            if (!$this->module('collections')->hasaccess($collection, 'entries_view')) {
                return $this->helper('admin')->denyRequest();
            } else {
                return $this->invoke('Collections\\Controller\\Admin', 'find');
            }

        });

    }

    if ($hardening['collections_tree']) {

        // deny request for `tree`
        $this->bind('/collections/tree', function() {

            $collection = $this->param('collection');

            if (!$this->module('collections')->hasaccess($collection, 'entries_view')) {
                return $this->helper('admin')->denyRequest();
            } else {
                return $this->invoke('Collections\\Controller\\Admin', 'tree');
            }

        });

    }

    if ($hardening['collections_collections']) {

        // don't list collections schema of restricted collections
        $this->bind('/collections/_collections', function() {

            return $this->module('collections')->getCollectionsInGroup(null, false);

        });

    }

    if ($hardening['accounts_find']) {

        // disable user lists for non-admins,
        // non-admins must send a user id to receive the user name
        $this->bind('/accounts/find', function() {

            if ($this->module('cockpit')->isSuperAdmin()) {

                return $this->invoke('Cockpit\\Controller\\Accounts', 'find');

            }

            // deny request to list all users
            $options = $this->param('options', []);
            if (!isset($options['filter']['_id'])) {
                return $this->helper('admin')->denyRequest();
            }

            $accounts = $this->invoke('Cockpit\\Controller\\Accounts', 'find');

            $allowed = [
                'user',
                'name',
                'group',  // dashboard group info
                '_id'     // used by cp-account field, page breaks if omitted
            ];

            foreach ($accounts['accounts'] as $key => $account) {
                $accounts['accounts'][$key] = array_intersect_key($account, array_flip($allowed));
            }

            return $accounts;

        });

    }

    if ($hardening['assetsmanager']) {

        // deny access to assetsmanager
        if (!$this->module('cockpit')->hasaccess('cockpit', 'assets')) {

            $this->bind('/assetsmanager', function() {

                return $this->helper('admin')->denyRequest();

            });

            $this->bind('/assetsmanager/*', function() {

                return $this->helper('admin')->denyRequest();

            });

        }

    }

});