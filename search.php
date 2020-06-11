<?php
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
                
                <section id="writing">
                    <span class="h1">
                        <?php $this->archiveTitle(array('search'  =>  _t('包含关键字“ %s ”的文章'),), '', ''); ?>
                    </span>
                    <ul class="post-list" id="post-list">
					 <?php if ($this->have()): ?>
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
					 <?php else: ?>
            <h2>没有找到相关内容</h2>
            
        <?php endif; ?>
                    </ul>
                </section>
                
            </section>
        </div>
 <?php $this->need('footer.php'); ?>