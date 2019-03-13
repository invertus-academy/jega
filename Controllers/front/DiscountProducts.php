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

        $this->context->smarty->assign(array(
            'products' => $productList,
        ));
        $this->setTemplate('module:randomdiscounts/views/templates/front/page.tpl');
    }

    private function GetRandomGeneratedProducts()
    {
//        $querry = "Select ps_product_lang.name, ps_product_lang.link_rewrite, ps_product.*,  from ((ps_product INNER join ps_random_discounts On ps_product.id_product = ps_random_discounts.id_spec_price) Inner Join ps_product_lang On ps_product.id_product = ps_product_lang.id_product AND ps_product_lang.id_lang = ".$this->context->language->id.")";
        $sql = new DbQuery();


        $sql->select('p.*, product_shop.*, pl.`name`, pl.`link_rewrite`,im.`cover`');
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
                'image_shop',
                'im',
                'im.`id_product`=rd.`id_spec_price` AND im.`id_shop` ='. $this->context->shop->id
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