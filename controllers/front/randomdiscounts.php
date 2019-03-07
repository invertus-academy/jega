<?php
class RandomDiscountsRandomDiscountsModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->setTemplate('page.tpl');
    }
}