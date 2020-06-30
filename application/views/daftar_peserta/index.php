
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <form action="" method="POST" id="filter-peserta">
          <div class="form-group row">
            <div class="col-sm-6 col-md-6 mt-2">
              <select name="filterGolongan" class="custom-select">
                <option value="null">Golongan</option>
                <option value="SMA">Penegak</option>
                <option value="SMP">Penggalang</option>
                <option value="SD">Penggalang (SD)</option>
              </select>
            </div>
            <div class="col-sm-2 col-md-2 mt-2">
              <button class="btn-sm btn btn-primary"> <i class="fa fa-filter"></i> Filter</button>
              <button class="btn-sm btn btn-secondary"><i class="glyphicon glyphicon-repeat"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
<table class="datatable table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
 <thead>
  <tr>
    <th>No.</th>
    <th>Nama Sekolah</th>
    <th>No Urut</th>
    <th>Golongan</th>
    <th>Jenis</th>
    <th>Tanggal Registrasi</th>
    <th>Aksi</th>
    
  </tr>
</thead>
<tbody class="tbody-peserta">
  <?php
  $tingkat = '';
  $i = 1;
  foreach($peserta as $p) :
   if ($p->tingkatan == "SMA") {
    $tingkatan = "Penegak";
  } elseif ($p->tingkatan == "SMP") {
    $tingkatan = "Penggalang (SMP)";
  } else {
    $tingkatan = "Penggalang (SD)";
  }
  
  if($p->jenis == "LP") {
    $jenis ="Putra & Putri";
  } elseif($p->jenis == "L") {
    $jenis = "Putra";
  } else {
    $jenis = "Putri";
  }

  ?>
  <tr>
    <td><?= $i; ?></td>
    <td> <?= $p->nama_pangkalan ?></td>
    <td><?= $p->nomor_peserta ?></td>
    <td><?= $tingkatan ?></td>
    <td><?= $jenis; ?></td>
    <td><?= $p->tgl_regist ?></td>
    <td>
      <div class="btn-actions">
        <a href="" onclick="modalEdit('<?= $p->id_daftar_peserta; ?>')" class="btn-sm btn btn-success btn-edit-peserta"  data-toggle="modal" id="<?= $p->id_daftar_peserta; ?>"><i class="fa fa-edit"></i></a>
        <a href="#" onclick="sweatAlert('<?= $p->id_daftar_peserta; ?>')" class="btn-sm btn btn-danger" id="<?= $p->id_daftar_peserta; ?>"><i class="fa fa-trash"></i></a>
      </div>
    </td>
  </tr>
  <?php 
  $i++;
endforeach;
?>

</tbody>
</table>

<!-- Modal Add -->
<div class="modal fade" id="addModalPeserta" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Tambah Peserta Lomba</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="add-peserta">
          <div class="form-group row">
            <label for="no_urut" class="col-sm-2 col-form-label">No. Urut</label>
            <div class="col-sm-10">
              <input type="text" name="no_urut" class="form-control">
            </div>
          </div>
          <div class="form-group row">
            <label for="sekolah" class="col-sm-2 col-form-label">Sekolah</label>
            <div class="col-sm-10">
              <input type="text" required name="sekolah" class="form-control">
            </div>
          </div>
          <div class="form-group row">
            <label for="tingkat" class="col-sm-2 col-form-label">Golongan</label>
            <div class="col-sm-10">
              <select required name="tingkatan" class="form-control form-control-sm">
                <option value="" >== Pilih Golongan ==</option>
                <option value="SMA">Penegak</option>
                <option value="SMP">Penggalang</option>
                <option value="SD">Penggalang (SD)</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
           <label class="col-sm-2 col-form-label">Tanggal Pendaftaran</label>
           <div class="col-sm-10">
             <input class="form-control date-picker" type="text" name="date_regist" value="<?= date('yy-m-d') ?>">
           </div>
           
         </div>
         <div class="form-group ml-2 row genre">
          <div class="custom-control custom-radio custom-control-inline">
            <input id="jk_lp" class="custom-control-input" type="radio" name="jenis" checked value="LP">
            <label for="jk_lp" class="custom-control-label">Putra & Putri</label>
            
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input id="jk_l" class="custom-control-input" type="radio" name="jenis" value="L">
            <label for="jk_l" class="custom-control-label">Putra</label>
            
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input id="jk_p" class="custom-control-input" type="radio" name="jenis" value="P">
            <label for="jk_p" class="custom-control-label">Putri</label>
          </div>
        </div>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editPesertaModal" tabindex="-1" role="dialog" aria-labelled aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Update Peserta Lomba</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update-peserta">
          <input type="hidden" name="id_daftar_peserta" value="">
          <div class="form-group row">
            <label for="no_urut" class="col-sm-2 col-form-label">No. Urut</label>
            <div class="col-sm-10">
              <input type="text" name="no_urut" class="form-control" id="no_urut">
            </div>
          </div>
          <div class="form-group row">
            <label for="sekolah" class="col-sm-2 col-form-label">Sekolah</label>
            <div class="col-sm-10">
              <input type="text" name="sekolah" class="form-control" id="sekolah">
            </div>
          </div>
          <div class="form-group row">
            <label for="tingkat" class="col-sm-2 col-form-label">Tingkat</label>
            <div class="col-sm-10">
              <select name="tingkatan" class="form-control form-control-sm">

              </select>
            </div>
          </div>
          <div class="form-group ml-2 row tiers">
            <div class="custom-control custom-radio custom-control-inline">
              <input id="jk_lp" class="custom-control-input" type="radio" name="jenis" value="LP">
              <label for="jk_lp" class="custom-control-label">Putra & Putri</label>
              
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input id="jk_l" class="custom-control-input" type="radio" name="jenis" value="L">
              <label for="jk_l" class="custom-control-label">Putra</label>
              
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input id="jk_p" class="custom-control-input" type="radio" name="jenis" value="P">
              <label for="jk_p" class="custom-control-label">Putri</label>
            </div>
           </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

</script>
<script type="text/javascript">
  $(document).ready(() => {
   $(".dt-buttons").removeClass("btn-group");
   $(".add-peserta").click(function(){
    $("#addModalPeserta").modal("show");
  });

 });
  const sesiLevel = `<?= $this->session->userdata('level'); ?>`;
  let btnOptions = [];
  sesiLevel !== "admin" ? $(".btn-actions").empty() : "";
  if (sesiLevel === "admin") {
    btnOptions.push(
    {
      text : "<span class='fa fa-plus-square'> Tambah</span>",
      className : "btn btn-sm btn-primary add-peserta"
    }
    );
  }


  const dt = $(".datatable").DataTable({
    dom : '<"row mt-2"<"col-sm-6 col-md-6 float-left"f><"col-sm-6 col-md-6 float-right"B>>rtip',
    buttons : btnOptions
  });


  $("form#add-peserta").submit(function(e) {
    e.preventDefault();
    const dataPeserta = $(this).serialize();
    
    $.ajax({
      url : `<?= base_url('peserta/add') ?>`,
      type : "POST",
      dataType : "JSON",
      data : dataPeserta,
      success : (result) => {
        window.location.href="<?= base_url('peserta') ?>";
      },
      error : (error) => {
        console.log(error);
      }
    });
  }); 

  function modalEdit(idPeserta) {
    $("#editPesertaModal").modal("show");
    let tingkatan = ["SD","SMP","SMA"];
    let optionTingkatan = '<option>Pilih Tingkatan</option>';
    let kindOfTiers = ["LP","L","P"];
    let optionSex = '';

    $.getJSON(`<?= base_url(); ?>/peserta/get_peserta_by_id/${idPeserta}`,(result)=>{
      $("input[name='no_urut']").val(result.nomor_peserta);
      $("input[name='sekolah']").val(result.nama_pangkalan);
      $("input[name='id_daftar_peserta']").val(result.id_daftar_peserta);
      let tingkat = '';
      for(const tiers of tingkatan) {
        if (tiers == "SMA") { 
          tingkat = "Penegak"
        } else if(tiers == "SMP") {
          tingkat = "Penggalang (SMP)";
        } else {
          tingkat = "Penggalang (SD)";
        }
        if (tiers == result.tingkatan) {
          optionTingkatan += `
          <option value=${tiers} selected>${tingkat}</option>                     
          `;
        } else {
          optionTingkatan += `
          <option value=${tiers}>${tingkat}</option>                     
          `;
        }
      }

      $(`input[value=${result.jenis}]`).attr("checked", true);

      $("select[name='tingkatan']").html(optionTingkatan);

   });
  }

  function sweatAlert(idPeserta) {
   swal({
    title: "Hapus Data Peserta?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
   .then((willDelete) => {
    if (willDelete) {
      $.ajax({
        url : `<?= base_url("peserta/delete/") ?>${idPeserta}`,
        type : "POST",
        dataType : "JSON",
        success : (result) => {
          window.location.href="<?=  base_url("peserta"); ?>";
        },
        error : (err) => {
          console.log(err);
        }
      });
      
    }
  });
 }




 
</script>
