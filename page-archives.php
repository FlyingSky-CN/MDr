<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 归档
 *
 * @package custom
 */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="main">
    <?php if (!empty($this->options->Breadcrumbs) && in_array('Pageshow', $this->options->Breadcrumbs)) : ?>
        <div class="mdui-card mdr-breadcrumbs">
            <span class="mdui-chip-icon"><i class="mdui-icon material-icons">&#xe5cc;</i></span>
            <span class="mdui-chip-title">
                <a href="<?php $this->options->siteUrl(); ?>">首页</a> &raquo; <?php $this->title() ?>
            </span>
        </div>
    <?php endif; ?>
    <article id="post" class="mdr-post mdui-card mdui-shadow-6" style="margin-top:20px;">
        <div class="mdui-card-media">
            <?php echo postThumb($this); ?>
        </div>
        <div class="mdui-card-primary">
            <div class="mdui-card-primary-title"><?php $this->title() ?></div>
            <div class="mdui-card-primary-subtitle">Archives</div>
        </div>
        <div class="mdui-card-content" style="padding: 0px;">
            <div class="mdui-list mdui-list-dense">
                <?php
                $this->widget(
                    'Widget_Contents_Post_Recent',
                    'pageSize=' . Typecho_Widget::widget('Widget_Stat')->publishedPostsNum
                )->to($archives);
                $current_year = 0;
                while ($archives->next()) {
                    $year_tmp = date('Y', $archives->created);
                    if ($current_year != $year_tmp) {
                        $current_year = $year_tmp;
                        print('<li class="mdui-subheader">' . date('Y', $archives->created) . '</li>');
                    }
                    print('<a href="' . $archives->permalink . '"><li class="mdui-list-item mdui-ripple"><div class="mdui-list-item-content">' . date('m/d ', $archives->created) . $archives->title . '</div></li></a>');
                } ?>
            </div>
        </div>
    </article>
</div>
<?php $this->need('footer.php'); ?>