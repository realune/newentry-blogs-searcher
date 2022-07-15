<!DOCTYPE html>
<html lang="ja">

{include file="./header.tpl"}

<body>
    <a href="/">検索画面へ戻る</a>
    {if !empty($results)}
        <table>
            <thead>
                <tr>
                    <th class="th-row1">日付</th>
                    <th class="th-row2">URL</th>
                    <th class="th-row3">タイトル</th>
                    <th class="th-row4">説明</th>
                </tr>
            </thead>
            <tbody>
                {* 検索結果を表示する *}
                {foreach from=$results item=val key=key}
                    <tr>
                        <td class="td-row1">{$val->getEntryDate()}</td>
                        <td class="td-row2">
                            <a href="{$val->getLink()}" target="_blank" rel="noopener noreferrer">{$val->getLink()}</a>
                        </td>
                        <td class="td-row3">{$val->getTitle()}</td>
                        <td class="td-row4">{$val->getDescription()}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
        {include file="./pager.tpl"}
    {else}
        <h2 class="no-data">検索データなし</h2>
    {/if}
</body>

</html>