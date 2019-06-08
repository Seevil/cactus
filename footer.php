<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="mx-auto px3 my5">
 <footer id="footer" style="display:block;">
            <div class="footer-left">
                Copyright © <?php echo date('Y'); ?> By <a href="http://www.typecho.org" target="_blank" rel="nofollow">Typecho</a> & <a href="http://www.xde.io" target="_blank">Xingr</a>
            </div>
            <div class="footer-right">
                <nav>
                    <ul>
                        <li>
                            <a href="<?php $this->options->siteUrl();?>">Home</a>
                        </li>
                        <?php $this->widget('Widget_Contents_Page_List')->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
                        <?php if($this->options->github): ?><li>
                            <a href="<?php $this->options->github();?>" target="_blank">Github</a>
                        </li><?php endif; ?>
                    </ul>
                </nav>
            </div>
        </footer>
		</div>
		<link rel="stylesheet" href="<?php $this->options->themeUrl('lib/font-awesome/css/font-awesome.min.css'); ?>">
		 <script src="<?php $this->options->themeUrl('js/main.js'); ?>"></script>
        <?php if ($this->is('index')) : ?>
		<script src="<?php $this->options->themeUrl('lib/typed.js'); ?>"></script>
		<script async src="//busuanzi.ibruce.info/busuanzi/2.3/busuanzi.pure.mini.js"></script>
		<script>	
$(function () {
  $.get("<?php $this->options->siteUrl();?><?php echo date('Ymd').'.json';?>", function (data) {
    var data = data.data;
    // var str =  data.content+'\n'
    // + data.translation+"\n---- "
    // +data.author +'\n'
    var str =  data.content+'\n'
    + data.translation+"\n---- "
    
    var options = {
      strings: [ 
        str + "Who??^1000",
        str + "It's me^2000",
        str +'Haha, make a joke',
        str +data.author,
      ],
      typeSpeed: 20,
      startDelay:300,
      // loop: true,
    }
    var typed = new Typed(".description .typed", options);
  })
});</script>
		<?php endif; ?>
		<?php if ($this->is('post')) : ?>
		<link rel="stylesheet" href="<?php $this->options->themeUrl('css/lightbox.min.css'); ?>">
		<script src="<?php $this->options->themeUrl('js/lightbox.min.js'); ?>"></script>
		<script src="<?php $this->options->themeUrl('lib/highlight.min.js'); ?>"></script>
		<script>
		$('#post-content img').wrap(function () {
		return '<a href="' + this.src + '" title="' + this.alt + '" data-lightbox="roadtrip"></a>';
		});
		</script>
        <script>
            hljs.initHighlightingOnLoad();
        </script>
       <?php endif; ?>
        <script>
			if ('serviceWorker' in navigator) {
			  window.addEventListener('load', function() {
				navigator.serviceWorker.register('<?php $this->options->themeUrl('/sw.js'); ?>').then(function(registration) {
				  console.log('ServiceWorker registration successful with scope: ', registration.scope);
				}, function(err) {
				  console.log('ServiceWorker registration failed: ', err);
				});
			  });
			}
        </script>
		<?php $this->footer(); ?>
    </body>
</html>
