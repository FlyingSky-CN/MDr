<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * MDr 是一套基于 MDUI 开发的 Typecho 模板
 * 
 * @package MDr
 * @author FlyingSky
 * @version Petals 0.1
 * @link https://fsky7.com/
 */
$this->need('header.php'); ?>
<div id="main">
    <?php if ($this->options->sitePic) : ?>
        <div class="mdui-card">
            <div class="mdui-card-media">
                <img src="<?= $this->options->sitePic ?>">
            </div>
            <div class="mdui-card-primary mdui-p-y-3">
                <div class="mdui-card-primary-title"><?php $this->options->title(); ?></div>
                <div class="mdui-card-primary-subtitle"><?= $this->options->subTitle ?></div>
            </div>
        </div>
    <?php endif; ?>
    <?php while ($this->next()) : ?>
        <?php if (mdrIsStatus($this) && !$this->hidden) : /* Status Post */ ?>
            <article class="mdui-card mdui-shadow-0 status post<?php if ($this->options->PjaxOption && $this->hidden) : ?> protected<?php endif; ?>">
                <div class="tag"><i class="mdui-icon material-icons">message</i></div>
                <div class="time mdui-text-right">
                    <i class="mdui-icon material-icons mdr-icon-info">&#xe192;</i> <?php $this->date(); ?>
                </div>
                <article class="mdr-post inner">
                    <span class="mdui-typo">
                        <?php $this->content(); ?>
                    </span>
                </article>
            </article>
        <?php else : /* Normal Post */ ?>
            <article class="mdr-post mdui-card mdui-hoverable post<?php if ($this->options->PjaxOption && $this->hidden) : ?> protected<?php endif; ?>">
                <a href="<?php $this->permalink() ?>">
                    <?php if (!$this->hidden && postThumb($this)) : /* If theres thumb */ ?>
                        <div class="mdui-card-media">
                            <?php echo postThumb($this); ?>
                        </div>
                    <?php endif; ?>
                    <div class="mdui-card-primary mdui-p-b-0">
                        <div class="mdui-card-primary-title"><?php $this->title() ?></div>
                    </div>
                    <div class="mdui-card-content mdui-p-b-1 mdui-typo">
                        <?php if ($this->options->PjaxOption && $this->hidden)
                            _e('这篇文章受密码保护，输入密码才能看哦。');
                        else
                            $this->excerpt(200, ''); ?>
                    </div>
                    <div class="mdui-card-content mdui-p-t-1">
                        <div class="mdui-card-primary-subtitle">
                            <div class="mdui-card-primary-subtitle">
                                <i class="mdui-icon material-icons mdr-icon-info">&#xe192;</i>
                                <?php $this->date(); ?>&nbsp;&nbsp;
                                <i class="mdui-icon material-icons mdr-icon-info">&#xe866;</i>
                                <?php $this->category(' ', false); ?>&nbsp;&nbsp;
                                <i class="mdui-icon material-icons mdr-icon-info">&#xe0b9;</i>
                                <?php $this->commentsNum(_t('暂无评论'), _t('%d 条评论')); ?>&nbsp;&nbsp;
                                <i class="mdui-icon material-icons mdr-icon-info">&#xe417;</i>
                                <?php Postviews($this); ?>
                            </div>
                        </div>
                    </div>
                </a>
            </article>
        <?php endif; ?>
    <?php endwhile; ?>
    <?php $this->pageNav('', _t('查看更多'), 0, '', ['wrapClass' => 'ajaxload hidden mdui-p-a-0']); ?>
</div>
<?php $this->need('footer.php'); ?>