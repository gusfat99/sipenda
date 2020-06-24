<div class="row">
	<div class="offset-md-1 col-md-10">	
		<div class="x_panel">
			<div id="step-1">
				<div class="x_title">
					<h2>Input Nama Mata Lomba</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form id="form-lomba" method="post" class="form-label-left input_mask">
						<div class="row">
							<div class="col-md-6 col-sm-6  form-group has-feedback">
								<input data-rule-required="true" type="text" class="form-control has-feedback-left" id="namaLomba" name="namaLomba" required placeholder="Nama Mata Lomba">
								<span class="fa fa-trophy form-control-feedback left"></span>
							</div>	
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6  form-group has-feedback">

								<select type="text" class="form-control has-feedback-left" id="golongan" required name="golongan">
									<option value="">Pilih Golongan..</option>
									<option value="SMA">Penegak</option>
									<option value="SMP" >Penggalang</option>
									<option value="SD" >Penggalang (SD)</option>
								</select>
								<span class="fa fa-users form-control-feedback left"></span>

							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6  form-group has-feedback">

								<select type="text" class="form-control has-feedback-left" id="jenis_lomba" required name="jenis_lomba">
									<option value="">Pilih Jenis Lomba..</option>
									<option value="Umum">Umum</option>
									<option value="LCT" >LCT</option>
									<option value="Debat" >Debat</option>
								</select>
								<span class="fa fa-gears form-control-feedback left"></span>

							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-md-3 col-sm-3 ">Satuan Terpisah</label>
							<div class="col-md-9 col-sm-9 ">
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" value="1" id="satuan_y" name="satuan" checked class="custom-control-input">
									<label class="custom-control-label" for="satuan_y">Ya</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="satuan_t" value="0" name="satuan" class="custom-control-input">
									<label class="custom-control-label" for="satuan_t">Tidak</label>
								</div>
							</div>
						</div>
						<div class="ln_solid"></div>
						<div class="form-group row">
							<div class="col-md-8 col-sm-8">
								<button type="submit" class="btn simpan btn-success">Selanjutnya</button>
								<a href="" class="btn btn-danger">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(argument) {
		$("#step-1").show();

		let jenisLomba;

		$("select[name=jenis_lomba]").change(function(){
			jenisLomba = $(this).val();
		});
		const onSubmitFormLomba = (a, b) => {
			const form1 = $("form#form-lomba").serialize();
		
			if(confirm("Data sudah sesuai ?")) {
				console.log(jenisLomba);
				

				if(jenisLomba === "LCT") {
					$.ajax({
						url : `<?= base_url("lomba/add_lomba"); ?>`,
						type : "POST",
						dataType : "json",
						data : form1,
						async : true,
						success : (rest) => {
							
							const tingkatan = $("select[name='golongan']").val();
							document.location.href=`<?= base_url('lomba/input_lomba/') ?>?input=${tingkatan}&&count=2&&minus=1&&insertId=${rest.insertId}&&lct=true`;
							
						},
						error : (err) => console.log(err)
					});
					return;
				}

				const countKriteria =  prompt("Masukan jumlah kriteria penilaian");
				if (countKriteria <= 0 || !parseInt(countKriteria)) {
					alert("Input tidak valid");
					return;
				}
				const countKriteriaMin = parseInt(prompt("Masukan jumlah kriteria pengurangan point"));
				console.log(countKriteriaMin);
				if (countKriteriaMin <= -1 || !parseInt(countKriteriaMin)) {
					alert("Input tidak valid");
					return;
				}
				
				$.ajax({
					url : `<?= base_url("lomba/add_lomba"); ?>`,
					type : "POST",
					dataType : "json",
					data : form1,
					async : true,
					success : (rest) => {
 						
						const tingkatan = $("select[name='golongan']").val();
						document.location.href=`<?= base_url('lomba/input_lomba/') ?>?input=${tingkatan}&&count=${countKriteria}&&minus=${countKriteriaMin}&&insertId=${rest.insertId}`;
						
					},
					error : (err) => console.log(err)
				});		
			}
		}


		$("#form-lomba").validate({
			errorElement : "span",
			submitHandler : onSubmitFormLomba,
			rules : {
				namaLomba : {
					required : true,
					minlength : 2,
				},
				golongan : "required"
			},
			messages : {
				namaLomba : {
					required : "Nama Mata Lomba tidak boleh kosong",
					minlength : "Nama Mata Lomba terlalu pendek"
				},
				golongan : "Silahkan Pilih Golongan"

			},

		});


		let counter = 1;

		$("#btn-add-kriteria").click(function(e) {
			e.preventDefault();
			counter += 1;
			let cloneKriteria = $(".kriteria-penilaian").clone();
			cloneKriteria.attr("class", `form-group row has-feedback kriteria-penilaian-${counter}`);
			cloneKriteria.appendTo("#append-kriteria");
		});



	});
</script>
