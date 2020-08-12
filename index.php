<?php
/**
 * 仙人掌(Cactus)是优雅简洁的暗色主题
 * @package Cactus Theme
 * @author Intern
 * @version 1.3.2
 * @link https://www.xde.io/
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
$sticky = $this->options->sticky; 
if($sticky && $this->is('index') || $this->is('front')){
    $sticky_cids = explode(',', strtr($sticky, ' ', ','));
    $sticky_html = "<span class='sticky'>[置顶] </span>";
    $db = Typecho_Db::get();
    $pageSize = $this->options->pageSize;
    $select1 = $this->select()->where('type = ?', 'post');
    $select2 = $this->select()->where('type = ? && status = ? && created < ?', 'post','publish',time());
    $this->row = [];
    $this->stack = [];
    $this->length = 0;
    $order = '';
    foreach($sticky_cids as $i => $cid) {
        if($i == 0) $select1->where('cid = ?', $cid);
        else $select1->orWhere('cid = ?', $cid);
        $order .= " when $cid then $i";
        $select2->where('table.contents.cid != ?', $cid);
    }
    if ($order) $select1->order(null,"(case cid$order end)");
    if ($this->_currentPage == 1) foreach($db->fetchAll($select1) as $sticky_post){ 
        $sticky_post['sticky'] = $sticky_html;
        $this->push($sticky_post);
    }
$uid = $this->user->uid; 
    if($uid) $select2->orWhere('authorId = ? && status = ?',$uid,'private');
    $sticky_posts = $db->fetchAll($select2->order('table.contents.created', Typecho_Db::SORT_DESC)->page($this->_currentPage, $this->parameter->pageSize));
    foreach($sticky_posts as $sticky_post) $this->push($sticky_post); 
    $this->setTotal($this->getTotal()-count($sticky_cids)); 
}
?>
    <body>
        <div class="content index width mx-auto px3 my4">
            <header id="header">
			<?php $today = today(); ?>
                <a href="<?php $this->options->siteUrl();?>">
                     <div id="logo" style="background-image: url(<?php if($this->options->logoimg): ?><?php $this->options->logoimg();?><?php else : ?><?php $this->options->themeUrl('images/logo.png'); ?><?php endif; ?>);"></div>
					 </a>
                    <div id="title">
                        <h1><?php $this->options->title(); ?></h1>
                    </div>
                <div id="nav">
                    <ul>
                        <li class="icon">
                            <a href="#">
                                <i class="fa fa-bars fa-2x"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php $this->options->siteUrl();?>">Home</a>
                        </li>
                        <?php $this->widget('Widget_Contents_Page_List')->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
                        <?php if($this->options->github): ?>
						<li>
                         <a href="<?php $this->options->github();?>" target="_blank">Github</a>
                        </li><?php endif; ?>
						
                    </ul>
                </div>
            </header>
            <section id="wrapper" class="home">
                <section id="about">
                    <div class="description coding">
                        <span class="typed prompt"></span>
                    </div>
                    <p style="display: inline">
                        <span>
                            <i class="fa fa-eye"></i>
                            <span id="busuanzi_container_site_pv">
                                <span id="busuanzi_value_site_pv">0</span>
                            </span>
                        </span>
                        | Find me on
                    </p>
                    <ul id="sociallinks">
						<li><?php if($this->options->github): ?><a class="icon" href="<?php $this->options->github();?>" target="_blank" title="github"><i class="fa fa-github"></i></a><?php endif; ?><?php if($this->options->twitter): ?> <a class="icon" href="<?php $this->options->twitter();?>" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a><?php endif; ?><?php if($this->options->weibo): ?> <a class="icon" href="<?php $this->options->weibo();?>" target="_blank" title="weibo"><i class="fa fa-weibo"></i></a><?php endif; ?><?php if($this->options->urldiy): ?> <?php $this->options->urldiy();?><?php endif; ?><?php if($this->options->email): ?> <a class="icon" href="mailto:<?php $this->options->email();?>" target="_blank" title="email"><i class="fa fa-envelope"></i></a><?php endif; ?>
                        </li>
                    </ul>. <a id="search" class="search icon" href="javascript:;"><i class="fa fa-search"></i></a><p></p>
                    <p class="prompt ad-text output new-output">p.s. 网站已经支持PWA,可尝试添加到桌面</p>
                </section>
                <section id="writing">
                    <span class="h1">
                        <a href="<?php if($this->options->writing): ?><?php $this->options->writing();?><?php else : ?>archives.html<?php endif; ?>">Writing</a>
                    </span>
                    <ul class="post-list" id="post-list">
					<?php while($this->next()): ?>
                        <li class="post-item">
                            <div class="meta">
                                <time datetime="<?php $this->date(); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
                            </div>
                            <span>
                                <a href="<?php $this->permalink() ?>"><?php $this->sticky(38,'...'); $this->title(38,'...') ?></a>
                            </span>
                        </li>
					 <?php endwhile; ?>
                    </ul>
                </section>
                <section id="projects">
                    <span class="h1">
                        <a href="<?php if($this->options->Projects): ?><?php $this->options->Projects();?><?php else : ?>#<?php endif; ?>" rel="external nofollow noopener noreferrer" target="_blank">Projects</a>
                    </span>
                    <ul class="project-list">
					<?php Projects(); ?>
                    </ul>
                </section>
            </section>
        </div>
 <?php $this->need('footer.php'); ?>