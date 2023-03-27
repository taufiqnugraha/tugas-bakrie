<div class="page-content">
	<div class="container-fluid">
		<?php
			if($_SESSION['user_type'] == 1){
				$usertype = 'Super Administrator';
			} elseif($_SESSION['user_type'] == 2){
				$usertype = 'Pegawai';
			} else {
				$usertype = 'SDM';
			}
		?>
		<h4 class="font-size-20 mb-3">Selamat datang <?php echo $_SESSION['fullname'] . ' (' . $usertype . ')' ?></h4>
		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h5 class="mb-sm-0 font-size-16">Dashboard - Kepegawaian</h5>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard'; ?>">Dashboard</a></li>
						</ol>
					</div>


				</div>
			</div>
		</div>

        <div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
                            <p> Tugas dapat diakses melalui menu master data > employee. User yang ditambahkan dapat login sesuai role yaitu kepegawaian dan dapat di edit melalui <code>hak akses dan role</code></p>
                    </div>
                </div>
            </div>
        </div>
		<!-- end page title -->
	</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
