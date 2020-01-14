<?php
/**
 * 归档
 *
 * @package custom
 */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="main">
<?php if (!empty($this->options->Breadcrumbs) && in_array('Pageshow', $this->options->Breadcrumbs)): ?>
<div class="mdui-card" style="margin-top:20px;background-color: rgba(180, 180, 180, 0.25);">
    <span class="mdui-chip-icon" style="border-radius:2px;"><i class="mdui-icon material-icons">chevron_right</i></span>
    <span class="mdui-chip-title">
        <a href="<?php $this->options->siteUrl(); ?>">首页</a> &raquo; <?php $this->title() ?>
    </span>
</div>
<?php endif; ?>
<div id="post" class="mdui-card" style="margin-top:20px;">
    <div class="mdui-card-primary">
        <div class="mdui-card-primary-title"><?php $this->title() ?></div>
        <div class="mdui-card-primary-subtitle">Archives</div>
    </div>
    <div class="mdui-card-content mdui-typo" style="padding: 0px 16px 16px 16px;">
        <?php
        $stat = Typecho_Widget::widget('Widget_Stat');
        $this->widget('Widget_Contents_Post_Recent', 'pageSize='.$stat->publishedPostsNum)->to($archives);
        $year=0; $mon=0; $i=0; $j=0;
        $output = '<div class="mdui-list mdui-list-dense">';
        while($archives->next()){
        	$year_tmp = date('Y',$archives->created);
        	if ($year != $year_tmp) {
        		$year = $year_tmp;
        		$output .= '<h4>'.date('Y 年',$archives->created).'</h4>';
        	}
        	if ($this->options->PjaxOption && $archives->hidden) {
        		$output .= '<li class="mdui-list-item mdui-ripple"><div class="mdui-list-item-content">'.date('m/d：',$archives->created).'<a>'. $archives->title .'</a></div></li>';
        	} else {
        		$output .= '<li class="mdui-list-item mdui-ripple"><div class="mdui-list-item-content">'.date('m/d：',$archives->created).'<a href="'.$archives->permalink .'">'. $archives->title .'</a></div></li>';
        	}
        }
        $output .= '</div>';
        echo $output;
        ?>
    </div>
</div>
</div>
<?php $this->need('footer.php'); ?>