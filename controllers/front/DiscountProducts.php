<?php
class RandomDiscountsDiscountProductsModuleFrontController extends ModuleFrontController
{
//    public function init()
//    {
////        $this->page_name = 'DiscountProducts';
//        parent::init();
//    }
    public function initContent()
    {
        parent::initContent();
        $productList = $this->GetRandomGeneratedProducts();
        //Generuojam img linka
        foreach ($productList as &$item)
        {
            $item['imgLinkas'] = $this->context->link->getImageLink($item["link_rewrite"], $item['img'], 'home_default');
            $item['specific_prices']['reduction'] = $item['specific_prices']['reduction'] * 100;
            $item['kaina']= $item['price_without_reduction'] - ($item['price_without_reduction'] / 100 * $item['specific_prices']['reduction']);
            $item['kaina'] = Tools::displayPrice($item['kaina']);
        }
//        dump($productList);
//        die;
        $this->context->smarty->assign(array(
            'products' => $productList,
            'currency' => $this->context->currency->iso_code,
        ));
        $this->setTemplate('module:randomdiscounts/views/templates/front/page.tpl');
    }
    public function setMedia()
    {
        parent::setMedia();
        $this->registerStylesheet(
            'random_stylesheet',
            'modules/'.$this->module->name.'/views/css/button.css'
        );
        $this->registerStylesheet('page_sheet',
            'modules/'.$this->module->name.'/views/css/page.css');
    }
    private function GetRandomGeneratedProducts()
    {
//        $querry = "Select ps_product_lang.name, ps_product_lang.link_rewrite, ps_product.*,  from ((ps_product INNER join ps_random_discounts On ps_product.id_product = ps_random_discounts.id_spec_price) Inner Join ps_product_lang On ps_product.id_product = ps_product_lang.id_product AND ps_product_lang.id_lang = ".$this->context->language->id.")";
        $sql = new DbQuery();
        $sql->select('rd.`from`, rd.`to`, p.*, product_shop.*, pl.`name`, pl.`link_rewrite`,im.`id_image` as img');
        $sql
            ->from('random_discounts',  'rd')
            ->innerJoin(
                'product',
                'p',
                'p.`id_product` = rd.`id_spec_price`'
            )
            ->innerJoin(
                'product_lang',
                'pl',
                'pl.`id_product`=rd.`id_spec_price` AND pl.`id_lang` = ' . $this->context->language->id.
                ' AND pl.`id_shop`=' . $this->context->shop->id
            )
            ->innerJoin(
                'image',
                'im',
                'im.`id_product`=rd.`id_spec_price`'
            )
            ->join(Shop::addSqlAssociation('product', 'p'));
        $listas = Db::getInstance()->executeS($sql);
        $productList = [];
        foreach ($listas as $single) {
            $productList[] = Product::getProductProperties($this->context->language->id, $single);
        }
        return $productList;
    }
    private function getProductsFromSql()
    {
        $query = new DbQuery();
        $query->select('p.`id_product`');
        $query->from('product', 'p');
        $query->innerJoin(
            'product_lang',
            'pl',
            'pl.`id_product` = p.`id_product` AND pl.`id_lang` = ' . $this->context->language->id
        );
        return Db::getInstance()->executeS($query);
    }
}