<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="main">
<?php if (!empty($this->options->Breadcrumbs) && in_array('Pageshow', $this->options->Breadcrumbs)): ?>
<div class="mdui-card" style="margin-top:20px;background-color: rgba(180, 180, 180, 0.25);">
    <span class="mdui-chip-icon" style="border-radius:2px;"><i class="mdui-icon material-icons">chevron_right</i></span>
    <span class="mdui-chip-title">
        <a href="<?php $this->options->siteUrl(); ?>">首页</a> &raquo; <?php $this->title() ?>

    </span>
</div>
<?php endif; ?>
<div class="mdui-card <?php if ($this->options->PjaxOption && $this->hidden): ?> protected<?php endif; ?>" style="margin-top:20px;">
    <div class="mdui-card-media">
        <?php echo postThumb($this); ?>
    </div>
    <div class="mdui-card-primary">
        <div class="mdui-card-primary-title"><?php $this->title() ?></div>
    </div>
    <div class="mdui-card-content mdui-typo" style="padding: 0px 16px 16px 16px;">
<?php $this->content(); ?>

<?php
// linceses
$linceses = $this->fields->linceses;
if ($linceses && $linceses != 'NONE') {
    $linceseslist = array(
        'BY' => '署名 4.0 国际 (CC BY 4.0)',
        'BY-SA' => '署名-相同方式共享 4.0 国际 (CC BY-SA 4.0)',
        'BY-ND' => '署名-禁止演绎 4.0 国际 (CC BY-ND 4.0)',
        'BY-NC' => '署名-非商业性使用 4.0 国际 (CC BY-NC 4.0)',
        'BY-NC-SA' => '署名-非商业性使用-相同方式共享 4.0 国际 (CC BY-NC-SA 4.0)',
        'BY-NC-ND' => '署名-非商业性使用-禁止演绎 4.0 国际 (CC BY-NC-ND 4.0)');
    $lincesestext = $linceseslist[$linceses];
?>
<div class="copyright">本篇文章采用 <a rel="noopener" href="https://creativecommons.org/licenses/<?=strtolower($linceses)?>/4.0/deed.zh" target="_blank" class="external"><?=$lincesestext?></a> 许可协议进行许可。
</div>
<?php
} else {
?>
<div class="copyright">本篇文章未指定许可协议。
</div>
<?php }; ?>
</div>
</div>
<?php $this->need('comments.php'); ?>
</div>
<?php $this->need('footer.php'); ?>