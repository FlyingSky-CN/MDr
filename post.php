<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="main">
<?php if (!empty($this->options->Breadcrumbs) && in_array('Postshow', $this->options->Breadcrumbs)): ?>
<div class="breadcrumbs">
<a href="<?php $this->options->siteUrl(); ?>">首页</a> &raquo; <?php $this->category(); ?> &raquo; <?php if (!empty($this->options->Breadcrumbs) && in_array('Text', $this->options->Breadcrumbs)): ?>正文<?php else: $this->title(); endif; ?>
</div>
<?php endif; ?>
<article class="post<?php if ($this->options->PjaxOption && $this->hidden): ?> protected<?php endif; ?>">
<h1 class="post-title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h1>
<ul class="post-meta">
<li><?php $this->date(); ?></li>
<li><?php $this->category(','); ?></li>
<li><a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('暂无评论', '%d 条评论'); ?></a></li>
<li><?php Postviews($this); ?></li>
<?php if ($this->options->WordCount): ?>
<li><?php WordCount($this->cid); ?></li>
<?php endif; ?>
</ul>
<div class="post-content mdui-typo">
<?php if ($this->options->TimeNotice): ?>
<?php 
$time=time() - $this->modified;
$lock=$this->options->TimeNoticeLock;
$lock=$lock*24*60*60;
if ($time>=$lock) {
?>
<script defer>
<?php if ($_GET['_pjax']) { ?>
mdui.snackbar({message: '此文章最后修订于 <?php echo date('Y年m月d日' , $this->modified);?>，其中的信息可能已经有所发展或是发生改变。',position: 'right-top',timeout:5000});
<?php } else { ?>
window.onload=function (){
    mdui.snackbar({message: '此文章最后修订于 <?php echo date('Y年m月d日' , $this->modified);?>，其中的信息可能已经有所发展或是发生改变。',position: 'right-top',timeout:5000});
}
<?php } ?>
</script>
<?php } ?>
<?php endif; ?>
<?php $this->content(); ?>
</div>
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
</article>
<p class="tags mdui-typo" style="margin-bottom: 0px;">标签: <?php $this->tags(', ', true, 'none'); ?></p>
<?php $this->need('comments.php'); ?>
<div class="mdui-row" style="margin-top: 32px;margin-bottom: 16px;">
<div class="mdui-ripple mdui-col-xs-6 mdui-col-sm-6" style="text-align: left;">
<div style="display: inline-block;box-sizing: border-box;width: 100%;height: 100%;font-weight: 500;font-size: 20px;line-height: 24px;-webkit-font-smoothing: antialiased;">
<i class="mdui-icon material-icons" style="float: left;margin-right: 10px;padding-top: 24px;width: 24px;">arrow_back</i>
<span style="margin-bottom: 1px;font-size: 15px;line-height: 18px;opacity: .75;">上一篇</span>
<div style="overflow: hidden;margin-left: 34px;height: 24px;text-overflow: ellipsis;white-space: nowrap;"><?php $this->thePrev('%s','没有了'); ?></div>
</div>
</div>
<div class="mdui-ripple mdui-col-xs-6 mdui-col-sm-6" style="text-align: right;">
<div style="display: inline-block;box-sizing: border-box;width: 100%;height: 100%;font-weight: 500;font-size: 20px;line-height: 24px;-webkit-font-smoothing: antialiased;">
<i class="mdui-icon material-icons" style="float: right;margin-left: 10px;padding-top: 24px;width: 24px;">arrow_forward</i>
<span style="margin-bottom: 1px;font-size: 15px;line-height: 18px;opacity: .75;">下一篇</span>
<div style="overflow: hidden;margin-left: 34px;height: 24px;text-overflow: ellipsis;white-space: nowrap;"><?php $this->theNext('%s','没有了'); ?></div>
</div>
</div>
</div>
</div>
<?php $this->need('footer.php'); ?>