{extends file="parent:frontend/listing/filter/facet-value-list.tpl"}

{block name="frontend_listing_filter_facet_value_list"}
    {if $facet->getValues()|count > 1}
        {$smarty.block.parent}
    {/if}
{/block}