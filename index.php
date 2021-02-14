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
        <?php if (is_status($this) && !$this->hidden) : /* Status Post */ ?>
            <article class="mdui-card mdui-shadow-0 status post<?php if ($this->options->PjaxOption && $this->hidden) : ?> protected<?php endif; ?>">
                <div class="tag"><i class="mdui-icon material-icons">message</i></div>
                <div class="time mdui-text-right">
                    <i class="mdui-icon material-icons mdr-icon-info">&#xe192;</i> <?php $this->date(); ?>
                </div>
                <article class="inner">
                    <span class="mdui-typo">
                        <?php $this->content(); ?>
                    </span>
                </article>
            </article>
        <?php else : /* Normal Post */ ?>
            <article class="mdui-card mdui-hoverable post<?php if ($this->options->PjaxOption && $this->hidden) : ?> protected<?php endif; ?>">
                <a href="<?php $this->permalink() ?>">
                    <?php if (!$this->hidden && postThumb($this)) : /* If theres thumb */ ?>
                        <div class="mdui-card-media">
                            <?php echo postThumb($this); ?>
                            <div class="mdui-card-media-covered mdui-card-media-covered-gradient">
                                <div class="mdui-card-primary">
                                    <div class="mdui-card-primary-title"><?php $this->title() ?></div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="mdui-card-primary" style="padding-bottom:8px;">
                            <a href="<?php $this->permalink() ?>">
                                <div class="mdui-card-primary-title"><?php $this->title() ?></div>
                            </a>
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
                    <?php endif; ?>
                    <div class="mdui-card-content mdui-p-b-1">
                        <?php if ($this->options->PjaxOption && $this->hidden) : ?>
                            这篇文章受密码保护，输入密码才能看哦
                        <?php else : ?>
                            <?php $this->excerpt(200, ''); ?>
                        <?php endif; ?>
                    </div>
                    <div class="mdui-card-content mdui-p-t-1">
                        <div class="mdui-card-primary-subtitle">
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
                    </div>
                </a>
            </article>
        <?php endif; ?>
    <?php endwhile; ?>
    <?php $this->pageNav('上一页', $this->options->AjaxLoad ? '查看更多' : '下一页', 0, '..', $this->options->AjaxLoad ? array('wrapClass' => 'ajaxload hidden mdui-p-a-0') : ''); ?>
</div>
<?php $this->need('footer.php'); ?>