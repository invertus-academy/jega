<?php
/**
 * Created by PhpStorm.
 * User: Julius
 * Date: 3/5/2019
 * Time: 6:29 PM
 */

class AdminRandomDiscountsConfigurationController extends ModuleAdminController
{
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
                    'name' => 'type_select',
                    'options' => array(
                        'query' => Zone::getZones(),
                        'id' => 'id_zone',
                        'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => 'Prekių kiekis(per Kategorija)',
                        'name' => 'type_select',
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

    private function getItemsCount()
    {
        $querry = "SELECT Count(id_product) as kiekis FROM `ps_product`";
        $numb = Db::getInstance()->executeS($querry);
        return $numb[0]["kiekis"];
    }

    private function getItemsSelectArray()
    {
        $num = $this::getItemsCount();
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