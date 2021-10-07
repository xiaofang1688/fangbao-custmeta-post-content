<?php
/*
Plugin Name: fangbao-custmeta-post-content
Plugin URI: https://www.fang1688.cn/study-code/2304.html
Description:wordpress短标签自定义文章模板内容
Version: 1.0
Author: 方包
Author URI: http://www.fang1688.cn
License: GPLv2
*/

//设置时区为 亚洲/上海
date_default_timezone_set('Asia/Shanghai');

class hcsem_change_font_style {
	
	//声明类里面的属性，用 var 开头
	var $icon_url = "/images/icon.png";
	var $option_group = "hc_test_group";
	
	//构造方法，创建类的时候调用
	function hcsem_change_font_style() {
		
		//创建菜单
		add_action( 'admin_menu', array( $this, 'hc_create_menu' ) );
		add_action( 'admin_init', array( $this, 'register_hc_test_setting' ) );

		
		//添加一个 hcsem 短标签，调用 hcsem_shortcode 方法进行处理
		add_shortcode( 'fbao', array( $this, 'hcsem_shortcode' ) );
	}



	

	function hcsem_shortcode( $atts, $content = "" ) {
		
// 		$atts = shortcode_atts( array(
// 			'title' => '方包博客',
// 		), $atts, 'fbao' );
		
		$hc_test_option = get_option( "hc_test_option" );
		$output = "<div>{$hc_test_option["color"]}</div>";
		
		return $output;
	}
	
		//使用register_setting()注册要存储的字段
	function register_hc_test_setting() {
		
		//注册一个选项，用于装载所有插件设置项
		register_setting( $this->option_group, 'hc_test_option' );
		
		//添加选项设置区域
		$setting_section = "hc_test_setting_section";
		add_settings_section(
			$setting_section,
			'',
			'',
			$this->option_group
		);
		
		//设置文章页模板内容
		add_settings_field(
			'hc_test_color',
			'文章页模板内容',
			array( $this, 'hc_test_color_function' ),
			$this->option_group,
			$setting_section
		);
		

	}
	


	function hc_test_color_function() {
		$hc_test_option = get_option( "hc_test_option" );
		?>

		<textarea rows="10" cols="30" name='hc_test_option[color]'><? echo $hc_test_option["color"]; ?></textarea>
		<?
	}

	function hc_create_menu() {
		
		//创建顶级菜单
		add_menu_page( 
			'方包的插件首页', 
			'文章内容模板', 
			'manage_options', 
			'hc_test' ,
			array( $this, 'hc_settings_page' ),
			plugins_url( $this->icon_url, __FILE__ )
		);
	}
	
	function hc_settings_page() {
		?>
		<div class="wrap">
			<h2>方包短标签文章内容模板插件</h2>
			<br><br>
			<div>使用方法：将您要作为模板的html内容输入到下面文本框并保存，然后写一篇文章在编辑栏输入短代码[fbao]即可！</div>
			<div>使用教程：<a href="https://www.fang1688.cn/study-code/2304.html">https://www.fang1688.cn/study-code/2304.html</a></div>
			
			<form action="options.php" method="post">
			<?
				//输出一些必要的字段，包括验证信息等
				settings_fields( $this->option_group );
				
				//输出选项设置区域
				do_settings_sections( $this->option_group );
				
				//输出按钮
				submit_button();
			?>
			</form>
		</div>
		<?
	}

}

new hcsem_change_font_style();


function fbao_copyright_deactivation() {
	
	//插件停用，设置停用标识为1
	update_option( "fbao_copyright_deactivation", "yes" );
	
}