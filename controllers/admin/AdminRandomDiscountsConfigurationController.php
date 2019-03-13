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
        if (isset($_POST["submitAddconfiguration"])) {
            $discount = $_POST['nuolaida'];
            $tempNuol = $discount / 100;
            $categories = $_POST['categ'];
            $items = $_POST['prekes'];
            $dateF = $_POST['date_from'];
            $dateT = $_POST['date_to'];
            $randomedCat = $this->getRandomCategories($categories);
            $randomedItems = $this->getRandomItems($randomedCat, $items);
//            dump($randomedItems);
            $numlength = strlen((string)$discount);
            if($randomedItems != []) {
                if (is_numeric($discount) && $numlength > 0 && $numlength < 3 && $this->validateDate($dateF) == 1 && $this->validateDate($dateT) == 1) {
//          Atsispausdint Itemus kategoriju
                    foreach ($randomedItems as $key => $val) {
//                        dump($val);
                        foreach ($val as $item){
//                            dump($item);
                            if ($item != 0) {
                                $specific = $this->SelectSpecificPriceItems($item);
                                $randomSpec = $this->SelectRandomDiscountsTableItems($item);
                                if ($specific == null && $randomSpec == null) {
                                    $this->AddToTableRandomQuery($item, $dateF, $dateT);
                                    $this->AddToTableSpecificQuery($item, $tempNuol, $dateF, $dateT);
                                } else if ($specific != null && $randomSpec == null) {
                                    $this->AddToTableRandomQuery($item, $dateF, $dateT);
                                    $this->UpdateSpecQuery($item, $tempNuol, $dateF, $dateT);
                                } else
                                    $this->UpdateSpecQuery($item, $tempNuol, $dateF, $dateT);
                            }
                        }
                    }
//                    die();
                    $this->confirmations[] = $this->l('Nuolaidos uždėtos: jos atvaizduotos "Random Discounts" skiltyje jūsų svetainėje');
                } else {
                    $this->errors[] = $this->l('Klaida: blogai įvesti duomenys');
                }
            }else
            {
                $this->errors[] = $this->l('Atsiprasome,taciau atsitiktinai pasirinkta kategorija, neturejo produktu');
            }
        }
    }
    public function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
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
                    'type' => 'datetime',
                    'label' => 'Data: Nuo',
                    'name' => 'date_from',
                ),
                array(
                    'type' => 'datetime',
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
    private function getActiveCategCount()
    {
        $querry = "SELECT Count(id_category) as kiekis FROM `ps_category` 
                   WHERE id_category != 1
                   AND id_category != 2";
        $kiek = Db::getInstance()->executeS($querry);
        return $kiek[0]["kiekis"];
    }
    private function getCategSelectArray()
    {
        $numb = $this::getActiveCategCount();
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
        $i = 0;
        while(count($result) != $selectedCountCat)
        {
            $rand = rand(3, $categories);
            if(!in_array($rand,$result)) {
                $result[$i] = $rand;
                $i= $i + 1;
            }
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
        $result = array();
        $temp1 = 0;
        $this->CheckIfCatGotItems($randomedCategories);
        $i =0;
        if($randomedCategories != []) {
            foreach ($randomedCategories as $single) {
//                dump($randomedCategories);
                $list = $this->getCategoryItems($single);
//            dump($list);
//            die();
                if (count($list) > $selectedCount) {
                    //sukame cikla, kol bus uzpilyta skirtingom reiksmem reikiamas kiekis masyve
                    if (!isset($result[$temp1])) {
                        $temp = array_rand($list);
                        $result[$temp1][$i] = $list[$temp]['produktai'];
                        $i = $i + 1;
                    }
                    while (count($result[$temp1]) != $selectedCount) {
                        $temp = array_rand($list);
                        //Jeigu sugalvoto random skaiciaus dar nera prideje i masyva tuomet ji pridedam, kad nebutu vienodu produktu.
                        if (!in_array($list[$temp]['produktai'], $result[$temp1])) {
                            $result[$temp1][$i] = $list[$temp]['produktai'];
                            $i = $i + 1;
                        }
                    }
                } else {
//                Jeigu Itemu yra maziau negu pasirinko vartotojas, tuomet sudedame visus itemus
                    foreach ($list as $val) {
                        $result[$temp1][$i] = $val['produktai'];
                        $i++;
                    }
                }
                $temp1 = $temp1 + 1;
            }
        }
        return $result;
    }
    private function CheckIfCatGotItems(&$Cat)
    {
        for ($i = 0; $i < count($Cat); $i++)
        {
            $list = $this->getCategoryItems($Cat[$i]);
            if(count($list) == 0)
            {
                unset($Cat[$i]);
            }
        }
        return $Cat;
    }
    private function SelectSpecificPriceItems($id)
    {
        $querry = "SELECT id_product as product FROM `ps_specific_price`
                    WHERE id_product = $id ";
        $result = Db::getInstance()->executeS($querry);
        return $result;
    }
    private function SelectRandomDiscountsTableItems($id)
    {
        $querry = "SELECT id_spec_price as spec FROM `ps_random_discounts`
                    WHERE id_spec_price = $id";
        $result = Db::getInstance()->executeS($querry);
        return $result;
    }
    private function AddToTableSpecificQuery($id_product, $discount, $dateF, $dateT)
    {
        $sql_query = "INSERT INTO `ps_specific_price` (`id_specific_price`, `id_specific_price_rule`, `id_cart`, `id_product`, `id_shop`,
                      `id_shop_group`, `id_currency`, `id_country`, `id_group`, `id_customer`, `id_product_attribute`, `price`,
                      `from_quantity`, `reduction`, `reduction_tax`, `reduction_type`, `from`, `to`) 
                      VALUES (null, '0', '0', '$id_product', '1', '0', '0', '0', '0', '0', '0', '-1.000000', '1',
                       '$discount', '1', 'percentage', '$dateF', '$dateT');";
        return Db::getInstance()->execute($sql_query);
    }
    private function AddToTableRandomQuery($id_product, $dateF, $dateT)
    {
        $sql_query = "INSERT INTO `ps_random_discounts` (`id_random_discount`, `id_spec_price`, `from`, `to`) VALUE (null, '$id_product', '$dateF', '$dateT')";
        return Db::getInstance()->execute($sql_query);
    }
    private function UpdateSpecQuery($id_item, $discount, $dateF, $dateT)
    {
        $sql_query = "UPDATE `ps_specific_price` 
                      SET `reduction` = $discount, `from` = '$dateF', `to` = '$dateT' WHERE id_product = $id_item";
        return Db::getInstance()->execute($sql_query);
    }
}