<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
    <body>
        <div class="content index width mx-auto px3 my4">
            <header id="header">
                 <a href="<?php $this->options->siteUrl();?>">
                    <div id="logo" style="background-image: url(<?php if($this->options->logoimg): ?><?php $this->options->logoimg();?><?php else : ?><?php $this->options->themeUrl('images/logo.png'); ?><?php endif; ?>);"></div>
                </a>
				<div id="title">
                        <h1><?php $this->category() ?></h1>
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
			<div id="theme-tagcloud" class="tagcloud-wrap">
			<?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=30')->to($tags); ?>
			<?php while($tags->next()): ?>
			<a style="font-size:<?php echo(rand(10, 24)); ?>px; text-transform:capitalize;" href="<?php $tags->permalink(); ?>"><?php $tags->name(); ?></a>
			<?php endwhile; ?>
            </div>
            <section id="wrapper" class="home">
                <div class="archive">
                   
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
					 <div class="pagination">
					 <?php if($this->_currentPage>1): ?>
					 <?php if($this->_currentPage>1): ?>
					<a href="<?php $this->pageLink('Previous'); ?>"><i class="fa fa-angle-left"></i></a><?php endif; ?>
					<span class="page-number"><?php if($this->_currentPage>0) echo 'Page '.$this->_currentPage.' of '; ?><?php echo ceil($this->getTotal() / $this->parameter->pageSize); ?></span>
					<a href="<?php $this->pageLink('Next','next'); ?>"><i class="fa fa-angle-right"></i></a>
					<?php endif; ?>
				</div>
                    </ul>
                </div>
            </section>
        </div>
 <?php $this->need('footer.php'); ?>