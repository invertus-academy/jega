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
                            'query' => Zone::getZones(),
                            'id' => 'id_zone',
                            'name' => 'name',
                        ),
                    ),
                array(
                    'type' => 'select',
                    'label' => 'Nuolaida (%)',
                    'name' => 'type_select',
                    'options' => array(
                        'query' => Zone::getZones(),
                        'id' => 'id_zone',
                        'name' => 'name',
                    ),
                ),
            ),
            'submit' => array(
                'title' => 'Save',
            ),
//            'buttons' => array(),
        );

        return parent::renderForm();
    }
}