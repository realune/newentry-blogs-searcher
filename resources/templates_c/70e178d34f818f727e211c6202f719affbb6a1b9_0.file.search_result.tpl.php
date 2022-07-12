<?php
/* Smarty version 4.1.1, created on 2022-07-12 21:57:30
  from '/Users/shunpei/work/newently-fc2blog-finder/resources/templates/search_result.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.1.1',
  'unifunc' => 'content_62cdd22a8fbcb7_16872799',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '70e178d34f818f727e211c6202f719affbb6a1b9' => 
    array (
      0 => '/Users/shunpei/work/newently-fc2blog-finder/resources/templates/search_result.tpl',
      1 => 1657655829,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./header.tpl' => 1,
  ),
),false)) {
function content_62cdd22a8fbcb7_16872799 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="ja">

<?php $_smarty_tpl->_subTemplateRender("file:./header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
    <a href="/">検索画面へ戻る</a>
    <?php if (!empty($_smarty_tpl->tpl_vars['results']->value)) {?>
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
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['results']->value, 'val', false, 'key');
$_smarty_tpl->tpl_vars['val']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->do_else = false;
?>
                    <tr>
                        <td class="td-row1"><?php echo $_smarty_tpl->tpl_vars['val']->value->getEntryDate();?>
</td>
                        <td class="td-row2">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value->getLink();?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value->getLink();?>
</a>
                        </td>
                        <td class="td-row3"><?php echo $_smarty_tpl->tpl_vars['val']->value->getTitle();?>
</td>
                        <td class="td-row4"><?php echo $_smarty_tpl->tpl_vars['val']->value->getDescription();?>
</td>
                    </tr>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </tbody>
        </table>
    <?php } else { ?>
        <h2 class="no-data">検索データなし</h2>
    <?php }?>
</body>

</html><?php }
}
