<!DOCTYPE html>
<html>
<head>
	<title>PALADIRGAWA</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>src/assets/myStyle.css">
	<!-- Bootstrap -->
    <link href="<?= base_url(); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
    <link href="<?= base_url(); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Signika:400,700&display=swap" rel="stylesheet">
     <!-- PNotify -->
    <link href="<?= base_url(); ?>vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?= base_url(); ?>vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?= base_url(); ?>vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="header">
			<h3>SELAMAT DATANG</h3>
			
			<hr>
		</div>
		

		<div class="logo">
			<img src="<?= base_url("src/assets/img/pdgw.jpg") ?>">
		</div>
		<div align="center" class="alert alert-countdown alert-info alert-dismissible mt-3 mb-3" role="alert">
			<div id="event-title">
				
			</div>
			
			<div class="countdown">
				
			</div>
      	
      </div>
		<div class="content">
			<div class="box">
				<a href="#" class="btn btn-set-sesi"  >
					<div class="content-title">
						<i class="icon fa fa-cogs"></i>
						<span>Set Sesi Lomba</span>
					</div>
				</a>
			</div>
			<div class="box2">
				<a href="#" class="btn" id="sipenda_action">
					<div class="content-title">
						<i class="icon fa fa-user"></i>
						<span>ADMIN SIPENDA</span>
					</div>
				</a>

			</div>

			<div class="box3">
				<a href="" class="btn" >
					<div class="content-title">
						<i class="icon fa fa-users"></i>
						<span>ADMIN PALADIRGAWA</span>
					</div>
				</a>

			</div>

			<div class="box4">
				<a href="" class="btn" >
					<div class="content-title">
						<i class="icon fa fa-sign-out"></i>
						<span>LOGOUT</span>
					</div>
				</a>

			</div>
			
		</div>
	</div>
</body>
</html>


<script src="<?= base_url(); ?>vendors/jquery/dist/jquery.min.js"></script>
<script src= 
"https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" > 
    </script> 
<!-- Bootstrap -->
<script src="<?= base_url(); ?>vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
 <!-- PNotify -->
<script src="<?= base_url(); ?>vendors/pnotify/dist/pnotify.js"></script>
<script src="<?= base_url(); ?>vendors/pnotify/dist/pnotify.buttons.js"></script>
<script src="<?= base_url(); ?>vendors/pnotify/dist/pnotify.nonblock.js"></script>
<script type="text/javascript">
$(document).ready(()=>{
	$(".btn-set-sesi").on("click", (e)=>{
		e.preventDefault();
		$("#set").modal("show");
	});
	let optionSesi = '<option>Pilih Sesi</option>';
	$.getJSON(`<?= base_url('main/get_sesi'); ?>`, (res)=>{	
		res.forEach((data)=>{
			optionSesi += `<option value='${data.id_sesi}'>${data.judul_kegiatan}</option>`;

		});
		$('select[name="chose_sesi"]').html(optionSesi);
		const data = res.find(data => data.status_sesi == 1);

		$("#nonaktif-sesi-btn").hide();
		$("#section-2").hide();

		
		if (data != null) {

			$(".alert-sesi").html(`
				<div class="alert alert-info" role="alert">
				  <h5 align="center">Sesi Lomba Sedang Aktif</h5>
				</div>`);
		
			$("#event-title").html(`<h3>${data.judul_kegiatan} </h3>`);
			$("#nonaktif-sesi-btn").show();
			$("#add-new-sesi-btn").hide();
			$("#section-1").hide();
			$("#section-").show();
			$("#nonaktif-sesi-btn").click((e)=>{
				e.preventDefault();
				if(confirm("Yakin ?")){
					$.ajax({
						url : `<?= base_url('main/nonaktif_sesi_lomba') ?>`,
						dataType : 'json',
						type : 'POST',
						data : {id_sesi : data.id_sesi},
						success : (res) => {console.log(res); window.location.href='<?= base_url(); ?>'},
						error : (err) => {console.log(err)}
					})
				}
			});

			$("select.form-control, input.form-control").attr("readOnly");
			$(".save-sesi")
			.attr("disabled",true)
			.removeClass("btn-primary")
			.addClass("btn-secondary");

			var x = setInterval(()=>{
			var dateEnd = new Date(data.tgl_berakhir).getTime();
			let dateNow = new Date().getTime();
			let distance = dateEnd - dateNow;

			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			$(".countdown").html(`<strong>${days} Hari : ${hours} Jam : ${minutes} Menit : ${seconds} Detik</strong>`);
			if (distance < 0) {
			    clearInterval(x);
			   
			    $.ajax({
			    	url : `<?= base_url('main/nonaktif_sesi_lomba') ?>`,
			    	type : "POST",
			    	data : {id_sesi : data.id_sesi},
			    	dataType : "json",
			    	success : () => { console.log("ok"); },
			    	error : (err) => {console.log(err); }
			    });
			 }
	
			}, 1000);


			$("#sipenda_action").click((e)=>{
				e.preventDefault();
				window.location.href=`<?= base_url("home"); ?>`
				
			});
		} else {
			$(".date_picker" ).datepicker({ 
		    	dateFormat: 'dd-mm-yy', 
		  	});
		  	$(".alert").removeClass("alert-info").addClass("alert-warning");
			$(".alert-countdown").html(`Tidak ada sesi lomba yang sedang berlangsung`);
			$("#sipenda_action").click((e)=>{

			e.preventDefault();
			
			new PNotify({
	            title: 'Akses ditolak',
	            text: 'Tidak ada sesi yang sedang berlangsung',
	            styling: 'bootstrap3'
	        });
		});
		}
		
	});


	$(".next-set").hide();

	$("#chose_sesi").change(()=>{
		$(".next-set").show(800);
	});

	$(".add-new-sesi").click((e)=>{
		$("#section-2").show(500);
		$("#section-1").hide();
		e.preventDefault();
		$(".add-new-sesi").removeClass('btn-success').addClass('btn-secondary').attr('disabled',true);
		$('#save').addClass("save-sesi-new").removeClass("save-sesi").attr("newSave", true);
	});

	
	$('.cancel-set').click((e)=>{
		e.preventDefault();
		window.location.href='<?= base_url(); ?>';
	});

	
	const btnSave = $("#save");
	

	btnSave.click((e)=>{
		e.preventDefault();
		let isNewSave = $("#save").attr("newSave");
		let data;
		if (isNewSave != "false") {
			
			data = {
				title : $('input[name="judul"]').val(),
				tema : $('input[name="tema"]').val(),
				tgl_berakhir : $('input[name="tgl_berakhir"]').val(),
				is_new_sesi : true
			};
			
		   $.ajax({
		   	url : `<?= base_url() ?>main/set_sesi_lomba`,
		   	type : 'POST',
		   	dataType : 'json',
		   	async : true,
		   	data : data,
		   	success : (res)=>{
		   		$("#set").modal("hide");
		   		window.location.href = '<?= base_url(); ?>'
		   		console.log(res);
		   	},
		   	error : (err) => {
		   		console.log(err);
		   	}
		   });

		} else {
			data = {
				id_sesi : $("select[name='chose_sesi']").val(),
				tgl_berakhir : $("input[name='tgl_berakhir1']").val(),
				is_new_sesi : false
			};
			  $.ajax({
				  	url : `<?= base_url() ?>main/set_sesi_lomba`,
				  	type : 'POST',
				  	dataType : 'json',
				  	async : true,
				  	data : data,
				  	success : (res)=>{
				  		$("#set").modal("hide");
				  		window.location.href='<?= base_url(); ?>';
				  	},
				  	error : (err) => {
				  		console.log(err);
				  	}
			  });
		}
		
	});

	
});


	

</script>


<div class="modal fade" id="set" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Set Sesi Lomba</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			
		  	<form id="set_sesi">
		  		<div class="alert-sesi"></div>
			 	
					<button id="add-new-sesi-btn" class="mb-5 btn btn-success add-new-sesi">Tambah Sesi baru</button>
					<button id="nonaktif-sesi-btn" class="mb-5 btn btn-warning">Nonaktifkan Sesi</button>
					
					
				<div id="section-1">
					<div class="form-group">
						<label><h4>Pilih Sesi Lomba</h4></label>
						<select class="form-control" name="chose_sesi" id="chose_sesi">

						</select>
					</div>
					<div class="next-set">
				   	
				   	<div class="form-group">
				   		<label for="tgl_berakhir1">Tanggal Berakhir</label>
				   		<input type="text" class="form-control date_picker" name="tgl_berakhir1" id="tgl_berakhir1">
				   	</div>
					</div>
					
				</div>

				<div id="section-2">
					<div class="form-group">
		  			
						<label for="Judul">Judul</label>
					   	<input type="text" class="form-control"  name="judul" id="Judul" placeholder="Judul Lomba">
			  	 	</div>

				  	<div  class="form-group">
				  	 	<label for="tema">Tema</label>
				    	<input type="text" class="form-control"  name="tema" id="tema" placeholder="Tema Lomba">
				  	</div>
			   	
			   	<div class="form-group">
			   		<label for="tgl_berakhir">Tanggal Berakhir</label>
			   		<input type="text" class="form-control date_picker" name="tgl_berakhir" id="tgl_berakhir">
			   	</div>
	        		
				</div>
				<hr>
				<button newSave="false" id="save" type="submit" class="btn btn-primary save-sesi">Simpan</button>

			  	<button   type="submit" class="btn btn-danger cancel-set">Batal</button>
				
			</form>
		  
		  
		 <!--  <p><a href="#" class="tooltip-test" title="Tooltip">This link</a> and <a href="#" class="tooltip-test" title="Tooltip">that link</a> have tooltips on hover.</p> -->
		</div>
     
    </div>
  </div>
</div>

