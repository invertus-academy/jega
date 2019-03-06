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
            $discount = $_POST['nuolaida'];
            $categories = $_POST['categ'];
            $items = $_POST['prekes'];
            $dateF = $_POST['date_from'];
            $dateT = $_POST['date_to'];
            $randomedCat = $this->getRandomCategories($categories);
            $randomedItems = $this->getRandomItems($randomedCat, $items);
//            echo '<pre>' ,var_dump($this->getCategoryItems(9)) , '</pre>';
//            ;
//            echo '<pre>' ,var_dump($randomedItems) , '</pre>';
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
                        'id' => 'name',
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
        $querry = "SELECT Count(id_category) as kiekis FROM `ps_category` 
                   WHERE id_category != 1
                   AND id_category != 2";
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
    private function getRandomCategories($selectedCountCat)
    {
        $result = array();
        $categories = $this->getCategCount();
        for($i = 0; $i < $selectedCountCat; $i++)
        {
            $result[$i] = rand(4, $categories);
        }
        return $result;
    }
    private function getCategoryItems($category)
    {
        $querry = "SELECT id_product as produktai FROM `ps_product` 
                   WHERE id_category_default = $category";
        $result = Db::getInstance()->executeS($querry);
        return $result;
    }
    private function getRandomItems($randomedCategories, $selectedCount)
    {
        $tempArr = array();
        $result = array();

        foreach ($randomedCategories as $single) {
            $list = $this->getCategoryItems(8);
            if (count($list) > $selectedCount) {
                    //sukame cikla, kol bus uzpilyta skirtingom reiksmem reikiamas kiekis masyve
                    $i =0;
                    while (count($result) != $selectedCount) {
                        $temp = array_rand($list);
                        //Jeigu sugalvoto random skaiciaus dar nera prideje i masyva tuomet ji pridedam, kad nebutu vienodu produktu.
                        if (!in_array($list[$temp]['produktai'], $result)) {
                            $result[$i] = $list[$temp]['produktai'];
                            $i = $i + 1;
                        }
                    }
            } else {
//                Jeigu Itemu yra maziau negu pasirinko vartotojas, tuomet sudedame visus itemus
                $temp = 0;
                foreach ($list as $val) {
                    $result[$temp] = $val['produktai'];
                    $temp = $temp + 1;
                }
            }
//            $randArr = array_rand($list, $selectedCount);
//            for($i = 0; $i <$selectedCount; $i++) {
//                $result[$temp][$i] = $list[$randArr[$i]];
//            }
//            $temp = $temp + 1;
        }
        return $result;
    }
}