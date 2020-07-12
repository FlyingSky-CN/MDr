<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="main">
    <div class="mdui-card" style="margin-top:20px;background-color: rgba(180, 180, 180, 0.25);">
        <span class="mdui-chip-icon" style="border-radius:2px;"><i class="mdui-icon material-icons">chevron_right</i></span>
        <span class="mdui-chip-title">
            <a href="<?php $this->options->siteUrl(); ?>">首页</a> &raquo;
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
            <?php if (is_status($this) && !$this->hidden) : ?>
                <div class="mdui-card mdui-shadow-0 status post<?php if ($this->options->PjaxOption && $this->hidden) : ?> protected<?php endif; ?>" style="margin-top: 20px;">
                    <div class="tag"><i class="mdui-icon material-icons">message</i></div>
                    <div class="time mdui-text-right"><?php $this->date(); ?></div>
                    <article class="inner">
                        <span class="mdui-typo">
                            <?php $this->content(); ?>
                        </span>
                    </article>
                </div>
            <?php else : ?>
                <div class="mdui-card post<?php if ($this->options->PjaxOption && $this->hidden) : ?> protected<?php endif; ?>" style="margin-top: 20px;">
                    <?php if ($this->options->PjaxOption && !$this->hidden and postThumb($this)) : ?>
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
                                                <?php if ($this->options->WordCount) : ?>
                                                    | <?php WordCount($this->cid); ?>
                                                <?php endif; ?>
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
                                    <?php if ($this->options->WordCount) : ?>
                                        | <?php WordCount($this->cid); ?>
                                    <?php endif; ?>
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
                        <?php if ($this->options->mdrPostInfo == 'menu') { ?>
                            <button class="mdui-float-left mdui-btn mdui-ripple" mdui-menu="{target: '#post-info-<?= $this->cid ?>', position: 'top'}" style="text-transform:none"><?php $this->date(); ?></button>
                            <ul class="mdui-menu" id="post-info-<?= $this->cid ?>">
                                <li class="mdui-menu-item">
                                    <a class="mdui-ripple">
                                        <?php $this->category(',', false); ?>
                                    </a>
                                </li>
                                <li class="mdui-menu-item">
                                    <a class="mdui-ripple">
                                        <?php Postviews($this); ?>
                                    </a>
                                </li>
                                <li class="mdui-menu-item">
                                    <a class="mdui-ripple">
                                        <?php $this->commentsNum('暂无评论', '%d 条评论'); ?>
                                    </a>
                                </li>
                                <?php if ($this->options->WordCount) : ?>
                                    <li class="mdui-menu-item">
                                        <a class="mdui-ripple">
                                            <?php WordCount($this->cid); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        <?php } ?>
                        <a href="<?php $this->permalink() ?>" class="<?php if ($this->options->mdrPostInfo == 'menu') { ?>mdui-float-right <?php } ?>mdui-btn mdui-ripple" <?php if ($this->options->mdrPostInfo == 'subtitle') { ?> style="width:100%" <?php } ?>>阅读全文</a>
                    </div>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php else : ?>
        <div class="error-page">
            <h2 class="post-title">没有找到内容</h2>
            <p>你想找的东西可能被吃了</p>
        </div>
    <?php endif; ?>
    <?php $this->pageNav('上一页', $this->options->AjaxLoad ? '查看更多' : '下一页', 0, '..', $this->options->AjaxLoad ? array('wrapClass' => 'page-navigator ajaxload') : ''); ?>
</div>
<?php $this->need('footer.php'); ?>