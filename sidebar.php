<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if (!empty($this->options->ShowWhisper) && in_array('sidebar', $this->options->ShowWhisper)) : ?>
    <?php $whisper = Whisper(); ?>
    <div class="widget">
        <h3 class="widget-title"><?= isset($whisper[2]) ? $whisper[2] : '轻语' ?></h3>
        <ul class="widget-list whisper">
            <?= $whisper[0] ?>
            <?php if (FindContents('page-whisper.php')) : ?>
                <li class="more"><a href="<?= $whisper[1] ?>">查看更多...</a></li>
            <?php endif; ?>
            <?php if ($this->user->pass('editor', true) && (!FindContents('page-whisper.php') || isset(FindContents('page-whisper.php')[1]))) : ?>
                <div class="mdui-card mdui-shadow-0 mdui-color-red-a700" style="margin-top: 20px">
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
        </ul>
    </div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowWaySit', $this->options->sidebarBlock)) : ?>
    <div class="widget"><?= $this->options->WaySit ?></div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowEatFoodSit', $this->options->sidebarBlock)) : ?>
    <div class="widget">
        <?= $this->options->EatFoodSit ?>
    </div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowHotPosts', $this->options->sidebarBlock)) : ?>
    <div class="widget">
        <h3 class="widget-title">热门文章</h3>
        <ul class="widget-list">
            <?php Contents_Post_Initial($this->options->postsListSize, 'views'); ?>
        </ul>
    </div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)) : ?>
    <div class="widget">
        <h3 class="widget-title">最新文章</h3>
        <ul class="widget-list">
            <?php Contents_Post_Initial($this->options->postsListSize); ?>
        </ul>
    </div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentComments', $this->options->sidebarBlock)) : ?>
    <div class="widget">
        <h3 class="widget-title">最近回复</h3>
        <ul class="widget-list">
            <?php Contents_Comments_Initial($this->options->commentsListSize, in_array('IgnoreAuthor', $this->options->sidebarBlock) ? 1 : ''); ?>
        </ul>
    </div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)) : ?>
    <div class="widget">
        <h3 class="widget-title">分类</h3>
        <ul class="widget-tile">
            <?php $this->widget('Widget_Metas_Category_List')
                ->parse('<li><a href="{permalink}">{name}</a></li>'); ?>
        </ul>
    </div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowTag', $this->options->sidebarBlock)) : ?>
    <div class="widget">
        <h3 class="widget-title">标签</h3>
        <ul class="widget-tile">
            <?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=20')->to($tags); ?>
            <?php if ($tags->have()) : ?>
                <?php while ($tags->next()) : ?>
                    <div class="mdui-chip"><a href="<?php $tags->permalink(); ?>"><span class="mdui-chip-title"><?php $tags->name(); ?></span></a></div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="mdui-chip"><span class="mdui-chip-title">None</span></div>
            <?php endif; ?>
        </ul>
    </div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowArchive', $this->options->sidebarBlock)) : ?>
    <div class="widget">
        <h3 class="widget-title">归档</h3>
        <ul class="widget-list">
            <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y 年 n 月')
                ->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
        </ul>
    </div>
<?php endif; ?>
<?php if (!empty($this->options->ShowLinks) && in_array('sidebar', $this->options->ShowLinks)) : ?>
    <div class="widget">
        <h3 class="widget-title">链接</h3>
        <ul class="widget-tile">
            <?php Links(true); ?>
            <?php if (FindContents('page-links.php', 'order', 'a', 1)) : ?>
                <div class="mdui-chip">
                    <a href="<?php echo FindContents('page-links.php', 'order', 'a', 1)[0]['permalink']; ?>">
                        <span class="mdui-chip-title">查看更多</span>
                    </a>
                </div>
            <?php endif; ?>
        </ul>
    </div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowStats', $this->options->sidebarBlock)) : ?>
    <div class="widget">
        <h3 class="widget-title">网站统计</h3>
        <ul class="widget-list">
            <?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
            <li>文章总数: <?php $stat->publishedPostsNum() ?> 篇 </li>
            <li>评论总数: <?php $stat->publishedCommentsNum() ?> 条 </li>
            <li>总访问量: <?php echo theAllViews() ?></li>
        </ul>
    </div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowOther', $this->options->sidebarBlock)) : ?>
    <div class="widget">
        <h3 class="widget-title">其它</h3>
        <ul class="widget-list">
            <li><a href="<?php $this->options->feedUrl(); ?>" target="_blank">文章 RSS</a></li>
            <li><a href="<?php $this->options->commentsFeedUrl(); ?>" target="_blank">评论 RSS</a></li>
            <?php if ($this->user->hasLogin()) : ?>
                <li><a href="<?php $this->options->adminUrl(); ?>" target="_blank">进入后台 (<?php $this->user->screenName(); ?>)</a></li>
                <li><a href="<?php $this->options->logoutUrl(); ?>" <?php if ($this->options->PjaxOption) : ?> no-pjax <?php endif; ?>>退出</a></li>
            <?php endif; ?>
        </ul>
    </div>
<?php endif; ?>