<table id="dataTables" class=" table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
 <thead>
  <tr>
    <th>No.</th>
    <th>Mata Lomba</th>
    <th>Golongan</th>
    <th>Satuan Terpisah</th>
    <th>Aksi</th>
  </tr>
</thead>
<tbody>

  <?php $i = 1; foreach($lomba as $l): ?>
  <tr>
    <td><?= $i; ?></td>
    <td><?= $l->mata_lomba; ?></td>
    <td><?= $l->tingkatan ?></td>
    <td><?= $l->satuan_terpisah == 1 ? "Ya" : "Tidak" ?></td>
    <td align="center">
      <a href="#" class="btn btn-sm btn-info kriteria-detail" onclick="detailKriteria('<?= $l->id_mata_lomba ?>')" data-toggle="tooltip" data-placement="top" title="Kriteria Penilaian"><span class="fa fa-toggle-down"></span></a>
      <a href="#" class="btn btn-sm btn-primary" onclick="updateKriteria('<?= $l->id_mata_lomba ?>')" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-edit"></span></a>
      <a href="#" class="btn btn-sm btn-danger" onclick="onDeleteLomba('<?= $l->id_mata_lomba ?>')" data-toggle="tooltip" data-placement="top" title="Hapus"><span class="fa fa-trash"></span></a>
    </td>
  </tr>
  <?php $i++; endforeach; ?>
</tbody>
</table>

<!-- Modal Detail -->
<div class="modal fade" id="kriteria-detail" tabindex="-1" role="dialog" aria-labelledby="detailKriteria" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailKriteria">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="ml-3 mr-3 modal-body">
        <div class="row"style="background-color: #f1f3f7">
          <div class="col-md-6 col-sm-6 lomba" >

          </div>
        </div>
        <hr>
        <h5>Kriteria Penilaian <span class="fa fa-trophy"></span></h5>
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Kriteria</th>
                  <th scope="col">Nilai Maksimum</th>
                  
                </tr>
              </thead>
              <tbody id="tbody">


              </tbody>
            </table>
          </div>
        </div>
        <hr>
        <h5>Kriteria Pengurangan Point <span class="glyphicon glyphicon-minus"></span></h5>
        <div class="row"style="background-color: #f1f3f7">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Kriteria Pengurangan</th>
                <th scope="col">Nilai Pengurangan</th>

              </tr>
            </thead>
            <tbody id="tbodymin">
            </tbody>
          </table>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<form id="form-edit-kriteria" method="POST">
  <div class="modal fade" id="kriteria-update" tabindex="-1" role="dialog" aria-labelledby="detailKriteria" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailKriteria">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="ml-3 mr-3 modal-body">
          <div class="row"style="background-color: #f1f3f7">
            <div class="col-md-12 col-sm-12 lomba-edit" >

            </div>
          </div>
          <hr>
          <h5>Kriteria Penilaian <span class="fa fa-trophy"></span></h5>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kriteria</th>
                    <th scope="col">Nilai Maksimum</th>
                    
                  </tr>
                </thead>
                <tbody class="tbody">


                </tbody>
              </table>
            </div>
          </div>
          <hr>
          <h5>Kriteria Pengurangan Point <span class="glyphicon glyphicon-minus"></span></h5>
          <div class="row"style="background-color: #f1f3f7">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Kriteria Pengurangan</th>
                  <th scope="col">Nilai Pengurangan</th>

                </tr>
              </thead>
              <tbody class="tbodymin">
              </tbody>
            </table>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </div>
    </div>
  </div>
</form>



<script>
  const dt = $("#dataTables").DataTable();
  const detailKriteria = async (id_mata_lomba) => {
    $("#kriteria-detail").modal("show");
    const fetchDataLomba = await $.getJSON(`<?= base_url("lomba/get_mata_lomba") ?>/${id_mata_lomba}`);
    const fetchDataKriteria = await $.getJSON(`<?= base_url("lomba/get_kriteria_penilaian") ?>/${id_mata_lomba}`);
    const fetchKriteriaMinus = await $.getJSON(`<?= base_url("lomba/get_kriteria_penilaian") ?>/${id_mata_lomba}/minus`);

    console.log({fetchDataLomba, fetchDataKriteria, fetchKriteriaMinus});

    let golongan = '';
    if (fetchDataLomba.tingkatan === "SMA") {
      golongan = "Penegak";
    } else if(fetchDataLomba.tingkatan === "SMP") {
      golongan ="Penggalang";
    } else {
      golongan = "Penggalang (SD)";
    }

    $(".modal-title").html(fetchDataLomba.mata_lomba);
    $(".lomba").html(`
     <table class="table table-borderless">
     <tr>
     <th scope="col">Golongan</th>
     <td scope="col">${golongan}</td>
     </tr>

     <tr>
     <th>Satuan Terpisah</th>
     <td>${fetchDataLomba.satuan_terpisah == 1 ? "Ya" : "Tidak" }</td>
     </tr>
     </table>
     `);

    let htmlTabel = ``;
    let i = 1;
    let totalNilai = 0;
    for(const data of fetchDataKriteria) {
      htmlTabel += `<tr><th>${i}</th><td>${data.kriteria}</td><td>${data.nilai_max}</td></tr>`;
      totalNilai += parseInt(data.nilai_max);
      i++;
    }
    $("#tbody").html(htmlTabel+`<tr><th colspan="2">Total Nilai</th><td>${totalNilai}</td></tr>`);

    let htmlTabelmin = ``;
    i = 1;
    for(const data of fetchKriteriaMinus) {
      htmlTabelmin = `<tr><th>${i}</th><td>${data.kriteria}</td><td>${data.nilai_max}</td></tr>`
    }
    $("#tbodymin").html(htmlTabelmin);
  }

  const updateKriteria = async (id_mata_lomba) => {
    $("#kriteria-update").modal("show");
    const fetchDataLomba = await $.getJSON(`<?= base_url("lomba/get_mata_lomba") ?>/${id_mata_lomba}`);
    const fetchDataKriteria = await $.getJSON(`<?= base_url("lomba/get_kriteria_penilaian") ?>/${id_mata_lomba}`);
    const fetchKriteriaMinus = await $.getJSON(`<?= base_url("lomba/get_kriteria_penilaian") ?>/${id_mata_lomba}/minus`);

    console.log({fetchDataLomba, fetchDataKriteria, fetchKriteriaMinus});
    const tingkatan = [
      {
        name : "Penegak",
        value : "SMA",
      },
      {
        name : "Penggalang",
        value : "SMP"
      },
      {
        name : "Penggalang (SD)",
        value : "SD"
      }
    ];

    let golongan = '';
    if (fetchDataLomba.tingkatan === "SMA") {
      golongan = "Penegak";
    } else if(fetchDataLomba.tingkatan === "SMP") {
      golongan ="Penggalang";
    } else {
      golongan = "Penggalang (SD)";
    }
    $(".modal-title").html("Edit Lomba "+fetchDataLomba.mata_lomba);
    $(".lomba-edit").html(`
      <input name="id_mata_lomba" type="hidden" value="${fetchDataLomba.id_mata_lomba}" />
      <table class="table table-borderless">
        <tr>
          <th scope="col">Mata Lomba</th>
          <td scope="col"><input class="form-control" name="edtMataLomba" value="${fetchDataLomba.mata_lomba}"  type="text" required ></td>
        </tr>
        <tr>
          <th scope="col">Golongan</th>
          <td scope="col">
            <select name="edtTingkatan" class="form-control">${tingkatan.map((data,i) => {
              return fetchDataLomba.tingkatan === data.value ? `<option value='${data.value}' selected>${data.name}</option>` : `<option value='${data.value}'>${data.name}</option>`
              })}
            </select>
          </td>
        </tr>
        <tr>
          <th>Satuan Terpisah</th>
          <td>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="editSatuan" type="radio" checked id="editSatuan_y" value="1">
              <label class="form-check-label" for="editSatuan_y">Ya</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="editSatuan" type="radio" id="editSatuan_t" value="0">
              <label class="form-check-label" for="editSatuan_t">Tidak</label>
            </div>
          </td>
        </tr>
      </table>
    `);

    let htmlTabel = ``;
    let i = 1;
    for(const data of fetchDataKriteria) {
      htmlTabel += `
      <tr>
        <th>${i}</th>
        <td><input class="form-control" type="text" name="editKriteria[]" required value="${data.kriteria}"></td>
        <td><input class="form-control" type="number" name="editNilaimax[]" required value="${data.nilai_max}"></td>
      </tr>`;
      i++;
    }

    $(".tbody").html(htmlTabel);

    let htmlTabelmin = ``;
    i = 1;
    for(const data of fetchKriteriaMinus) {
      htmlTabelmin = `
        <tr>
          <th>${i}</th>
          <td> <input class="form-control" type="text" name="editKriteriaMin[]" value="${data.kriteria}"></td>
          <td><input class="form-control" type="number" name="editNilaiMin[]" value="${data.nilai_max}"></td>
        </tr>`;
    }
    $(".tbodymin").html(htmlTabelmin);

  };

  const onDeleteLomba = async (id_mata_lomba) => {
    const alert = await swal({
      title: "Hapus Data Perlombaan ?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    });

    if (alert) {
      $.post(`<?= base_url('lomba/delete') ?>`,
      {
        id : id_mata_lomba
      },
      (data, status) => {
        console.log({data, status});
        if (status == "success") {
          document.location.href = "<?= base_url("lomba/penggalang"); ?>"
        }
      });
    }

  };

$(document).ready(function() {

  $(".kriteria-detail").click(function(event) {
    event.preventDefault();  
  });
  const onSubmitHandler = async (a, e) => {
    e.preventDefault();
    const reqUpdate = await $.ajax({
      url : `<?= base_url('lomba/update_lomba'); ?>`,
      type : "POST",
      dataType : "JSON",
      data : $("form#form-edit-kriteria").serialize()
    });
    if (reqUpdate) {
      document.location.href="<?= base_url("lomba/penggalang"); ?>";
    }
  };

  $("form#form-edit-kriteria").validate({
    errorElement : "span",
    submitHandler : onSubmitHandler,
  });
});

</script>