<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function threadedComments($comments, $options)
{
    $commentClass = '';
    if ($comments->authorId)
        if ($comments->authorId == $comments->ownerId)
            $commentClass .= ' comment-by-author';
        else
            $commentClass .= ' comment-by-user';
    if ($comments->type == 'pingback') : ?>
        <div id="<?php $comments->theId(); ?>" class="mdui-card comment-body<?= $commentClass ?> mdui-shadow-0 pingback">
            <div class="mdui-card-header">
                <div class="mdui-card-header-avatar" mdui-tooltip="{content: 'Pingback'}">
                    <i class="mdui-icon material-icons">&#xe15e;</i>
                </div>
                <div class="mdui-card-header-title">
                    <?php CommentAuthor($comments); ?>
                </div>
                <div class="mdui-card-header-subtitle"><?php $comments->date(); ?></div>
            </div>
        </div>
    <?php else : ?>
        <div id="<?php $comments->theId(); ?>" class="mdui-card comment-body<?= $commentClass ?>">
            <div class="mdui-card-header">
                <div class="mdui-card-header-avatar">
                    <?php $comments->gravatar('40'); ?>
                </div>
                <div class="mdui-card-header-title">
                    <?php CommentAuthor($comments); ?>
                    <?php if ($comments->authorId == $comments->ownerId) : ?>
                        <span class="author-icon"><?= _t('博主') ?></span>
                    <?php endif; ?>
                </div>
                <div class="mdui-card-header-subtitle"><?php $comments->date(); ?></div>
            </div>
            <div class="mdui-card-content mdui-typo comment-content">
                <?php $comments->content(); ?>
            </div>
            <div class="mdui-card-actions" style="text-align: right">
                <?php if ($comments->status == 'waiting') { ?>
                    <span class="mdui-btn mdui-btn-dense"><?= _t('您的评论正等待审核！') ?></span>
                <?php } ?>
                <span class="mdui-btn mdui-ripple mdui-btn-dense"><?php $comments->reply(); ?></span>
            </div>
            <?php if ($comments->children) : ?>
                <div class="mdui-card-content" style="padding: 0px 8px;">
                    <?php $comments->threadedComments($options); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php } ?>
<!-- mdr | Comments -->
<div id="comments">
    <?php $this->comments()->to($comments); ?>
    <?php if ($this->allow('comment')) : ?>
        <!-- mdr | allowComment -->
        <div class="mdui-card respond" id="<?php $this->respondId(); ?>">
            <div class="mdui-card-primary">
                <div class="mdui-card-primary-title" id="response"><?= _t('发表评论') ?></div>
                <div class="mdui-card-primary-subtitle"><?php $this->commentsNum(_t('暂无评论'), _t('已有 <span class="comment-num">%d</span> 条评论')); ?></div>
            </div>
            <div class="mdui-card-content">
                <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" class="comment-form mdui-row">
                    <div class="mdui-textfield mdui-textfield-floating-label mdui-col-md-12">
                        <i class="mdui-icon material-icons">&#xe0d8;</i>
                        <label class="mdui-textfield-label"><?= _t('说点什么……') ?></label>
                        <textarea class="mdui-textfield-input" name="text" id="textarea" require><?php $this->remember('text'); ?></textarea>
                        <div class="mdui-textfield-error" role="alert"><?= _t('内容不能为空') ?></div>
                    </div>
                    <?php if ($this->user->hasLogin()) : ?>
                        <div class="mdui-textfield mdui-textfield-floating-label mdui-col-md-12">
                            <i class="mdui-icon material-icons">&#xe853;</i>
                            <label class="mdui-textfield-label"><?= _t('登录身份') ?></label>
                            <input class="mdui-textfield-input text" value="<?php $this->user->screenName(); ?>" readonly>
                            <div class="mdui-textfield-error" role="alert"><?= _t('昵称不能为空') ?></div>
                        </div>
                    <?php else : ?>
                        <div class="mdui-textfield mdui-textfield-floating-label mdui-col-md-4">
                            <i class="mdui-icon material-icons">&#xe853;</i>
                            <label class="mdui-textfield-label"><?= _t('昵称') ?></label>
                            <input class="mdui-textfield-input text" type="text" name="author" id="author" value="<?php $this->remember('author'); ?>" required>
                            <div class="mdui-textfield-error" role="alert"><?= _t('昵称不能为空') ?></div>
                        </div>
                        <div class="mdui-textfield mdui-textfield-floating-label mdui-col-md-4">
                            <i class="mdui-icon material-icons">&#xe0be;</i>
                            <label class="mdui-textfield-label"><?= _t('邮箱') ?></label>
                            <input class="mdui-textfield-input text" type="email" name="mail" id="mail" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail) : ?> required<?php endif; ?>>
                            <div class="mdui-textfield-error" role="alert"><?= _t('请按格式填写邮箱') ?></div>
                        </div>
                        <div class="mdui-textfield mdui-textfield-floating-label mdui-col-md-4">
                            <i class="mdui-icon material-icons">&#xe157;</i>
                            <label class="mdui-textfield-label"><?= _t('网站') ?></label>
                            <input class="mdui-textfield-input text" type="url" name="url" id="url" value="<?php $this->remember('url'); ?>" <?php if ($this->options->commentsRequireURL) : ?> required<?php endif; ?>>
                            <div class="mdui-textfield-error" role="alert"><?= _t('请按格式填写网站') ?></div>
                        </div>
                    <?php endif; ?>
                    <div class="mdui-col-md-12">
                        <div class="mdui-btn mdui-ripple cancel-comment-reply" style="display:none">
                            <?php $comments->cancelReply(); ?>
                        </div>
                        <button type="submit" class="submit mdui-btn mdui-ripple mdui-color-theme-accent mdui-float-right"><?= _t('提交评论') ?></button>
                    </div>
                </form>
            </div>
        </div>
        <?php if ($this->options->commentsThreaded) : ?>
            <?php /**Note commentsThreaded => 启用评论回复 */ ?>
            <!-- mdr | commentsThreaded -->
            <script>
                (function() {
                    window.TypechoComment = {
                        dom: function(id) {
                            return document.getElementById(id)
                        },
                        create: function(tag, attr) {
                            var el = document.createElement(tag);
                            for (var key in attr) {
                                el.setAttribute(key, attr[key])
                            }
                            return el
                        },
                        reply: function(cid, coid) {
                            var comment = this.dom(cid),
                                parent = comment.parentNode,
                                response = this.dom('<?php $this->respondId(); ?>'),
                                input = this.dom('comment-parent'),
                                form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                                textarea = response.getElementsByTagName('textarea')[0];
                            if (null == input) {
                                input = this.create('input', {
                                    'type': 'hidden',
                                    'name': 'parent',
                                    'id': 'comment-parent'
                                });
                                form.appendChild(input)
                            }
                            input.setAttribute('value', coid);
                            if (null == this.dom('comment-form-place-holder')) {
                                var holder = this.create('div', {
                                    'id': 'comment-form-place-holder'
                                });
                                response.parentNode.insertBefore(holder, response)
                            }
                            comment.appendChild(response);
                            this.dom('cancel-comment-reply-link').parentNode.style.display = 'inline-block';
                            this.dom('cancel-comment-reply-link').style.display = '';
                            response.style.borderTopLeftRadius = '0';
                            response.style.borderTopRightRadius = '0';
                            response.style.display = 'block';
                            if (null != textarea && 'text' == textarea.name) {
                                textarea.focus()
                            }
                            <?php if (!$this->user->hasLogin()) : ?>
                            <?php endif; ?>
                            return false
                        },
                        cancelReply: function() {
                            var response = this.dom('<?php $this->respondId(); ?>'),
                                holder = this.dom('comment-form-place-holder'),
                                input = this.dom('comment-parent');
                            if (null != input) {
                                input.parentNode.removeChild(input)
                            }
                            if (null == holder) {
                                return true
                            }
                            this.dom('cancel-comment-reply-link').parentNode.style.display = 'none';
                            this.dom('cancel-comment-reply-link').style.display = 'none';
                            response.style.borderTopLeftRadius = '2px';
                            response.style.borderTopRightRadius = '2px';
                            response.style.display = '';
                            holder.parentNode.insertBefore(response, holder);
                            return false
                        }
                    }
                })();
            </script>
        <?php endif; ?>
    <?php else : ?>
        <!-- mdr | unallowComment -->
    <?php endif; ?>
    <?php if ($comments->have()) : ?>
        <?php $comments->listComments(); ?>
        <?php $comments->pageNav(_t('上一页'), _t('下一页'), 0, '...'); ?>
    <?php endif; ?>
</div>