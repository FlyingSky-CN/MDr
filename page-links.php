<?php
/**
 * 链接
 *
 * @package custom
 */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="main">
<?php if (!empty($this->options->Breadcrumbs) && in_array('Pageshow', $this->options->Breadcrumbs)): ?>
<div class="breadcrumbs">
<a href="<?php $this->options->siteUrl(); ?>">首页</a> &raquo; <?php $this->title() ?>
</div>
<?php endif; ?>
<article class="post">
<h1 class="post-title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h1>
<div class="post-content">
<div class="mdui-typo">
<?php $this->content(); ?>
</div>
<div class="mdui-row-xs-1 mdui-row-sm-2 mdui-row-md-3">
<?php Links(); ?>
</div>
</div>
</article>
<?php $this->need('comments.php'); ?>
</div>
<?php $this->need('footer.php'); ?>