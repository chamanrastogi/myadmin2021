<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Hashing\BcryptHasher;
class User extends Model {
	
	protected $table ="users";
	public $timestamps = false; 
	public $folder ="users";
	
	
	public static function call_cl_fun() {
		return (new Template());
  }
	public function image_path()
    {
        return FULL_PATH.$this->folder.DS.$this->image;
    }
    public function fpath()
    {
        return FULL_PATH.$this->folder.DS.$this->image;
    }
    public function path()
    {
        return FULL_PATH.$this->folder.DS;
    }
    public function img_path()
    {
        return $this->folder.DS;
    }
    public static function image_maker($image, $upload_size, $uid, $imgfield)
    {

        $message = '';
        $upload_size = ($upload_size * 1024) * 1024;
       
        $size = round($image['size']);
        $n = explode(".", $image['name']);
        $filename = $image["tmp_name"];
        $type = $n[1];
        if ($size > $upload_size)
        {

            $message = '<div align="center">                
                <h4 class="alert alert-danger">Image Size is Larger Than 1MB ' . $size . 'Kb</h4>                
            </div>';
            echo output_message($message);
            redirect_by_js('', 1000);
            exit();

        }
        if ($type != 'jpg' && $type != 'jpeg' && $type != 'png')
        {
            toast_msg("Error", "", "Image type is not jpg or png -" . $type . "", 1000);
            $message = '<div align="center">                
                <h4 class="alert alert-danger">Image type is not jpg or png - ' . $type . '</h4>                
            </div>';
            echo output_message($message);
            redirect_by_js('', 1000);
?>
  
    <?php
            redirect_by_js('', 100);
            exit();
        }
        if ($uid != '')
        {
            $user = self::find($uid);
            if ($user->$imgfield != '')
            {

                unlink($_SERVER['DOCUMENT_ROOT'] . "/" . MYF . $user->image_path());
                $user->empty_imgae($uid);
            }
        }
        $n = explode('.', $image['name']);
        $imgname = $n[0] . "_" . rand(5, 8522166) . "." . $n[1];

        $manager = new ImageManager(array(
            'driver' => 'gd'
        ));
        $image = $manager->make($filename)->resize(null, 200, function ($constraint)
        {
            $constraint->aspectRatio();
        })
            ->save(SITE_ROOT . DS . $data->path() . $imgname);
        return $imgname;

    }
  public static function authenticate($username="", $password="") {
    global $database;
    
	$cs=self::where("username",'=',$username)->count();
	if($cs==1)
	{
	$xx=self::where('username', '=', $username)->first();
	}else
	{
		  $msg='Username Not Matched';
		  return $msg;
		  exit();
	 }
	$np=$xx->password;
	$xp=new BcryptHasher();  
	if($xp->check($password,$np,['rounds' => 4]))
	{
		$password=$xx->password;
	}else
	{
		  $msg='Password Not Matched';
		  return $msg;
		  exit();
	}	

   
    $result_array = $xx;	
	
		return !empty($result_array) ? ($result_array) : false;
	}
		
	
	 public static function hd_css()
    {
        $x = stylesheet_formate('assets/plugin/datatables/media/css/dataTables.bootstrap.min.css');
        $x .= stylesheet_formate('assets/plugin/datatables/extensions/Responsive/css/responsive.bootstrap.min.css');
        $x .= stylesheet_formate('assets/plugin/datatables/media/css/buttons.dataTables.min.css');
        $x .= stylesheet_formate('assets/plugin/touchspin/jquery.bootstrap-touchspin.min.css');
        $x .= stylesheet_formate('assets/plugin/lightview/css/lightview/lightview.css');
        echo $x;
    }
    public static function hd_script()
    {
        $x = script_formate('assets/plugin/datatables/media/css/dataTables.bootstrap.min.css');
        $x .= script_formate('assets/plugin/datatables/media/js/jquery.dataTables.min.js');
        $x .= script_formate('assets/plugin/datatables/media/js/dataTables.bootstrap.min.js');
        $x .= script_formate('assets/plugin/datatables/media/js/dataTables.buttons.min.js');
        $x .= script_formate('assets/plugin/datatables/media/js/buttons.flash.min.js');
        $x .= script_formate('assets/plugin/datatables/media/js/jszip.min.js');
        $x .= script_formate('assets/plugin/datatables/media/js/pdfmake.min.js');
        $x .= script_formate('assets/plugin/datatables/media/js/vfs_fonts.js');
        $x .= script_formate('assets/plugin/datatables/media/js/buttons.html5.min.js');
        $x .= script_formate('assets/plugin/datatables/media/js/buttons.print.min.js');
        $x .= script_formate('assets/scripts/datatables.demo.min.js');
        $x .= script_formate('assets/scripts/image.js');
        $x .= script_formate('assets/plugin/lightview/js/lightview/lightview.js');
        $x .= script_formate('assets/plugin/validator/validator.min.js');
        $x .= self::extra_script();
        echo $x;
    }
    public static function extra_script()
    {
        $table = "user";
?>
	    <script type="text/javascript" language="javascript" >
	
	
			$(document).ready(function() {
				
				var dataTable = $('#<?=$table
?>').DataTable( {
					"processing": true,
                     "order": [[ 0, "desc" ]],
					"serverSide": true,
					 dom : 'lBfrtip',
        
		"lengthMenu": [ [10, 25, 50, 100,1000,2000,3000,10000, -1], [10, 25, 50, 100,1000,2000,3000,10000] ],
    "pageLength": 10,
					"ajax":{
						url :"<?=TP_BACK
?>resources/ajax_<?=$table
?>.php", // json datasource
						type: "post", // method  , by default get
						data: {           
						action: '<?=$table
?>',      // etc..
						},						
						error: function(){  // error handling
							$(".employee-grid-error").html("");
							$("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#employee-grid_processing").css("display","none");
							
						}
					}
				} );
			} );
		</script>
		<?php
    }
    public function front_script()
    {
?>
	   
<script>
	 $(document).ready(function(){
		 $("#loginst").validate({
			rules: {
				username: {
					required: true,
					digits: true,
					minlength:10,
					maxlength:10
				},
				password: {
				required: true,
				minlength: 6
			},
			},
			
		});
$("#loginte").validate({
			rules: {
				username: {
					required: true,
					digits: true,
					minlength:10,
					maxlength:10
				},
				password: {
				required: true,
				minlength: 6
			},
			},
			
		});
		 // validate the comment form when it is submitted
		// validate signup form on keyup and submit		
		
});

	</script>
<?php
    }
    // Common Database Methods
   

    // replaced with a custom save()
    // public function save() {
    //   // A new record won't have an id yet.
    //   return isset($this->id) ? $this->update() : $this->create();
    // }
   
    protected function empty_imgae($id = 0)
    {
        global $database;
        $sql = ("UPDATE " . self::$table_name . " SET `image`='' WHERE `id`=" . $database->escape_value($id) . "");
        if ($database->query($sql))
        {
            $this->id = $database->insert_id();
            return true;
        }
        else
        {
            return false;
        }
    }
    
   

   
    protected static function action_data($id, $type)
    {
		if ($type == 'edit')
            {
        $data = self::find($id);
			}else
			{
		 $data = self::call_cl_fun();
		 	}
        $image_name = '';
        $temp = '';
        $checkbox = '';
        if (isset($_REQUEST['submit']))
        {
            extract($_POST);
            $data->username = $username;
            $data->full_name = $full_name;
            $data->profession = $profession;
            $data->about = $about;
            $data->facebook = $facebook;
            $data->twitter = $twitter;
            $data->linkedin = $linkedin;
            if ($_FILES['image']['size'] != 0)
            {
                $data->image = $data->image_maker($_FILES['image'], 1, $id, "image");
            }
            elseif (isset($_POST['tpimg_image']))
            {
                $data->image = $_POST['tpimg_image'];
            }
            if ($type == 'edit')
            {
                if (isset($_POST['check_image']))
                {
                    $datas = self::find($id);
                    $image_name = '';

                    unlink($_SERVER['DOCUMENT_ROOT'] . "/" . MYF . $datas->image_path());
                    $user->empty_imgae($id);
                }
                if ($password != '')
                {
                    $xp = new BcryptHasher();
                    $data->password = $xp->make($password, ['rounds' => 4]);
                }
                else
                {
                    $us = User::find($id);
                    $data->password = $us->password;
                }

                $us = User::find($id);
                $data->userlevel = $us->userlevel;
                $data->created = $us->created;
                $data->lastip = $us->lastip;               
                $pp = $data->save();
                $message = '<div align="center"><h4 class="alert alert-success">Success! Record Updated Successfully</h4><span><img src="' . TP_BACK . 'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span>

</div>';
                echo output_message($message);
                redirect_by_js($id, 100);
            }
            else
            {
                $data->userlevel = "admin";
                $xp = new BcryptHasher();
                $data->password = $xp->make($password, ['rounds' => 4]);
                $data->created = date('Y-m-d H:i:s');
                $data->lastip = $_SERVER['REMOTE_ADDR'];
                $pp = $data->save();
                $message = '<div align="center"><h4 class="alert alert-success">Success! New Record Added Successfully</h4><span><img src="' . TP_BACK . 'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span>

</div>';
                echo output_message($message);
                redirect_by_js("add", 1000);
            }
        }

    }
   
    public static function form_data()
    {
        echo $fo = Forms::form_start();

        if ($_GET['action'] == 'add')
        {
            self::action_data('', 'add');
            $username = '';
            $password = '';
            $full_name = '';
            $profession = '';
            $about = '';
            $facebook = '';
            $twitter = '';
            $linkedin = '';
            $impath = '';
            $image = '';
        }
        else
        {
            self::action_data($_GET['id'], 'edit');
            $rw = self::find($_GET['id']);
            $username = $rw->username;
            $full_name = $rw->full_name;
            $profession = $rw->profession;
            $about = $rw->about;
            $facebook = $rw->facebook;
            $twitter = $rw->twitter;
            $linkedin = $rw->linkedin;
            $impath = $rw->image_path();
            $image = $rw->image;
            $password = '';

        }

if($image=='')
{
        echo $fo = Forms::img("Avatar", "image", $impath, $image);
}else
{
	echo $fo=Forms::image_simple_edit("Avatar","image",$impath,$image); 

	}
        echo $fo = Forms::input("Username", "username", $username, 1);
        echo $fo = Forms::password("Password", "password", $password, 0);
        echo $fo = Forms::input("Full Name", "full_name", $full_name, 1);
        echo $fo = Forms::input("Profession", "profession", $profession, 1);
        echo $fo = Forms::textarea("About", "about", $about, "", 0);
        echo $fo = Forms::input("Facebook", "facebook", $facebook, 0);
        echo $fo = Forms::input("Twitter", "twitter", $twitter, 0);
        echo $fo = Forms::input("Linkedin", "linkedin", $linkedin, 0);

        echo $fo = Forms::submit();
        echo $fo = Forms::form_end();
    }

    public static function show($pname, $action)
    {
        echo '<form name="form" action="deleteall.php" method="post">
            <table id="' . $pname . '" class="table table-responsive table-striped table-bordered display" style="width:100%">
              <thead>
               <tr>
                  <th><input type="checkbox" name="checkall"/>Id</th>
					<th >Name</th>
                  <th >Profession</th>
                  <th >Image</th>				 
                  <th >Status</th>
				   <th >Created/Updated</th>
                  <th >Options </th>
                </tr>
              </thead>
              
            </table>
          </form>';
    }
    public static function log_history()
    {
        $dps = '';
        $link = '';
        $maction = 'clear';
        $logfile = SITE_ROOT . DS . 'logs' . DS . 'log.txt';

?>
  
  <!-- /.col-xl-6 col-12 -->
  <div class="card-content">
  <ul class="list-inline text-right">
							<li class="margin-bottom-10 "><a href="<?=TP_BACK_SIDE
?>user/log_history_clear" class="btn btn-primary btn-rounded waves-effect waves-light">Clear History</a></li>
							
						</ul>
 
      <div class="col-md-12">  
     
      <div class="list-group">
	
        <?php
        if (file_exists($logfile) && is_readable($logfile) && $handle = fopen($logfile, 'r'))
        { // read
            echo "<ul class=\"log-entries\">";
            while (!feof($handle))
            {
                $entry = fgets($handle);
                if (trim($entry) != "")
                {
                    echo '<a href="#" class="list-group-item">									
			<p class="list-group-item-text">' . $entry . '</p>
			</a>';
                }
            }
            echo "</ul>";
            fclose($handle);
        }
        else
        {
            echo "Could not read from {$logfile}.";
        }

?>

</div>
      </div>
       </div>

  <?php
    }
    public static function log_history_clear()
    {
        $logfile = SITE_ROOT . DS . 'logs' . DS . 'log.txt';
        file_put_contents($logfile, '');
        // Add the first log entry
        log_action('Logs Cleared', "by User ID : {$_SESSION['user_id']}");
        // redirect to this same page so that the URL won't
        // have "clear=true" anymore
        $message = '<div align="center"><h4 class="alert alert-success">Success! Clear the history</h4><span><img src="' . TP_BACK . 'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span>

</div>';
        echo output_message($message);
        redirect_by_js("log_history", 1000);

    }
}

?>