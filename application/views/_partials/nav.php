    <div class="navbar <?=$admin_bar ?> navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="/"><?=$page_brand ?></a>
          <div class="nav-collapse collapse">
	          <ul class="nav">
							<?=$navigation_menu ?>
						</ul>
						<ul class="nav pull-right">
							<li class="working-img"></li>
							<?php if (isset($user->email)) { ?>
							<li class="gravatar"><?=gravatar($user->email,32) ?></li>
							<?php } ?>
							<?php if ($logged_in) { ?>
								<li class="logout">
									Logged in as <?=$user->username ?>
									<a href="/auth/logout">Logout</a>
								</li>
							<?php } else { ?>
								<li class="login"><a href="/auth">Login</a></li>
							<?php } ?>
 						</ul>
          </div>
        </div>
      </div>
    </div>