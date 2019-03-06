<?php

class AdminRandomDiscountsConfigurationController extends ModuleAdminController
{
    public function  __construct()
    {
        $this->bootstrap=true;
        parent::__construct();
    }
    public function postProcess()
    {
        if(isset($_POST["submitAddconfiguration"]))
        {
            var_dump($_POST['nuolaida']);
            die();
        }
    }
    public function renderOptions()
    {
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-edit',
            ),
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => 'Kategorijų kiekis:',
                    'name' => 'categ',
                    'options' => array(
                        'query' => $this->getCategSelectArray(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                ),
                array(
                    'type' => 'select',
                    'label' => 'Prekių kiekis(per Kategorija)',
                    'name' => 'prekes',
                    'options' => array(
                        'query' => $this::getItemsSelectArray(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => 'Nuolaida (%)',
                    'name' => 'nuolaida',
                ),
                array(
                    'type' => 'date',
                    'label' => 'Data: Nuo',
                    'name' => 'date_from',
                ),
                array(
                    'type' => 'date',
                    'label' => 'Data: Iki',
                    'name' => 'date_to',
                )
            ),
            'submit' => array(
                'title' => 'Save',
            ),
//            'buttons' => array(),
        );
        return parent::renderForm();
    }
    private function getRandomCategId($number)
    {
    }
//    private function getItemsCount()
//    {
//        $querry = "SELECT Count(id_product) as kiekis FROM `ps_product`";
//        $numb = Db::getInstance()->executeS($querry);
//        return $numb[0]["kiekis"];
//    }
    private function getCategCount()
    {
        $querry = "SELECT Count(id_category) as kiekis FROM `ps_category`";
        $kiek = Db::getInstance()->executeS($querry);
        return $kiek[0]["kiekis"];
    }
    private function getCategSelectArray()
    {
        $numb = $this::getCategCount();
        $result = array();
        for($i = 0; $i < $numb; $i++)
        {
            $result[$i]["id"] = $i+1 ;
            $result[$i]["name"] = $i +1;
        }
        return $result;
    }
    private function getItemsSelectArray()
    {
        $result = array();
        $item = 0;
        for ($i = 0;$i < 5; $i++)
        {
            $item = $item +5;
            $result[$i]["id"] = $i+1;
            $result[$i]["name"] = $item;
        }
        return $result;
    }
}