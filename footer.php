<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
 <footer id="footer">
            <div class="footer-left">
                Copyright © 2019 Xingr
            </div>
            <div class="footer-right">
                <nav>
                    <ul>
                        <li>
                            <a href="/">Home</a>
                        </li>
                        <?php $this->widget('Widget_Contents_Page_List')->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
                        <li>
                            <a href="http://github.com/seevil" target="_blank">Github</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </footer>
        <script src="<?php $this->options->themeUrl('lib/justified-gallery/jquery.justifiedGallery.min.js'); ?>"></script>
        <script src="<?php $this->options->themeUrl('lib/typed.js'); ?>"></script>
        <script src="<?php $this->options->themeUrl('js/main.js'); ?>"></script>
		<script src="<?php $this->options->themeUrl('lib/highlight.min.js'); ?>"></script>
        <script>
            hljs.initHighlightingOnLoad();
        </script>
       
        <script>
            if ('serviceWorker'in navigator) {
                window.addEventListener('load', ()=>{
                    navigator.serviceWorker.register('/sw.js').then(registration=>{
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