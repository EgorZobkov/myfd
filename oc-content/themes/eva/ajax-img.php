<?php
define('ABS_PATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');
require_once ABS_PATH . 'oc-load.php';
    $do = Params::getParam('do');
    
    if($do == 'img-rotate') {
        $img_name = Params::getParam('imgName');
		if(!empty(Params::getParam('imgPath'))) {
    $img_path = Params::getParam('imgPath');
          }
     	if(!empty(Params::getParam('itemType'))) {
    $item_type = Params::getParam('itemType');
          } else {
		$item_type = '';	  
		  }  
        
        
        $angle = -90;
        $file_org = '';
        
        if($item_type == 'edit') {
            $img_path = substr($img_path, strpos($img_path, 'uploads'), strlen($img_path));
            $img_org = str_replace('_thumbnail', '', $img_path);
            
            $file = $_SERVER['DOCUMENT_ROOT'] . '/oc-content/' . $img_path;
            $file_org = $_SERVER['DOCUMENT_ROOT'] . '/oc-content/' . $img_org; 
        }
        else {
            $file = $_SERVER['DOCUMENT_ROOT'] . '/oc-content/uploads/temp/' . $img_name;
        }
        
        $img_info = getimagesize($file);
        
        switch($img_info['mime']) {
            case 'image/jpeg':
                $img = imagecreatefromjpeg($file) or die('Error opening file '.$file);
                $rotate_img = imagerotate($img, $angle, '0xffffff');
                imagejpeg($rotate_img, $file);
            break;
            
            case 'image/png':
                $img = imagecreatefrompng($file) or die('Error opening file '.$file);
                imagealphablending($img, false);
                imagesavealpha($img, true);
                
                $rotate_img = imagerotate($img, $angle, imageColorAllocateAlpha($img, 0, 0, 0, 127));
                imagealphablending($rotate_img, false);
                imagesavealpha($rotate_img, true);
                
                imagepng($rotate_img, $file);
            break;
            
            default:
                $img = imagecreatefromgif($file) or die('Error opening file '.$file);
                $rotate_img = imagerotate($img, $angle, '0xffffff');
                imagegif($rotate_img, $file);
            break;
			
			        imagedestroy($rotate_img);
        }
        

        
        if($file_org) {
            switch($img_info['mime']) {
                case 'image/jpeg':
                    $img = imagecreatefromjpeg($file_org) or die('Error opening file '.$file_org);
                    $rotate_org_img = imagerotate($img, $angle, '0xffffff');
                    imagejpeg($rotate_org_img, $file_org);
                break;
                
                case 'image/png':
                    $img = imagecreatefrompng($file_org) or die('Error opening file '.$file_org);
                    $rotate_org_img = imagerotate($img, $angle, '0xffffff');
                    imagepng($rotate_org_img, $file_org);
                break;
                
                default:
                    $img = imagecreatefromgif($file_org) or die('Error opening file '.$file_org);
                    $rotate_org_img = imagerotate($img, $angle, '0xffffff');
                    imagegif($rotate_org_img, $file_org);
                break;
            }
			        imagedestroy($rotate_org_img);
        }
        

    }
?>