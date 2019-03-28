<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<link rel="stylesheet" href="<?php $this->options->themeUrl('css/comments.css'); ?>">
<?php 
function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }

    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
?>
<?php
            $host = 'https://gravatar.loli.net'; 
            $url = '/avatar/'; 
            $rating = Helper::options()->commentsAvatarRating;
            $hash = md5(strtolower($comments->mail));
			$email = strtolower($comments->mail);
			$qq=str_replace('@qq.com','',$email);
			if(strstr($email,"qq.com") && is_numeric($qq) && strlen($qq) < 11 && strlen($qq) > 4)
			{
			$avatar = '//q3.qlogo.cn/g?b=qq&nk='.$qq.'&s=100';
			}else{
			  $avatar = $host . $url . $hash . '?s=50' . '&r=' . $rating . '&d=mm';
			}       
            ?>
	<div class="vlist">
		<div class="vcard" id="<?php $comments->theId(); ?>">
			<img class="vimg" src="<?php echo $avatar ?>">
			<div class="vh">
				<div class="vhead">
					<span class="vnick"><?php $comments->author(); ?></span><span class="vsys"><?php echo getBrowser($comments->agent); ?></span><span class="vsys"><?php echo getOs($comments->agent); ?></span>
				</div>
				<div class="vmeta" >
					<span class="vtime"><?php $comments->dateWord(); ?></span>
					<span class="vat"><?php $comments->reply('回复'); ?></span>
				</div>
				<div class="vcontent">
					<?php showCommentContent($comments->coid); ?>
				</div>
			</div>
		</div>
		<?php if ($comments->children) { ?>
		<?php $comments->threadedComments($options); ?>
		<?php } ?>
	</div>
<?php } ?>
<?php $this->comments()->to($comments); ?>
<?php if($this->allow('comment')): ?>	
<div class="blog-post-comments v" id="<?php $this->respondId(); ?>">
<form  method="post" action="<?php $this->commentUrl() ?>" id="comment-form">
	<?php if($this->user->hasLogin()): ?>
	<?php _e('登录身份: '); ?><h5><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></h5>
	<div class="vwrap">
		<div class="vheader item3">
		</div>
		<div class="vedit">
			<textarea  name="text" id="veditor" class="veditor vinput" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('misubmit').click();return false};" placeholder="说点什么?"><?php $this->remember('text',false); ?></textarea>
		</div>
		<div class="vcontrol">
			<div class="col col-20" title="Markdown is supported">
				<a href="https://segmentfault.com/markdown" target="_blank"><svg class="markdown" viewbox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M14.85 3H1.15C.52 3 0 3.52 0 4.15v7.69C0 12.48.52 13 1.15 13h13.69c.64 0 1.15-.52 1.15-1.15v-7.7C16 3.52 15.48 3 14.85 3zM9 11H7V8L5.5 9.92 4 8v3H2V5h2l1.5 2L7 5h2v6zm2.99.5L9.5 8H11V5h2v3h1.5l-2.51 3.5z"></path></svg></a>
			</div>
			<div class="col col-80 text-right">
			<button type="submit" title="Cmd|Ctrl+Enter" class="vsubmit vbtn" id="misubmit">回复</button>
			<?php $security = $this->widget('Widget_Security'); ?>
			</div>
		</div>
		<div style="display:none;" class="vmark">
		</div>
	</div>
		<?php else: ?>
		<div class="vwrap">
		<div class="vheader item3">
			<input name="author" placeholder="昵称" class="vnick vinput" type="text" value="<?php $this->remember('author'); ?>" required><input name="mail" placeholder="邮箱" class="vmail vinput" type="email" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?>><input name="url" placeholder="网址(http://)" class="vlink vinput" type="text" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?>>
		</div>
		
		<div class="vedit">
			<textarea  name="text" id="veditor" class="veditor vinput" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('misubmit').click();return false};" placeholder="说点什么?"><?php $this->remember('text'); ?></textarea>
		</div>
		<div class="vcontrol">
			<div class="col col-20" title="Markdown is supported">
				<a href="https://segmentfault.com/markdown" target="_blank"><svg class="markdown" viewbox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M14.85 3H1.15C.52 3 0 3.52 0 4.15v7.69C0 12.48.52 13 1.15 13h13.69c.64 0 1.15-.52 1.15-1.15v-7.7C16 3.52 15.48 3 14.85 3zM9 11H7V8L5.5 9.92 4 8v3H2V5h2l1.5 2L7 5h2v6zm2.99.5L9.5 8H11V5h2v3h1.5l-2.51 3.5z"></path></svg></a>
			</div>
			<div class="col col-80 text-right">
			<?php spam_protection_math();?>
			<button type="submit" title="Cmd|Ctrl+Enter" class="vsubmit vbtn" id="misubmit">回复</button>
			<?php $security = $this->widget('Widget_Security'); ?>
			
			</div>
		</div>
		
		<div style="display:none;" class="vmark">
		</div>
	</div>
	<?php endif; ?>
	</form>
	<?php if($this->commentsNum!=0): ?>
	<div class="vinfo" style="display:block;">
		<div class="vcount col">
			<span class="vnum"><?php $this->commentsNum('%d'); ?></span> 评论
		</div>
	</div>
	<?php else: ?>
	<div class="vempty" style="display:block;">快来做第一个评论的人吧~</div>
	<?php endif; ?>
	<?php if ($comments->have()): ?>
	<?php $comments->listComments(); ?>
	<?php endif; ?>

				<?php $comments->pageNav('<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>',10,'',array('wrapTag' => 'div', 'wrapClass' => 'pagination','itemTag' => '','currentClass' => 'page-number',)); ?>

<?php endif; ?>