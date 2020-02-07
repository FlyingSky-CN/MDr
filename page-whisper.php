<?php
/**
 * 轻语
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
<div id="main">
<?php if (!empty($this->options->Breadcrumbs) && in_array('Pageshow', $this->options->Breadcrumbs)): ?>
<div class="mdui-card" style="margin-top:20px;background-color: rgba(180, 180, 180, 0.25);">
    <span class="mdui-chip-icon" style="border-radius:2px;"><i class="mdui-icon material-icons">chevron_right</i></span>
    <span class="mdui-chip-title">
        <a href="<?php $this->options->siteUrl(); ?>">首页</a> &raquo; <?php $this->title() ?>
    </span>
</div>
<?php endif; ?>
<div id="post" class="mdui-card" style="margin-top:20px;">
	<div class="mdui-card-media">
        <?php echo postThumb($this); ?>
    </div>
    <div class="mdui-card-primary">
        <div class="mdui-card-primary-title"><?php $this->title() ?></div>
        <div class="mdui-card-primary-subtitle">Whisper</div>
    </div>
	<?php if ($this->content()) { ?>
    <div class="mdui-card-content mdui-typo" style="padding: 0px 16px 16px 16px;">
        <?php $this->content(); ?>
	</div>
	<?php } ?>
</div>
<?php $this->need('comments.php'); ?>
</div>
<?php $this->need('footer.php'); ?>