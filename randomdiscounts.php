<?php
if (!defined('_PS_VERSION_')) {
    exit;
}
class RandomDiscounts extends Module
{
    public function __construct()
    {
        $this->name = 'randomdiscounts';
        $this->author = 'PrestaShop';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        parent::__construct();
        $this->controllers =['randomdiscounts',
        ];
        $this->displayName = $this->l('Random Discounts');
        $this->description = $this->l('Module that randomizes discounts for you');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }
    public function install()
    {
        $this->createTable();
        return parent::install() &&
            $this->registerHook('displayHome') &&
            $this->registerHook('displayTop')&&
            $this->registerHook('displayAdminProductsExtra');
    }
    public function uninstall()
    {
        $this->deleteTable();
        return parent::uninstall();
    }
    public function createTable()
    {
        $sql_Query = "CREATE TABLE IF NOT EXISTS "._DB_PREFIX_."random_discounts (
                `id_random_discount` int(11) NOT NULL AUTO_INCREMENT,
                `id_spec_price` int(11) NOT NULL,
                `from` datetime,
                `to` datetime,
                PRIMARY KEY(`id_random_discount`)
                )";
        Db::getInstance()->execute($sql_Query);
    }
    public function deleteTable()
    {
        $sql_query = "DROP TABLE "._DB_PREFIX_."random_discounts";
        DB::getInstance()->execute($sql_query);
    }
    public function getContent()
    {
        $controlerLink = Context::getContext()->link->getAdminLink('AdminRandomDiscountsConfiguration');
        Tools::redirectAdmin($controlerLink);
    }
    public function getTabs()
    {
        return [
            [
                'name' => 'randomdiscounts',
                'parent_class_name' => 'AdminParentModulesSf',
                'class_name' => 'AdminRandomDiscountsParent',
                'visible' => false,
            ],
            [
                'name' => 'Configuration',
                'parent_class_name' => 'AdminRandomDiscountsParent',
                'class_name'=> 'AdminRandomDiscountsConfiguration',
            ]
        ];
    }
    public function hookDisplayHome()
    {
        return '<h1> Hello World </h1>';
    }
    public function hookDisplayTop()
    {
        $this->context->smarty->assign([
            "smartykintamasis"=> $this->context->link->getModuleLink($this->name, 'DiscountProducts'),
        ]);
        return $this->context->smarty->fetch($this->getLocalPath()."views/templates/front/bandymas.tpl");
    }

    public function hookDisplayAdminProductsExtra()
    {
        return 'Random Discounts';
    }
}