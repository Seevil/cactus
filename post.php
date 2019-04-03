<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
    <body>
        <div id="header-post">
            <a id="menu-icon" href="#">
                <i class="fa fa-bars fa-lg"></i>
            </a>
            <a id="menu-icon-tablet" href="#">
                <i class="fa fa-bars fa-lg"></i>
            </a>
            <a id="top-icon-tablet" href="#" onclick="$('html, body').animate({ scrollTop: 0 }, 'fast');" style="display:none;">
                <i class="fa fa-chevron-up fa-lg"></i>
            </a>
            <span id="menu">
                <span id="nav">
                    <ul>
                        <li>
                            <a href="<?php $this->options->siteUrl();?>">Home</a>
                        </li>
                        <?php $this->widget('Widget_Contents_Page_List')->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
                        <?php if($this->options->github): ?><li>
                            <a href="<?php $this->options->github();?>" target="_blank">Github</a>
                        </li><?php endif; ?>
                    </ul>
                </span>
                <br>
                <span id="actions">
                    <ul>
                        <li>
                            <?php $this->theNext('%s', '', array('title' => '<i class="fa fa-chevron-left" aria-hidden="true" onmouseover=\'$("#i-prev").toggle();\' onmouseout=\'$("#i-prev").toggle();\'></i>', 'tagClass' => 'icon')); ?>
                        </li>
                        <li> 
							<?php $this->thePrev('%s', '', array('title' => '<i class="fa fa-chevron-right" aria-hidden="true" onmouseover=\'$("#i-next").toggle();\' onmouseout=\'$("#i-next").toggle();\'></i>', 'tagClass' => 'icon')); ?>
                        </li>
                        <li>
                            <a class="icon" href="#" onclick="$('html, body').animate({ scrollTop: 0 }, 'fast');">
                                <i class="fa fa-chevron-up" aria-hidden="true" onmouseover='$("#i-top").toggle();' onmouseout='$("#i-top").toggle();'></i>
                            </a>
                        </li>
                        <li>
                            <a class="icon" href="#">
                                <i class="fa fa-share-alt" aria-hidden="true" onmouseover='$("#i-share").toggle();' onmouseout='$("#i-share").toggle();' onclick='$("#share").toggle();return false;'></i>
                            </a>
                        </li>
                    </ul>
                    <span id="i-prev" class="info" style="display:none;">Previous post</span>
                    <span id="i-next" class="info" style="display:none;">Next post</span>
                    <span id="i-top" class="info" style="display:none;">Back to top</span>
                    <span id="i-share" class="info" style="display:none;">Share post</span>
                </span>
                <br>
                <div id="share" style="display: none">
                    <ul>
                        <li>
                            <a class="icon" href="http://v.t.sina.com.cn/share/share.php?u=<?php $this->permalink() ?>&text=<?php $this->title() ?>">
                                <i class="fa fa-weibo" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a class="icon" href="http://www.facebook.com/sharer.php?u=<?php $this->permalink() ?>">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a class="icon" href="https://twitter.com/share?url=<?php $this->permalink() ?>&text=<?php $this->title() ?>">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a class="icon" href="http://www.linkedin.com/shareArticle?url=<?php $this->permalink() ?>&title=<?php $this->title() ?>">
                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a class="icon" href="https://pinterest.com/pin/create/bookmarklet/?url=<?php $this->permalink() ?>&is_video=false&description=<?php $this->title() ?>">
                                <i class="fa fa-pinterest" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a class="icon" href="mailto:?subject=<?php $this->title() ?>&body=Check out this article: <?php $this->permalink() ?>">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a class="icon" href="https://getpocket.com/save?url=<?php $this->permalink() ?>&title=<?php $this->title() ?>">
                                <i class="fa fa-get-pocket" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a class="icon" href="http://reddit.com/submit?url=<?php $this->permalink() ?>&title=<?php $this->title() ?>">
                                <i class="fa fa-reddit" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a class="icon" href="http://www.stumbleupon.com/submit?url=<?php $this->permalink() ?>&title=<?php $this->title() ?>">
                                <i class="fa fa-stumbleupon" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a class="icon" href="http://digg.com/submit?url=<?php $this->permalink() ?>&title=<?php $this->title() ?>">
                                <i class="fa fa-digg" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div id="toc">
                    <nav id="TableOfContents">
                        <ul>
							<?php if ($this->options->catalog == 'able'): ?><?php getCatalog(); ?><?php else: ?><?php theme_random_posts();?><?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </span>
        </div>
        <div class="content index width mx-auto px3 my3">
            <section id="wrapper" class="home">
                <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
                    <header>
                        <h1 class="posttitle" itemprop="name headline"><?php $this->title() ?></h1>
                        <div class="meta">
                            <div class="postdate">
                                <time datetime="<?php $this->date(); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
                            </div>
                            <div class="article-tag">
                                <i class="fa fa-eye"></i>
                                <span id="busuanzi_container_page_pv">
                                    <span id="busuanzi_value_page_pv"><?php Postviews($this); ?></span>
                                </span>
                            </div>
                            <div class="article-tag">
                                <i class="fa fa-tag"></i>
                                <?php $this->category(' '); ?>
                            </div>
                            <div class="article-tag-box"></div>
                        </div>
                    </header>
                    <div class="content" itemprop="articleBody" id="post-content">
                        <?php $this->content(); ?>
                        <h2>本文链接：</h2>
                        <a href="<?php $this->permalink() ?>" target="_blank"><?php $this->permalink() ?></a>
                    </div>
                </article>
                 <?php $this->need('comments.php'); ?>
            </section>
        </div>
 <?php $this->need('footer.php'); ?>