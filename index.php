<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * MDr 是一套基于 MDUI 开发的 Typecho 模板
 * 
 * @package MDr
 * @author FlyingSky
 * @version Petals Dev
 * @link https://fsky7.com/
 */
$this->need('header.php'); ?>
<div id="main">
    <?php while ($this->next()) : ?>
        <?php if (is_status($this) && !$this->hidden) : ?>
            <article class="mdui-card mdui-shadow-0 status post<?php if ($this->options->PjaxOption && $this->hidden) : ?> protected<?php endif; ?>">
                <div class="tag"><i class="mdui-icon material-icons">message</i></div>
                <div class="time mdui-text-right"><?php $this->date(); ?></div>
                <article class="inner">
                    <span class="mdui-typo">
                        <?php $this->content(); ?>
                    </span>
                </article>
            </article>
        <?php else : ?>
            <article class="mdui-card post<?php if ($this->options->PjaxOption && $this->hidden) : ?> protected<?php endif; ?>">
                <?php if (!$this->hidden && postThumb($this)) : ?>
                    <div class="mdui-card-media">
                        <a href="<?php $this->permalink() ?>">
                            <?php echo postThumb($this); ?>
                        </a>
                        <?php if ($this->options->mdrPostTitle != 'normal') { ?>
                            <div class="mdui-card-media-covered mdui-card-media-covered-transparent <?php if ($this->options->mdrPostTitle == 'top') { ?>mdui-card-media-covered-top<?php } ?>">
                                <div class="mdui-card-primary" style="padding-bottom:8px;">
                                    <a href="<?php $this->permalink() ?>">
                                        <div class="mdui-card-primary-title"><?php $this->title() ?></div>
                                    </a>
                                    <?php if ($this->options->mdrPostInfo == 'subtitle') { ?>
                                        <div class="mdui-card-primary-subtitle">
                                            <?php $this->date(); ?>
                                            | <?php $this->category(',', false); ?>
                                            | <?php $this->commentsNum('暂无评论', '%d 条评论'); ?>
                                            | <?php Postviews($this); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->options->mdrPostTitle == 'normal' || !postThumb($this)) { ?>
                    <div class="mdui-card-primary" style="padding-bottom:8px;">
                        <a href="<?php $this->permalink() ?>">
                            <div class="mdui-card-primary-title"><?php $this->title() ?></div>
                        </a>
                        <?php if ($this->options->mdrPostInfo == 'subtitle') { ?>
                            <div class="mdui-card-primary-subtitle">
                                <?php $this->date(); ?>
                                | <?php $this->category(',', false); ?>
                                | <?php $this->commentsNum('暂无评论', '%d 条评论'); ?>
                                | <?php Postviews($this); ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="mdui-card-content" style="padding: 0px 16px;">
                    <?php if ($this->options->PjaxOption && $this->hidden) : ?>
                        <p>这篇文章受密码保护，输入密码才能看哦</p>
                    <?php else : ?>
                        <p><?php $this->excerpt(200, ''); ?></p>
                    <?php endif; ?>
                </div>
                <div class="mdui-card-actions" style="text-align: center">
                    <a href="<?php $this->permalink() ?>" class="<?php if ($this->options->mdrPostInfo == 'menu') { ?>mdui-float-right <?php } ?>mdui-btn mdui-ripple" <?php if ($this->options->mdrPostInfo == 'subtitle') { ?> style="width:100%" <?php } ?>>阅读全文</a>
                </div>
            </article>
        <?php endif; ?>
    <?php endwhile; ?>
    <?php $this->pageNav('上一页', $this->options->AjaxLoad ? '查看更多' : '下一页', 0, '..', $this->options->AjaxLoad ? array('wrapClass' => 'page-navigator ajaxload') : ''); ?>
</div>
<?php $this->need('footer.php'); ?>