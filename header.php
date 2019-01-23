<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="HandheldFriendly" content="True">
        <meta name="viewport" content="initial-scale=1,width=device-width,minimum-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="wap-font-scale" content="no">
        <meta name="description" itemprop="description" content="<?php $this->options->description() ?>">
        <meta name="keywords" content="<?php $this->options->keywords() ?>">
        <meta property="og:locale" content="zh_CN">
        <meta property="og:title" content="<?php $this->options->title(); ?>">
        <meta property="og:image" content="<?php $this->options->themeUrl('images/logo.png'); ?>">
        <meta property="og:description" content="<?php $this->options->description() ?>">
        <meta property="og:site_name" content="<?php $this->author(); ?>">
        <?php $this->header('keywords=&generator=&template=&pingback=&xmlrpc=&wlw=&commentReply=&rss1=&rss2=&atom='); ?>
		<title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
        <link rel="shortcut icon" href="<?php $this->options->themeUrl('images/favicon.ico'); ?>">
        <link rel="manifest" href="<?php $this->options->themeUrl('/manifest.json'); ?>">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('lib/font-awesome/css/font-awesome.min.css'); ?>">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('lib/justified-gallery/justifiedGallery.min.css'); ?>">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('css/style.css'); ?>">
        <script src="<?php $this->options->themeUrl('lib/jquery/jquery.min.js'); ?>"></script>
        <script>
            document.addEventListener("error", function(e) {
                var elem = e.target;
                if (elem.tagName.toLowerCase() == 'img') {
                    elem.style.display = 'none'
                }
            }, true);
        </script>
    </head>