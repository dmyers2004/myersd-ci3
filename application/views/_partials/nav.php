    <div class="navbar <? echo $admin_bar ?> navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="nav-collapse collapse">
	          <ul class="nav">
						<li><a class="brand" href="/"><?=$page_brand ?></a></li>          
<?=$navigation_menu ?>
						</ul>
						<ul class="nav pull-right">
<?php if ($logged_in) { ?>
						<li><a href="/admin/auth/logout">Logout</a></li>
<?php } else { ?>
						<li><a href="/admin/auth">Login</a></li>
<?php } ?>
 						</ul>
          </div>
        </div>
      </div>
    </div>
