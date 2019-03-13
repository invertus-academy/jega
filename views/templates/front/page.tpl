{extends file='page.tpl'}
{block name="page_content"}
    {*{foreach from=$products item="product"}*}
        {*{include file="catalog/_partials/miniatures/product.tpl" product=$product}*}
    {*{/foreach}*}
{/block}