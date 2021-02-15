<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Template extends Model {
	
	protected $table ="template";
	public $timestamps = false; 	
	

	public static function call_cl_fun() {
		return (new Template());
  }
	

	public function image_path() {
	   return FULL_PATH.$this->folder.DS.$this->logo;
	}
	public function image_path2() {
	   return FULL_PATH.$this->folder.DS.$this->favicon_logo;
	}
	public function path() {
	  return FULL_PATH.$this->folder.DS;
	}
    public static function image_maker($image,$upload_size,$uid,$imgfield)
    {
	$message='';
	$upload_size=($upload_size*1024)*1024;
	$data=self::call_cl_fun();
	$size=round($image['size']);
	$n=explode(".",$image['name']);
	$filename=$image["tmp_name"];
    $type=$n[1];	
	if($size>$upload_size)
	{
		
	$message='<div align="center">                
                <h4 class="alert alert-danger">Image Size is Larger Than 1MB '.$size.'Kb</h4>                
            </div>';
echo output_message($message);
redirect_by_js('',1000);
	exit();
	
		}
		if($type!='jpg' && $type!='jpeg' && $type!='png')
		{
			toast_canonical("Error","","Image type is not jpg or png -".$type."",1000);
			$message='<div align="center">                
                <h4 class="alert alert-danger">Image type is not jpg or png - '.$type.'</h4>                
            </div>';
echo output_message($message);
redirect_by_js('',1000);
	?>
  
    <?php
	redirect_by_js('',100);
	exit();
	}	
	if($uid!='')
	{	
	$user=self::find($uid);
	if($user->$imgfield!='')
	{	
	
	unlink($_SERVER['DOCUMENT_ROOT']."/".MYF.$user->image_path());
	$user->empty_imgae($uid,$imgfield);
	}
	}	 
     $n=explode('.',$image['name']);
	 $imgname=$n[0]."_".rand(5, 8522166).".".$n[1];
	 //$date = date('m/d/Yh:i:sa', time());
 	 
    // $encname=$date;
     $imgname=$imgname.'.'.$n[0].'.'.$n[1];
	 $manager = new ImageManager(array('driver' => 'gd'));
	 $image = $manager->make($filename)->save(SITE_ROOT.DS.$data->path().$imgname); 
     return $imgname;
	 
    }	
	
	// Common Database Methods
	// Common Database Methods
	public static function hd_css() {
	$x=stylesheet_formate('assets/plugin/datatables/media/css/dataTables.bootstrap.min.css');
	$x.=stylesheet_formate('assets/plugin/datatables/extensions/Responsive/css/responsive.bootstrap.min.css');
	$x.=stylesheet_formate('assets/styles/jquery-ui.css');
	$x.=stylesheet_formate('elfinder/css/elfinder.min.css');
	$x.=stylesheet_formate('elfinder/css/theme.css');
	$x.=stylesheet_formate('assets/plugin/lightview/css/lightview/lightview.css');		
	echo $x;
    } 
    public static function hd_script() {
	$x=script_formate('assets/scripts/image.js');
	$x.=script_formate('assets/plugin/validator/validator.min.js');
	$x.=script_formate('elfinder/js/elfinder.min.js');
	$x.=script_formate('assets/plugin/lightview/js/lightview/lightview.js');
	echo $x;
    }	
   public static function other_script() {
	   
	   ?>
<script type="text/javascript" charset="utf-8">
			// Documentation for client options:
			// https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
			$(document).ready(function() {
				
				$('#cache_time').datepicker({dateFormat:"dd/mm/yy"})
				$('#elfinder').elfinder(
					// 1st Arg - options
					{
						cssAutoLoad : false,               // Disable CSS auto loading
						baseUrl : './',                    // Base URL to css/*, js/*
						url : '<?=TP_BACK?>elfinder/php/connector.minimal.php'  // connector URL (REQUIRED)
						// , lang: 'ru'                    // language (OPTIONAL)
					},
					// 2nd Arg - before boot up function
					function(fm, extraObj) {
						// `init` event callback function
						fm.bind('init', function() {
							// Optional for Japanese decoder "encoding-japanese.js"
							if (fm.lang === 'ja') {
								fm.loadScript(
									[ '//cdn.rawgit.com/polygonplanet/encoding.js/1.0.26/encoding.min.js' ],
									function() {
										if (window.Encoding && Encoding.convert) {
											fm.registRawStringDecoder(function(s) {
												return Encoding.convert(s, {to:'UNICODE',type:'string'});
											});
										}
									},
									{ loadType: 'tag' }
								);
							}
						});
						// Optional for set document.title dynamically.
						var title = document.title;
						fm.bind('open', function() {
							var path = '',
								cwd  = fm.cwd();
							if (cwd) {
								path = fm.path(cwd.hash) || null;
							}
							document.title = path? path + ':' + title : title;
						}).bind('destroy', function() {
							document.title = title;
						});
					}
				);
			});
		</script>
<?php
   }
	// Common Database Methods
	
	
	protected function empty_imgae($id=0,$field='') {
	  global $database;
    $sql=("UPDATE ".self::$table_name." SET `".$field."`='' WHERE `id`=".$database->escape_value($id)."");
	 if($database->query($sql)) {
	    $this->id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
  }	
 

	
public static function action_data($id) {	 
	$data=self::find($id);
	$logo='';
	$favicon_logo='';
	$temp='';
	$checkbox='';
	$temps='';
	$checkboxs='';
	$tpimg_logo='';
	$tpimg_favicon_logo ='';
 if(isset($_REQUEST['submit'])){
	extract($_POST);
$data->sitename=$sitename;

 if($_FILES['logo']['size']!=0)
	  {  
      $data->logo=$data->image_maker($_FILES['logo'],1,$id,"logo");  
	  }elseif($_POST['tpimg_logo'])
	  {
		  $data->logo=$_POST['tpimg_logo'];
	  }
	 if($_FILES['favicon_logo']['size']!=0)
	  {    
      $data->favicon_logo=$data->image_maker($_FILES['favicon_logo'],1,$id,"favicon_logo");  
	  } elseif($_POST['tpimg_favicon_logo'])
	  {
		  $data->favicon_logo=$_POST['tpimg_favicon_logo'];
	  }
	$data->email=$email;
	$data->phone=$phone;
	$data->canonical=$canonical;
	$data->keyword=$keyword;
	$data->description=$description;
	$data->ana=$ana;
	$data->footer=$footer;
	$data->cache=$cache;
	if($cache>1)
	{	
	$data->cache_time=date_formatess($cache_time);
	}else
	{
		$temp=self::find(1);
		$data->cache_time=$temp->cache_time;
		
	}
	
	$pp=$data->save();
	$message='<div align="center">                
                <h4 class="alert alert-success">Success! Record Updated Successfully</h4>
                <span><img src="'.TP_BACK.'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span>
            </div>';	 

echo output_message($message);
redirect_by_js("".TP_BACK."admin/dashboard/settings",100);
 }
}
	
	public static function backupsql() {		
		$data=Template_mo::backnow();
		backup_action('File Name', "{$data}");
		redirect_by_js("backnow_history",100);
  }
  public static function backnow_history() {		
		Template_mo::backnow_his();
		
  }
   public static function backup_history_clear() {		
		Template_mo::backup_history_clears();
		
  }
   public static function cache_timer() {	
        $row=self::find(1);
		//echo $cdate=strtotime(date("d/m/Y"));
		$dateTimestamp1 = strtotime(date("d/m/Y")); 
		$dateTimestamp2 = strtotime($row->cache_time);
		if ($dateTimestamp1 < $dateTimestamp2) 
		{
			$newdate=date('Y-m-d', strtotime($row->cache_time. ' + 10 day'));			
			self::update_cache_timer($row->id,"cache_time",$newdate);
			delete_files(CACHE);
		}
		
		
  }
public static function form_data() {
		     echo $fo=Forms::form_start();			
			  self::action_data(1,'edit');
			  $data = self::find(1);
			  $impath=$data->image_path();
			  $impath2=$data->image_path2();
			  
			  $sitename=$data->sitename;
			  
			  $email=$data->email;
			  $phone=$data->phone;
			  $canonical=$data->canonical;
			  $favicon_logo=$data->favicon_logo;
			  $logo=$data->logo;
			  $keyword=$data->keyword;
			  $description=$data->description;
			  $ana=$data->ana;
			  $footer=$data->footer;
			  $cache=$data->cache;
			  $cache_time=date_formates($data->cache_time);
			  
			  echo $fo=Forms::image_simple_edit("Logo","logo",$impath,$logo); 
			  echo $fo=Forms::image_simple_edit("Favicon image","favicon_logo",$impath2,$favicon_logo);       
			  echo $fo=Forms::input("Sitename","sitename",$sitename,1);
			  echo $fo=Forms::input("Email","email",$email,0);  
			  echo $fo=Forms::input("Share Mobile No","phone",$phone,0);  
			  echo $fo=Forms::input("Canonical","canonical",$canonical,0);			  		  
			  echo $fo=Forms::text_editor("Keyword","keyword",$keyword,'',0);
			  echo $fo=Forms::text_editor("Description","description",$description,'',0);
			  echo $fo=Forms::text_editor("Analytics Code","ana",$ana,'',0);
			  echo $fo=Forms::input("Footer Copywrite","footer",$footer,0);
			  echo $fo=Forms::Select_status_yes("Cache","cache",$cache);
			  if($cache!=0)
			  {
			  echo $fo=Forms::date_mm("Cache Clean Timer (in days)","cache_time",$cache_time,"cache_time",0);	
			  }
			  echo $fo=Forms::submit();
			  echo $fo=Forms::form_end();
	 }
}

?>