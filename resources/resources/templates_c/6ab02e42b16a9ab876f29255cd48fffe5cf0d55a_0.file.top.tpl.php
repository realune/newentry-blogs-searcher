<?php
/* Smarty version 4.1.1, created on 2022-07-15 22:38:48
  from '/Users/shunpei/work/newently-fc2blog-finder/resources/templates/top.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.1.1',
  'unifunc' => 'content_62d1d05845c790_18401977',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ab02e42b16a9ab876f29255cd48fffe5cf0d55a' => 
    array (
      0 => '/Users/shunpei/work/newently-fc2blog-finder/resources/templates/top.tpl',
      1 => 1657917508,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./header.tpl' => 1,
  ),
),false)) {
function content_62d1d05845c790_18401977 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="ja">

<?php $_smarty_tpl->_subTemplateRender("file:./header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
    <?php if ((isset($_COOKIE['search_cond']))) {?>
                <?php $_smarty_tpl->_assignInScope('cookie', json_decode($_COOKIE['search_cond'],true));?>
    <?php }?>
    <div class="container">
        <form class="sform" action="/search" method="GET">
            <div>
                <label for="search">日付</label>
                <input class="sbox" type="date" id="search" name="entry_date"
                    value=<?php if ((isset($_smarty_tpl->tpl_vars['cookie']->value['entry_date']))) {
echo $_smarty_tpl->tpl_vars['cookie']->value['entry_date'];
}?>>
            </div>
            <div>
                <label for="search">URL</label>
                <input class="sbox" type="search" id="search" name="link"
                    value=<?php if ((isset($_smarty_tpl->tpl_vars['cookie']->value['link']))) {
echo $_smarty_tpl->tpl_vars['cookie']->value['link'];
}?>>
            </div>
            <div>
                <label for="search">ユーザー名</label>
                <input class="sbox" type="search" id="search" name="username"
                    value=<?php if ((isset($_smarty_tpl->tpl_vars['cookie']->value['username']))) {
echo $_smarty_tpl->tpl_vars['cookie']->value['username'];
}?>>
            </div>
            <div>
                <label for="search">サーバー番号</label>
                <input class="sbox" type="search" id="search" name="server_no" oninput="value = value.replace(/[^0-9]+/i,'');"
                    value=<?php if ((isset($_smarty_tpl->tpl_vars['cookie']->value['server_no']))) {
echo $_smarty_tpl->tpl_vars['cookie']->value['server_no'];
}?>>
            </div>
            <div>
                <label for="search">エントリーNo.</label>
                <input class="sbox" type="search" id="search" name="entry_no" oninput="value = value.replace(/[^0-9]+/i,'');"
                    value=<?php if ((isset($_smarty_tpl->tpl_vars['cookie']->value['entry_no']))) {
echo $_smarty_tpl->tpl_vars['cookie']->value['entry_no'];
}?>>
                <input type="checkbox" id="search_btn" name="entry_no_over"
                    <?php if (((isset($_smarty_tpl->tpl_vars['cookie']->value['entry_no_over'])) && $_smarty_tpl->tpl_vars['cookie']->value['entry_no_over'] == 'on')) {?>checked<?php }?>>以上
            </div>
            <button class="sbtn" type="submit">検索</button>
        </form>
    </div>
</body>

</html><?php }
}
