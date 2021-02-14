<?php
require_once('../../includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }?>
<?php include_layout_template('header.php');
$template=Template::find_by_id(1);
  if(isset($_GET['sid']))
		  {
			  $s="Edit";
		  }else
			  {
				  $s="Add";}
		  if(isset($_GET['do']))
		  {
			   $s="Show";
			  }
 ?>
<title>
<?=$s?>
Category</title>

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
        Category</li>
    </ul>
    <?php include_layout_template('top_menu.php');?>
  </div>
  <div class="workplace">
    <?PHP
$data=new Cat();
 if(isset($_REQUEST['submit'])){
	extract($_POST);

$data->name=$cname;

$data->status="Active";
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
	 
		window.location="cat.php?sid=<?=$_GET['sid']?>";
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
	 
		window.location="cat.php";
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
 $mo=new Cat(); 
$rc = Cat::find_by_id($act);
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
if(isset($_GET['id']) && $_GET['id']!=''){
  $Gcat = Cat::find_by_id($_GET['id']);
  $Gcat->delete(); 
   ?>
    <script>
		function Redirect()
	  {	
	 
		window.location="cat.php?do=show";
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
          <h1>Show Category</h1>
          <div class="right" align="right"><a href="cat.php"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;">&nbsp;Add Category</strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-list"></i></a></div>
        </div>
        <div class="block-fluid table-sorting clearfix">
          <form name="form" action="deleteall.php" method="post">
            <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
              <thead>
                <tr>
                  <th><input type="checkbox" name="checkall"/>
                    Id</th>
                  <th >Name</th>
                  <th >-</th>
                  <th >Status</th>
                  <th >Options </th>
                </tr>
              </thead>
              <tbody>
                <?php 
				
					$row2 = Cat::find_all();
					foreach($row2 as $row2) { 
				
?>
                <tr class="item">
                  <td><input type="checkbox" name="checkall[]"  value="<?=$row2->id?>" />
                    <?=$row2->id?></td>
                  <td class="subject"><?=$row2->name?></td>
                  <td class="subject">-</td>
                  <td width="25%"><a href="cat.php?act=<?=$row2->id?>"  style="color:blue"><?php echo $row2->status?></a></td>
                  <td class="action"><a href="cat.php?sid=<?=$row2->id?>" class="icon-pencil"></a> <a href="javascript:confirmDelete('cat.php?did=<?=$row2->id?>')" class="isb-delete" ></a></td>
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
				  if(isset($_GET['sid']))		  {
			  	    $sid=$_GET['sid'];
					$rw = Cat::find_by_id($sid);
					$name=$rw->name;
					
					$pagetitle="Edit Category";
		  }else
		  {
			  $name='';
		   $pagetitle="Add Category";  
			  }
			?>
        <div class="head clearfix">
          <div class="isw-documents"></div>
          <h1>
            <?=$pagetitle?>
          </h1>
          <div class="rright" align="right"><a href="cat.php?do=show"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;">&nbsp;Show Category</strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-list"></i></a></div>
        </div>
        <div class="block-fluid table-sorting clearfix">
          <form enctype="multipart/form-data"  id="validation" method="post" action="#" >
            <div class="block-fluid">
              <?=forms::input2("Name","name",$name)?>
               <?=forms::submit()?>              
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
