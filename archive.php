<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="main">
    <div class="mdui-card breadcrumbs">
        <span class="mdui-chip-icon"><i class="mdui-icon material-icons">chevron_right</i></span>
        <span class="mdui-chip-title mdui-p-l-0">
            <a href="<?php $this->options->siteUrl(); ?>">首页</a> &nbsp;&raquo;&nbsp;
            <?php $this->archiveTitle([
                'category'  =>  _t('分类 %s 下的文章'),
                'search'    =>  _t('包含关键字 %s 的文章'),
                'tag'       =>  _t('标签 %s 下的文章'),
                'date'      =>  _t('在 %s 发布的文章'),
                'author'    =>  _t('作者 %s 发布的文章')
            ], '', ''); ?>
        </span>
    </div>
    <?php if ($this->have()) : ?>
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
                            </div>
                        <?php endif; ?>
                        <div class="mdui-card-primary mdui-p-b-0">
                            <div class="mdui-card-primary-title"><?php $this->title() ?></div>
                        </div>
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
    <?php else : ?>
        <div class="error-page">
            <div class="mdui-typo-display-1">404 Not Found</div>
            <p>没有找到你想要的结果</p>
        </div>
    <?php endif; ?>
    <?php $this->pageNav('', '查看更多', 0, '', array('wrapClass' => 'ajaxload mdui-p-a-0')); ?>
</div>
<?php $this->need('footer.php'); ?>