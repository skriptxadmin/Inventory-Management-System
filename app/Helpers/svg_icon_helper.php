<?php 

function svg_icon($filename, $classnames=''){

    $path = FCPATH.'/./svgs/'.$filename.'.svg';

    if(!file_exists($path)){

        return '';
    }

    $contents = file_get_contents($path);

    if($classnames){
$str = '<span class="%1$s">'.$contents.'</span>';
  return sprintf($str, $classnames);

    }

    return $contents;

    

}