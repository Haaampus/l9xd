  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="<?php 
      if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
        if (App\Repository\UserRepository::getInstance()->getType($_SESSION['user']['id']) === "member") {
          echo App\Router\Router::url(App\Config::CUSTOMER);
        } else if (App\Repository\UserRepository::getInstance()->getType($_SESSION['user']['id']) === "booster") {
          echo App\Router\Router::url(App\Config::BOOSTER);
        } else if (App\Repository\UserRepository::getInstance()->getType($_SESSION['user']['id']) === "admin") {
          echo App\Router\Router::url(App\Config::ADMIN);
        }
      }
    ?>" class="navbar-brand"><?php echo App\Config::WEBSITE_NAME; ?></a>
        </div>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo asset('boostpanel_assets/img/avatars/' . App\Repository\UserRepository::getInstance()->getAvatar()); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo ucfirst(App\Repository\UserRepository::getInstance()->getUsername($_SESSION['user']['id'])); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo asset('boostpanel_assets/img/avatars/' . App\Repository\UserRepository::getInstance()->getAvatar()); ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo ucfirst(App\Repository\UserRepository::getInstance()->getUsername($_SESSION['user']['id'])); ?>
                  <small><?php echo ucfirst(App\Repository\UserRepository::getInstance()->getType($_SESSION['user']['id'])); ?> since <?php echo App\Repository\UserRepository::getInstance()->getCreatedDate($_SESSION['user']['id']); ?></small>
                  <?php if(App\Repository\UserRepository::getInstance()->getType($_SESSION['user']['id']) === "booster"): ?>
                    <small>Total Balance Of Earnings : $<?php echo round(\App\Repository\BoosterRepository::getInstance()->totalBalance($_SESSION['user']['id']), 2); ?></small>
                  <?php endif; ?>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo App\Router\Router::url('profile'); ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo App\Router\Router::url('logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
