<?php
require_once('../../includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }?>
<?php include_layout_template('header.php');
$template=Template::find_by_id(1);
 ?>
 <title>Edit Social</title>
 <style>
 #m{
	 color:red;
	 font-size:14px;}
 </style>
   
<body>
    
    <div class="header"><a class="logo" href="index.php"><img src="../img/logo2.png"/><b style="color:white;font-size:14px;font-weight:bold;">Admin Panel</b></a>
        <ul class="header_menu">
            <li class="list_icon"><a href="#">&nbsp;</a></li>
        </ul>    
    </div>
    
    <?php include_layout_template('side.php');?>
        
    
    <div class="content">
    
        
        
        <div class="breadLine"> <ul class="breadcrumb">
      <li><a href="index.php"><?=$template->sitename?></a> <span class="divider">></span></li>              
                <li class="active"><?php $pagename;?></li>
            </ul>
                        
            <?php include_layout_template('top_menu.php');?>
            
        </div>

        
        <div class="workplace">
       <?PHP
$data=new Social();
  $id=$_GET['id'];
  
 if(isset($_REQUEST['submit'])){
 	extract($_POST);
 $data->title=$title;
 $data->url=$url;
 $data->class=$class;
 $data->status=$status;
  
 $data->id=$id;
 $pp=$data->update();
if($pp)
{
echo '<div class="alert alert-success">';
echo  "<h4>Success!</h4>";
echo "Entry Edit Successfully";
echo "</div>";
?>
<script>
<!--
function Redirect()
{
	
    window.location="editsocial.php?id=<?=$_GET['id']?>";
	
}

setTimeout('Redirect()', 1000);
</script>
<?php
}
else
{ 
echo '<div class="alert alert-error">';
echo  "<h4>Error!</h4>";
echo "Error in Editing Entry.";
echo "</div>";
}
}
?>
   <script type="text/javascript">

function validateForm()
{
	var x=document.forms["menuCreater"]["title"].value;
if (x==null || x=="")
  {
  alert("Page Title Name is empty");
  document.forms["menuCreater"]["title"].focus();
  return false;
  }
  var y=document.forms["menuCreater"]["url"].value;
if (y==null || y=="")
  {
  alert("Latitude is empty");
  document.forms["menuCreater"]["url"].focus();
  return false;
  }
	
  }
</script>
          
        <div class="row-fluid">
                
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>Edit Social</h1><div class="right" align="right"><a href="showsocial.php"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;">&nbsp;Show Social</strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-plus"></i></a></div>
                    </div>
                    <div class="block-fluid">                        
                        <form action="#" method="post" name="menuCreater" onSubmit="return validateForm()">
                        <input type="hidden" name="menucreater" value="Yes">
                        <?php
			$id=$_GET['id'];
			$rw = Social::find_by_id($id);
		
			?>
                        <div class="row-form clearfix">
                            <div class="span3"><strong>Title:</strong></div>
                            <div class="span4"><input type="text" value="<?=$rw->title?>" placeholder="Social Network Name" name="title" id="title"/></div>
                        </div>
  <div class="row-form clearfix">
                            <div class="span3"><strong>Class:</strong></div>
                            <div class="span4"><input type="text" value="<?=$rw->class?>" placeholder="Social Network Name" name="title" id="title"/></div>
                        </div>						
                        <div class="row-form clearfix">
                            <div class="span3"><strong>Url</strong></div>
                            <div class="span4"><input type="text" value="<?=$rw->url?>" placeholder="url" name="url"/>
                            <input type="hidden" value="<?=$rw->class?>" name="class"/>
                            </div>
                        </div>      
                        <div class="row-form clearfix">
                            <div class="span3"><strong>Select Status:</strong></div>
                            <div class="span4">
                                <?php
                         $acts=$rw->status;
                   ?>
                                <select name="status">
                         <option selected="selected" value="<?=$rw->status?>"> <?=$acts?> </option> 
                         <?php if($acts=='Deactive')
                         {  
                         echo'<option value="Active"> Active</option>';
                         }
                         ?>
                         <?php if($acts=='Active')
                         {  
                         echo'<option value="Deactive"> Deactive</option>';
                         }
                         ?>    
                                </select>
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
                </div>
                
            </div>
        </div>
    </div>   
    </div>
  <?php include_layout_template('footer.php'); ?>
