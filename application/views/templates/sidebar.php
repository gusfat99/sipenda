            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">

                <ul class="nav side-menu">
                  <?php 
                  $levelUser = $this->session->userdata("level"); 
                  $menuLevel_1 = load_menu($levelUser, 'level 1')->result();
                  $username = $this->session->userdata('username');
                  $user = $this->db->get_where("users", ["username" => $username])->row();
                  $userId = $user->id_user;
                 
                  foreach($menuLevel_1 as $mLvl1):

                    $menuLevel_2 = load_menu($levelUser, 'level 2', $mLvl1->id_menu)->result();
                    $current_url=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                    
                    $active_stat='';
                    $link='';
                    $icon='';
                    $dropdown='';
                    $arrow_dropdown='';
                    $ulOpen = '';
                    $ulClose = '';

                    if (count($menuLevel_2) > 0) {
                      $arrow_dropdown='<span class="fa fa-chevron-down"></span>';                 
                      foreach($menuLevel_2 as $mLvl2) {
                        $dataAttr = '';
                        
                        if ($mLvl2->id_r_mata_lomba) {
                          $dataAttr = 'data-lomba = '.$mLvl2->id_r_mata_lomba.' class="mata-lomba-link"';
                        }

                        if ($mLvl2->id_r_juara_favorite) {
                          $dataAttr = 'data-lomba = '.$mLvl2->id_r_juara_favorite.' class="favorite-link"';
                        }



                        $menu_context_url=str_replace('http://','',base_url().$mLvl2->link);
                        $menu_context_url=str_replace('https://','',$menu_context_url);
                        $ulOpen = '<ul class="nav child_menu">';
                        $ulClose = '</ul>';
                        if ($levelUser == 'juri') {
                          $juri = $this->db->get_where("juri", ["id_r_user" => $userId])->result();
                          foreach ($juri as $j) {
                            if ($j->id_r_mata_lomba == $mLvl2->id_r_mata_lomba) {
                               $dropdown .='
                                <li><a href="'.base_url('/').$mLvl2->link.'" '.$dataAttr.'>'.$mLvl2->title.'</a></li>
                                ';
                                continue;
                            } 
                          }
                        } else {
                          $dropdown .='
                          <li><a href="'.base_url('/').$mLvl2->link.'" '.$dataAttr.'>'.$mLvl2->title.'</a></li>
                          ';
                        }

                       

                        // if($current_url==$menu_context_url) {
                        //   $active_stat='class="active"';
                        //   break;
                        // }


                      }
                    } else {
                      $menu_context_url=str_replace('http://','',base_url().$mLvl1->link);
                      $menu_context_url=str_replace('https://','',$menu_context_url);
                      if($current_url==$menu_context_url) {
                        $active_stat='class="active"';

                      }
                    }
                    $link = $mLvl1->link;
                    $mLvl1->icon != null ? $icon = $mLvl1->icon : "";

                    ?>

                    <li <?= $active_stat; ?>>
                      <a href="<?= $link == '#' ? '#' : base_url("/").$link; ?>">
                        <i class="<?= $icon; ?>"></i> <?= $mLvl1->title." ".$arrow_dropdown; ?>           
                      </a>

                      <?= $ulOpen; ?>
                      <?= $dropdown; ?>
                      <?= $ulClose; ?>
                    </li>

                  <?php endforeach; ?>  


                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small float-right">
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?= base_url("auth/logout"); ?>">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>
        <script type="text/javascript">
          const levelUser = `<?= $levelUser ?>`;
          const userId = `<?= $userId ?>`;
          

          const getJuri =  (lombaId) => {
            const userJuri =  $.getJSON(`<?= base_url('set_menu_penilaian/fetchDataJuri/') ?>${lombaId}`);
            return userJuri;
          };

         
          $('.mata-lomba-link').click( async function(e){
            e.preventDefault();
            const mataLombaId = $(this).data('lomba');

            let jenis = ``;
            if (levelUser === 'juri') {
              const userJuries = await getJuri(mataLombaId);
              const juri = userJuries.result.find(juri => juri.id_r_user === userId);
              jenis = juri.golongan_kelamin;

            } else {
              jenis = 'semua_jenis';
            }
            let selector = '';
            if (jenis === 'semua_jenis') {
              selector = '&&select=putra';
            }
            document.location.href= '<?= base_url('penilaian') ?>/list/'+mataLombaId+'?jenis='+jenis+selector;
          });

          $(".favorite-link").click(async function(e) {
            e.preventDefault();
            const favoriteId = $(this).data("lomba");

            document.location.href=`<?= base_url('kejuaraan_favorite') ?>/list/${favoriteId}?golongan=sma`;
          });

        </script>