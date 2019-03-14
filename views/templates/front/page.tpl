{extends file='page.tpl'}
{block name="page_content"}
    <h1>{l s="Generated Discounts" mod="randomdiscounts"}</h1>
    <section class="featured-products clearfix">
    <div class="products" id="productsbelekoks">
    {foreach $products as $single}
        {if $single['to'] > date("Y-m-d H:i:s")}
                <article class="product-miniature js-product-miniature" data-id-product="1" data-id-product-attribute="1" itemscope="" itemtype="http://schema.org/Product">
                    <div class="thumbnail-container">
                        <a href="" class="thumbnail product-thumbnail">
                            <img src="{$single['imgLinkas']}" >
                        </a>
                        <div class="product-description">

                            <h3 class="h3 product-title" itemprop="name"><a href="">{$single.name}</a></h3>
                            <div class="product-price-and-shipping">
                                <span class="sr-only">Bazinė kaina</span>
                                <span class="regular-price">28,92&nbsp;EUR</span>
                                <span class="discount-percentage discount-product" style="top: -238px;">-{$single['specific_prices']['reduction']}%</span>
                                <span class="sr-only">Kaina</span>
                                <span itemprop="price" class="price"> {$single['kaina']}</span>
                            </div>
                        </div>
                    </div>
                </article>
        {/if}
    {/foreach}
    </div>
    </section>
{/block}
