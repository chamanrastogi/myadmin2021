<?php
require_once('../../includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }?>
<?php include_layout_template('header.php');
$template=Template::find(1);
  if(isset($_GET['sid']))
		  {
			  $s="Edit";
		  }
		  else
			  {
				  $s="Add";}
		  if(isset($_GET['do']))
		  {
			   $s="Show";
			  }
 ?>
<title>
<?=$s?>
Module</title>
<script type="text/javascript">

function validateForm()
{
	var x=document.forms["save_model"]["cname"].value;
if (x==null || x=="")
  {
  alert(" Name is empty");
  document.forms["save_model"]["cname"].focus();
  return false;
  }
  	
	
  }</script>
<?php include("../../includes/upload.php"); ?>
<body>
<div class="header"> <a class="logo" href="index.php"><img src="../img/logo2.png"/></a>
  <ul class="header_menu">
    <li class="list_icon"><a href="#">&nbsp;</a></li>
  </ul>
</div>
<?php include_layout_template('side.php');?>
<div class="content">
  <div class="breadLine">
    <ul class="breadcrumb">
      <li><a href="index.php">
        <?=$template->sitename?>
        </a> <span class="divider">></span></li>
      <li class="active">
        <?=$s?>
        Module</li>
    </ul>
    <?php include_layout_template('top_menu.php');?>
  </div>
  <div class="workplace">
    <?php
$data=new Module();

 if(isset($_REQUEST['submit'])){
	extract($_POST);
	
 $data->name=$title;
 $data->heading=$heading;
 $data->text=$text;
$path=$data->path();
	
	if(isset($_FILES["image"]))
	{
	if(!empty($_FILES['image']['name']))
{
	
	$image=$_FILES["image"];
	$image_name=upload($path,$image); 
	}else
	{
		$image_name=$_POST['tpimg']; 		
		
		}
	}
if(isset($_REQUEST['checkbox']))
	{
		
		$image_name='';
		
		unlink($data->path().$_POST['tpimg']);
		}
		$data->image=$image_name; 
 $data->decription=$textdata;
 $data->status=$status;
 if(isset($_GET['sid']))
 {
  $data->id=$_GET['sid'];
	 $pp=$data->update();
	 $msg="Update Successfully";
	 $ermsg="Duplicate Entry Try Again";
	 		?>
    <script>
		function Redirect()
	  {	
	 
		window.location="module.php?sid=<?=$_GET['sid']?>";
	  }
	  setTimeout('Redirect()', 0);
	</script>
    <?php
 }else{
	  $pp=$data->create();
	  $msg="New Added Successfully";
	 $ermsg="Duplicate Entry Try Again";
	 		?>
    <script>
		function Redirect()
	  {	
		window.location="module.html";
	  }
	  setTimeout('Redirect()', 0);
	</script>
    <?php
	 }

 if($pp)
 {

echo '<div class="alert alert-success">';
echo  "<h4>Success!</h4>";
echo $msg;
echo "</div>";

}
else
{ 
echo '<div class="alert alert-error">';
echo  "<h4>Error!</h4>";
echo $msg;
echo "</div>";
}
}
?>
    <?php
if(isset($_GET['act'])&&$_GET['act']!=''){
  $act=$_GET['act'];
 $mo=new Module(); 
$rc = Module::find_by_id($act);
if($rc->status=='Active')
{ 
$mo->status='Deactive';
$mo->id=$_GET['act'];
$mo->update();

}
else
{
$mo->status='Active';
$mo->id=$_GET['act'];
$mo->update();
}

}
if(isset($_GET['did']) && $_GET['did']!=''){
  $Module = Module::find_by_id($_GET['did']);
  $Module->delete();   
}

	?>
    <script>
function confirmDelete(delUrl) {
  if (confirm("Are you sure you want to delete")) {
   document.location = delUrl;
  }
}
</script>
    
    <div class="row-fluid">
      <div class="span12">
        <?php
		 
          if(isset($_GET['do']))
          {  ?>
        <div class="head clearfix">
          <div class="isw-documents"></div>
          <h1>Show Module</h1>
          <div class="rright" align="right"><a href="module.php"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;">&nbsp;Add Module</strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-list"></i></a></div>
        </div>
        <div class="block-fluid table-sorting clearfix">
          <form name="form" action="deleteall.php" method="post">
            <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
              <thead>
                <tr>
                  <th><input type="checkbox" name="checkall"/>
                    Id</th>
                  <th >Name</th>
                  <th >Heading</th>
                  <th >Image</th>
                  <th >Options </th>
                </tr>
              </thead>
              <tbody>
                <?php 
				
					$row2 = Module::find_all();
					foreach($row2 as $row2) { 
				
?>
                <tr class="item">
                  <td><input type="checkbox" name="checkall[]"  value="<?=$row2->id?>" />
                    <?=$row2->id?></td>
                  <td class="subject"><a href="#">
                    <?=$row2->name?>
                    </a></td>
                  <td class="subject"><a href="#">
                    <?=$row2->heading?>
                    </a></td>
                  <td class="subject"><?php
					   if($row2->image!='')
					   {
						  
						   echo' <a class="fancybox" rel="group" href="'.$row2->path().$row2->image.'">
    <img src="'.$row2->path().$row2->image.'"  class="img-polaroid" width="60" height="60" border="0"></a>';
						   }
                       ?></td>
                  <td class="action"><a href="module.php?sid=<?=$row2->id?>" class="icon-pencil"></a></td>
                </tr>
                <?php  
                  
                   }
										 ?>
              </tbody>
            </table>
          </form>
        </div>
        <?php
            }else{
				  if(isset($_GET['sid']))
		  {
			  	    $sid=$_GET['sid'];
					$rw = Module::find_by_id($sid);
					$title=$rw->name;
					$heading=$rw->heading;
					$text=$rw->text;
 					$textdata=$rw->decription;
					$pagetitle="Edit Module";
		  }else
		  {
		  $title='';
		  $heading='';
		  $text='';
 		  $textdata='';		  
		  $pagetitle="Add Module";   
			  }
			?>
        <div class="head clearfix">
          <div class="isw-documents"></div>
          <h1>
            <?=$pagetitle?>
          </h1>
          <div class="right" align="right"><a href="module.php?do=show"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;">&nbsp;Show Module</strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-list"></i></a></div>
        </div>
        <div class="block-fluid table-sorting clearfix">
          <form enctype="multipart/form-data" id="save_model" method="post" name="save_model" action="#" onSubmit="return validateForm()">
            <div class="block-fluid">
            <div class="row-form clearfix">
              <div class="span3"><strong>Name:</strong></div>
              <div class="span5">
                <input type="text" name="title"  value="<?=$title?>"/>
              </div>
            </div>
            <div class="row-form clearfix">
              <div class="span3"><strong>Heading:</strong></div>
              <div class="span5">
                <input type="text" name="heading"  value="<?=$heading?>"/>
              </div>
            </div>
            <div class="row-form clearfix">
              <div class="span3"><strong>Text:</strong></div>
              <div class="span5">
                <input type="text" name="text"  value="<?=$text?>"/>
              </div>
            </div>
            <div class="row-form clearfix">
              <div class="span3"><strong>Upload Image:</strong></div>
              <div class="span5">
                <div>
                  <?php
				  if(isset($_GET['sid']))
		  {
							 if($rw->image!='')
							 {
								 ?>
                  <div> <a class="fancybox" rel="group" href="<?=$rw->path().$rw->image?>"><img class="img-polaroid" src="<?=$rw->path().$rw->image?>" width="60" height="60" /></a></div>
                  <div><strong>Remove Image:</strong>
                    <input type="checkbox" name="checkbox" id="checkbox" value="1" />
                  </div>
                  
                  <input type="hidden" name="tpimg" value="<?=$rw->image?>" >
                  <?php
							 }}
							 ?>
                </div>
                <input type="file" name="image"/>
              </div>
            </div>
            <div class="row-form clearfix">
              <div class="span3"><strong>Descripction</strong>:</div>
              <div class="span8">
                <div class="block-fluid" >
                  <textarea class="ckeditor" id="editor1"   rows="10" cols="80" name="textdata" style="height: 300px;"><?=$textdata?>
</textarea>
                  <script>

			
CKEDITOR.replace( 'editor1', { 
filebrowserBrowseUrl: '../editor/files/browse.php',
filebrowserUploadUrl: '../editor/files/uploader/upload.php' 

});

CKEDITOR.config.toolbar = [ ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','PasteText', 'PasteFromWord', '-', 'Undo', 'Redo','Find','Replace','-','Outdent','Indent','-','Print'],
   '/',
   ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],['Table','-','Link','Unlink','Flash','Smiley','TextColor','BGColor','Source']
] ;


CKEDITOR.replace( 'editor1', {
        qtRows: 20, // Count of rows
        qtColumns: 20, // Count of columns
        qtBorder: '1', // Border of inserted table
        qtWidth: '90%', // Width of inserted table
        qtStyle: { 'border-collapse' : 'collapse' },
        qtClass: 'test', // Class of table
        qtCellPadding: '0', // Cell padding table
        qtCellSpacing: '0', // Cell spacing table
        qtPreviewBorder: '4px double black', // preview table border 
        qtPreviewSize: '4px', // Preview table cell size 
        qtPreviewBackground: '#c8def4' // preview table background (hover)
    });
	
			CKEDITOR.replace( 'editor1', {
				allowedContent:
					'h1 h2 h3 p blockquote strong em;' +
					'a[!href];' +
					'img(left,right)[!src,alt,width,height];' +
					'table tr th td caption;' +
					'span{!font-family};' +
					'span{!color};' +
					'span(!marker);' +
					'del ins'
			} );
		</script> 
                </div>
              </div>
            </div>
            <div class="row-form clearfix">
              <div class="span3"><strong>Select Status:</strong></div>
              <div class="span4">
                <?php
				if(isset($_GET['sid']))
		  {
                        $acts=$rw->status;
                        if($rw->status=="Active")
							{
						$mm='checked';
						$mm2='Active';
						$act=1;
						}
				       else
						{
						$m1='checked';
						$mm2='Deactive';
						$act=0;
						}
                        ?>
                <select name="status">
                  <option selected="selected" value="<?=$rw->status?>"><?=$mm2?></option>
                  <?php if($mm2=='Deactive')
                         {  
                         echo'<option value="Acitve"> Active</option>';
                         }
                         ?>
                  <?php if($mm2=='Active')
                         {  
                         echo'<option value="1"> Deactive</option>';
                         }
                         ?>
                </select>
                <?php
		  }else
		  {
				?>
                <select name="status">
                <option selected="selected" value="Active"> Active</option>
                <option value="Deactive"> Deactive</option>
                </select>
                <?php
		  }
				?>
              </div>
            </div>
            <div class="row-form clearfix">
              <div class="span3"></div>
              <div class="span1">
                <input name="submit" class="btn btn-block" type="submit" value="Submit">
              </div>
              <div class="span1">
                <input type="reset" class="btn btn-inverse" value="Clear">
              </div>
            </div>
            </div>
          </form>
        </div>
        <?php
			}
			?>
      </div>
    </div>
  </div>
</div>
<?php include_layout_template('footer.php'); ?>
