<?php

require_once dirname(__FILE__) . '/openSRS_config.php';

final class Autoloader
{
  static public function load( $classname )
  {
    $lib_paths = array(OPENSRSURI, OPENSRSMAIL, OPENSRSOMA, OPENSRSFASTLOOKUP, OPENSRSTRUST);

    foreach ($lib_paths as &$path) {
    	$classfile = $path . DS . $classname . ".php";
    	if(file_exists( $classfile )) {
      	require_once $classfile;
    	}
  	}
  }
  static public function load_domains( $classname )
  {
    $iterator = new DirectoryIterator(OPENSRSDOMAINS);
    foreach($iterator as $dir){
    	if($dir->isDot()) continue;
      $classfile = OPENSRSDOMAINS . DS . $dir . DS . $classname . ".php";
    	if(file_exists( $classfile )) {
      	require_once $classfile;
    	}
    }
  }
}

spl_autoload_register( array( 'Autoloader', 'load') );
spl_autoload_register( array( 'Autoloader', 'load_domains') );
