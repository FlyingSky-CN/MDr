<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="error-page">
    <div class="mdui-typo-display-1">404 Not Found</div>
    <p><?= _t('你想查看的页面不存在') ?></p>
</div>
<?php $this->need('footer.php'); ?>