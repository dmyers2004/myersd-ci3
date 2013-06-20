    <div class="navbar <?=$admin_bar ?> navbar-fixed-top">
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
							<li><img class="working-img" src="/assets/images/ajax-loader.gif"></li>
							<?php if ($logged_in) { ?>
								<li class="logged-in-as">Logged in as <?=$is_logged_in_as ?></li>
								<li><a href="/auth/logout">Logout</a></li>
							<?php } else { ?>
								<li><a href="/auth">Login</a></li>
							<?php } ?>
 						</ul>
          </div>
        </div>
      </div>
    </div>
