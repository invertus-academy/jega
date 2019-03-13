{extends file='page.tpl'}
{block name="page_content"}
    <h1>{l s="Atsitiktinai sugeneruotos nuolaidos" mod="randomdiscounts"}</h1>
    {foreach $products as $single}
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="{$single['imgLinkas']}" height="245" width="285" align="center">
            <div class="card-body">
                <h5 class="card-title" align="center">{$single['name']}</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">{l s="Kaina" mod="randomdiscounts"} {$single['price_without_reduction'] - ($single['price_without_reduction'] / 100 * $single['specific_prices']['reduction'])} {l s="Eur" mod="randomdiscounts"}</li>
                <li class="list-group-item">{l s="Nuolaida:" mod="randomdiscounts"} {$single['specific_prices']['reduction']} %</li>
                <li class="list-group-item">{l s="Paprasta Kaina:" mod="randomdiscounts"} {$single['price_without_reduction']} {l s="Eur" mod="randomdiscounts"}</li>
            </ul>
        </div>
    {/foreach}
{/block}