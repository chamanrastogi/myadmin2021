<?php

?>
<div class="navigation">
			<h5 class="title">Navigation</h5>
			<!-- /.title -->
			<ul class="menu js__accordion">
				<li class="current">
					<a class="waves-effect" href="<?=TP_BACK?>admin"><i class="menu-icon ti-dashboard"></i><span>Dashboard</span></a>
				</li>
                <li>
					<a class="waves-effect" href="<?=TP_BACK_SIDE?>user/log_history"><i class="menu-icon ti-bookmark-alt"></i><span>Login Log</span></a>
				</li>
                         	
                <li>
					<a class="waves-effect parent-item js__control" href="#"><i class="menu-icon ti-user"></i><span>Users</span>
                            <span class="notice notice-blue"><?=$user?></span></a>
					<ul class="sub-menu js__content">
						<li><a href="<?=TP_BACK_SIDE?>user/add">Add User</a></li>
						<li><a href="<?=TP_BACK_SIDE?>user/show">Show User</a></li>	
					</ul>				
				</li>
              
			</ul>
			
		</div>