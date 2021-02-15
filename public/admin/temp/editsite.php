<?php
require_once('../../includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>

<?php include_layout_template('header.php');
$temp=Template::find(1);
 ?>
 
<title>Edit Setting</title>
<body>
    
    <div class="header"><a class="logo" href="index.php"><img src="../img/logo2.png"/><b style="color:white;font-size:14px;font-weight:bold;">Admin Panel</b></a>
        <ul class="header_menu">
            <li class="list_icon"><a href="#">&nbsp;</a></li>
        </ul>    
    </div>
    
    <?php include_layout_template('side.php');?>
        
    
    <div class="content">
    
        
        
        <div class="breadLine"> <ul class="breadcrumb">
      <li><a href="index.php"><?=$temp->sitename?></a> <span class="divider">></span></li>                
                <li class="active">Site Settings</li> </ul> <?php include_layout_template('top_menu.php');?>
            
        </div>
        
        <div class="workplace">
       
<?PHP
$data=new Template();
$rest='-';
	$image_name='';
  	$image_name1='';
 if(isset($_REQUEST['submit'])){

 	define ("MAX_SIZE","100"); 
extract($_POST);
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
if($_FILES['image']['name']!='')
{
unlink("../../assets/img/".$tpimg);
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
if ($size > MAX_SIZE*5120)
{

$errors=1;
}

//we will give an unique name, for example the time in unix time format
$image_name=$name[0].'.'.$extension;
//the new name will be containing the full path where will be stored (images folder)
$image_name=str_replace(' ', '_',$image_name);
$image_name=str_replace("'", '_',$image_name);
$image_name=str_replace('"', '_',$image_name);
$image_name=str_replace('/', '_',$image_name);
 $newname="../../assets/img/".$image_name;
//we verify if the image has been uploaded, and print error instead
$copied = copy($_FILES['image']['tmp_name'], $newname);
 chmod($newname, 0777); 
if (!$copied) 
{

$errors=1;
}}}
}
else
{
	$image_name=$tpimg;
	}
	if($_FILES['image1']['name']!='')
{
unlink("../../assets/img/".$tpimg1);
$image1=$_FILES['image1']['name'];
$name = explode(".", $image1);
//if it is not empty
if ($image1) 
{
//get the original name of the file from the clients machine
$filename = stripslashes($_FILES['image1']['name']);
//get the extension of the file in a lower case format
$extension = getExtension($filename);
$extension = strtolower($extension);
//if it is not a known extension, we will suppose it is an error and will not upload the file, otherwize we will do more tests
if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "ico"))	
{
//print error message
echo '<h1>Unknown extension!</h1>';
$errors=1;
}
else
{
//get the size of the image in bytes
//$_FILES['image1']['tmp_name'] is the temporary filename of the file in which the uploaded file was stored on the server
$size=filesize($_FILES['image1']['tmp_name']);

//compare the size with the maxim size we defined and print error if bigger
if ($size > MAX_SIZE*5120)
{

$errors=1;
}

//we will give an unique name, for example the time in unix time format
$image_name1=$name[0].'.'.$extension;
//the new name will be containing the full path where will be stored (images folder)
$image_name1=str_replace(' ', '_',$image_name1);
$image_name1=str_replace("'", '_',$image_name1);
$image_name1=str_replace('"', '_',$image_name1);
$image_name1=str_replace('/', '_',$image_name1);
 $newname1="../../assets/img/".$image_name1;
//we verify if the image has been uploaded, and print error instead
$copied = copy($_FILES['image1']['tmp_name'], $newname1);
 chmod($newname1, 0777); 
if (!$copied) 
{

$errors=1;
}}}
}
else
{
	$image_name1=$tpimg1;
	}
	
	
	  
 
 $data->sitename=$sitename;
 
 $data->box=$box;
 $data->pattern=$background;
 $data->theme=$theme;
 $data->logotittle=$logotittle;
 $data->favicon=$image_name1;
 
 $data->email=$email;

 
 $data->keyword=$keyword;
 $data->description=$description;
 $data->logo=$image_name;
 
 
 $data->id=1;
 $pp=$data->update();
if($pp)
{

echo "
 <div class='alert alert-success'>                
               
               <h4>New Added Successfully</h4>
            </div> 
        ";
}
else
{
echo " <div class='alert alert-block'>                
               
               <h4>Error in Adding Entry</h4>
            </div>";
}
}
?>
          
        <div class="row-fluid">
                
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>Site Settings</h1>
                    </div>
                     <form enctype="multipart/form-data" id="save_model" method="post" name="save_model" action="#" onSubmit="return validateForm()">
                     	<?php
			 $rw = Template::find(1);
		  $rws = Background::find_by_id($rw->pattern);
		   $rwth = Theme::find_by_id($rw->theme);
		                  ?>
                    <div class="block-fluid"> 
                                           
                        <div class="row-form clearfix">
                            <div class="span3"><strong>Favicon Icon:</strong></div>
                            <div class="span5"><a href="#"><img src="../../assets/img/<?=$rw->favicon?>" /></a>
                          <input type="file" name="image1" id="image1"/><input type="hidden" name="tpimg1" value="<?=$rw->favicon?>" ></div>
                        </div>
                        <div class="row-form clearfix">
              <div class="span3"><strong>Select Box/full:</strong></div>
              <div class="span4">
                <?php
               if($rw->box==1)
			   {
				   $go="Box";
				   }else{
					   $go="Full";}
			   
			   ?>
                <select name="box">
                  <option selected="selected" value="<?=$rw->box?>">
                  <?=$go?>
                  </option>
                  <?php if($rw->box==1)
                         {  
                         echo'<option value="0">Full</option>';
                         }                       
				  	else
                         {  
                         echo'<option value="1">Box</option>';
                         }
                         ?>
                </select>
              </div>
            </div>
           				<div class="row-form clearfix">
              <div class="span3"><strong>Background:</strong></div>
              <div class="span4">
                <select name="background">
                  <option selected="selected" value="<?=$rw->id?>">
                  <?=$rws->name?>
                  </option>
                  <?php 
				  $rdd=Background::find_all();
				  foreach($rdd as $rds)
				  {
				  if($rds->image!=$rw->bg)
                         {  
                         echo'<option value="'.$rds->id.'">'.$rds->name.'</option>';
                         }                       
				  }
                         ?>
                </select>
              </div>
            </div>
           				 <div class="row-form clearfix">
              <div class="span3"><strong>Theme:</strong></div>
              <div class="span4">
                <select name="theme">
                  <option selected="selected" value="<?=$rwth->id?>">
                  <?=ucfirst($rwth->name)?>
                  </option>
                  <?php 
				  $rdd=Theme::find_all();
				  foreach($rdd as $rds)
				  {
				  if($rwth->id!=$rds->id)
                         {  
                         echo'<option value="'.$rds->id.'">'.ucfirst($rds->name).'</option>';
                         }                       
				  }
                         ?>
                </select>
              </div>
            </div>
                        <div class="row-form clearfix">
                            <div class="span3"><strong>Site Name:</strong></div>
                            <div class="span5"><input type="text" name="sitename"  value="<?=$rw->sitename?>"/></div>
                        </div>
                          <div class="row-form clearfix">
                            <div class="span3"><strong>Logo Title:</strong></div>
                            <div class="span5"><input type="text" name="logotittle"  value="<?=$rw->logotittle?>"/></div>
                        </div> 
                       
                        
                        <div class="row-form clearfix">
                            <div class="span3"><strong>Email:</strong></div>
                            <div class="span5">
                              <input name="email" type="text" value="<?=$rw->email?>">
                            </div>
                        </div> 
                        <div class="row-form clearfix">
                            <div class="span3"><strong>Meta Tag:</strong></div>
                            <div class="span5"><textarea  name="description"  ><?=$rw->description?></textarea></div>
                        </div> 

                           <div class="row-form clearfix">
                            <div class="span3"><strong>Keywords:</strong></div>
                            <div class="span5"><textarea  name="keyword"  /><?=$rw->keyword?></textarea></div>
                        </div>                                              
                         
                        
                         <div class="row-form clearfix">
                            <div class="span3"><strong>Logo Image:</strong></div>
                            <div class="span5"><a href="#"><img src="../../assets/img/<?=$rw->logo?>" width="60" height="60" /></a>
                           <input type="file" name="image"/><input type="hidden" name="tpimg" value="<?=$rw->logo?>" >
                           </div>
                        </div>
                          <div class="row-form clearfix">
                            <div class="span3"><input name="submit" type="submit" class="btn btn-small"></div>
                           
                       
                        </div>
                        
                    </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>   
    </div>
  <?php include_layout_template('footer.php'); ?>
