<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
 <footer id="footer" style="display:block;">
            <div class="footer-left">
                Copyright © 2019 By <a href="http://www.typecho.org" target="_blank" rel="nofollow">Typecho</a> & <a href="http://www.xde.io" target="_blank">Xingr</a>
            </div>
            <div class="footer-right">
                <nav>
                    <ul>
                        <li>
                            <a href="/">Home</a>
                        </li>
                        <?php $this->widget('Widget_Contents_Page_List')->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
                        <?php if($this->options->github): ?><li>
                            <a href="<?php $this->options->github();?>" target="_blank">Github</a>
                        </li><?php endif; ?>
                    </ul>
                </nav>
            </div>
        </footer>

        <?php if ($this->is('index')) : ?><script src="<?php $this->options->themeUrl('lib/typed.js'); ?>"></script><?php endif; ?>
        <script src="<?php $this->options->themeUrl('js/main.js'); ?>"></script>
		<?php if ($this->is('post')) : ?>
		<link rel="stylesheet" href="<?php $this->options->themeUrl('css/zoom.css'); ?>">
		<script src="<?php $this->options->themeUrl('js/zoom.js'); ?>"></script>
		<script src="<?php $this->options->themeUrl('lib/highlight.min.js'); ?>"></script>
		<script>
		$(function(){
		$("#post-content img").each(function(){
		$(this).attr("data-action","zoom");
		})
		})
		</script>
        <script>
            hljs.initHighlightingOnLoad();
        </script>
       <?php endif; ?>
        <script>
            if ('serviceWorker'in navigator) {
                window.addEventListener('load', ()=>{
                    navigator.serviceWorker.register('<?php $this->options->themeUrl('/sw.js'); ?>').then(registration=>{
                        console.log('SW registered: ', registration);
                    }
                    ).catch(registrationError=>{
                        console.log('SW registration failed: ', registrationError);
                    }
                    );
                }
                );
            }
        </script>
		<?php $this->footer(); ?>
    </body>
</html>