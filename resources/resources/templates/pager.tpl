    {* クエリパラメータからページを削除。後続で挿入するため *}
    {assign var=uri value=$smarty.server.REQUEST_URI}
    {assign var=query value=$uri|regex_replace:'/&page=\d+/':''}

    {* ページ番号1の表示 *}
    {if ($current_page == 1)}
        <span>1</span>
    {else}
        <a href="{$query}&page=1">1</a>
    {/if}

    {* ページ番号2以降の表示 *}
    {foreach from=$page_nums item=num key=key}
        {if ($num === $current_page)}
            <span>{$num}</span>
        {else}
            <a href="{$query}&page={$num}">{$num}</a>
        {/if}
    {/foreach}

    {* 残りページ数が多い場合...を表示する *}
    {if (($total_page - 1) > $end)}
        ...
    {/if}

    {* 最終ページの表示 *}
    {if !($total_page == 1)}
        {if ($current_page < $total_page)}
            <a href="{$query}&page={$total_page}">{$total_page}</a>
        {else}
            <span>{$total_page}</span>
        {/if}
    {/if}
