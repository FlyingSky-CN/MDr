<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="mdui-card mdr-breadcrumbs">
    <span class="mdui-chip-icon"><i class="mdui-icon material-icons">&#xe5cc;</i></span>
    <span class="mdui-chip-title mdui-p-l-0">
        <a href="<?php $this->options->siteUrl(); ?>"><?= _t('首页') ?></a> &nbsp;&raquo;&nbsp;
        <?php $this->title() ?>
    </span>
</div>
<article id="post" class="mdr-post mdui-card <?php if ($this->options->PjaxOption && $this->hidden) : ?> protected<?php endif; ?> mdui-shadow-6" style="margin-top:20px;">
    <div class="mdui-card-media">
        <?= postThumb($this) ?>
    </div>
    <div class="mdui-card-primary">
        <div class="mdui-card-primary-title"><?php $this->title() ?></div>
    </div>
    <div class="mdui-card-content mdui-typo" style="padding: 0px 16px 16px 16px;">
        <?php $this->content(); ?>
    </div>
    <?= mdrLicense($this->fields->linceses) ?>
</article>
<?php $this->need('comments.php'); ?>
<?php $this->need('footer.php'); ?>