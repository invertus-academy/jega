<?php
if (!defined('_PS_VERSION_')) {
    exit;
}
class randomdiscounts extends Module
{
    public function __construct()
    {
        $this->name = 'randomdiscounts';
        $this->author = 'PrestaShop';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';

        parent::__construct();

        $this->displayName = $this->l('Random Discounts');
        $this->description = $this->l('Descriptionas');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

    }

    public function install()
    {
        $link = "Create table if not EXISTS "._DB_PREFIX_."Random_discounts(
             `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `id_something` int(11) unsigned NOT NULL,
             PRIMARY KEY (`id`)
             )";
            // Run sql for creating DB tables
            Db::getInstance()->execute($link);
        return parent::install() && $this->registerHook('displayHome');
    }

    public function hookDisplayHome()
    {
        return '<h1> Hello World </h1>';
    }

}
