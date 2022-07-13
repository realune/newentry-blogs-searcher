<!DOCTYPE html>
<html lang="ja">

{include file="./header.tpl"}

<body>
    {if isset($smarty.cookies.search_cond)}
        {* cookieを取得 *}
        {assign var=cookie value=$smarty.cookies.search_cond|json_decode:true}
    {/if}
    <div class="container">
        <form class="sform" action="/search" method="GET">
            <div>
                <label for="search">日付</label>
                <input class="sbox" type="date" id="search" name="entry_date"
                    value={if isset($cookie.entry_date)}{$cookie.entry_date}{/if}>
            </div>
            <div>
                <label for="search">URL</label>
                <input class="sbox" type="search" id="search" name="link"
                    value={if isset($cookie.link)}{$cookie.link}{/if}>
            </div>
            <div>
                <label for="search">ユーザー名</label>
                <input class="sbox" type="search" id="search" name="username"
                    value={if isset($cookie.username)}{$cookie.username}{/if}>
            </div>
            <div>
                <label for="search">サーバー番号</label>
                <input class="sbox" type="search" id="search" name="server_no" oninput="value = value.replace(/[^0-9]+/i,'');"
                    value={if isset($cookie.server_no)}{$cookie.server_no}{/if}>
            </div>
            <div>
                <label for="search">エントリーNo</label>
                <input class="sbox" type="search" id="search" name="entry_no" oninput="value = value.replace(/[^0-9]+/i,'');"
                    value={if isset($cookie.entry_no)}{$cookie.entry_no}{/if}>
                <input type="checkbox" id="search_btn" name="entry_no_over"
                    {if (isset($cookie.entry_no_over) && $cookie.entry_no_over == 'on')}checked{/if}>以上
            </div>
            <button class="sbtn" type="submit">検索</button>
        </form>
    </div>
</body>

</html>