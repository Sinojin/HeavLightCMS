<?php
/*

router system
a code by Seyhan YILDIZ a.k.a. sTaRs

*/

class route {
	public static $view;
	public static $function;
	public static $get;
	public static $id;

	public static function sql($route){
		try {

			$db = new PDO('sqlite:' . config::$database);	
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db = $db->query("select count(*) as count, * from router where seo = '{$route}';");
			$result =  $db->fetch(PDO::FETCH_ASSOC);

			//route yoksa ana sayfayı döndür
			if(!$result['count']){
				return 'default';
			}

			//rota belirle
			//id yi aktar
			self::$id = $result['module_id'];

			//controller tanı
			return $result['view'];

			//bağlantıyı kes
			$db = null;

		} catch (Exception $e) {
			
			die ($e);
		}

	}

	public static function get(){
		if(!$_GET){
			self::$view = 'default';
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