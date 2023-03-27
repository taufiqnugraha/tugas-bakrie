<div class="page-content">
	<div class="container-fluid">

		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Master Employee</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item">Data Master</li>
							<li class="breadcrumb-item active">Employee</li>
						</ol>
					</div>

				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row mb-2">
							<div class="col-sm-4">
								<div class="search-box me-2 mb-2 d-inline-block">
									<div class="position-relative">
										<input type="text" id="search_emp" class="form-control" placeholder="Cari">
										<i class="bx bx-search-alt search-icon"></i>
									</div>
								</div>
							</div>
							<div class="col-sm-8">
								<div class="text-sm-end">
									<button type="button" id="btn-add-emp" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2" data-bs-toggle="modal" data-bs-target="#modalAddEmp"><i class="mdi mdi-plus me-1"></i> Tambah Data Karyawan</button>
                                    <button type="button" id="btn-add-emp-bulk" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2" data-bs-toggle="modal" data-bs-target="#modalAddBulk"><i class="mdi mdi-file-excel me-1"></i> Tambah Data Bulk</button>
								</div>
							</div><!-- end col-->
						</div>

						<div class="table-responsive">
							<table id="master_emp" class="table align-middle table-nowrap table-check">
								<thead class="table-light">
									<tr>
										<th class="align-middle">NIK</th>
										<th class="align-middle">Nama</th>
										<th class="align-middle">Jenis Kelamin</th>
										<th class="align-middle">Tempat, Tanggal Lahir</th>
										<th class="align-middle text-center">Action</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
		</div>
		<!-- end row -->
	</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!-- Modal Add Emp -->
<div id="modalAddEmp" class="modal fade" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Tambah Data Pegawai</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form_emp" method="post">
				<div class="modal-body">
					<div class="col-lg-12 mb-2">
						<label class="form-label">NIK</label>
						<input class="form-control" type="text" name="nik" id="nik">
                        <small id="err_nik"></small>
					</div>
					<div class="col-lg-12 mb-2">
						<label class="form-label">Nama Lengkap</label>
						<input class="form-control" type="text" name="full_name" id="full_name">
                        <small id="err_full_name"></small>

					</div>
                    <div class="col-lg-12 mb-2">
						<label class="form-label">Nama Panggilan</label>
						<input class="form-control" type="text" name="called_name" id="called_name">
                        <small id="err_called_name"></small>
					</div>
                    <div class="col-lg-12 mb-2">
						<label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="" selected disabled>Pilih Jenis Kelamin</option>
                            <option value="1">Laki-Laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                        <small id="err_jenis_kelamin"></small>
					</div>
                    <div class="col-lg-12 mb-2">
						<label class="form-label">Tempat Kelahiran</label>
                        <select name="city" id="city" class="form-control select2">
                        <option value="">Pilih Kota Kelahiran</option>

                        </select>
                        <small id="err_city"></small>
					</div>
                    <div class="col-lg-12 mb-2">
						<label class="form-label">Tanggal Lahir</label>
						<input class="form-control" type="date" name="start_date" id="start_date">
                        <small id="err_start_date"></small>

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Batal</button>
					<button type="submit" id="btn-save-emp" class="btn btn-primary waves-effect waves-light">Simpan</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal Add Emp -->
<div id="modalAddBulk" class="modal fade" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Tambah Data Pegawai</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form_emp_bulk" method="post">
				<div class="modal-body">
					<div class="col-lg-12 mb-2">
						<label class="form-label">File</label>
						<input class="form-control" type="file" name="file" id="file" accept=".xls,.xlsx">
                        <small id="err_file"></small>
					</div>

                    <div class="col-lg-12 mb-2">
						<label class="form-label">Download format</label> <a href="">Link</a>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Batal</button>
					<button type="submit" id="btn-save-emp" class="btn btn-primary waves-effect waves-light">Simpan</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- Modal Edit Emp -->
<div id="modalUpdateEmp" class="modal fade" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Update Data Emp</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form_update_emp" method="post">
				<div class="modal-body">
					<input class="form-control" type="hidden" name="_id_nik" id="_id_nik">
					<div class="col-lg-12 mb-2">
						<label class="form-label">NIK</label>
						<input class="form-control" type="text" name="nik" id="_nik" disabled>
                        <small id="err_nik"></small>
					</div>
					<div class="col-lg-12 mb-2">
						<label class="form-label">Nama Lengkap</label>
						<input class="form-control" type="text" name="full_name" id="_full_name">
                        <small id="err_full_name"></small>

					</div>
                    <div class="col-lg-12 mb-2">
						<label class="form-label">Nama Panggilan</label>
						<input class="form-control" type="text" name="called_name" id="_called_name">
                        <small id="err_called_name"></small>
					</div>
                    <div class="col-lg-12 mb-2">
						<label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="_jenis_kelamin" class="form-control" required>
                            <option value="" selected disabled>Pilih Jenis Kelamin</option>
                            <option value="1">Laki-Laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                        <small id="err_jenis_kelamin"></small>
					</div>
                    <div class="col-lg-12 mb-2">
						<label class="form-label">Tempat Kelahiran</label>
                        <select name="city" id="city_update" class="form-control select2">
                        <option value="" disabled>Pilih Kota Kelahiran</option>

                        </select>
                        <small id="err_city"></small>
					</div>
                    <div class="col-lg-12 mb-2">
						<label class="form-label">Tanggal Lahir</label>
						<input class="form-control" type="date" name="start_date" id="_start_date">
                        <small id="err_start_date"></small>

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Batal</button>
					<button type="submit" id="btn-update-uom" class="btn btn-primary waves-effect waves-light">Update</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
