<?php
require_once('../../includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }?>
<?php include_layout_template('header.php');
$template=Template::find_by_id(1);
 ?>
  <?php
if(isset($_GET['act'])&&$_GET['act']!=''){
  $act=$_GET['act'];
 $mo=new Social(); 
$rc = Social::find_by_id($act);
if($rc->status=='Active')
{ 

$mo->update_status("Deactive",$_GET['act']);
?>
<script>
<!--
function Redirect()
{
	
    window.location="showsocial.php";
	
}

setTimeout('Redirect()', 1000);
</script>
<?php
}
else
{
$mo->update_status("Active",$_GET['act']);
?>
<script>
<!--
function Redirect()
{
	
    window.location="showsocial.php";
	
}

setTimeout('Redirect()', 1000);
</script>
<?php
}

}
if(isset($_GET['id']) && $_GET['id']!=''){
  $Social = Social::find_by_id($_GET['id']);
  $Social->delete(); 
  ?>
<script>
<!--
function Redirect()
{
	
    window.location="showsocial.php";
	
}

setTimeout('Redirect()', 1000);
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

 
<title>Show Social</title>
<body>
    
    <div class="header"><a class="logo" href="index.php"><img src="../img/logo2.png"/><b style="color:white;font-size:14px;font-weight:bold;">Admin Panel</b></a>
        <ul class="header_menu">
            <li class="list_icon"><a href="#">&nbsp;</a></li>
        </ul>    
    </div>
        <script>
function confirmDelete(delUrl) {
  if (confirm("Are you sure you want to delete")) {
   document.location = delUrl;
  }
}
</script>
    <?php include_layout_template('side.php');?>
        
    <div class="content">
        
        
        <div class="breadLine"> <ul class="breadcrumb">
      <li><a href="index.php"><?=$template->sitename?></a> <span class="divider">></span></li>              
                <li class="active">Show Social</li> </ul> <?php include_layout_template('top_menu.php');?>
            
        </div>
        
        <div class="workplace">
            
                         
            
            
<div class="row-fluid">
                
                <div class="span12">                    
                    <div class="head clearfix">
                        <div class="isw-grid"></div>
                        <h1>Show Social</h1>    <div class="rright" align="right"><a href="#"><strong style="color:#FFF; padding: 8px 10px 0 0; float:right;"></strong><i style="float:right; padding-top:8px; padding-left: 10px;"class="isw-plus"></i></a></div>                           
                    </div>
                    <div class="block-fluid table-sorting clearfix">
                     <form name="form" action="deleteall.php" method="post">
                        <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="checkall"/>Id</th>
                                  
                                  
                            <th >Title</th>
                       
                        <th >Url</th>
                        <th>Status</th>

                        <th >Options </th>                                   
                                </tr>
                            </thead>
                            <tbody>
                           <?php 
				$row2 = Social::find_all();
					foreach($row2 as $row2) { 
?>                
                    <tr >
                    
                        <td width="100px;"   ><input  type="checkbox" name="checkall[]"  value="<?=$row2->id?>" /><?=$row2->id?></td>
                        
                        
                         <td width="15%" ><?=$row2->title?></a></td>
                          
                         <td width="25%"><a href="<?=$row2->url?>" target="_blank"><?=$row2->url?></a></td>  
                       <td width="25%"> <a href="showsocial.php?act=<?=$row2->id?>"  style="color:blue"><?php echo $row2->status?></a>   </td>
                
                        <td>
                        
                        <a href="editsocial.php?id=<?=$row2->id?>" class="button-a gray"><i class="icon-pencil"></i></a>  
                       
                     </td>
                        
                    </tr>
                    
                  <?php  
                  
                   }
										 ?>
                                                            
                            </tbody>
                        </table>
                         
   </form>
                    </div>
                </div>                                
                
            </div>
                          
            
            <div class="dr"><span></span></div>
            
                        
            
           
            
        </div>
        
    </div>   
    
  <?php include_layout_template('footer.php'); ?>
