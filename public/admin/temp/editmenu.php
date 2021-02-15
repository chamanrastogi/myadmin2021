<?php
require_once('../../includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }?>

<?php include_layout_template('header.php');
$template=Template::find(1);
 ?>
    
<body>
    
    <div class="header"><a class="logo" href="index.php"><img src="../img/logo2.png"/><b style="color:white;font-size:14px;font-weight:bold;">Admin Panel</b></a>
        <ul class="header_menu">
            <li class="list_icon"><a href="#">&nbsp;</a></li>
        </ul>    
    </div>
    
    <?php include_layout_template('side.php');?>
        
    
    <div class="content">
    
        
        
        <div class="breadLine"> <ul class="breadcrumb">
      <li><a href="index.php"><?=$template->sitename?></a><span class="divider">></span></li>            
                <li class="active">Edit Menu</li> </ul> <?php include_layout_template('top_menu.php');?>
            
        </div>

        
        <div class="workplace">
        <?PHP
 $data=new Menus();
$id=$_GET['id'];

 if(isset($_REQUEST['submit'])){
 extract($_POST);
$name=$title;
	$data->title=$name;	
	$data->url=$url;
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
	
    window.location="editmenu.php?id=<?=$_GET['id']?>";
	
}

setTimeout('Redirect()', 1000);
</script>
<?php
}
else
{ 
echo '<div class="alert alert-info">';
echo  "<h4>Error!</h4>";
echo "Error in Editing Entry.. Or NO";
echo "</div>";
}
}
?>
  <script type="text/javascript">

function validateForm()
{
	var x=document.forms["save_model"]["title"].value;
if (x==null || x=="")
  {
  alert("Mneu Name is empty");
  document.forms["save_model"]["title"].focus();
  return false;
  }
	
  }
</script>
          
        <div class="row-fluid">
                
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>Edit Menu</h1>
                    </div>
                    <div class="block-fluid">                        
                        <form action="" method="post" name="save_model" onSubmit="return validateForm()">
                        	<?php
			$rw= Menus::find_by_id($_GET['id']);
			
			?>
                        <div class="row-form clearfix">
                            <div class="span3"><strong>Menu Name:</strong></div>
                            <div class="span4"><input type="text" value="<?=$rw->title?>" placeholder="Menu Name" name="title"/></div>
                        </div> 
                            <div class="row-form clearfix">
                            <div class="span3"><strong>URL:</strong></div>
                            <div class="span4"><input type="text" value="<?=$rw->url?>" placeholder="Menu URL" name="url"/></div>
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
