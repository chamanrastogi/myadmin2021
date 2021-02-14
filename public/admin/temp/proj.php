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
<?=$s?> Project</title>
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
        Project</li>
    </ul>
    <?php include_layout_template('top_menu.php');?>
  </div>
  <div class="workplace">
    <?php
$data=new Project();

 if(isset($_REQUEST['submit'])){
	extract($_POST);
	define ("MAX_SIZE","100"); 	
    $data->cid=$cid;
    $data->name=$title;
	$data->address=$address;
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
	if(isset($_FILES["image2"]))
	{
	if(!empty($_FILES['image2']['name']))
{
	
	$image2=$_FILES["image2"];
	$image_name2=upload($path,$image2); 
	}else
	{
		$image_name2=$_POST['tpimg2']; 		
		
		}
	}
	
	if(isset($_FILES["image3"]))
	{
	if(!empty($_FILES['image3']['name']))
{
	
	$image3=$_FILES["image3"];
	$image_name3=upload($path,$image3); 
	}else
	{
		$image_name3=$_POST['tpimg3']; 		
		
		}
	}
	if(isset($_FILES["image4"]))
	{
	if(!empty($_FILES['image4']['name']))
{
	
	$image4=$_FILES["image4"];
	$image_name4=upload($path,$image4); 
	}else
	{
		$image_name4=$_POST['tpimg4']; 		
		
		}
	}
	$path=$data->path();
    $data->image=$image_name; 
	$data->image2=$image_name2; 
	$data->image3=$image_name3; 
	$data->image4=$image_name4; 
   
    $data->text=$text;
    $data->text2=$text2;
	$data->created=date('Y-m-d H:i:s');
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
	 
		window.location="proj.php?sid=<?=$_GET['sid']?>";
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
		//window.location="proj.php";
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
 $mo=new Project(); 
$rc = Project::find_by_id($act);
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
  $Project = Project::find_by_id($_GET['did']);
  $Project->delete(); 
  ?>
    <script>
		function Redirect()
	  {	
	 
		window.location="proj.php?do=show";
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
          <h1>Show Project</h1>
          <div class="rright" align="right"><a href="proj.php"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;">&nbsp;Add Project</strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-list"></i></a></div>
        </div>
        <div class="block-fluid table-sorting clearfix">
          <form name="form" action="deleteall.php" method="post">
            <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
              <thead>
                <tr>
                  <th><input type="checkbox" name="checkall"/>
                    Id</th>
                  <th >Project Type</th>
                  <th >Name</th>
                  <th >Image</th>                 
                  <th >Options </th>
                </tr>
              </thead>
              <tbody>
                <?php 
				
					$row2 = Project::find_all();
					foreach($row2 as $row2) { 
					$rw3 = Cat::find_by_id($row2->cid);
				
				?>
                <tr class="item">
                  <td><input type="checkbox" name="checkall[]"  value="<?=$row2->id?>" />
                    <?=$row2->id?></td>
                    <td class="subject"><a href="#">
                    <?=$rw3->name?>
                    </a></td>
                  <td class="subject"><a href="#">
                    <?=$row2->name?>
                    </a></td>
                  
                  <td class="subject"><?php
					   if($row2->image!='')
					   {
						  
						   echo' <a class="fancybox" rel="group" href="'.$row2->image_path().'">
    <img src="'.$row2->image_path().'"  class="img-polaroid" width="60" height="60" border="0"></a>';
						   }
                       ?></td>
                       
                  <td class="action"><a href="proj.php?sid=<?=$row2->id?>" class="icon-pencil"></a>
                  <a href="javascript:confirmDelete('proj.php?did=<?=$row2->id?>')" class="isb-delete" ></a></td>
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
					$rw = Project::find_by_id($sid);
					$title=$rw->name;
					$address=$rw->address;				
					$image=$rw->image;
					$text=$rw->text;
					$text2=$rw->text2;
					$rws=Cat::find_by_id($rw->cid);
 					$pagetitle="Edit Project";
		  }else
		  {
		  $title='';
		  $image='';
		  $address='';		 
		  $text='';
		  $text2='';		  
		  $pagetitle="Add Project";   
			  }
			?>
        <div class="head clearfix">
          <div class="isw-documents"></div>
          <h1>
            <?=$pagetitle?>
          </h1>
          <div class="right" align="right"><a href="proj.php?do=show"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;">&nbsp;Show Project</strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-list"></i></a></div>
        </div>
        <div class="block-fluid table-sorting clearfix">
          <form enctype="multipart/form-data" id="save_model" method="post" name="save_model" action="#" onSubmit="return validateForm()">
            <div class="block-fluid">
            <div class="row-form clearfix">
                <div class="span3"><strong> Project Category</strong><span id="m">*</span>:</div>
                <div class="span4">
                  <select id="country" name="cid" required>
                    <?php  
													if(!isset($_GET['sid']))
		  											{
			echo'<option selected="selected" value="0"> Please Select</option>';
		        $cat=Cat::find_all(1,0);
					foreach($cat as $cats)
					{
						if($cats->status=="Active")
						{
							 echo'<option value="'.$cats->id.'">'.ucfirst($cats->name).'</option>';
					}}
							
			}else{
					?>
                    <option selected="selected" value="<?=$rws->id?>"><?=ucfirst($rws->name)?></option>
                    <?php
                         $row1 = Cat::find_all();
					foreach($row1 as $row1) {            
				if($row1->id!=$rws->id)
				{
                         echo '<option value='.$row1->id.'>'.ucfirst($row1->name).'</option>';
				}
						 
				}
			}
                         ?>
                  </select>
                </div>
              </div>
              <div class="row-form clearfix">
                <div class="span3"><strong>Name:</strong></div>
                <div class="span5">
                  <input type="text" name="title"  value="<?=$title?>"/>
                </div>
              </div>
              <div class="row-form clearfix">
                <div class="span3"><strong>Address:</strong></div>
                <div class="span5">
                  <input type="text" name="address"  value="<?=$address?>"/>
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
                    <div> <a class="fancybox" rel="group" href="<?=$rw->image_path()?>"><img class="img-polaroid" src="<?=$rw->image_path()?>" width="60" height="60" /></a></div>
                    
                    <?php
							 }}
							 ?>
                  </div>
                  <input type="file" name="image"/>
                  <input type="hidden" name="tpimg" value="<?=$rw->image?>"/>
                </div>
              </div>
              <div class="row-form clearfix">
                <div class="span3"><strong>Upload Image2:</strong></div>
                <div class="span5">
                  <div>
                    <?php
				  if(isset($_GET['sid']))
		  {
							 if($rw->image2!='')
							 {
								 ?>
                    <div> <a class="fancybox" rel="group" href="<?=$rw->image_path2()?>"><img class="img-polaroid" src="<?=$rw->image_path2()?>" width="60" height="60" /></a></div>
                    
                    <?php
							 }}
							 ?>
                  </div>
                  <input type="file" name="image2"/>
                   <input type="hidden" name="tpimg2" value="<?=$rw->image2?>"/>
                </div>
              </div>
              
              <div class="row-form clearfix">
                <div class="span3"><strong>Upload Image3:</strong></div>
                <div class="span5">
                  <div>
                    <?php
				  if(isset($_GET['sid']))
		  {
							 if($rw->image3!='')
							 {
								 ?>
                    <div> <a class="fancybox" rel="group" href="<?=$rw->image_path3()?>"><img class="img-polaroid" src="<?=$rw->image_path3()?>" width="60" height="60" /></a></div>
                    
                    <?php
							 }}
							 ?>
                  </div>
                  <input type="file" name="image3"/>
                   <input type="hidden" name="tpimg3" value="<?=$rw->image3?>"/>
                </div>
              </div>
              <div class="row-form clearfix">
                <div class="span3"><strong>Upload Image4:</strong></div>
                <div class="span5">
                  <div>
                    <?php
				  if(isset($_GET['sid']))
		  {
							 if($rw->image4!='')
							 {
								 ?>
                    <div> <a class="fancybox" rel="group" href="<?=$rw->image_path4()?>"><img class="img-polaroid" src="<?=$rw->image_path4()?>" width="60" height="60" /></a></div>
                    
                    <?php
							 }}
							 ?>
                  </div>
                  <input type="file" name="image4"/>
                   <input type="hidden" name="tpimg4" value="<?=$rw->image4?>"/>
                </div>
              </div>
              <div class="row-form clearfix">
                <div class="span3"><strong>Small Text:</strong></div>
                <div class="span9">
                  
                   <textarea name="text"><?=$text?></textarea>
                </div>
              </div>
              <div class="row-form clearfix">
                <div class="span3"><strong>Full Text:</strong></div>
                <div class="span9">
                  <textarea class="ckeditor" id="editor1"   rows="10" cols="80"  name="text2"><?=$text2?></textarea>
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
