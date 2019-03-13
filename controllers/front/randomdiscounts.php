<?php
class RandomDiscountsRandomDiscountsModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->setTemplate('page.tpl');
    }
    public function setMedia()
    {
         parent::setMedia();

         $this->registerStylesheet(
             'random_stylesheet',
             'modules/'.$this->module->name.'/views/css/button.css'
         );
    }
}