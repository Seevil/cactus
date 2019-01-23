<?php
/**
 * Cactus是优雅简洁的主题
 * @package Cactus Theme
 * @author Intern
 * @version 1.0.0
 * @link https://wwww.xde.io/
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
    <body>
        <div class="content index width mx-auto px3 my4">
            <header id="header">
                <a href="/">
                    <div id="logo" style="background-image: url(<?php $this->options->themeUrl('images/logo.png'); ?>);"></div>
                    <div id="title">
                        <h1><?php $this->options->title(); ?></h1>
                    </div>
                </a>
                <div id="nav">
                    <ul>
                        <li class="icon">
                            <a href="#">
                                <i class="fa fa-bars fa-2x"></i>
                            </a>
                        </li>
                        <li>
                            <a href="/">Home</a>
                        </li>
                        <?php $this->widget('Widget_Contents_Page_List')->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
                        <li>
                            <a href="http://github.com/Seevil" target="_blank">Github</a>
                        </li>
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
                        &nbsp;
                        <li>
                            <a class="icon" target="_blank" href="http://github.com/Seevil" title="github">
                                <i class="fa fa-github"></i>
                            </a>
                        </li>
                    </ul>
                    .<p></p>
                    <p class="prompt ad-text output new-output">p.s. 网站已经支持PWA,可尝试添加到桌面</p>
                </section>
                <section id="writing">
                    <span class="h1">
                        <a href="/archive/">Writing</a>
                    </span>
                    <ul class="post-list" id="post-list">
					<?php while($this->next()): ?>
                        <li class="post-item">
                            <div class="meta">
                                <time datetime="<?php $this->date(); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
                            </div>
                            <span>
                                <a href="<?php $this->permalink() ?>"><?php $this->title(35,'...') ?></a>
                            </span>
                        </li>
					 <?php endwhile; ?>
                    </ul>
                </section>
                <section id="projects">
                    <span class="h1">
                        <a href="http://github.com/Seevil" rel="external nofollow noopener noreferrer" target="_blank">Projects</a>
                    </span>
                    <ul class="project-list">
                        <li class="project-item">
                            <a href="https://github.com/Seevil/microfrontend-base-demo" rel="external nofollow noopener noreferrer" target="_blank">Fantasy</a>
                            : 一款极简Typecho 博客主题
                        </li>

                    </ul>
                </section>
            </section>
        </div>
		 <script async src="//busuanzi.ibruce.info/busuanzi/2.3/busuanzi.pure.mini.js"></script>
 <?php $this->need('footer.php'); ?>