<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?php $this->options->charset(); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <?php if ($this->options->favicon): ?>
        <link rel="shortcut icon" href="<?php $this->options->favicon(); ?>" />
        <?php endif; ?>
        <title><?php $this->archiveTitle(array(
        'category'  =>  _t('分类 %s 下的文章'),
        'search'    =>  _t('包含关键字 %s 的文章'),
        'tag'       =>  _t('标签 %s 下的文章'),
        'date'      =>  _t('在 %s 发布的文章'),
        'author'    =>  _t('作者 %s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); if ($this->is('index') && $this->options->subTitle): ?> - <?php $this->options->subTitle(); endif; ?></title>
        <?php $this->header('generator=&template=&pingback=&xmlrpc=&wlw=&commentReply=&rss1=&rss2=&antiSpam=&atom='); ?>
        <!-- MDUI STR -->
        <link rel="stylesheet" href="//<?php if ($this->options->mdrMDUICDN == 'bootcss'): ?>cdn.bootcss.com/mdui/0.4.2/css/mdui.min.css<?php elseif ($this->options->mdrMDUICDN == 'cdnjs'): ?>cdnjs.cloudflare.com/ajax/libs/mdui/0.4.3/css/mdui.min.css<?php else: ?>cdnjs.loli.net/ajax/libs/mdui/0.4.3/css/mdui.min.css<?php endif; ?>"></script>
        <!-- MDUI END -->
        <?php if (!$this->options->mdrCornertool) { ?>
        <style>
            *::-webkit-scrollbar {
                width:0px!important;
                height:0px!important
            }
            *::-webkit-scrollbar-thumb {
                background:#444!important
            }
            *::-webkit-scrollbar-track {
                background:#f3f3f3!important
            }
            *::-webkit-scrollbar-corner {
                background:#f3f3f3!important
            }
        </style>
        <?php } ?>
        <?php if ($this->options->mdrPray) { ?>
        <style>
            body {
                -webkit-filter: grayscale(100%); 
                -moz-filter: grayscale(100%); 
                -ms-filter: grayscale(100%); 
                -o-filter: grayscale(100%); 
                filter: grayscale(100%); 
                filter: gray; 
            }
        </style>
        <?php } ?>
        <?php if ($this->options->DarkMode): ?>
        <style>
            /* Dark mode */
            .mdui-theme-layout-dark a {
                color: #fff!important;
            }
            .mdui-theme-layout-dark .post-meta li {
                border-left: 1px solid #444;
            }
            .mdui-theme-layout-dark #secondary a, .mdui-theme-layout-dark .post-content .more a, .mdui-theme-layout-dark .post-meta, .mdui-theme-layout-dark .widget-tile li {
                color: #aaa;
            }
            .mdui-theme-layout-dark img {
                filter: brightness(75%);
            }
            .mdui-theme-layout-dark .ajaxload a, .mdui-theme-layout-dark .ajaxload .loading:hover, .mdui-theme-layout-dark .ajaxload .loading, .mdui-theme-layout-dark .mdui-row a {
                color: #aaa;
            }
            .mdui-theme-layout-dark .ajaxload a:hover {
                border-color: #bbb;
            }
            .mdui-theme-layout-dark blockquote {
                background: none;
                color: #fff;
            }
            .mdui-theme-layout-dark .textbutton {
                box-shadow: none;
            }
            .mdui-theme-layout-dark .textbutton input, .mdui-theme-layout-dark .respond #textarea {
                background: #424242;
                box-shadow: none;
                border: none;
                color: #fff;
            }
            .mdui-theme-layout-dark .comment-list li, .mdui-theme-layout-dark .whisper .comment-list li, .mdui-theme-layout-dark .comment-list .respond {
                border-color: #424242;
            }
            .mdui-theme-layout-dark .whisper .comment-child {
                background: none;
            }
            .mdui-theme-layout-dark .whisper .comment-body, .mdui-theme-layout-dark .whisper .comment-list li.comment-parent, .mdui-theme-layout-dark .post {
                border: 1px solid #424242;
            }
            /* 滚动条 */
            .mdui-theme-layout-dark *::-webkit-scrollbar-thumb {
                background: #aaa;
            }
            .mdui-theme-layout-dark *::-webkit-scrollbar-track {
                background: #424242;
            }
            .mdui-theme-layout-dark *::-webkit-scrollbar-corner {
                background: #424242;
            }
            .mdui-theme-layout-dark::-webkit-scrollbar-thumb {
                background: #aaa;
            }
            .mdui-theme-layout-dark::-webkit-scrollbar-track {
                background: #424242;
            }
            .mdui-theme-layout-dark::-webkit-scrollbar-corner {
                background: #424242;
            }
            /* Notice */
            .mdui-theme-layout-dark .notie {
                background: rgba(0,0,0,.7)!important;
            }
        </style>
        <?php endif; ?>
        <link rel="stylesheet" href="<?php cjUrl('style.css?v=10') ?>" />
    </head>
    <body class="<?php if($_COOKIE['dark']=='1'): ?>mdui-theme-layout-dark<?php endif; ?> <?php if ($this->options->mdrNavDefOpen): ?>mdui-drawer-body-left<?php endif; ?> mdui-appbar-with-toolbar mdui-drawer-body-right mdui-theme-accent-<?php if($_COOKIE['dark']=='1'){$this->options->mdrAccentD();}else{$this->options->mdrAccent();}?> mdui-theme-primary-<?=$this->options->mdrPrimary?>">
        <div class="mdui-progress" style="z-index:9999;position: fixed; <?php if ($this->options->mdrLoading == 'bottom') { ?> bottom:0 <?php } else { ?> top:0 <?php } ?>; left:0;display:none;border-radius: 0px;" id="loading">
            <div class="mdui-progress-indeterminate"></div>
        </div>
        <div class="mdui-appbar mdui-appbar-fixed" style="background: #<?php if($_COOKIE['dark']=='1') { echo '212121'; } else { echo 'fff'; } ?>;z-index:5000;">
            <div class="mdui-toolbar <?php if ($this->options->mdrNavBackground): ?>mdui-color-theme<?php endif; ?>">
                <a class="mdui-btn mdui-btn-icon" mdui-drawer="{target: '#mdrDrawerL'}">
                    <i class="mdui-icon material-icons">menu</i>
                </a>
                <a href="<?php $this->options->siteUrl(); ?>" class="mdui-typo-title">
                    <?php if ($this->options->customTitle): $this->options->customTitle(); else: $this->options->title(); endif; ?>
                </a>
                <div class="mdui-toolbar-spacer"></div>
                <a class="mdui-btn mdui-btn-icon" mdui-drawer="{target: '#mdrDrawerR'}">
                    <i class="mdui-icon material-icons">more_vert</i>
                </a>
            </div>
        </div>
        <div class="mdui-drawer <?php if (!$this->options->mdrNavDefOpen): ?>mdui-drawer-close<?php endif; ?>" id="mdrDrawerL" style="z-index: 4000;">
            <div class="mdui-appbar mdui-hidden-md-up">
                <div class="mdui-toolbar">
                    <a class="mdui-btn mdui-btn-icon">
                        <i class="mdui-icon material-icons">close</i>
                    </a>
                    <a class="mdui-typo-title"><?php if ($this->options->customTitle): $this->options->customTitle(); else: $this->options->title(); endif; ?></a>
                </div>
            </div>
            <ul class="mdui-list" mdui-collapse="{accordion: true}">
                <a href="<?php $this->options->siteUrl(); ?>">
                    <li class="mdui-list-item mdui-ripple">
                        <i class="mdui-list-item-icon mdui-icon material-icons <?php if ($this->options->mdrNavColorBut) { ?>mdui-text-color-blue<?php } ?>">home</i>
                        <div class="mdui-list-item-content">首页</div>
                    </li>
                </a>
                <?php if (!empty($this->options->Navset) && in_array('ShowCategory', $this->options->Navset)): ?>
                <li class="mdui-collapse-item <?php if (!empty($this->options->Navset) && in_array('OpenCategory', $this->options->Navset)) { echo 'mdui-collapse-item-open'; } ?>">
                    <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
                        <i class="mdui-list-item-icon mdui-icon material-icons <?php if ($this->options->mdrNavColorBut) { ?>mdui-text-color-green<?php } ?>">widgets</i>
                        <div class="mdui-list-item-content">分类</div>
                        <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                    </div>
                    <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">
                        <?php $this->widget('Widget_Metas_Category_List')->to($categorys); while($categorys->next()): if ($categorys->levels == 0): $children = $categorys->getAllChildren($categorys->mid); if (empty($children)): ?>
                        <a href="<?php $categorys->permalink(); ?>">
                            <li class="mdui-list-item mdui-ripple"><?php $categorys->name(); ?></li>
                        </a>
                        <?php else: ?>
                        <a href="<?php $categorys->permalink(); ?>"><li class="mdui-list-item mdui-ripple"><?php $categorys->name(); ?></li></a>
                        <?php foreach ($children as $mid) { $child = $categorys->getCategory($mid); ?>
                        <a href="<?php echo $child['permalink'] ?>"><li class="mdui-list-item mdui-ripple"><?php echo $child['name']; ?></li></a>
                        <?php } endif;endif;endwhile; ?>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (!empty($this->options->Navset) && in_array('ShowPage', $this->options->Navset)): ?>
                <li class="mdui-collapse-item <?php if (!empty($this->options->Navset) && in_array('OpenPage', $this->options->Navset)) { echo 'mdui-collapse-item-open'; } ?>">
                    <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
                        <i class="mdui-list-item-icon mdui-icon material-icons <?php if ($this->options->mdrNavColorBut) { ?>mdui-text-color-deep-orange<?php } ?>">layers</i>
                        <div class="mdui-list-item-content">页面</div>
                        <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                    </div>
                    <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">
                        <?php $this->widget('Widget_Contents_Page_List')->to($pages); while($pages->next()): ?>
                        <a href="<?php $pages->permalink(); ?>"><li class="mdui-list-item mdui-ripple"><?php $pages->title(); ?></li></a>
                        <?php endwhile; ?>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (!empty($this->options->MyLinks)): ?>
                <li class="mdui-collapse-item mdui-collapse-item-open">
                    <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
                        <i class="mdui-list-item-icon mdui-icon material-icons <?php if ($this->options->mdrNavColorBut) { ?>mdui-text-color-purple<?php } ?>">link</i>
                        <div class="mdui-list-item-content">其他</div>
                        <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                    </div>
                    <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">
                        <?php MyLinks($this->options->MyLinks); ?>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (!empty($this->options->Navset) && in_array('ShowArchive', $this->options->Navset)): ?>
                <li class="mdui-collapse-item">
                    <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
                        <i class="mdui-list-item-icon mdui-icon material-icons <?php if ($this->options->mdrNavColorBut) { ?>mdui-text-color-brown<?php } ?>">archive</i>
                        <div class="mdui-list-item-content">归档</div>
                        <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                    </div>
                    <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">
                        <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y 年 n 月')->parse('<a href="{permalink}"><li class="mdui-list-item mdui-ripple">{date}</li></a>'); ?>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="mdui-drawer mdui-drawer-right" id="mdrDrawerR" style="z-index: 3000;padding-bottom:128px;">
            <?php $this->need('sidebar.php'); ?>
        </div>
        <div class="mdui-container">