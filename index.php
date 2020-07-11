<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * MDr 是一套基于 MDUI 开发的 Typecho 模板
 * 
 * @package MDr
 * @author FlyingSky
 * @version 1.0.5 Dev
 * @link https://fsky7.com/
 */
$this->need('header.php'); ?>
<div id="main">
    <?php if ($this->_currentPage == 1 && !empty($this->options->ShowWhisper) && in_array('index', $this->options->ShowWhisper)) : ?>
        <?php $whisper = Whisper(); ?>
        <article class="mdui-card mdui-shadow-0 status post">
            <div class="tag"><?= isset($whisper[2]) ? $whisper[2] : '轻语' ?></div>
            <div class="time mdui-text-right">Whisper</div>
            <div class="inner">
                <span class="mdui-typo">
                    <?= $whisper[0] ?>
                </span>
            </div>
        </article>
        <?php if ($this->user->pass('editor', true) && (!FindContents('page-whisper.php') || isset(FindContents('page-whisper.php')[1]))) : ?>
            <div class="mdui-card mdui-shadow-0 mdui-color-red-a700 post">
                <div class="mdui-card-content">
                    <b>仅管理员可见</b><br>
                    <?php if (FindContents('page-whisper.php')) : ?>
                        发现多个"轻语"模板页面，已自动选取内容最多的页面作为展示，请删除多余模板页面。
                    <?php else : ?>
                        未找到"轻语"模板页面，请检查是否创建模板页面。
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
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
                                    <div class="mdui-card-primary-title"><?php $this->title() ?></div>
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
                        <div class="mdui-card-primary-title"><?php $this->title() ?></div>
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
                        <form method="post" style="margin: 14px 0px;">
                            <div class="mdui-row">
                                <div class="mdui-col-xs-12 mdui-col-md-6">
                                    <div class="mdui-textfield" style="padding-bottom: 32px;">
                                        <label class="mdui-textfield-label">请输入密码访问</label>
                                        <input class="mdui-textfield-input" type="password" class="text" name="protectPassword" />
                                    </div>
                                </div>
                                <div class="mdui-col-xs-12 mdui-col-md-6" style="padding-top:40px">
                                    <input type="submit" class="mdui-btn mdui-ripple" value="提交" />
                                </div>
                            </div>
                        </form>
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
            </article>
        <?php endif; ?>
    <?php endwhile; ?>
    <?php $this->pageNav('上一页', $this->options->AjaxLoad ? '查看更多' : '下一页', 0, '..', $this->options->AjaxLoad ? array('wrapClass' => 'page-navigator ajaxload') : ''); ?>
</div>
<?php $this->need('footer.php'); ?>