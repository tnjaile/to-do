<?php
/* Smarty version 3.1.34-dev-7, created on 2020-07-09 09:27:12
  from 'E:\UniServerZ\www\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f06d4e0589c61_15094358',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c3a3e8752b13a31e681f9e5f6f2b9b6019b90046' => 
    array (
      0 => 'E:\\UniServerZ\\www\\templates\\index.tpl',
      1 => 1594283226,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:post_form.tpl' => 1,
    'file:show_one.tpl' => 1,
  ),
),false)) {
function content_5f06d4e0589c61_15094358 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'E:\\UniServerZ\\www\\smarty\\libs\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<!DOCTYPE html>
<html lang="zh-TW">
  <!-- 引入檔頭 -->
  <?php $_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<body>
  <div class="container">
    <img src="images/logo.jpg" class="rounded-circle mx-auto d-block" width="100%" height="200rem" alt="logo">
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
        <a class="navbar-brand" href="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
            <h1><?php echo $_smarty_tpl->tpl_vars['header']->value;?>
</h1>
        </a>

        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav  ml-auto mt-2 mt-lg-0">
                <li class="nav-item <?php if (!$_smarty_tpl->tpl_vars['op']->value) {?>active<?php }?>">
                    <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['navbar']->value['home'];?>
 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['op']->value == 'post_form') {?>active<?php }?>">
                    <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
?op=post_form"><?php echo $_smarty_tpl->tpl_vars['navbar']->value['post'];?>
</a>
                </li>
                <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['op']->value == 'done') {?>active<?php }?>">
                  <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
?op=done"><?php echo $_smarty_tpl->tpl_vars['navbar']->value['done'];?>
</a>
                </li>
            </ul>
        </div>
    </nav>
    <hr>
    <div class="row">
        <div class="col-sm-3">
            <p>
              日期：<?php echo smarty_modifier_date_format(time(),"%Y-%m-%d");?>

            </p>
        </div>
        <div class="col-sm-9">
            <ul>
                <li>今天到期：<?php echo $_smarty_tpl->tpl_vars['dueToday']->value;?>
</li>
                <li>逾期：<?php echo $_smarty_tpl->tpl_vars['expired']->value;?>
</li>
            </ul>
        </div>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['op']->value == "post_form") {?>
      <?php $_smarty_tpl->_subTemplateRender("file:post_form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <?php } elseif ($_smarty_tpl->tpl_vars['op']->value == "show_one") {?>
      <?php $_smarty_tpl->_subTemplateRender("file:show_one.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <?php } else { ?>
        <?php if ($_smarty_tpl->tpl_vars['content']->value) {?>
          <h2><?php if ($_smarty_tpl->tpl_vars['op']->value == "done") {?>完成清單<?php } else { ?>待辦清單<?php }?><small>（共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 個事項）</small></h2>
          <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-sm">
                <thead  class="thead-dark">
                  <tr>
                      <th><i class="fas fa-check"></i></th>
                      <th>事項</th>
                      <th>到期日</th>
                      <th>優先順序</th>
                      <th>指派對象</th>
                      <th>建立時間</th>
                      <th>功能</th>
                  </tr>
                </thead>
                <tbody>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['content']->value, 'data');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['data']->value) {
?>
                  <tr>
                      <td>
                        <?php if ($_smarty_tpl->tpl_vars['data']->value['done']) {?>
                            <span class="badge badge-success text-center"><i class="fas fa-check"></i></span>
                        <?php } else { ?>
                            <span class="badge badge-danger text-center"><i class="fas fa-times-circle"></i></span>
                        <?php }?>
                      </td>
                      <td><a href="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
?sn=<?php echo $_smarty_tpl->tpl_vars['data']->value['sn'];?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['title'];?>
</a></td>
                      <td><?php echo $_smarty_tpl->tpl_vars['data']->value['end'];?>
</td>
                      <td><?php echo $_smarty_tpl->tpl_vars['data']->value['priority'];?>
</td>
                      <td><?php echo $_smarty_tpl->tpl_vars['data']->value['assign'];?>
</td>
                      <td><?php echo $_smarty_tpl->tpl_vars['data']->value['create_time'];?>
</td>
                      <td>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
?op=delete&sn=<?php echo $_smarty_tpl->tpl_vars['data']->value['sn'];?>
" class="btn btn-danger"  title="刪除"><i class="fas fa-times-circle"></i> 刪除</a>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
?op=post_form&sn=<?php echo $_smarty_tpl->tpl_vars['data']->value['sn'];?>
" class="btn btn-warning" title="編輯"><i class="fas fa-pencil-alt"></i> 編輯</a>
                      </td>
                  </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </tbody>
              </table>
          </div>
          <?php echo $_smarty_tpl->tpl_vars['bar']->value;?>

        <?php } else { ?>
          <div class="jumbotron text-center">
            <a class="btn btn-info" href="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
?op=post_form" role="button">新增待辦事項</a>
          </div>
        <?php }?>
    <?php }?>

</body>
</html><?php }
}
