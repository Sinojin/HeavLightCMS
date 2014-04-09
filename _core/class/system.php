<?php
/*

RUN service RUN
a code by Seyhan YILDIZ

*/


//system class
class design {
	public static function test(){
		echo 'asdsa';
	}
}

class app extends design{
	public static $auto_configure = 1;

	public static function seo_filter($link){
		//seo link hazırlamak için        //tr karakter encode
        $search = Array('Ü', 'İ', 'Ş', 'Ğ', 'Ö', 'Ç', 'ü', 'ı', 'ş', 'ğ', 'ö', 'ç', 'Ãœ', '.',' ', '?','_','\\','=','&','+');
        $replice = Array('u', 'i', 's', 'g', 'o', 'c', 'u', 'i', 's', 'g', 'o', 'c', '', '', '', '', '', '', '', '');

        $data = str_replace($search, $replice, $link); 
        $data = strtolower($data);

        return $data; 
	}
	public static function config($array=null){
		//veritabanı bilgisi al
		require_once('configuration.php');
		self::$auto_configure = 0;
		//array i congig class ına değer olarak aktar
		if($array){

			$key = array_keys($array);
	        $size = sizeOf($key);
	        for ($i = 0; $i < $size; $i++) {

	        	$cnf = $key[$i];
	        	$data = $array[$key[$i]];

	        	eval('config::$' . $cnf . ' = $data;');

	            $i++;
	            
	        }

	    }
        return true;
	}

	public static function run(){

		if(self::$auto_configure == 1){
			//veritabanı bilgisi al
			require_once('configuration.php');			
		}

		//router bilgisi al
		require_once('router.php');

		route::get();

		//test
		echo route::$view; 

		/*


		controller e aktar
		views i controller hazırlasın


		*/
 

		//görüntüle
		 
	}
}
