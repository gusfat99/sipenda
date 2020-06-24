<?php $countKriteria = abs($this->input->get('count', true));
$tingkatan = $this->input->get('input', true);
$minKriteria = $this->input->get('minus', true);
?>
<div class="row">
	<div class="offset-md-1 col-md-10">
		<form method="post" id="form-kriteria">
			<div class="x_panel">
				<div id="step-2">
					<div class="x_title">
						<h2 id="title-lomba">Kriteria Penilaian Lomba <?= $mata_lomba->mata_lomba ?></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="form-label-left input_mask">
							<input type="hidden" name="id_mata_lomba" value="<?= $mata_lomba->id_mata_lomba ?>">
							<?php for($i = 0; $i<$countKriteria; $i++):?>
								<div class="form-group row has-feedback kriteria-penilaian">
									<div class="col-md-6 col-sm-6 ">
										<input type="text" class="form-control has-feedback-left" value="<?= $kriteria ? $kriteria[$i] : "" ;?>" name="kriteria<?= $i ?>" placeholder="Input Kriteria ke-<?= $i+1; ?>" required="required">
										<span class="fa fa-at form-control-feedback left"></span>
									</div>
									<div class="col-md-3 col-sm-3">
										<input type="number" class="form-control has-feedback-left" name="nilaimax<?= $i; ?>" placeholder="Niai Maks." requ	required="required">
										<span class="fa fa-edit form-control-feedback left" ></span>
									</div>
								</div>
							<?php endfor; ?>
						</div>
					</div>
				</div>
				<div id="step-3">
					<div class="x_title">
						<h2 id="title-lomba">Kriteria Pengurangan Point Lomba <?= $mata_lomba->mata_lomba ?></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<input type="hidden" name="id_mata_lomba" value="<?= $mata_lomba->id_mata_lomba ?>">
						<input type="hidden" name="identifyIsLct" value="<?= $kriteria ? true : false ?>">
						<div class="form-label-left input_mask">
							<?php for($i = 0; $i<$minKriteria; $i++):?>
								<div class="form-group row has-feedback kriteria-penilaian">
									<div class="col-md-6 col-sm-6 ">
										<input type="text" class="form-control has-feedback-left" value="<?= $kriteria ? $kriteria[2] : ""; ?>" name="kriteriamin<?= $i ?>" placeholder="Kriteria Penguran Point ke-<?= $i+1; ?>" required="required">
										<span class="glyphicon glyphicon-minus form-control-feedback left"></span>
									</div>
									<div class="col-md-3 col-sm-3">
										<input type="number" class="form-control has-feedback-left" name="nilaimin<?= $i; ?>" placeholder="Minus" required="required">
										<span class="fa fa-edit form-control-feedback left" ></span>
									</div>
								</div>
							<?php endfor; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="ln_solid"></div>
			<div class="form-group row">
				<div class="col-md-8 col-sm-8">
					<button type="submit" class="btn simpan btn-success">Simpan</button>
				</div>
			</div>	
		</form>
	</div>
</div>

<script>

	const onSubmitForm = (e,b) => {
		const data = $("form#form-kriteria").serialize();
		const insertId = '<?= $mata_lomba->id_mata_lomba ?>'
		const countKriteria = `<?= $countKriteria ?>`;
		const tingkatan = '<?= $tingkatan ?>';
		const minKriteria = '<?= $minKriteria ?>';
		let golongan = '';
		let isLct = $("input[name=identifyIsLct]").val();


		if (tingkatan == "SMA") {
			golongan = "penegak";
		} else if (tingkatan == "SMP") {
			golongan = "penggalang";
		} else {
			golongan ="penggalang_sd";
		}
		b.preventDefault();
		$.ajax({
			url : `<?= base_url("lomba/add_kriteria_penilaian"); ?>/${countKriteria}/${insertId}/${minKriteria}?isLct=${isLct}`,
			type : "POST",
			dataType : "json",
			data : data,
			async : true,
			success : (rest) => {
				console.log(rest);
				document.location.href = `<?= base_url('lomba/') ?>${golongan}`;
			},
			error : (err) => console.log(err)
		});	
	}

	$(document).ready(function(argument) {
		$("form#form-kriteria").validate({
			errorElement : "span",
			submitHandler : onSubmitForm,
		});
	})
</script>
