<?php
/**
 * gifstop阻止文章中gif后缀的图片自动播放，插件基于https://github.com/krasimir/gifffer
 * 
 * @package gifstop
 * @author Jrotty
 * @version 1.0
 * @link http://qqdie.com/archives/gif-stop.html
 */
class gifstop_Plugin implements Typecho_Plugin_Interface
{ 
 public static function activate()
	{
        Typecho_Plugin::factory('Widget_Archive')->footer = array('gifstop_Plugin', 'footer');
        Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('gifstop_Plugin', 'gifclass');
        Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('gifstop_Plugin', 'gifclass');
    }
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
	public static function deactivate(){}

   /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
$sj = new Typecho_Widget_Helper_Form_Element_Radio(
        'sj', array('0'=> '默认', '1'=> '默认'), 0, '无用设置',
            '这是个无用的设置');
        $form->addInput($sj);
	}   
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
 
 /**
     * 自动替换图片链接
     *
     * @access public
     * @param string $content
     * @return void
     */
    public static function gifclass($content, $widget, $lastResult) {
    	$content = empty($lastResult) ? $content : $lastResult;
    	$content = preg_replace('#<img(.*?)src="(.*?).gif"(.*?)>#','<img$1data-gifffer="$2.gif"$3>', $content);
        return $content;
    }
    
  
    public static function footer(){
        $options = Typecho_Widget::widget('Widget_Options')->plugin('gifstop'); 
        echo '</script><script  src="'.Helper::options()->pluginUrl . '/gifstop/res/gifffer.min.js"></script>' . "\n"; 
        echo '<script>    window.onload = function() {
                Gifffer();
            }</script>';
    }

}
