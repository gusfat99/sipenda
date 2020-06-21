        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <nav class="nav navbar-nav">
              <div class="nav__">
               
                <div class="sesi-title">
                  <marquee>
                    <span> <?= strtoupper($sesi->judul_kegiatan); ?> :</span> <?= strtolower($sesi->tema_kegiatan) ?>
                  </marquee>
                </div>

                <ul class="navbar-right">
                  <div></div>
                  <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                      <?= $this->session->userdata('name'); ?>
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item"  href="javascript:;"> Profile</a>
                      <a class="dropdown-item"  href="<?= base_url("auth/logout"); ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                    </div>
                  </li>


                  <li role="presentation" class="nav-item dropdown open">
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-envelope-o"></i>
                      <span class="badge bg-green"></span>
                    </a>

                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">


                    </ul>
                  </li>
                </ul>
              </div>
              
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
        <?php 
        echo $this->session->flashData("notif") ? "<div id='flash-delete' data='".$this->session->flashdata('notif')."' ></div>" : "";
        ?>
