<?php
/*
Plugin Name: NIC Photo Editor
Description: NIC Photo Editor allows us to create some absolutely amazing graphics on the web. Merge multiple image and convert in single image. Save your canvas image in media library and you can insert it in any location of your post or page. Objects can be easily flipped or rotate in any direction. Or locked in movement, scaling, etc.
Version: 1.1
Author: IndiaNIC
Author URI: http://profiles.wordpress.org/indianic/
License: GPLv2 or later
*/

if( !defined('CANVASFRAME_VER') ) define( 'CANVASFRAME_VER', '1.0' );

class photo_editor_frame{

var $wpdb;  

public function __construct() {
	
	global $wpdb;
	$this->wpdb = $wpdb;
	$this->ds = DIRECTORY_SEPARATOR;
	$this->pluginPath = dirname(__FILE__) . $this->ds;
	$this->rootPath = dirname(dirname(dirname(dirname(__FILE__))));
	$this->pluginUrl = WP_PLUGIN_URL . '/'.plugin_basename(dirname(__FILE__)).'/';
	
	add_action('admin_menu', array($this, 'canvas_image_frame_admin_menu'));	
	add_action('admin_enqueue_scripts', array($this, 'canvas_image_frame_enqueue_styles'));
	add_action( 'wp_print_scripts', array($this, 'canvas_image_frame_enqueue_scripts'));
	add_action('wp_ajax_my_special_action', array($this,'save_canvas_ajax'));
		
	if (isset($_GET['page']) && $_GET['page'] == 'add_image_frame.php') {
      add_action('admin_print_scripts', array($this, 'wp_gear_manager_admin_scripts'));
      add_action('admin_print_styles', array($this, 'wp_gear_manager_admin_styles'));    
    }
	
}


public function canvas_image_frame_admin_menu(){
	
	add_menu_page('add_image_frame.php','NIC Photo Editor','publish_posts','add_image_frame.php',array($this,'canvas_image_frame_add_dashbord'),$this->pluginUrl.'/images/icon.png');
	
}

/**
 * Canvas image maker dashbord file
 */
public function canvas_image_frame_add_dashbord()
{
	require($this->pluginPath . "add_image_frame.php");	
}

/**
 * Save/Add canvas image to media library
 */
public function save_canvas_ajax() {
	global $wpdb;
	if($_REQUEST['type'] == 'add_frame'){			
		// requires php5							
		$uploads = wp_upload_dir();			
		$img = str_replace('data:image/png;base64,', '', $_POST['image_data']);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$filename = uniqid() . '.png';
		$file = $uploads['path'].'/'. $filename;		
		$success = file_put_contents($file, $data);
		$src = imagecreatefrompng($file);
		
		//to get temporary uploaded image size
		list($width,$height)=getimagesize($file);
		$canvas_w = 500;
		$canvas_h = 500;	
		
		//if user change canvas size
		if($_REQUEST['canvas_final_w'] !='' || $_REQUEST['canvas_final_h'] !=''){		
			if($_REQUEST['canvas_final_w'] !='')
			$canvas_w = $_REQUEST['canvas_final_w'];
			
			if($_REQUEST['canvas_final_h'] !='')
			$canvas_h = $_REQUEST['canvas_final_h'];
			
			//to transparency image
			$tmp=imagecreatetruecolor($canvas_w,$canvas_h);
			imagealphablending($tmp, false);
			$color = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
	        imagefill($tmp, 0, 0, $color);
	        imagesavealpha($tmp, true);
	        
	        //to upload re-size image, temporary
			imagecopyresampled($tmp,$src,0,0,0,0,$canvas_w,$canvas_h,$width,$height);
			imagepng($tmp,$file);		
			imagedestroy($src);
			imagedestroy($tmp);
		}
		
		$imageurl = $uploads['url'].'/'.$filename;		
		$imageurl = stripslashes($imageurl);		
		$ext = pathinfo( basename($imageurl) , PATHINFO_EXTENSION);
		$newfilename = $_POST['newfilename'] ? $_POST['newfilename'] . "." . $ext : basename($imageurl);
					
		$filename = wp_unique_filename( $uploads['path'], $newfilename, $unique_filename_callback = null );
		
		$wp_filetype = wp_check_filetype($filename, null );
		$fullpathfilename = $uploads['path'] . "/" . $filename;
		
		try {
				if ( !substr_count($wp_filetype['type'], "image") ) {
					throw new Exception( basename($imageurl) . ' is not a valid image. ' . $wp_filetype['type']  . '' );
				}
			
				$image_string = $this->fetch_image($imageurl);
				
				
				$fileSaved = file_put_contents($uploads['path'] . "/" . $filename, $image_string);
				if ( !$fileSaved ) {
					throw new Exception("The file cannot be saved.");
				}
				
				$attachment = array(
					 'post_mime_type' => $wp_filetype['type'],
					 'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
					 'post_content' => '',
					 'post_status' => 'inherit',
					 'guid' => $uploads['url'] . "/" . $filename
				);
				$attach_id = wp_insert_attachment( $attachment, $fullpathfilename, '' );
				if ( !$attach_id ) {
					throw new Exception("Failed to save record into database.");
				}
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				$attach_data = wp_generate_attachment_metadata( $attach_id, $fullpathfilename );
				wp_update_attachment_metadata( $attach_id,  $attach_data );								
				
			
			} catch (Exception $e) {
				$msg = $e->getMessage();
			}
			unlink($file);
			
			if ( $fileSaved && $attach_id ) {
				$msg =  'success';				
			}
			
			echo $msg;
			die;
		}
		
}

/**
 * Upload image with thumbnail size
 */
function fetch_image($url) {
	if ( function_exists("curl_init") ) {
		return $this->curl_fetch_image($url);
	} elseif ( ini_get("allow_url_fopen") ) {
		return $this->fopen_fetch_image($url);
	}
}

function curl_fetch_image($url) {
	$canvas_curl = curl_init();
	curl_setopt($canvas_curl, CURLOPT_URL, $url);
	curl_setopt($canvas_curl, CURLOPT_RETURNTRANSFER, 1);
	$image = curl_exec($canvas_curl);
	curl_close($canvas_curl);
	return $image;
}

function canvas_image_frame_enqueue_styles(){
			// Loads our styles, only on the back end of the site
			if( is_admin() ){
				wp_enqueue_style( 'canvas_image_frame_main', plugins_url('css/style.css', __FILE__) );
			}
}

function canvas_image_frame_enqueue_scripts(){
			// Loads our scripts, only on the back end of the site
			if( is_admin() ){				
				// Load javascript
				$load_js_in_footer = '';
				wp_enqueue_script( 'canvas_image_frame_main', plugins_url('/js/fabric.js', __FILE__), array('jquery'), FALSE, $load_js_in_footer );		
				$data = array('version' => CANVASFRAME_VER);
				wp_localize_script('canvas_image_frame_main', 'canvas_image_frame_options', $data);
				
				wp_enqueue_script( 'canvas_image_frame_main2', plugins_url('/js/jscolor.js', __FILE__), array('jquery'), FALSE, $load_js_in_footer );		
				$data = array('version' => CANVASFRAME_VER);
				wp_localize_script('canvas_image_frame_main2', 'canvas_image_frame_options2', $data);
			}
		}

/**
 * include media upload related files.
 */
function wp_gear_manager_admin_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('jquery');
  }
  
function wp_gear_manager_admin_styles() {
    wp_enqueue_style('thickbox');
  }

}

add_action("init", "register_photo_editor_frame");
function register_photo_editor_frame() {
  global $photo_editor_frame;
  $photo_editor_frame = new photo_editor_frame();
}

?>