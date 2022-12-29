<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 链接
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
    <div class="mdui-card-primary">
        <div class="mdui-card-primary-title"><?php $this->title() ?></div>
        <div class="mdui-card-primary-subtitle">Links</div>
    </div>
    <div class="mdui-card-content mdui-typo" style="padding: 0px 16px 16px 16px;">
        <?php $this->content(); ?>
    </div>
</article>
<div class="mdui-row-xs-1 mdui-row-sm-2 mdui-row-md-3" style="margin: -16px -8px 0;">
    <?php Links(); ?>
    <?php if ($this->options->RandomLinks) : ?>
        <script>
            var cards = document.getElementsByClassName('mdui-col');
            for (var i = 0; i < cards.length; i++) {
                var target1 = Math.floor(Math.random() * cards.length - 1) + 1;
                var target2 = Math.floor(Math.random() * cards.length - 1) + 1;
                cards[target1].before(cards[target2]);
            }
        </script>
    <?php endif; ?>
</div>
<?php $this->need('comments.php'); ?>
<?php $this->need('footer.php'); ?>