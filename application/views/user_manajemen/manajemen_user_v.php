
<table class="table table-hover table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
	<thead>
		<tr>
			<td>No</td>
			<td>Username</td>
			<td>Nama</td>
			<td>Level</td>
			<td>Status</td>
		</tr>
	</thead>
	<tbody>
		
	</tbody>
</table>

<!-- Modal Add -->
<!-- Modal -->
<div class="modal fade" id="modalAddUser" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAddUserLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form method="POST" id="form-user" autocomplete="on">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalAddUserLabel">Tambah User Baru</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					
					<div class="form-group">
						<label for="name">Nama <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="name" name="name" required autocomplete="on">
						<small class="form-text text-muted"></small>
					</div>
					<div class="form-group">
						<label for="user">Username <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="user" required name="username">
						<small class="form-text text-muted"></small>
					</div>
					<div class="form-group">
						<label for="password">Password <span class="text-danger">*</span></label>
						<input type="password"  class="form-control" id="password" required name="password">
					</div>

					<div class="form-group">

						<select required class="form-control" name="levelUser" id="levelUser">
							<option value="">Pilih Level</option>
							<option value="admin" >Admin</option>
							<option value="rekap" >Rekap</option>
							<option value="juri">Juri</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEditUser" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAddUserLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form method="POST" id="form-edit-user" autocomplete="on">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalAddUserLabel">Update User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">	
					<div class="form-group">
						<label for="eidtName">Nama <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="eiditName" name="editName" required autocomplete="on">
						<small class="form-text text-muted"></small>
					</div>
					<div class="form-group">
						<label for="editUser">Username <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="editUser" required name="editUser">
						<small class="form-text text-muted"></small>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	
	const controller = `<?= $this->uri->segment(1); ?>`
	const formUser = $("#form-user");
	const sessionUser = `<?= $this->session->userdata('username'); ?>`

	const fetchDataLomba = async () => {
		const dataOptionLomba = await $.getJSON(`<?= base_url('lomba/get_mata_lomba'); ?>`);
		return dataOptionLomba;
	};

	const fetchDataUser = async (username) => {
		const dataUser = await $.getJSON(`<?= base_url(); ?>/${controller}/fetchUser/${username}`);
		return dataUser;
	};

	//config datatable
	const dt = $(".table").DataTable({
		dom : '<"row"<"col-sm-6 col-md-6 float-left"f><"col-sm-6 col-md-6 float-right"B>>rtip',
		processing: true, 
		serverSide: true, 
		order: [],
		scrollY: "250px",
		scrollCollapse: true,
		ajax : {
			url : `<?= base_url("manajemen_user/get_data_user"); ?>`,
			type : "POST"
		},
		columnDefs : [{targets: [ 0 ],orderable: false,}],
		buttons : [
		{
			text : "Tambah User",
			className : "btn btn-sm btn-primary add-user"
		}, 
		{
			text : "<span class='fa fa-edit'> Edit</span>",
			className : "btn btn-sm btn-success edit-user"
		},
		{
			text : "<span class='fa fa-trash'> Hapus</span>",
			className : "btn btn-sm btn-danger delete-juri"
		}
		],
		rowCallback : function(row, data, iDisplayIndex) {
			const att = document.createAttribute("data");
			att.value = data[1];
			row.setAttributeNode(att);

		}
	});

	


	const onSubmitHandler = async (a,e) => {
		var username = $("input[name='username']").val();
		e.preventDefault();
		const user = await fetchDataUser(username);
		if (user) {
			new PNotify({
				text: "Username "+username+" telah terdaftar silahkan gunakan username lain",
				type : 'danger',
				styling: 'bootstrap3'
			})
			return;
		}

		const insert = await $.ajax({
			url : `<?= base_url() ?>/${controller}/add`,
			data : formUser.serialize(),
			type : "POST",
			dataType : "JSON"
		});
		if (insert) {
			new PNotify({
				text: "Username "+username+" Berhasil ditambahkan",
				type : 'success',
				styling: 'bootstrap3'
			})
			dt.ajax.reload();
			$("#modalAddUser").modal("hide");
			$("input[name='username']").val('');
			$("input[name='password']").val('');
			$("input[name='name']").val('');
			$("input[name='matalomba']").val('');
			$("input[name='levelUser']").val('');

		}

	};
	

	$("select[name='levelUser']").change(function() {
		$(this).val() === "juri" ? $(".form-lomba").hide().show() : $(".form-lomba").hide();
	});

	formUser.validate({
		errorElement : "span",
		submitHandler : onSubmitHandler,
		rules : {
			username : {
				required : true,
				minlength : 5
			},
			password : {
				required : true,
				minlength : 6
			}
		}
	});



	
	
	//logic selected baris
	$('.table tbody').on('click', 'tr', function() {
		if ($(this).hasClass("selected")) {
			$(this).removeClass('selected');
		} else {
			dt.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
		}
	});
	$(".dt-buttons").removeClass("btn-group");

	//fungsi tambah
	$(".add-user").click(async function() {
		$(".form-lomba").hide();
		$("#modalAddUser").modal("show");

	});

	// fungsi edit
	$(".edit-user").click(async function() {
		const user = $("tr.selected").attr("data");	

		const dataUser = await fetchDataUser(user);

		const onSubmitHandler = async (a, e) => {
			e.preventDefault();
			const inputUsername = $("input[name='editUser']").val();
			const users = await fetchDataUser(inputUsername);
			if(users && users.username !== dataUser.username) {
				new PNotify({
					text: "Username "+inputUsername+" telah terdaftar silahkan gunakan username lain",
					type : 'danger',
					styling: 'bootstrap3'
				})
				return;
			}


			const update = await $.ajax({
				url : `<?= base_url() ?>/${controller}/update/${dataUser.id_user}`,
				data : $("form#form-edit-user").serialize(),
				type : "POST",
				dataType : "JSON"
			});
			if (update) {
				new PNotify({
					text: "User berhasil di update",
					type : 'success',
					styling: 'bootstrap3'
				})
				document.location.href=`<?= base_url() ?>${controller}`;
				$("#modalEditUser").modal("hide");
				$("input[name='editName']").val('');
				$("input[name='editUser']").val('');
			}

		};

		$(".form-lomba").show();
		$(".empty").hide()
		if (!user) {
			swal({
				title: "Tidak ada user yang dipilih!",	
			});
			return;
		}

		// $('option')
	 //     .removeAttr('selected')
	 //     .filter(`[value=${dataUser.level}]`)
	 //     .attr('selected', true);
	 $("input[name='editName']").val(dataUser.nama);
	 $("input[name='editUser']").val(dataUser.username);	 	

	 if (dataUser.level === "juri") {	     	
	 	$("input[name='editLevel']").val(dataUser.level);
	 	$(".empty").show();
	 }
	 $("#modalEditUser").modal("show");

	 $("form#form-edit-user").validate({
	 	errorElement : "span",
	 	submitHandler : onSubmitHandler,
	 	rules : {
	 		editUser : {
	 			required : true,
	 			minlength : 5
	 		}
	 	}
	 });

	});

	//fungsi delete
	$(".delete-juri").click( async function() {
		const user = $("tr.selected").attr("data");		
		const dataUser = await fetchDataUser(user);

		if (!user) {
			swal({
				title: "Tidak ada user yang dipilih!",	
			});
			return;
		}

		if(dataUser.username === sessionUser){
			swal({title: "Akses tidak diizinkan"});
			return;
		}

		const alert = await swal({
			title: "Yakin ingin menghapus?",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		});

		if (alert) {
			const post = await $.post(`<?= base_url('manajemen_user/delete') ?>`, {user : user});
			if (post) {
				new PNotify({
					text: user+" Berhasil dihapus",
					type : 'success',
					styling: 'bootstrap3'
				});
				dt.ajax.reload();
			}
		}	
	});
	
</script>