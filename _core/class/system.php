<?php
/*

RUN service RUN
a code by Seyhan YILDIZ

*/


//system class
class design {
	public static $header;
	public static $footer;
	public static $page;
	public static $header_file ='header';
	public static $footer_file = 'footer';

	public static function load($file){

		if(!file_exists('_core/views/' . $file .'.html')){
			return $file . ' file doesn\'t exists..<br />';
		}

		$data = file_get_contents('_core/views/' . $file .'.html');

		return $data;
	}
	public static function display(){
		/*verilerin aktarılması ve soyutlanmış sayfa ayarlanabilir hale getirilmesi */
		self::$header = self::load(self::$header_file);
		self::$footer = self::load(self::$footer_file);
		self::$page   = self::load(route::$view);
		
		$data =  self::$header . self::$page . self::$footer;
		/*
		
			 kelime işlemleri eklenecek
		
		*/

		echo $data;//görüntü aktarımı 

	}
}

class app extends design{
	public static $auto_configure = 1;
	public static $config = Array('cache' => false, 
								  'db_type' =>'sqlite', 
								  'db_host' => 'database.db', 
								  'db_user' => '',  
								  'db_pass' => '',
								  'x404'=>1 // 0 = default(controller) 1 = static check (and if fail turn to default) string is rooting "string" controller
								  ); 

	public static function seo_filter($link){
		//seo link hazırlamak için        //tr karakter encode
        $search  = Array('Ü', 'İ', 'Ş', 'Ğ', 'Ö', 'Ç', 'ü', 'ı', 'ş', 'ğ', 'ö', 'ç', 'Ãœ', '.',' ', '?','_','\\','=','&','+');
        $replice = Array('u', 'i', 's', 'g', 'o', 'c', 'u', 'i', 's', 'g', 'o', 'c', '', '', '', '', '', '', '', '');

        $data = str_replace($search, $replice, $link); 
        $data = strtolower($data);

        return $data; 
	}

	public static function run(){
		//charset
		header('Content-Type: text/html; charset=UTF-8');

		//router bilgisi al
		require_once('router.php');

		route::get();


		/*


		controller e aktar
		views i controller hazırlasın
		
		static sayfaysa controllerı es geçip sayfa şablonuna yükle

		*/
		if(route::$static == 1){
			parent::display();
			return;
		} 
		//kontroller ı devreye al hazırla sonra görüntüle
 

		//görüntüle
		parent::display();
		 
	}
}
