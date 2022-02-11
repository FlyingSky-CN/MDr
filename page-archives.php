<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 归档
 *
 * @package custom
 */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<?php if (!empty($this->options->Breadcrumbs) && in_array('Pageshow', $this->options->Breadcrumbs)) : ?>
    <div class="mdui-card mdr-breadcrumbs">
        <span class="mdui-chip-icon"><i class="mdui-icon material-icons">&#xe5cc;</i></span>
        <span class="mdui-chip-title">
            <a href="<?php $this->options->siteUrl(); ?>"><?= _t('首页') ?></a> &raquo; <?php $this->title() ?>
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
        <?php
        $stat = Typecho_Widget::widget('Widget_Stat');
        $this->widget('Widget_Contents_Post_Recent', 'pageSize=' . $stat->publishedPostsNum)->to($archives);
        $year = 0;
        $mon = 0;
        $i = 0;
        $j = 0;
        $output = '<div class="mdui-list mdui-list-dense">';
        while ($archives->next()) {
            $year_tmp = date('Y', $archives->created);
            if ($year != $year_tmp) {
                $year = $year_tmp;
                $output .= '<li class="mdui-subheader">' . date('Y', $archives->created) . '</li>';
            }
            if ($this->options->PjaxOption && $archives->hidden) {
                $output .= '<li class="mdui-list-item mdui-ripple"><div class="mdui-list-item-content">' . date('m/d ', $archives->created) . $archives->title . '</div></li>';
            } else {
                $output .= '<a href="' . $archives->permalink . '"><li class="mdui-list-item mdui-ripple"><div class="mdui-list-item-content">' . date('m/d ', $archives->created) . $archives->title . '</div></li></a>';
            }
        }
        $output .= '</div>';
        echo $output;
        ?>
    </div>
</article>
<?php $this->need('footer.php'); ?>