<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="main">
    <div class="mdui-card breadcrumbs">
        <span class="mdui-chip-icon"><i class="mdui-icon material-icons">chevron_right</i></span>
        <span class="mdui-chip-title mdui-p-l-0">
            <a href="<?php $this->options->siteUrl(); ?>">首页</a> &nbsp;&raquo;&nbsp;
            <?php $this->category(' & '); ?> &nbsp;&raquo;&nbsp;
            <?= $this->title() ?>
        </span>
    </div>
    <div id="post" class="mdui-card<?php if ($this->options->PjaxOption && $this->hidden) : ?> protected<?php endif; ?> mdui-shadow-6" style="margin-top:20px;">
        <?php if (postThumb($this) && !$this->hidden) : ?>
            <div class="mdui-card-media">
                <?php echo postThumb($this); ?>
            </div>
        <?php endif; ?>
        <div class="mdui-card-primary">
            <div class="mdui-card-primary-title"><?php $this->title() ?></div>
            <div class="mdui-card-primary-subtitle">
                <i class="mdui-icon material-icons mdr-icon-info">&#xe192;</i>
                <?php $this->date(); ?>&nbsp;&nbsp;
                <i class="mdui-icon material-icons mdr-icon-info">&#xe866;</i>
                <?php $this->category(' ', false); ?>&nbsp;&nbsp;
                <i class="mdui-icon material-icons mdr-icon-info">&#xe0b9;</i>
                <?php $this->commentsNum('暂无评论', '%d 条评论'); ?>&nbsp;&nbsp;
                <i class="mdui-icon material-icons mdr-icon-info">&#xe417;</i>
                <?php Postviews($this); ?>
            </div>
        </div>
        <?php if ($this->options->mdrPostAuthor) : ?>
            <div class="mdui-card-header">
                <div class="mdui-card-header-avatar"><?php $this->author->gravatar(40); ?></div>
                <div class="mdui-card-header-title"><a href="<?php $this->author->permalink(); ?>"><?php $this->author() ?></a></div>
                <div class="mdui-card-header-subtitle">author</div>
            </div>
        <?php endif; ?>
        <div class="mdui-card-content mdui-typo">
            <?php /* MDr Time Notice */
            if ($this->options->TimeNotice && !$this->hidden) :
                if ((time() - $this->modified) >= ($this->options->TimeNoticeLock) * 24 * 60 * 60) : ?>
                    <script defer>
                        <?php if (!MDR_PJAX) echo "window.onload = () => {"; ?>
                        mdui.snackbar({
                            message: '此文章最后修订于 <?= date('Y年m月d日', $this->modified) ?>，其中的信息可能已经有所发展或是发生改变。',
                            position: '<?= $this->options->mdrSnackbar ?>',
                            timeout: 5000
                        });
                        <?php if (!MDR_PJAX) echo "}"; ?>
                    </script>
            <?php endif;
            endif; ?>
            <?php $this->content(); ?>
            <?php if (!$this->hidden) : ?>
                <?php license($this->fields->linceses); ?>
                <script defer>
                    <?php if (!MDR_PJAX) echo "window.onload = () => {"; ?>
                    mdrCatalog(<?= json_encode(getCatalog($this->content)) ?>)
                    <?php if (!MDR_PJAX) echo "}"; ?>
                </script>
            <?php endif; ?>
        </div>
    </div>
    <?php if (!$this->hidden) : ?>
        <div class="tags"><?php mdrTags($this); ?></div>
        <?php $this->need('comments.php'); ?>
    <?php endif; ?>
    <div class="mdui-row footer-nav">
        <div class="mdui-ripple mdui-col-xs-6 mdui-col-sm-6 footer-nav-left">
            <div class="footer-nav-inner">
                <i class="mdui-icon material-icons footer-nav-icon">arrow_back</i>
                <span class="footer-nav-title">上一篇</span>
                <div class="footer-nav-text"><?php $this->thePrev('%s', '没有了'); ?></div>
            </div>
        </div>
        <div class="mdui-ripple mdui-col-xs-6 mdui-col-sm-6 footer-nav-right">
            <div class="footer-nav-inner">
                <i class="mdui-icon material-icons footer-nav-icon">arrow_forward</i>
                <span class="footer-nav-title">下一篇</span>
                <div class="footer-nav-text"><?php $this->theNext('%s', '没有了'); ?></div>
            </div>
        </div>
    </div>
</div>
<?php $this->need('footer.php'); ?>