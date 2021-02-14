<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Hashing\BcryptHasher;
class User extends Model {
	
	protected $table ="users";
	public $timestamps = true; 
	
	
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
		
	// Common Database Methods
	public static function hd_css() {
	$x=stylesheet_formate('assets/plugin/datatables/media/css/dataTables.bootstrap.min.css');
	$x.=stylesheet_formate('assets/plugin/datatables/extensions/Responsive/css/responsive.bootstrap.min.css');
	$x.=stylesheet_formate('assets/plugin/datatables/media/css/buttons.dataTables.min.css');	
	$x.=stylesheet_formate('assets/plugin/touchspin/jquery.bootstrap-touchspin.min.css');
	$x.=stylesheet_formate('assets/plugin/lightview/css/lightview/lightview.css');
	echo $x;
  } public static function hd_script() {
	$x=script_formate('assets/plugin/datatables/media/css/dataTables.bootstrap.min.css'); 
	  $x.=script_formate('assets/plugin/datatables/media/js/jquery.dataTables.min.js');
    $x.=script_formate('assets/plugin/datatables/media/js/dataTables.bootstrap.min.js');
	$x.=script_formate('assets/plugin/datatables/media/js/dataTables.buttons.min.js');
	$x.=script_formate('assets/plugin/datatables/media/js/buttons.flash.min.js');
	$x.=script_formate('assets/plugin/datatables/media/js/jszip.min.js');
	$x.=script_formate('assets/plugin/datatables/media/js/pdfmake.min.js');
	$x.=script_formate('assets/plugin/datatables/media/js/vfs_fonts.js');
	$x.=script_formate('assets/plugin/datatables/media/js/buttons.html5.min.js');
	$x.=script_formate('assets/plugin/datatables/media/js/buttons.print.min.js');
	$x.=script_formate('assets/scripts/datatables.demo.min.js');
	$x.=script_formate('assets/scripts/image.js');
    $x.=script_formate('assets/plugin/lightview/js/lightview/lightview.js');
	$x.=script_formate('assets/plugin/validator/validator.min.js');
	$x.=self::extra_script();
	  echo $x;
  }	
   public static function extra_script() {
	      $table="user";
	   ?>
	    <script type="text/javascript" language="javascript" >
	
	
			$(document).ready(function() {
				
				var dataTable = $('#<?=$table?>').DataTable( {
					"processing": true,
                     "order": [[ 0, "desc" ]],
					"serverSide": true,
					 dom : 'lBfrtip',
        
		"lengthMenu": [ [10, 25, 50, 100,1000,2000,3000,10000, -1], [10, 25, 50, 100,1000,2000,3000,10000] ],
    "pageLength": 10,
					"ajax":{
						url :"<?=TP_BACK?>resources/ajax_<?=$table?>.php", // json datasource
						type: "post", // method  , by default get
						data: {           
						action: '<?=$table?>',      // etc..
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
   public function front_script() {
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
	
}

?>