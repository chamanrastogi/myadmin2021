<?php
require_once('../../includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }?>
<?php include_layout_template('header.php');
$template=Template::find_by_id(1);
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
Slider</title>
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
        Slider</li>
    </ul>
    <?php include_layout_template('top_menu.php');?>
  </div>
  <div class="workplace">
    <?php
$data=new Slider();

 if(isset($_REQUEST['submit'])){
	extract($_POST);
	define ("MAX_SIZE","100"); 
//This function reads the extension of the file. It is used to determine if the file is an image by checking the extension. 
function getExtension($str) {
$i = strrpos($str,".");
if (!$i) { return ""; }
$l = strlen($str) - $i;
$ext = substr($str,$i+1,$l);
return $ext;
}
//This variable is used as a flag. The value is initialized with 0 (meaning no error found) and it will be changed to 1 if an errro occures. If the error occures the file will not be uploaded.
$errors=0;
//checks if the form has been submitted

//reads the name of the file the user submitted for uploading
if(!empty($_FILES['image']['name']))
{
if(isset($_POST['tpimg']))
	{
	if($_POST['tpimg']!='' )
	{
	unlink($data->path().$_POST['tpimg']);
	}}}
$image=$_FILES['image']['name'];
$name = explode(".", $image);
//if it is not empty
if ($image) 
{
//get the original name of the file from the clients machine
$filename = stripslashes($_FILES['image']['name']);
//get the extension of the file in a lower case format
$extension = getExtension($filename);
$extension = strtolower($extension);
//if it is not a known extension, we will suppose it is an error and will not upload the file, otherwize we will do more tests
if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif"))	
{
//print error message
echo '<h1>Unknown extension!</h1>';
$errors=1;
}
else
{
//get the size of the image in bytes
//$_FILES['image']['tmp_name'] is the temporary filename of the file in which the uploaded file was stored on the server
$size=filesize($_FILES['image']['tmp_name']);

//compare the size with the maxim size we defined and print error if bigger
if ($size > MAX_SIZE*51200)
{
$errors=1;
}
//we will give an unique name, for example the time in unix time format
 $nns=rand(5, 8522166);
 $image_name=$name[0].'-'.$nns.'.'.$extension;
//the new name will be containing the full path where will be stored (images folder)
 $image_name=str_replace(' ', '-',$image_name);
 $newname=$data->path().$image_name;
//we verify if the image has been uploaded, and print error instead
$copied = copy($_FILES['image']['tmp_name'], $newname);
if (!$copied) 
{

$errors=1;
}
}
}
if(empty($_FILES['image']['name']))
{
	$image_name='';
	if(isset($_POST['tpimg']))
	{
	$image_name=$_POST['tpimg'];
	}
	}
	
		
	if(isset($_REQUEST['checkbox']))
	{
		
		$image_name='';
			
		unlink($data->path().$_POST['tpimg']);
		}	

 $data->name=$title;
  
 $data->image=$image_name;
$cost=Slider::count_all();

 $data->sort=$cost;
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
	 
		window.location="slider.php?sid=<?=$_GET['sid']?>";
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
		window.location="slider.html";
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
 $mo=new Slider(); 
$rc = Slider::find_by_id($act);
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
  $Slider = Slider::find_by_id($_GET['did']);
  $Slider->delete(); 
  ?>
    <script>
		function Redirect()
	  {	
	 
		window.location="sider.php?do=show";
	  }
	  setTimeout('Redirect()', 0);
	</script>
    <?php  
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
          <h1>Show Slider</h1>
          <div class="right" align="right"><a href="slider.php"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;">&nbsp;Add Slider</strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-list"></i></a></div>
        </div>
        <div class="block-fluid table-sorting clearfix">
          <form name="form" action="deleteall.php" method="post">
            <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
              <thead>
                <tr>
                  <th><input type="checkbox" name="checkall"/>
                    Id</th>
                
                  <th >Name</th>  
                   <th >Text</th>                   
                  <th >Image</th>
                  <th >Options </th>
                </tr>
              </thead>
              <tbody>
                <?php 
				
					$rowd = Slider::find_all();
					foreach($rowd as $row2) { 

?>
                <tr class="item">
                  <td><input type="checkbox" name="checkall[]"  value="<?=$row2->id?>" />
                    <?=$row2->id?></td>
                   
                  <td class="subject"><a href="#">
                    <?=$row2->name?>
                    </a></td>
                   <td class="subject"><a href="#">
                    <?=$row2->text?>
                    </a></td>
                  <td class="subject"><?php
					   if($row2->image!='')
					   {
						  
						   echo' <a class="fancybox" rel="group" href="../../public/editor/files/Uploads/sliderimage/'.$row2->image.'">
    <img src="../../public/editor/files/Uploads/sliderimage/'.$row2->image.'"  class="img-polaroid" width="60" height="60" border="0"></a>';
						   }
                       ?></td>
                  <td class="action"><a href="slider.php?sid=<?=$row2->id?>" class="icon-pencil"></a> <a href="javascript:confirmDelete('slider.php?did=<?=$row2->id?>')" class="isb-delete" ></a></td>
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
					$rw = Slider::find_by_id($sid);
					$title=$rw->name;
					
 					
					$pagetitle="Edit Slider";
		  }else
		  {
		  $title='';
		 
		 
 		   
		  $pagetitle="Add Slider";   
			  }
			?>
        <div class="head clearfix">
          <div class="isw-documents"></div>
          <h1>
            <?=$pagetitle?>
          </h1>
          <div class="right" align="right"><a href="slider.php?do=show"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;">&nbsp;Show Slider</strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-list"></i></a></div>
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
                <div class="span3"><strong>Upload Image:</strong></div>
                <div class="span5">
                  <div>
                    <?php
				  if(isset($_GET['sid']))
		  {
							 if($rw->image!='')
							 {
								 ?>
                    <div> <a class="fancybox" rel="group" href="../../public/editor/files/Uploads/sliderimage/<?=$rw->image?>"><img class="img-polaroid" src="../../public/editor/files/Uploads/sliderimage/<?=$rw->image?>" width="60" height="60" /></a></div>
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
                    <option selected="selected" value="<?=$rw->status?>">
                    <?=$mm2?>
                    </option>
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
