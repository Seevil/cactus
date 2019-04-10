<?php
/**
 * 仙人掌(Cactus)是优雅简洁的暗色主题
 * @package Cactus Theme
 * @author Intern
 * @version 1.2.0
 * @link https://www.xde.io/
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
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
                    </ul>.<p></p>
                    <p class="prompt ad-text output new-output">p.s. 网站已经支持PWA,可尝试添加到桌面</p>
                </section>
                <section id="writing">
                    <span class="h1">
                        <a href="archives.html">Writing</a>
                    </span>
                    <ul class="post-list" id="post-list">
					<?php while($this->next()): ?>
                        <li class="post-item">
                            <div class="meta">
                                <time datetime="<?php $this->date(); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
                            </div>
                            <span>
                                <a href="<?php $this->permalink() ?>"><?php $this->title(38,'...') ?></a>
                            </span>
                        </li>
					 <?php endwhile; ?>
                    </ul>
                </section>
                <section id="projects">
                    <span class="h1">
                        <a href="#" rel="external nofollow noopener noreferrer" target="_blank">Projects</a>
                    </span>
                    <ul class="project-list">
					<?php Projects(); ?>
                    </ul>
                </section>
            </section>
        </div>
 <?php $this->need('footer.php'); ?>