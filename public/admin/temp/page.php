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
<title><?=$s?> Page</title>
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
      <li class="active"><?=$s?> Page</li>
    </ul>
    <?php include_layout_template('top_menu.php');?>
  </div>
  <div class="workplace">
     <?PHP
$data=new Cmsdata();

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
	
	if(isset($_POST['mid']))
	{
		$mid=$_POST['mid'];
	}
	else
	{
		$mid='';
		}	
	if(isset($_REQUEST['checkbox']))
	{
		
		$image_name='';
		 $data->imgwidth=0;
     $data->imgheight=0;
	
		unlink($data->path().$_POST['tpimg']);
		}	
		$imgwidth='';
		$imgheight='';
		if(isset($_POST['tpimg']))
		{
		if($_POST['tpimg']!='' && $image_name!='')
		{
			echo $imgwidth;
	$data->imgwidth=$imgwidth;
     $data->imgheight=$imgwidth;
		
		}
		}
 $data->mid=$cat;
 $data->title=$title;
 $data->heading=$heading;
 $data->keyword='';
 $data->description='';
 $data->image=$image_name;
 $data->text=$textdata;
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
	 
		window.location="page.php?sid=<?=$_GET['sid']?>";
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
	 
		window.location="page.php";
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
if(isset($_GET['did']) && $_GET['did']!=''){
  $Cmsdata = Cmsdata::find_by_id($_GET['did']);
  $Cmsdata->delete();   
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
          <h1>Show Page</h1>
          <div class="rright" align="right"><a href="page.php"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;">&nbsp;Add Page</strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-list"></i></a></div>
        </div>
        <div class="block-fluid table-sorting clearfix">
          <form name="form" action="deleteall.php" method="post">
                        <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="checkall"/>Id</th>
                                  
                                   
                         <th >Name</th>
                          <th >Menu Name</th>
                           <th >Image</th>
                        <th >Options </th>                                   
                                </tr>
                            </thead>
                            <tbody>
                               <?php 
				 $datas = Cmsdata::find_all();
					foreach($datas as $data) {
						$ids=$data->mid;
					$mm = Menus::find_by_id($ids);
					
?>               
                    <tr >
                    
                        <td width="100px;"   ><input  type="checkbox" name="checkall[]"  value="<?=$data->id?>" /><?=$data->id?></td>
                        
                        <td width="15%" ><?=$data->title?></td>
                           <td width="15%" ><?=$mm->title?></td>
                        
                       <td width="25%"><?php
					   if($data->image!='')
					   {
						  
						   echo' <a class="fancybox" rel="group" href="../../public/editor/files/Uploads/pageimg/'.$data->image.'">
    <img src="../../public/editor/files/Uploads/pageimg/'.$data->image.'"  class="img-polaroid" width="60" height="60" border="0"></a>';
						   }
                       ?></td>
               
                        <td>
                        
                        <a href="page.php?sid=<?=$data->id?>" class="button-a gray"><i class="icon-pencil"></i></a>  
                        <a href="javascript:confirmDelete('page.php?did=<?=$data->id?>')" class="isb-delete" ></a>
                     </td>
                        
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
					$rw = Cmsdata::find_by_id($sid);
					$id=$rw->mid;
   					$rw3 = Menus::find_by_id($id);
					$title=$rw->title;
					$heading=$rw->heading;
					$headlink=$rw->headlink;  
 					$key=$rw->keyword;
					$dis=$rw->description;  
					$textdata=$rw->text;
					$pagetitle="Edit Page";
		  }else
		  {
			  $title='';
		  $heading='';
		  $headlink='';  
 		  $key='';
		  $dis='';  
		  $textdata='';		  
		 $pagetitle="Add Page";  
			  }
			?>
        <div class="head clearfix">
          <div class="isw-documents"></div>
          <h1>
            <?=$pagetitle?>
          </h1>
          <div class="rright" align="right"><a href="cat.php?do=show"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;">&nbsp;Show Page</strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-list"></i></a></div>
        </div>
        <div class="block-fluid table-sorting clearfix">
        <form enctype="multipart/form-data" id="save_model" method="post" name="save_model" action="#" onSubmit="return validateForm()">
            
            <div class="row-form clearfix">
              <div class="span3"><strong> Menu</strong><span id="m">*</span>:</div>
              <div class="span4">
                <select id="country" name="cat" required>
                   
                                                	<?php  
													if(!isset($_GET['sid']))
		  											{
			echo'<option selected="selected" value="0"> Please Select</option>';
		$Menus=Menus::find_by_group_par(1,0);
					foreach($Menus as $menus)
					{			
					        $m=Menus::find_by_parent_id($menus->id);
							$m1=Cmsdata::find_by_mid_count($menus->id);
							$menu_name=str_replace(' ', '-',$menus->title);
							if($m1!=0 && $menus->url=='')
							{
							$link=$menus->id;
							}
								
							if($m1==0 && $menus->url=='')
							{echo'<option value="'.$link.'">'.ucfirst($menus->title).'</option>';
						    }
							
							if($m!=0)
							{
							
							$sub=Menus::find_by_group_par(1,$menus->id);
							foreach($sub as $ro)
							{	
							$m2=Menus::find_by_parent_id($ro->id);
							$rp1=Cmsdata::find_by_mid_count($ro->id);
							$menu_name2=str_replace(' ', '-',$ro->title);
														
							if($rp1!=0 && $ro->url=='')
							{
							$link=$menu_name2;
							}
							elseif($ro->url!='')
						    {$link=$ro->url;
						    }
							
							if($rp1==0 AND $ro->url=='')
						    {echo'<option value="'.$link.'">&nbsp;&nbsp;&nbsp;&nbsp;|-'.ucfirst($ro->title).'</option>';
						    }
							
						
						if($m2!=0)
							{
							
							$sub1=Menus::find_by_group_par(1,$ro->id);
						foreach($sub1 as $ro1)
					{	
							$m3=Menus::find_by_parent_id($ro1->id);
							$rp2=Cmsdata::find_by_mid_count($ro1->id);
							$menu_name3=str_replace(' ', '-',$ro1->title);							
							if($rp2!=0 && $ro1->url=='')
							{
							$link=$menu_name3;
							}
							elseif($ro1->url!='')
						    {$link=$ro1->url;
						    }
							
							if($rp2==0 && $ro1->url=='')
							{echo'<option value="'.$link.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|-|-'.ucfirst($ros->title).'</option>';
						    }
							
						
						if($m3!=0)
						
							{
							
							$sub2=Menus::find_by_group_par(1,$ro1->id);
						foreach($sub2 as $ro2)
					{	
							$m3=Menus::find_by_parent_id($ro2->id);
							$rp3=Cmsdata::find_by_mid_count($ro2->id);
							$menu_name4=str_replace(' ', '-',$ro2->title);									
							if($rp3!=0 && $ro2->url=='')
							{
							$link=$menu_name4;
							}
							elseif($ro2->url!='')
						    {$link=$ro2->url;
						    }
							
							if($rp3==0 && $ro2->url=='')
							{echo'<option value="'.$link.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|-|-|-'.ucfirst($rop->title).'</option>';
						    }}}}}}}}
			}else{
					?>
                      <option selected="selected" value="<?=$rw3->id?>"><?=$rw3->title?></option>
                      <?php
                         $row1 = Menus::find_all();
					foreach($row1 as $row1) {            
				if($rw3->title!=$row1->title)
				{            
				if($row1->parent_id!=0)
				{
					$m1="--";
				}
				else
				{
					$m1="";
				}
                         echo '<option value='.$row1->id.'>'.$m1.''.$row1->title.'</option>';
						 
				}
					 }}
                         ?>	
                                                        </select>
              </div>
            </div>
            <div class="row-form clearfix">
              <div class="span3"><strong>Title</strong><span id="m">*</span>:</div>
              <div class="span4">
                <input type="text" id="name" name="title"  class="medium" value="<?=$title?>">
                <br>
                <br>
              </div>
            </div>
            <div class="row-form clearfix">
              <div class="span3"><strong>Heading</strong>:</div>
              <div class="span4">
                <input type="text" id="name" name="heading" value="<?=$heading?>"  class="medium">
                <br>
                <br>
              </div>
            </div>
       
            <div class="row-form clearfix">
              <div class="span3"><strong>Upload Image:</strong></div>
              <div class="span5">
                <div>
                  <?php
				  if(isset($_GET['sid']))
		  {
							 if($rw->image!='' )
							 {
								
								 ?>
                  <div> <a class="fancybox" rel="group" href="../../public/editor/files/Uploads/pageimg/<?=$rw->image?>"><img class="img-polaroid" src="../../public/editor/files/Uploads/pageimg/<?=$rw->image?>" width="60" height="60" /></a></div>
                  <div><strong>Remove Image:</strong>
                    <input type="checkbox" name="checkbox" id="checkbox" value="1" />
                  </div>
                  <?php
							
                             $data = getimagesize("../../public/editor/files/Uploads/pageimg/".$rw->image."");
						
							if($rw->imgwidth=='')
							{
								$width=$data[0];
							}else
							{
								$width=$rw->imgwidth;
								}
							
							if($rw->imgheight=='')
							{
								$height=$data[1];
							}
							else
							{
								$height=$rw->imgheight;
								}
							
                            ?>
                  <div><strong>Image Width:</strong>
                    <input type="text" id="name" name="imgwidth" value="<?=$width?>"  class="medium">
                  </div>
                  <div><strong>Image Height:</strong>
                    <input type="text" id="name" name="imgheight" value="<?=$height?>"  class="medium">
                  </div>
                   <input type="hidden" name="tpimg" value="<?=$rw->image?>" >
                  <?php
							 }
		  }
							 ?>
                </div>
                <input type="file" name="image"/>
               
              </div>
            </div>
            <div class="row-form clearfix">
              <div class="span3"><strong>Descripction</strong>:</div>
              <div class="span8">
                <div class="block-fluid" id="wysiwyg_container">
                 <textarea cols="80" id="editor1" name="textdata" rows="10"><?=$textdata?></textarea>

<script>

			
CKEDITOR.replace( 'editor1', { 
filebrowserBrowseUrl: '../editor/files/browse.php',
filebrowserUploadUrl: '../editor/files/uploader/upload.php' 

});
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
              <div class="span3"></div>
              <div class="span1">
                <input name="submit" class="btn btn-block" type="submit" value="Submit">
              </div>
              <div class="span1">
                <input type="reset" class="btn btn-inverse" value="Clear">
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
