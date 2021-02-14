<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Template extends Model {
	
	protected $table ="template";
	public $timestamps = false; 	
	

	public static function hd_css() {
	$x=stylesheet_formate('assets/plugin/datatables/media/css/dataTables.bootstrap.min.css');
	$x.=stylesheet_formate('assets/plugin/datatables/extensions/Responsive/css/responsive.bootstrap.min.css');
	$x.=stylesheet_formate('assets/styles/jquery-ui.css');
	$x.=stylesheet_formate('elfinder/css/elfinder.min.css');
	$x.=stylesheet_formate('elfinder/css/theme.css');
	$x.=stylesheet_formate('assets/plugin/lightview/css/lightview/lightview.css');
	
		
		
	echo $x;
  } public static function hd_script() {
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
	
}

?>