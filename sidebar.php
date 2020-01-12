<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if (!empty($this->options->ShowWhisper) && in_array('sidebar', $this->options->ShowWhisper)): ?>
<div class="widget">
    <form method="post" id="search" action="<?php $this->options->siteUrl(); ?>">
        <div class="mdui-textfield mdui-textfield-floating-label">
            <label class="mdui-textfield-label">Search</label>
            <input class="mdui-textfield-input" type="text" id="s" name="s"/>
        </div>
    </form>
</div>
<div class="widget">
<h3 class="widget-title"><?php echo FindContents('page-whisper.php') ? FindContents('page-whisper.php', 'commentsNum', 'd')[0]['title'] : '轻语' ?></h3>
<ul class="widget-list whisper">
<?php Whisper(1); ?>
<?php if ($this->user->pass('editor', true) && (!FindContents('page-whisper.php') || isset(FindContents('page-whisper.php')[1]))): ?>
<li class="notice"><b>仅管理员可见: </b><br><?php echo FindContents('page-whisper.php') ? '发现多个"轻语"模板页面，已自动选取内容最多的页面作为展示，请删除多余模板页面。' : '未找到"轻语"模板页面，请检查是否创建模板页面。' ?></li>
<?php endif; ?>
</ul>
</div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowWaySit', $this->options->sidebarBlock)): ?>
<div class="widget">
<?=$this->options->WaySit?>
</div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowEatFoodSit', $this->options->sidebarBlock)): ?>
<div class="widget">
<?=$this->options->EatFoodSit?>
</div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowHotPosts', $this->options->sidebarBlock)): ?>
<div class="widget">
<h3 class="widget-title">热门文章</h3>
<ul class="widget-list">
<?php Contents_Post_Initial($this->options->postsListSize, 'views'); ?>
</ul>
</div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
<div class="widget">
<h3 class="widget-title">最新文章</h3>
<ul class="widget-list">
<?php Contents_Post_Initial($this->options->postsListSize); ?>
</ul>
</div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
<div class="widget">
<h3 class="widget-title">最近回复</h3>
<ul class="widget-list">
<?php Contents_Comments_Initial($this->options->commentsListSize, in_array('IgnoreAuthor', $this->options->sidebarBlock) ? 1 : ''); ?>
</ul>
</div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
<div class="widget">
<h3 class="widget-title">分类</h3>
<ul class="widget-tile">
<?php $this->widget('Widget_Metas_Category_List')
->parse('<li><a href="{permalink}">{name}</a></li>'); ?>
</ul>
</div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowTag', $this->options->sidebarBlock)): ?>
<div class="widget">
<h3 class="widget-title">标签</h3>
<ul class="widget-tile">
<?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=30')->to($tags); ?>
<?php if($tags->have()): ?>
<?php while($tags->next()): ?>
<li><a href="<?php $tags->permalink(); ?>"><?php $tags->name(); ?></a></li>
<?php endwhile; ?>
<?php else: ?>
<li>暂无标签</li>
<?php endif; ?>
</ul>
</div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowArchive', $this->options->sidebarBlock)): ?>
<div class="widget">
<h3 class="widget-title">归档</h3>
<ul class="widget-list">
<?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y 年 n 月')
->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
</ul>
</div>
<?php endif; ?>
<?php if (!empty($this->options->ShowLinks) && in_array('sidebar', $this->options->ShowLinks)): ?>
<div class="widget">
<h3 class="widget-title">链接</h3>
<ul class="widget-tile">
<?php Links(true); ?>
<?php if (FindContents('page-links.php', 'order', 'a', 1)): ?>
<li class="more"><a href="<?php echo FindContents('page-links.php', 'order', 'a', 1)[0]['permalink']; ?>">查看更多...</a></li>
<?php endif; ?>
</ul>
</div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowStats', $this->options->sidebarBlock)): ?>
<div class="widget">
<h3 class="widget-title">网站统计</h3>
<ul class="widget-tile" id="stat">
<?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
<li>文章总数： <?php $stat->publishedPostsNum() ?> 篇 </li>
<li>评论总数： <?php $stat->publishedCommentsNum() ?> 条 </li>
<li>总访问量： <?php echo theAllViews() ?> ( PV ) </li>
</ul>
</div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowOther', $this->options->sidebarBlock)): ?>
<div class="widget">
<h3 class="widget-title">其它</h3>
<ul class="widget-list">
<li><a href="<?php $this->options->feedUrl(); ?>" target="_blank">文章 RSS</a></li>
<li><a href="<?php $this->options->commentsFeedUrl(); ?>" target="_blank">评论 RSS</a></li>
<?php if($this->user->hasLogin()): ?>
<li><a href="<?php $this->options->adminUrl(); ?>" target="_blank">进入后台 (<?php $this->user->screenName(); ?>)</a></li>
<li><a href="<?php $this->options->logoutUrl(); ?>"<?php if ($this->options->PjaxOption): ?> no-pjax <?php endif; ?>>退出</a></li>
<?php endif; ?>
</ul>
</div>
<?php endif; ?>