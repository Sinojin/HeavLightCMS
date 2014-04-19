<?php
/*

router system
a code by Seyhan YILDIZ a.k.a. sTaRs

*/

class route {
	public static $view;
	public static $static = 0;
	public static $function;
	public static $get;
	public static $id;

	public static function sql($route){
		try { 

			//route yoksa ve static arama kapalıysa ana sayfayı döndür
			$result = app::$db->query("select count(*) as count, * from router where seo = '{$route}';")->fetch(PDO::FETCH_ASSOC); 
 
			if(!$result['count']){
				if(app::$config['x404'] == 0){

					return 'index';

				}
				if(!is_int(app::$config['x404'])){

					return app::$config['x404'];

				}
				if(app::$config['x404'] == 1 &&	file_exists('_core/views/static/' . $route . '.html')){

					self::$static = 1;
					return 'static/' . $route;

				}
				return 'index';

			}

			//rota belirle
			//id yi aktar
			self::$id = $result['module_id'];

			//controller tanı
			return $result['view'];

			//bağlantıyı kes
			//app::$db = null;

		} catch (Exception $e) {
			
			die ($e);
		}

	}

	public static function get(){
		if(!$_GET){

			self::$view = 'index';
			return true;

		}
		else {
			/*
			/
			/	sql injection kontrol edicek
			/	
			----------------------------*/


			self::$get = explode('/',$_GET['route']);

			//veritabanından route et
			self::$view = self::sql(self::$get[0]);

			//fonksiyon yükle
			if(count(self::$get)<0){
				self::$function = self::$get[1];
			}
			
			//return baby..
			return true;


		}
	}

}