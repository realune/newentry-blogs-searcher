<?php
/* Smarty version 4.1.1, created on 2022-07-13 14:51:21
  from '/Users/shunpei/work/newently-fc2blog-finder/resources/templates/pager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.1.1',
  'unifunc' => 'content_62cebfc9e22911_57997070',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '573d9b4b9baba331e6b247b18730183e9bc65075' => 
    array (
      0 => '/Users/shunpei/work/newently-fc2blog-finder/resources/templates/pager.tpl',
      1 => 1657716546,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_62cebfc9e22911_57997070 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/Users/shunpei/work/newently-fc2blog-finder/vendor/smarty/smarty/libs/plugins/modifier.regex_replace.php','function'=>'smarty_modifier_regex_replace',),));
?>
        <?php $_smarty_tpl->_assignInScope('uri', $_SERVER['REQUEST_URI']);?>
    <?php $_smarty_tpl->_assignInScope('query', smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['uri']->value,'/&page=\d+/',''));?>

        <?php if (($_smarty_tpl->tpl_vars['current_page']->value == 1)) {?>
        <span>1</span>
    <?php } else { ?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['query']->value;?>
&page=1">1</a>
    <?php }?>

        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['page_nums']->value, 'num', false, 'key');
$_smarty_tpl->tpl_vars['num']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['num']->value) {
$_smarty_tpl->tpl_vars['num']->do_else = false;
?>
        <?php if (($_smarty_tpl->tpl_vars['num']->value === $_smarty_tpl->tpl_vars['current_page']->value)) {?>
            <span><?php echo $_smarty_tpl->tpl_vars['num']->value;?>
</span>
        <?php } else { ?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['query']->value;?>
&page=<?php echo $_smarty_tpl->tpl_vars['num']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['num']->value;?>
</a>
        <?php }?>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

        <?php if ((($_smarty_tpl->tpl_vars['total_page']->value-1) > $_smarty_tpl->tpl_vars['end']->value)) {?>
        ...
    <?php }?>

        <?php if (!($_smarty_tpl->tpl_vars['total_page']->value == 1)) {?>
        <?php if (($_smarty_tpl->tpl_vars['current_page']->value < $_smarty_tpl->tpl_vars['total_page']->value)) {?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['query']->value;?>
&page=<?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
</a>
        <?php } else { ?>
            <span><?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
</span>
        <?php }?>
    <?php }
}
}
