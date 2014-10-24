<div class="row">
	<!-- Profile Info and Notifications -->
	<div class="col-md-8  clearfix">
		<ul class="user-info pull-left pull-none-xsm">
			<!-- Profile Info -->
			<li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="images/head.png" alt="" class="img-circle" width="44">
					<?php if(isset($_SESSION["username"]))echo $_SESSION["username"]; ?>
				</a>
			</li>
		</ul>
	</div>
	<!-- Raw Links -->
	<div class="col-md-3 clearfix">	
		<ul class="list-inline links-list pull-right">		
			<li><a href="#" id="editmail_a" >截图邮件<i class="entypo-mail right"></i></a>
			</li>
			<li class="sep"></li>
			<li><a href="logout.php?action=logout">注销 <i class="entypo-logout right"></i></a></li>
		</ul>
	</div>
</div>
<hr>
