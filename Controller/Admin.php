<?php

namespace rljUtils\Controller;

class Admin extends \Cockpit\AuthController {

    public function index() {

        $config = $this->app->module('rljutils')->getConfig();

        return $this->render('rljutils:views/index.php', ['config' => $config]);

    }

    public function saveConfig() {

        $config = $this->param('config', false);

        if ($config) {
            $this->app->storage->setKey('cockpit/options', 'rljutils', $config);
        }

        return $config;

    }

}
