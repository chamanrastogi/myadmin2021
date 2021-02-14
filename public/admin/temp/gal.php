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
Gallery</title>

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
        Gal</li>
    </ul>
    <?php include_layout_template('top_menu.php');?>
  </div>
  <div class="workplace">
    <?php
$data=new Gal();
$image_name='';
 if(isset($_REQUEST['submit'])){
	extract($_POST);
	 $data->name=$title;
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
	 
		//window.location="gal.html?sid=<?=$_GET['sid']?>";
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
	//window.location="gal.html";
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
 $mo=new Gal(); 
$rc = Gal::find_by_id($act);
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
  $Gal = Gal::find_by_id($_GET['did']);
  $Gal->delete();   
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
          <h1>Show Gallery</h1>
          <div class="rright" align="right"><a href="gal.html"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;">&nbsp;Add Gallery</strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-list"></i></a></div>
        </div>
        <div class="block-fluid table-sorting clearfix">
          <form name="form" action="deleteall.php" method="post">
            <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
              <thead>
                <tr>
                  <th><input type="checkbox" name="checkall"/>
                    Id</th>
                  <th >Name</th>
                  <th ></th>
                  <th >Image</th>
                  <th >Options </th>
                </tr>
              </thead>
              <tbody>
                <?php 
				
					$row2 = Gal::find_all();
					foreach($row2 as $row2) { 
				
?>
                <tr class="item">
                  <td><input type="checkbox" name="checkall[]"  value="<?=$row2->id?>" />
                    <?=$row2->id?></td>
                  <td class="subject"><a href="#">
                    <?=$row2->name?>
                    </a></td>
                  <td class="subject"><a href="#">
                  
                    </a></td>
                  <td class="subject"><?php
					   if($row2->image!='')
					   {
						  
						   echo' <a class="fancybox" rel="group" href="'.$row2->path().$row2->image.'">
    <img src="'.$row2->path().$row2->image.'"  class="img-polaroid" width="60" height="60" border="0"></a>';
						   }
                       ?></td>
                  <td class="action"><a href="gal.html?sid=<?=$row2->id?>" class="icon-pencil"></a>
                  <a href="javascript:confirmDelete('gal.html?did=<?=$row2->id?>')" class="isb-delete" ></a></td>
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
					$rw = Gal::find_by_id($sid);
					$title=$rw->name;
					
					$pagetitle="Edit Gallery";
		  }else
		  {
		  $title='';
		 	  
		  $pagetitle="Add Gallery";   
			  }
			?>
        <div class="head clearfix">
          <div class="isw-documents"></div>
          <h1>
            <?=$pagetitle?>
          </h1>
          <div class="right" align="right"><a href="gal.html?do=show"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;">&nbsp;Show Gallery</strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-list"></i></a></div>
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
                  <div> <a class="fancybox" rel="group" href="<?=$row2->path().$row2->image?>"><img class="img-polaroid" src="<?=$row2->path().$row2->image?>" width="60" height="60" /></a></div>
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
