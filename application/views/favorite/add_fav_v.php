<div class="row">
	<div class="offset-md-1 col-md-10">	
		<div class="x_panel">
			<div id="step-1">
				
				<div class="x_content">
					<form id="form-lomba" method="post" class="form-label-left input_mask">
						<div class="x_title">
							<h2>Input Nama Kejuaraan Favorite</h2>
							<div class="clearfix"></div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6  form-group has-feedback">
								<input data-rule-required="true" type="text" class="form-control has-feedback-left" id="kejuaraan_fav" name="kejuaraan_fav" required placeholder="Nama Kejuaraan Favorite">
								<span class="fa fa-star form-control-feedback left"></span>
							</div>	
						</div>
						<div class="x_title">
							<h2>Kriteria Penilaian Kejuaraan Favorite</h2>
							
							<div class="float-right">
								<a href="#" id="btn-add-form" class="btn btn-sm btn-outline-info"><i class="fa fa-plus"></i></a>
							</div>
							
							<div class="clearfix"></div>
						</div>
						<div class="clone-form">
							<div class="row current-form-kriteria">
								<div class="col-md-6 col-sm-6  form-group has-feedback">
									<input data-rule-required="true" type="text" class="form-control has-feedback-left" name="kriteria_fav-0[]" required placeholder="Kriteria Penilaian">
									<span class="fa fa-at form-control-feedback left"></span>
								</div>	
								<div class="col-md-4 col-sm-4  form-group has-feedback">
									<input data-rule-required="true" type="text" class="form-control has-feedback-left"  name="nilaimax_fav-0[]" required placeholder="Nilai Max.">
									<span class="fa fa-plus form-control-feedback left"></span>
								</div>	
								
							</div>	
						</div>
						
						<div class="x_title">
							<h2>Kriteria Penguranan Nilai Kejuaraan Favorite</h2>
							<div class="float-right">
								<a href="#" id="btn-add-kriteria_min" class="btn btn-sm btn-outline-info"><i class="fa fa-plus"></i></a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="contain-form-kriteria_min">
							<div class="row">
								<div class="col-md-6 col-sm-6  form-group has-feedback">
									<input data-rule-required="true" type="text" class="form-control has-feedback-left" id="kriteriaMinus_fav1" name="kriteriaMinus_fav" required placeholder="Kriteria Pengurangan nilai ke-1">
									<span class="fa fa-at form-control-feedback left"></span>
								</div>
								<div class="col-md-4 col-sm-4  form-group has-feedback">
									<input data-rule-required="true" type="text" class="form-control has-feedback-left" id="nilaiMinus_fav1" name="nilaiMinus_fav1" required placeholder="Nilai Min.">
									<span class="fa fa-minus form-control-feedback left"></span>
								</div>	
								
									<a href=""  class="btn btn-remove-kriteri-min btn-sm btn-outline-danger"><i class="fa fa-minus"></i></a>
								
							</div>
						
						</div>
						
						<div class="ln_solid"></div>
						<div class="form-group row">
							<div class="col-md-8 col-sm-8">
								<button type="submit" class="btn simpan btn-success">Simpan</button>
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
	const formKriteria = $(".current-form-kriteria");
	let counterFormKriteria = 1;

	$("#btn-add-form").click(function(e){
		e.preventDefault();

		const cloneForm = `
			<div class="row current-form-kriteria-${counterFormKriteria}">
				<div class="col-md-6 col-sm-6  form-group has-feedback">
					<input data-rule-required="true" type="text" class="form-control has-feedback-left" name="kriteria_fav-0[]" required placeholder="Kriteria Penilaian ke-${counterFormKriteria+1}">
					<span class="fa fa-at form-control-feedback left"></span>
				</div>	
				<div class="col-md-4 col-sm-4  form-group has-feedback">
					<input data-rule-required="true" type="text" class="form-control has-feedback-left"  name="nilaimax_fav-0[]" required placeholder="Nilai Max.">
					<span class="fa fa-plus form-control-feedback left"></span>
				</div>	
				
				<a href="#" data-current="${counterFormKriteria}" class="btn text-center btn-remove-kriteria btn-sm btn-outline-danger"><i class="fa fa-minus"></i>
				</a>
				
			</div>	
		`;
		$(".clone-form").append(cloneForm);

		// const filter = $(".current-form-kriteria-"+counterFormKriteria).filter(`input[name=kriteria_fav-${counterFormKriteria - 1}]`);
		// console.log(filter);		
		
		counterFormKriteria++;
	});

	$(".clone-form").on('click', '.btn-remove-kriteria', function(e) {
		e.preventDefault();
		$(this).parent().remove();
	})

	let counterFormKriteriaMin = 1;
	
	$("#btn-add-kriteria_min").click(function(e) {
		e.preventDefault();

		const formKriteriaMin = `
			<div class="row">
				<div class="col-md-6 col-sm-6  form-group has-feedback">
					<input data-rule-required="true" type="text" class="form-control has-feedback-left" name="kriteriaMinus_fav[]" required placeholder="Kriteria Pengurangan nilai ke-${counterFormKriteriaMin+1}">
					<span class="fa fa-at form-control-feedback left"></span>
				</div>
				<div class="col-md-4 col-sm-4  form-group has-feedback">
					<input data-rule-required="true" type="text" class="form-control has-feedback-left" id="nilaiMinus_fav1" name="nilaiMinus_fav[]" required placeholder="Nilai Min.">
					<span class="fa fa-minus form-control-feedback left"></span>
				</div>	
				
				<a href=""  class="btn btn-remove-kriteri-min btn-sm btn-outline-danger"><i class="fa fa-minus"></i>
				</a>
			</div>
		`;

		$(".contain-form-kriteria_min").append(formKriteriaMin);
		counterFormKriteriaMin++;

	});

	$(".contain-form-kriteria_min").on('click', '.btn-remove-kriteri-min', function(e) {
		e.preventDefault();
		$(this).parent().remove();
	});
	
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
