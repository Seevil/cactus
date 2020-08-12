<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<link rel="stylesheet" href="<?php $this->options->themeUrl('css/comments.css'); ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('lib/OwO/OwO.min.css'); ?>">
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
	
		<div class="vcard" id="<?php $comments->theId(); ?>">
			<img class="vimg" src="<?php echo $avatar ?>">
			<div class="vh">
				<div class="vhead">
					<span class="vnick"><?php $comments->author(); ?></span><span class="vsys"><?php echo getBrowser($comments->agent); ?></span><span class="vsys"><?php echo getOs($comments->agent); ?></span>
				</div>
				<div class="vmeta" >
					<span class="vtime"><?php $comments->dateWord(); ?></span>
					<span class="vat comment-reply cp-<?php $comments->theId(); ?> text-muted comment-reply-link"><?php $comments->reply('回复'); ?></span><span id="vat cancel-comment-reply" class="cancel-comment-reply cl-<?php $comments->theId(); ?> text-muted comment-reply-link" style="display:none" ><?php $comments->cancelReply('取消'); ?></span>
				</div>
				<div class="vcontent">
					<?php showCommentContent($comments->coid); ?>
				</div>
				
				
			</div>
		</div>
		<?php if ($comments->children) { ?>
		<?php $comments->threadedComments($options); ?>
		<?php } ?>
	
<?php } ?>
<?php $this->comments()->to($comments); ?>
<?php if($this->allow('comment')): ?>	
<div class="blog-post-comments v" id="comments">
<div class="blog-post-comments v" id="<?php $this->respondId(); ?>">
<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form">
	<?php if($this->user->hasLogin()): ?>
	<?php _e('登录身份: '); ?><h5><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></h5>

		<div class="vwrap">
		<?php else: ?>
		<div class="vwrap">
		<div class="vheader item3">
			<input name="author" placeholder="昵称" class="vnick vinput" type="text" value="<?php $this->remember('author'); ?>" required><input name="mail" placeholder="邮箱" class="vmail vinput" type="email" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?>><input name="url" placeholder="网址(http://)" class="vlink vinput" type="url" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?>>
		</div>
		<?php endif; ?>
		<div class="vedit">
			<textarea  name="text" id="veditor" class="OwO-textarea veditor vinput" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('misubmit').click();return false};" placeholder="说点什么?"><?php $this->remember('text'); ?></textarea>
			<div class="vrow"><div class="vcol vcol-60 status-bar"></div><div class="vcol vcol-40 vctrl text-right"><div title="表情" class="OwO"></div></div></div>
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
	
	</form>
	</div>
	<?php if($this->commentsNum!=0): ?>
	<div class="vinfo" style="display:block;">
		<div class="vcount col">
			<span class="vnum"><?php $this->commentsNum('%d'); ?></span> 评论
		</div>
	</div>
	<?php else: ?>
	<div class="vempty" style="display:block;">快来做第一个评论的人吧~</div>
	<?php endif; ?>
	<div class="vlist">
	<?php if ($comments->have()): ?>
	<?php $comments->listComments(); ?>
	<?php endif; ?>
	</div>
	<?php $comments->pageNav('<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>',10,'',array('wrapTag' => 'div', 'wrapClass' => 'pagination','itemTag' => '','currentClass' => 'page-number',)); ?>
	
</div>
	<script type="text/javascript">
function showhidediv(id){var sbtitle=document.getElementById(id);if(sbtitle){if(sbtitle.style.display=='flex'){sbtitle.style.display='none';}else{sbtitle.style.display='flex';}}}
(function(){window.TypechoComment={dom:function(id){return document.getElementById(id)},pom:function(id){return document.getElementsByClassName(id)[0]},iom:function(id,dis){var alist=document.getElementsByClassName(id);if(alist){for(var idx=0;idx<alist.length;idx++){var mya=alist[idx];mya.style.display=dis}}},create:function(tag,attr){var el=document.createElement(tag);for(var key in attr){el.setAttribute(key,attr[key])}return el},reply:function(cid,coid){var comment=this.dom(cid),parent=comment.parentNode,response=this.dom("<?php echo $this->respondId(); ?>"),input=this.dom("comment-parent"),form="form"==response.tagName?response:response.getElementsByTagName("form")[0],textarea=response.getElementsByTagName("textarea")[0];if(null==input){input=this.create("input",{"type":"hidden","name":"parent","id":"comment-parent"});form.appendChild(input)}input.setAttribute("value",coid);if(null==this.dom("comment-form-place-holder")){var holder=this.create("div",{"id":"comment-form-place-holder"});response.parentNode.insertBefore(holder,response)}comment.appendChild(response);this.iom("comment-reply","");this.pom("cp-"+cid).style.display="none";this.iom("cancel-comment-reply","none");this.pom("cl-"+cid).style.display="";if(null!=textarea&&"text"==textarea.name){textarea.focus()}return false},cancelReply:function(){var response=this.dom("<?php echo $this->respondId(); ?>"),holder=this.dom("comment-form-place-holder"),input=this.dom("comment-parent");if(null!=input){input.parentNode.removeChild(input)}if(null==holder){return true}this.iom("comment-reply","");this.iom("cancel-comment-reply","none");holder.parentNode.insertBefore(response,holder);return false}}})();
</script>
	<script src="<?php $this->options->themeUrl('lib/OwO/OwO.min.js'); ?>"></script>
	<script type="text/javascript">
//OwO
var OwO_winds = new OwO({
    logo: '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>',
    container: document.getElementsByClassName('OwO')[0],
    target: document.getElementsByClassName('OwO-textarea')[0],
    api: '<?php if ($this->options->Emoji == 'able'): ?><?php $this->options->themeUrl('lib/OwO/OwO.json'); ?><?php else: ?><?php $this->options->themeUrl('lib/OwO/OwOmini.json'); ?><?php endif; ?>',
    position: 'down',
    width: '100%',
    maxHeight: '250px'
});</script>
<?php endif; ?>