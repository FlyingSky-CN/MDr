<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
if ($this->user->hasLogin() && $this->user->pass('administrator', true) and null !== @$_GET['debug']):
    if ($_GET['debug'] == 'start'):
        $_SESSION['mdrConfig'] = $_POST;
        header('Location: '.$this->options->originalSiteUrl.'/?debug=true');
        exit();
    endif;
    if ($_GET['debug'] == 'true'):
        if (!is_array(@$_SESSION['mdrConfig'])):
            header('Location: '.$this->options->originalSiteUrl.'/');
            exit();
        else:
            foreach ($_SESSION['mdrConfig'] as $name => $key):
                $this->options->$name = $key;
            endforeach;
        endif;
    endif;
endif;
?>
<!DOCTYPE html>
<html <?php if ($this->options->mdrPray): ?>class="pray"<?php endif; ?>>
    <head>
        <meta charset="<?php $this->options->charset(); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <?php if ($this->options->mdrChrome): ?>
        <meta name="theme-color" content="<?php echo $this->options->mdrChrome(); ?>">
        <?php else:?>
        <meta name="theme-color" content="#FFFFFF">
        <?php endif;?>
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
        <!-- mdr | Style -->
        <!-- MDUI STR -->
        <link rel="stylesheet" href="<?=staticUrl('mdui.min.css')?>"></script>
        <!-- MDUI END -->
        <?php if (!$this->options->mdrCornertool): ?>
        <!-- mdr | Cornertool -->
        <style>
            *::-webkit-scrollbar {
                width:0px!important;
                height:0px!important
            }
        </style>
        <?php endif; ?>
        <link rel="stylesheet" href="<?php cjUrl('style.css?v=22') ?>" />
        <?php if ($this->options->ViewImg): ?>
        <link rel="stylesheet" href="<?=staticUrl('jquery.fancybox.min.css')?>"/>
        <?php endif; ?>
    </head>
    <body class="<?php if($this->options->DarkMode and @$_COOKIE['dark'] == '1'): ?>mdui-theme-layout-dark<?php endif; ?> <?php if ($this->options->mdrNavDefOpen): ?>mdui-drawer-body-left<?php endif; ?> mdui-appbar-with-toolbar mdui-drawer-body-right mdui-theme-accent-<?=(($this->options->DarkMode and @$_COOKIE['dark']=='1') ? $this->options->mdrAccentD() : $this->options->mdrAccent() )?> mdui-theme-primary-<?=$this->options->mdrPrimary?>">
        <div class="mdui-progress" style="z-index:9999;position: fixed; <?php if ($this->options->mdrLoading == 'bottom') { ?> bottom:0 <?php } else { ?> top:0 <?php } ?>; left:0;display:none;border-radius: 0px;" id="loading">
            <div class="mdui-progress-indeterminate"></div>
        </div>
        <header class="mdui-appbar mdui-appbar-fixed" style="background: #<?php if($this->options->DarkMode and $_COOKIE['dark']=='1') { echo '212121'; } else { echo 'fff'; } ?>;z-index:5000;">
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
        </header>
        <aside class="mdui-drawer <?php if (!$this->options->mdrNavDefOpen): ?>mdui-drawer-close<?php endif; ?>" id="mdrDrawerL" style="z-index: 4000;">
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
        </aside>
        <aside class="mdui-drawer mdui-drawer-right<?php if ($this->options->SidebarFixed): ?> fixed<?php endif; ?>" id="mdrDrawerR" style="z-index: 3000;padding-bottom:128px;">
            <?php $this->need('sidebar.php'); ?>
        </aside>
        <main class="mdui-container">