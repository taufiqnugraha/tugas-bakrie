<div class="page-content">
  <div class="container-fluid">
    <div class="d-xl-flex">
      <div class="w-100">
        <div class="d-md-flex">
          <div class="card filemanager-sidebar me-md-2">
            <div class="pt-3 pb-0 p-3 btn-light">
              <div class="form-check form-check-primary mb-3 text-center">
                <label class="form-check-label font-size-14">Daftar Pengguna</label>
              </div>
            </div>

            <div class="mb-2 mt-2 pb-0 px-2">
              <div class="dropdown">
                <a href="<?php echo base_url() . 'user-access' ?>">
                  <button class="btn btn-success btn-rounded dropdown-toggle w-100" type="button">
                    Tambah Pengguna </button>
                </a>
              </div>
            </div>

            <div class="card-body p-0">
              <div class="d-flex flex-column h-100">
                <div class="mb-3">
                  <ul class="list-unstyled m-0 categories-list">
                    <?php foreach ($user as $ls) { ?>
                      <a data-bs-toggle="tooltip" data-bs-placement="right" title="Edit <?php echo $ls['fullname']; ?>" href="<?php echo base_url() . 'user-access/detail/' . encrypt_url($ls['id_login']); ?>">
                        <li class="py-2 px-3">
                          <div class="row">
                            <div class="col">
                              <span class="text-body d-flex align-items-center me-auto"><?php echo $ls['fullname']; ?></span>
                            </div>
                            <div class="col col text-end">
                              <?php if ($ls['flag'] == 1) { ?>
                                <p class="text-success m-0">Aktif</p>
                              <?php } else { ?>
                                <p class="text-danger m-0">Inaktif</p>
                              <?php } ?>
                            </div>
                          </div>
                        </li>
                      </a>
                    <?php } ?>
                  </ul>
                </div>
                <div class="mt-auto"></div>
              </div>
            </div>
          </div>
          <!-- filemanager-leftsidebar -->
          <div class="w-100">
            <div class="card">
              <div class="card-body">
                <div>
                  <div class="row mb-3">
                    <div class="col-xl-12 col-sm-12">
                      <div class="mt-2">
                        <h5>Edit Pengguna <?php echo $useredit['fullname']; ?></h5>
                      </div>
                    </div>
                  </div>
                </div>
                <?php #echo json_encode($menu_id) 
                ?>
                <form class="" id="form_access_edit">
                  <input type="hidden" name="id_login" value="<?php echo encrypt_url($useredit['id_login']); ?>">
                  <div class="row mb-3">

                    <div class="col-lg-4 mb-2">
                      <label class="form-label">Nama lengkap</label>
                      <input class="form-control" type="text" value="<?php echo $useredit['fullname']; ?>" name="fullname" id="fullname">
                    </div>

                    <div class="col-lg-4 mb-2">
                      <label class="form-label">E-mail</label>
                      <input class="form-control" value="<?php echo $useredit['email']; ?>" type="email" name="email" id="email">
                    </div>

                    <div class="col-lg-4 mb-2">
                      <label class="form-label">Username</label>
                      <input class="form-control" value="<?php echo $useredit['username']; ?>" type="text" name="username" id="username">
                    </div>

                    <div class="col-lg-4 mb-2">
                      <label class="form-label">Password</label>
                      <input class="form-control" type="password" name="password" id="password">
                    </div>

                    <div class="col-lg-4 mb-2">
                      <label class="form-label">Status</label>
                      <select name="flag" id="flag" class="form-select">
                        <option selected value="">Pilih Status</option>
                        <option <?php echo $useredit['flag'] == 1 ? "selected" : "" ?> value="1">Aktif</option>
                        <option <?php echo $useredit['flag'] == 0 ?  "selected" : "" ?> value="0">Inaktif</option>
                      </select>
                    </div>

                    <div class="col-lg-4 mb-2">
                      <label class="form-label">Role</label>
                      <select name="role" id="role" class="form-select">
                        <option value="">Pilih Role</option>
                        <option <?php echo $useredit['user_type'] == 1 ? "selected" : "" ?> value="1">Super Administrator</option>
                        <option <?php echo $useredit['user_type'] == 2 ? "selected" : "" ?> value="2">Kasir</option>
                        <option <?php echo $useredit['user_type'] == 3 ? "selected" : "" ?> value="3">Admin Stock</option>
                      </select>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <?php foreach ($menu as $ls) : ?>
                        <div class="col-xl-4 col-sm-6">
                          <div class="card shadow-none border">
                            <div class="pt-3 pb-0 p-3 btn-light">
                              <div class="form-check form-check-primary mb-3">
                                <?php
                                $sel_menu = "";
                                if (array_search($ls['menu_id'], $menu_access)) {
                                  $sel_menu = "checked";
                                }
                                ?>
                                <input <?php echo $sel_menu; ?> onchange="selectAll(<?php echo $ls['menu_id'] ?>)" class="form-check-input" value="<?php echo $ls['menu_id'] ?>" name="menu[]" type="checkbox" id="menu<?php echo $ls['menu_id'] ?>">
                                <label class="form-check-label font-size-14" for="menu<?php echo $ls['menu_id'] ?>"> <?php echo $ls['menu_name'] ?> </label>
                              </div>
                            </div>
                            <div class="card-body p-3">
                              <div class="">

                                <div class="">
                                  <?php foreach ($ls['submenu'] as $data) :
                                    $sel_submenu = "";
                                    if (array_search($data['submenu_id'], $access)) {
                                      $sel_submenu = "checked";
                                    }
                                  ?>
                                    <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                      <input <?php echo $sel_submenu; ?> class="form-check-input menu<?php echo $ls['menu_id'] ?>" value="<?php echo $data['submenu_id'] ?>" name="submenu[]" type="checkbox" id="submenu<?php echo $data['submenu_id'] ?>">
                                      <label class="form-check-label font-size-12" for="submenu<?php echo $data['submenu_id'] ?>"> <?php echo $data['submenu_name'] ?> </label>
                                    </div>
                                  <?php endforeach; ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                      <!-- end col -->
                    </div>
                    <!-- end row -->

                  </div>
                  <div class="d-flex justify-content-center">
                    <div class="col-xl-4">
                      <button type="submit" class="btn btn-primary btn-roundec waves-effect waves-light col-xl-12">Simpan</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- end card -->
          </div>
          <!-- end w-100 -->
        </div>
      </div>
    </div>
  </div>
  <!-- container-fluid -->
</div>
<!-- End Page-content -->