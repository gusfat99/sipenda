<?php 
	$lombaId = $this->uri->segment(3);
	$selectJenis = $this->input->get('select');
	$jenis = $this->input->get('jenis');
	if ($jenis == 'putra') {
		$getUrl = "?jenis=putra";
	} else if ($jenis == 'putri') {
		$getUrl = "?jenis=putri";
	} else {
		$selectJenis == "putra" ? $valueSelectJenis = "putri" : $valueSelectJenis = "putra";
		$getUrl = "?jenis=semua_jenis&&select=".$valueSelectJenis;
	}
 ?>
<ul class="nav nav-tabs">
	<li class="nav-item pa">
		<a class="nav-link <?= $selectJenis == 'putra' ?  'active' : '' ?>" href="<?= base_url('penilaian/list/').$lombaId; echo $getUrl;?>"><h5>Putra</h5></a>
	</li>
	<li class="nav-item pi">
		<a class="nav-link <?= $selectJenis == 'putri' ?  'active' : '' ?>" href="<?= base_url('penilaian/list/').$lombaId; echo $getUrl; ?>"><h5>Putri</h5></a>
	</li>
</ul>
<br>
<table id="table-penilaian-peserta" class="table table-hover table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>ID</th>
			<th>No Peserta</th>
			<th>Pangkalan</th>
			<th>Golongan</th>
			<th>Jenis</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		$("div.dt-buttons").removeClass("btn-group");
	});
	const jenis = `<?= $this->input->get('jenis') ;?>`
	let jenisGol = '';
	if (jenis === 'putra') {
		$("ul li.pi").remove();
		jenisGol = jenis;
	} else if(jenis === 'putri') {
		$("ul li.pa").remove();
		jenisGol = jenis;
	} else {
		jenisGol = `<?= $this->input->get('select'); ?>`
	}

	const tingkatan = `<?= $tingkatan; ?>`;
	const controller = `<?= $this->uri->segment(1); ?>`;
	const userLevel = `<?= $this->session->userdata('level'); ?>`;

	let buttonOptions = [];

	if (userLevel !== 'juri') {
		buttonOptions.push(
		{
			text : "<span class='glyphicon glyphicon-eye-open'> Lihat</span>",
			className : "btn btn-sm btn-success lihat-nilai"
		}
		);
	} else {
		buttonOptions.push(
		{
			text : "<span class='fa fa-pencil-square'> Nlai</span>",
			className : "btn btn-sm btn-primary nilai-peserta"
		}, 
		{
			text : "<span class='glyphicon glyphicon-eye-open'> Lihat</span>",
			className : "btn btn-sm btn-success lihat-nilai"
		},
		{
			text : "<span class='fa fa-rotate-right'> Ulangi</span>",
			className : "btn btn-sm btn-danger repeat-nilait"
		},
		{
			text : "<span class='fa fa-check'> Validasi</span>",
			className : "btn btn-sm btn-info validasi-nilai"
		}
		);
	}


	const dt = $("#table-penilaian-peserta").DataTable({
		dom : '<"row"<"col-sm-6 col-md-6 float-left"f><"col-sm-6 col-md-6 float-right"B>>rtip',
		processing: true, 
		serverSide: true, 
		order: [],
		scrollY: "250px",
		scrollCollapse: true,
		ajax : {
			url : `<?= base_url(); ?>${controller}/get_data_peserta/${tingkatan}/${jenisGol}`,
			type : "POST"
		},
		columnDefs : [{targets: [ 0 ],orderable: false,}],
		buttons : buttonOptions,
		rowCallback : (row, data, iDisplayIndex) => {
			const att = document.createAttribute("id");
			att.value = data[0];
			row.setAttributeNode(att);
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
</script>

