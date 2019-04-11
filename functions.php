<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function themeConfig($form) {
    $logoimg = new Typecho_Widget_Helper_Form_Element_Text('logoimg', NULL, NULL, _t('页头logo地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则使用站点名称'));
    $form->addInput($logoimg->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('favicon地址'), _t('一般为http://www.yourblog.com/image.ico,支持 https:// 或 //,留空则不设置favicon'));
    $form->addInput($favicon->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));

    $appleicon = new Typecho_Widget_Helper_Form_Element_Text('appleicon', NULL, NULL, _t('apple touch icon地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则不设置Apple Touch Icon'));
    $form->addInput($appleicon->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
	
	$github = new Typecho_Widget_Helper_Form_Element_Text('github', NULL, NULL, _t('Github地址'), _t('一般为https://github.com/Seevil ,留空则不设置Github地址'));
    $form->addInput($github->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
	$twitter = new Typecho_Widget_Helper_Form_Element_Text('twitter', NULL, NULL, _t('twitter地址'), _t('一般为https://twitter.com/skyurl ,留空则不设置twitter地址'));
    $form->addInput($twitter->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
	$weibo = new Typecho_Widget_Helper_Form_Element_Text('weibo', NULL, NULL, _t('Weibo地址'), _t('一般为http://www.weibo.com/xxx ,留空则不设置Weibo地址'));
    $form->addInput($weibo->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
	$urldiy = new Typecho_Widget_Helper_Form_Element_Text('urldiy', NULL, NULL, _t('主页自定义地址'), _t('注意该设置会直接输出设置内容，建议格式为\<a class="icon" href="https://twitter.com/skyurl" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a> 支持 FontAwesome 图标 ,留空则不显示'));
    $form->addInput($urldiy->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));


	$Projects = new Typecho_Widget_Helper_Form_Element_Textarea('Projects', NULL, NULL, _t('首页 Projects 设置（注意：切换主题会被清空，注意备份！）'), _t('按照格式输入链接信息，格式：<br><strong>链接名称（必须）|链接地址（必须）|链接描述</strong><br>不同信息之间用英文竖线“|”分隔，例如：<br><strong>XDE|http://www.xde.io/|仙岛驿站</strong><br>若中间有暂时不想填的信息，请留空，例如暂时不想填写链接描述：<br><strong>XDE|http://www.xde.io||</strong><br>多个链接换行即可，一行一个'));
	$form->addInput($Projects);
	
	$catalog = new Typecho_Widget_Helper_Form_Element_Radio('catalog',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('文章目录设置'), _t('默认显示随机文章，启用则显示文章目录'));
    $form->addInput($catalog);
}

function themeInit($archive) {
    if ($archive->is('index')) {
        $archive->parameter->pageSize = 9; // 自定义条数
    }
	if ($archive->is('single')) {  
    $archive->content = createCatalog($archive->content);//文章锚点实现
}
	@$comment = spam_protection_pre($comment,$post, $result);//数字验证码
}

function parseContent($obj){
    $options = Typecho_Widget::widget('Widget_Options');
    if(!empty($options->src_add) && !empty($options->cdn_add)){
        $obj->content = str_ireplace($options->src_add,$options->cdn_add,$obj->content);
    }
    echo trim($obj->content);
}

/**项目展示
<?php Projects(); ?>
*/
function Projects($sorts = NULL) {
    $options = Typecho_Widget::widget('Widget_Options');
    $Project = NULL;
    if ($options->Projects) {
        $list = explode("\r\n", $options->Projects);
        foreach ($list as $val) {
            list($name, $url, $description, $sort) = explode("|", $val);
            if ($sorts) {
                $arr = explode("|", $sorts);
                if ($sort && in_array($sort, $arr)) {
                    $Project .= $url ? '<li class="project-item"><a href="'.$url.'" target="_blank">'.$name.'</a>: '.$description.'</li>' : '<li class="project-item">'.$name.': '.$description.'</li>';
                }
            } else {
                $Project .= $url ? '<li class="project-item"><a href="'.$url.'" target="_blank">'.$name.'</a>: '.$description.'</li>' : '<li class="project-item">'.$name.': '.$description.'</li>';
            }
        }
    }
    echo $Project ? $Project : '世间无限丹青手，一片伤心画不成。';
}

/**阅读浏览次数 
<?php Postviews($this); ?>
*/
function Postviews($archive) {
    $db = Typecho_Db::get();
    $cid = $archive->cid;
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'contents` ADD `views` INT(10) DEFAULT 0;');
    }
    $exist = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))['views'];
    if ($archive->is('single')) {
        $cookie = Typecho_Cookie::get('contents_views');
        $cookie = $cookie ? explode(',', $cookie) : array();
        if (!in_array($cid, $cookie)) {
            $db->query($db->update('table.contents')
                ->rows(array('views' => (int)$exist+1))
                ->where('cid = ?', $cid));
            $exist = (int)$exist+1;
            array_push($cookie, $cid);
            $cookie = implode(',', $cookie);
            Typecho_Cookie::set('contents_views', $cookie);
        }
    }
    echo $exist == 0 ?  : $exist;
}

function theme_random_posts(){
$defaults = array(
'number' => 6,
'xformat' => '<li><a href="{permalink}">{title}</a></li>'
);
$db = Typecho_Db::get();
$adapterName = $db->getAdapterName();//兼容非MySQL数据库
if($adapterName == 'pgsql' || $adapterName == 'Pdo_Pgsql' || $adapterName == 'Pdo_SQLite' || $adapterName == 'SQLite'){
   $order_by = 'RANDOM()';
   }else{
   $order_by = 'RAND()';
 }
$sql = $db->select()->from('table.contents') 
->where('status = ?','publish')
->where('type = ?', 'post')
->where('created <= '. Helper::options()->gmtTime, 'post') //添加这一句避免未达到时间的文章提前曝光
->limit($defaults['number'])
->order($order_by);
$result = $db->fetchAll($sql);
foreach($result as $val){
$val = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($val);
echo str_replace(array('{permalink}', '{title}'),array($val['permalink'], $val['title']), $defaults['xformat']);
}
}


/** 获取浏览器信息 <?php echo getBrowser($comments->agent); ?> */
function getBrowser($agent)
{ $outputer = false;
    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
        $outputer = 'IE Browser';
    } else if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
      $str1 = explode('Firefox/', $regs[0]);
$FireFox_vern = explode('.', $str1[1]);
        $outputer = 'Firefox Browser '. $FireFox_vern[0];
    } else if (preg_match('/Maxthon([\d]*)\/([^\s]+)/i', $agent, $regs)) {
      $str1 = explode('Maxthon/', $agent);
$Maxthon_vern = explode('.', $str1[1]);
        $outputer = 'Maxthon Browser '.$Maxthon_vern[0];
    } else if (preg_match('#SE 2([a-zA-Z0-9.]+)#i', $agent, $regs)) {
        $outputer = 'Sogo Browser';
    } else if (preg_match('#360([a-zA-Z0-9.]+)#i', $agent, $regs)) {
$outputer = '360 Browser';
    } else if (preg_match('/Edge([\d]*)\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('Edge/', $regs[0]);
$Edge_vern = explode('.', $str1[1]);
        $outputer = 'Edge '.$Edge_vern[0];
    } else if (preg_match('/EdgiOS([\d]*)\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('EdgiOS/', $regs[0]);
        $outputer = 'Edge';
    } else if (preg_match('/UC/i', $agent)) {
              $str1 = explode('rowser/',  $agent);
$UCBrowser_vern = explode('.', $str1[1]);
        $outputer = 'UC Browser '.$UCBrowser_vern[0];
    }else if (preg_match('/OPR/i', $agent)) {
              $str1 = explode('OPR/',  $agent);
$opr_vern = explode('.', $str1[1]);
        $outputer = 'Open Browser '.$opr_vern[0];
    } else if (preg_match('/MicroMesseng/i', $agent, $regs)) {
        $outputer = 'Weixin Browser';
    }  else if (preg_match('/WeiBo/i', $agent, $regs)) {
        $outputer = 'WeiBo Browser';
    }  else if (preg_match('/QQ/i', $agent, $regs)||preg_match('/QQ Browser\/([^\s]+)/i', $agent, $regs)) {
                  $str1 = explode('rowser/',  $agent);
$QQ_vern = explode('.', $str1[1]);
        $outputer = 'QQ Browser '.$QQ_vern[0];
    } else if (preg_match('/MQBHD/i', $agent, $regs)) {
                  $str1 = explode('MQBHD/',  $agent);
$QQ_vern = explode('.', $str1[1]);
        $outputer = 'QQ Browser '.$QQ_vern[0];
    } else if (preg_match('/BIDU/i', $agent, $regs)) {
        $outputer = 'Baidu Browser';
    } else if (preg_match('/LBBROWSER/i', $agent, $regs)) {
        $outputer = 'KS Browser';
    } else if (preg_match('/TheWorld/i', $agent, $regs)) {
        $outputer = 'TheWorld Browser';
    } else if (preg_match('/XiaoMi/i', $agent, $regs)) {
        $outputer = 'XiaoMi Browser';
    } else if (preg_match('/UBrowser/i', $agent, $regs)) {
              $str1 = explode('rowser/',  $agent);
$UCBrowser_vern = explode('.', $str1[1]);
        $outputer = 'UCBrowser '.$UCBrowser_vern[0];
    } else if (preg_match('/mailapp/i', $agent, $regs)) {
        $outputer = 'Email Browser';
    } else if (preg_match('/2345Explorer/i', $agent, $regs)) {
        $outputer = '2345 Browser';
    } else if (preg_match('/Sleipnir/i', $agent, $regs)) {
        $outputer = 'Sleipnir Browser';
    } else if (preg_match('/YaBrowser/i', $agent, $regs)) {
        $outputer = 'Yandex Browser';
    }  else if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
        $outputer = 'Opera Browser';
    } else if (preg_match('/MZBrowser/i', $agent, $regs)) {
        $outputer = 'MZ Browser';
    } else if (preg_match('/VivoBrowser/i', $agent, $regs)) {
        $outputer = 'Vivo Browser';
    } else if (preg_match('/Quark/i', $agent, $regs)) {
        $outputer = 'Quark Browser';
    } else if (preg_match('/mixia/i', $agent, $regs)) {
        $outputer = 'Mixia Browser';
    }else if (preg_match('/fusion/i', $agent, $regs)) {
        $outputer = 'Fusion';
    } else if (preg_match('/CoolMarket/i', $agent, $regs)) {
        $outputer = 'CoolMarket Browser';
    } else if (preg_match('/Thunder/i', $agent, $regs)) {
        $outputer = 'Thunder Browser';
    } else if (preg_match('/Chrome([\d]*)\/([^\s]+)/i', $agent, $regs)) {
$str1 = explode('Chrome/', $agent);
$chrome_vern = explode('.', $str1[1]);
        $outputer = 'Chrome '.$chrome_vern[0];
    } else if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
         $str1 = explode('Version/',  $agent);
$safari_vern = explode('.', $str1[1]);
        $outputer = 'Safari '.$safari_vern[0];
    } else{
        return false;
    }
   return $outputer;
}

/** 获取操作系统信息 <?php echo getOs($comments->agent); ?>*/
function getOs($agent)
{
    $os = false;
 
    if (preg_match('/win/i', $agent)) {
        if (preg_match('/nt 6.0/i', $agent)) {
            $os = 'Windows Vista';
        } else if (preg_match('/nt 6.1/i', $agent)) {
            $os = 'Windows 7';
        } else if (preg_match('/nt 6.2/i', $agent)) {
            $os = 'Windows 8';
        } else if(preg_match('/nt 6.3/i', $agent)) {
            $os = 'Windows 8.1';
        } else if(preg_match('/nt 5.1/i', $agent)) {
            $os = 'Windows XP';
        } else if (preg_match('/nt 10.0/i', $agent)) {
            $os = 'Windows 10';
        } else{
            $os = 'Windows';
        }
    } else if (preg_match('/android/i', $agent)) {
if (preg_match('/android 9/i', $agent)) {
        $os = 'Android P';
    }
else if (preg_match('/android 8/i', $agent)) {
        $os = 'Android O';
    }
else if (preg_match('/android 7/i', $agent)) {
        $os = 'Android N';
    }
else if (preg_match('/android 6/i', $agent)) {
        $os = 'Android M';
    }
else if (preg_match('/android 5/i', $agent)) {
        $os = 'Android L';
    }
else{
        $os = 'Android';
}
    }
 else if (preg_match('/ubuntu/i', $agent)) {
        $os = 'Linux';
    } else if (preg_match('/linux/i', $agent)) {
        $os = 'Linux';
    } else if (preg_match('/iPhone/i', $agent)) {
        $os = 'iPhone';
    } else if (preg_match('/iPad/i', $agent)) {
        $os = 'iPad';
    } else if (preg_match('/mac/i', $agent)) {
        $os = 'OSX';
    }else if (preg_match('/cros/i', $agent)) {
        $os = 'Chrome os';
    }else {
 return false;
    }
   return $os;
}
//html压缩 
/***<?php $html_source = ob_get_contents(); ob_clean(); print compressHtml($html_source); ob_end_flush(); ?>**/
function compressHtml($html_source) {
    $chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
    $compress = '';
    foreach ($chunks as $c) {
        if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
            $c = substr($c, 19, strlen($c) - 19 - 20);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
            $c = substr($c, 12, strlen($c) - 12 - 13);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
            $tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
            $c = '';
            foreach ($tmps as $tmp) {
                if (strpos($tmp, '//') !== false) {
                    if (substr(trim($tmp), 0, 2) == '//') {
                        continue;
                    }
                    $chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
                    $is_quot = $is_apos = false;
                    foreach ($chars as $key => $char) {
                        if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
                            $is_quot = !$is_quot;
                        } else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
                            $is_apos = !$is_apos;
                        } else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
                            $tmp = substr($tmp, 0, $key);
                            break;
                        }
                    }
                }
                $c .= $tmp;
            }
        }
        $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
        $c = preg_replace('/\\s{2,}/', ' ', $c);
        $c = preg_replace('/>\\s</', '> <', $c);
        $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
        $c = preg_replace('/<!--[^!]*-->/', '', $c);
        $compress .= $c;
    }
    return $compress;
}

//为文章标题添加锚点
function createCatalog($obj) {    
    global $catalog;
    global $catalog_count;
    $catalog = array();
    $catalog_count = 0;
    $obj = preg_replace_callback('/<h([1-6])(.*?)>(.*?)<\/h\1>/i', function($obj) {
        global $catalog;
        global $catalog_count;
        $catalog_count ++;
        $catalog[] = array('text' => trim(strip_tags($obj[3])), 'depth' => $obj[1], 'count' => $catalog_count);
        return '<h'.$obj[1].$obj[2].'><a name="cl-'.$catalog_count.'"></a>'.$obj[3].'</h'.$obj[1].'>';
    }, $obj);
    return $obj;
}

//输出文章目录容器
function getCatalog() {    
    global $catalog;
    $index = '';
    if ($catalog) {
        
        $prev_depth = '';
        $to_depth = 0;
        foreach($catalog as $catalog_item) {
            $catalog_depth = $catalog_item['depth'];
            if ($prev_depth) {
                if ($catalog_depth == $prev_depth) {
                    $index .= '</li>';
                } elseif ($catalog_depth > $prev_depth) {
                    $to_depth++;
                   
                } else {
                    $to_depth2 = ($to_depth > ($prev_depth - $catalog_depth)) ? ($prev_depth - $catalog_depth) : $to_depth;
                    if ($to_depth2) {
                        for ($i=0; $i<$to_depth2; $i++) {
                            $index .= '</li>';
                            $to_depth--;
                        }
                    }
                    $index .= '</li>';
                }
            }
            $index .= '<li><a href="#cl-'.$catalog_item['count'].'">'.$catalog_item['text'].'</a>';
            $prev_depth = $catalog_item['depth'];
        }
        for ($i=0; $i<=$to_depth; $i++) {
            $index .= '</li>';
        }
    }
    echo $index;
}

/**
 * 根据$coid获取链接
 */
function getPermalinkFromCoid($coid)
{
    $db = Typecho_Db::get();
    $options = Helper::options();
    $contents = Typecho_Widget::widget('Widget_Abstract_Contents');
    $row = $db->fetchRow($db->select('cid, type, author, text')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));
    if (empty($row)) {
        return 'Comment not found!';
    }

    $cid = $row['cid'];
    $select = $db->select('coid, parent')->from('table.comments')->where('cid = ? AND status = ?', $cid, 'approved')->order('coid');
    if ($options->commentsShowCommentOnly) {
        $select->where('type = ?', 'comment');
    }

    $comments = $db->fetchAll($select);
    if ($options->commentsOrder == 'DESC') {
        $comments = array_reverse($comments);
    }

    foreach ($comments as $key => $val) {
        $array[$val['coid']] = $val['parent'];
    }

    $i = $coid;
    while ($i != 0) {
        $break = $i;
        $i = $array[$i];
    }
    $count = 0;
    foreach ($array as $key => $val) {
        if ($val == 0) {
            $count++;
        }

        if ($key == $break) {
            break;
        }

    }
    $parentContent = $contents->push($db->fetchRow($contents->select()->where('table.contents.cid = ?', $cid)));
    $permalink = rtrim($parentContent['permalink'], '/');
    $page = ($options->commentsPageBreak) ? '/comment-page-' . ceil($count / $options->commentsPageSize) : (substr($permalink, -5, 5) == '.html' ? '' : '/');
    return array("author" => $row['author'], "text" => $row['text'], "href" => "{$permalink}{$page}#{$row['type']}-{$coid}");
}

/**
 * 输出评论回复内容，配合 commentAtContent($coid)一起使用
 * <?php showCommentContent($comments->coid); ?>
 */
function showCommentContent($coid)
{
    $db = Typecho_Db::get();
    $result = $db->fetchRow($db->select('text')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));
    $text = $result['text'];
    $atStr = commentAtContent($coid);
    $_content = Markdown::convert($text);
    //<p>
    if ($atStr !== '') {
        $content = substr_replace($_content, $atStr, 0, 3);
    } else {
        $content = $_content;
    }

    echo $content;
}

/**
 * 评论回复加@ 
 */
function commentAtContent($coid)
{
    $db = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));
    $parent = $prow['parent'];
    if ($parent != "0") {
        $arow = $db->fetchRow($db->select('author')->from('table.comments')
            ->where('coid = ? AND status = ?', $parent, 'approved'));
        $author = $arow['author'];
        $href = '<p><a  href="#comment-' . $parent . '">@' . $author . '</a> ';
        return $href;
    } else {
        return '';
    }
}


//算术验证评论

function spam_protection_math(){
    $num1=1;
    $num2=rand(1,9);
    echo "$num1 + $num2 = ";
    echo "<input type=\"text\" name=\"sum\" class=\"vnick vinput\" value=\"\" size=\"25\" tabindex=\"4\" style=\" width:70px;\" placeholder=\"计算结果\">\n";
    echo "<input type=\"hidden\" name=\"num1\" value=\"$num1\">\n";
    echo "<input type=\"hidden\" name=\"num2\" value=\"$num2\">";
}
function spam_protection_pre($comment, $post, $result){
    if(isset($_POST['sum'])){$sum=$_POST['sum'];}
    switch($sum){
        case $_POST['num1']+$_POST['num2']:
        break;
        case null:
        throw new Typecho_Widget_Exception(_t('抱歉：请输入验证码','评论失败'));
        break;
        default:
        throw new Typecho_Widget_Exception(_t('抱歉：验证码错误，请返回重试','评论失败'));

	};
    return $comment;
}

/**
* 获取扇贝单词每日一句
*/
function today(){
    //删除之前的图片和故事
    for ($i=1; $i <=30 ; $i++) { 
        @unlink(date('Ymd',time()-24*3600*$i).'.json');
    }
    $coverstory = date('Ymd').'.json'; //每日故事 json格式
    if (!file_exists($coverstory)) {
        $json = file_get_contents("compress.zlib://".'https://rest.shanbay.com/api/v2/quote/quotes/today/');
        @file_put_contents($coverstory,$json); //写入文本
    }
    $coverstory = json_decode(file_get_contents($coverstory),true);
    return $coverstory;
}