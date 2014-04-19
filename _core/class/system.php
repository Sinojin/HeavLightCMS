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
	public static $db;
	public static $controller;
	public static $config = Array('cache' => false, 
				  'db_type' =>'sqlite', 
				  'db_host' => 'localhost', 
				  'db_name' => 'database.db', 
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
	public static function connect(){
			if(!self::$db){
				switch (self::$config['db_type']) {
					case 'mysql':
						# mysql connecting..
						$dns = 'mysql:host=' . self::$config['db_host'] . ';dbname=' . self::$config['db_name'];
						break;
					case 'mssql':
						# mssql connecting..
						$dns = 'sqlsrv:server=' . self::$config['db_host'] . ';database=' . self::$config['db_name'];
						break;
					
					default:
						# sqlite connecting..
						$dns = 'sqlite:' . self::$config['db_name'];
						break;
				}
				self::$db = new PDO($dns, self::$config['db_user'], self::$config['db_pass']);
				self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			return self::$db;
	}
	private function load_controller(){
		//load controller file
		include('_core/controllers/' . route::$view . '.php');  
 	  	self::$controller = new route::$view();

	}

	public static function run(){
		//charset
		header('Content-Type: text/html; charset=UTF-8');

		//router bilgisi al
		require_once('router.php');

		self::connect();
  
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
		
 	   //file_exists('_core/controllers/' . route::$view . '.php') ? $this->load_controller() : die('File doesn\'t exits..');


		//görüntüle
		parent::display();
		 
	}  
	private function __clone(){ }
}
