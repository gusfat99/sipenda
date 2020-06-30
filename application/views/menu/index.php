<table id="dataTables" class="table-hover table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
 <thead>
  <tr>
    <th>No.</th>
    <th>Mata Lomba</th>
    <th>Golongan</th>
    <th>Satuan Terpisah</th>
    <th>Akses Oleh Juri</th>
    <th>Status</th>
  </tr>
</thead>
<tbody>

  <?php


  $i = 1; foreach($lomba as $l): 
  $status = "Nonaktif";
  $button = "btn-danger";
  $title ="Aktifkan";
  $icon ="fa fa-ban";
  $action = 0;
  foreach($menu_lomba as $ml) {
    if ($ml->id_r_mata_lomba == $l->id_mata_lomba and $ml->is_active != 0) {
      $status = "Aktif";
      $button = "btn-success";
      $title ="Nonaktifkan";
      $icon ="fa fa-check";
      $action = $ml->is_active;
    } elseif ($ml->id_r_mata_lomba == $l->id_mata_lomba) {
      $action = "update";
    }
  }

  ?>
  <tr data-id="<?= $l->id_mata_lomba; ?>" >
    <td><?= $i; ?></td>
    <td><?= $l->mata_lomba; ?></td>
    <td><?= $l->tingkatan ?></td>
    <td><?= $l->satuan_terpisah == 1 ? "Ya" : "Tidak" ?></td>
    <td>
      <?php foreach($juriLomba as $row): ?>
        <?php if($row->id_r_mata_lomba == $l->id_mata_lomba){
          if ($row->golongan_kelamin != 'semua_jenis') {
            echo $row->nama." (".$row->golongan_kelamin.") <br>";
          } else {
           echo $row->nama."<br>";
         }
         continue;
       } ?>
     <?php endforeach; ?>
   </td>
   <td align="center">
    <a href="#" class="btn btn-sm <?= $button ?> btn-actions" data-id="<?= $l->id_mata_lomba; ?>" data-toggle="tooltip" data-placement="top" data-title="<?= $l->mata_lomba; ?>" action="<?= $action; ?>" title="<?= $title; ?>"><span class="<?= $icon; ?>"> <?= $status; ?></span></a>
  </td>
</tr>
<?php $i++; endforeach; ?>
</tbody>
</table>

<!-- Set Menu Modal -->
<div class="modal fade" id="setMenuModal" tabindex="-1" role="dialog" aria-labelledby="setMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="formSetMenu">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="setMenuModalLabel">Set Menu</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <fieldset class="form-group">
            <div class="row">
              <input type="hidden" name="id_mata_lomba">
              <legend class="col-form-label col-sm-3 pt-0">Putra - putri </legend>
              <div class="col-sm-9">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="untuk2Golongan" id="untuk2Golongan1" value="1">
                  <label class="form-check-label" for="untuk2Golongan1">
                    Ya
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="untuk2Golongan" id="untuk2Golongan2" value="0">
                  <label class="form-check-label" for="untuk2Golongan2">
                   Tidak
                 </label>
               </div>
             </div>
           </div>
         </fieldset>
         <div class="form-group changeJuri1">
          <select class="form-control" name="juri1">
            <option>Pilih Juri</option>
            <?php foreach($juri as $row): ?>
              <option value="<?= $row->id_user; ?>" ><?= $row->nama; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group changeJuri2">
          <select class="form-control" name="juri2">
            <option>Pilih Juri Putri</option>
            <?php foreach($juri as $row): ?>
              <option value="<?= $row->id_user; ?>" ><?= $row->nama; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <a class="btn btn-secondary" href="<?= base_url('set_menu_penilaian') ?>">Batal</a>
        <button type="submit" class="btn btn-primary save">Simpan</button>
      </div>
    </div>
  </form> 
</div>
</div>



<script type="text/javascript">
  const controller = `<?= $this->uri->segment(1); ?>`;
  const formSetMenu = $("form#formSetMenu");

  const onSubmitHandler = async(b,event) => {
    event.preventDefault();
    const lombaId = $("input[name=id_mata_lomba]").val();
    if ($('.save').attr('is_update') === 'true') {
      let id_juri;
      const fetchDataJuri = await $.getJSON(`<?= base_url(); ?>/${controller}/fetchDataJuri/${lombaId}`);
      if (fetchDataJuri.count > 1) {
        id_juri = `${fetchDataJuri.result[0].id_juri}/${fetchDataJuri.result[1].id_juri}`;
      } else {
        id_juri = fetchDataJuri.result[0].id_juri;
      }
      const update = await $.ajax({
        url : `<?= base_url() ?>${controller}/updateSetMenu/${id_juri}`,
        data : formSetMenu.serialize(),
        dataType : 'JSON',
        type : 'POST',
      });
      if (update) {
        return document.location.href=`<?= base_url(); ?>${controller}`;  
      }
      
    }
    const insert = await $.ajax({
      url : `<?= base_url(); ?>${controller}/setMenu`,
      data : formSetMenu.serialize(),
      type : 'POST',
      dataType : 'JSON'
    });

    if (insert) {
      return document.location.href=`<?= base_url(); ?>${controller}`;
    }
    
  };

  $(".dt-buttons").removeClass("btn-group");
  const dt =  $("#dataTables").DataTable({
    dom : '<"row"<"col-sm-6 col-md-6 float-left"f><"col-sm-2 col-md-2 offset-md-4 offset-sm-4"B>>rtip',
    buttons : [
    {
      text : "Set",
      className : "btn btn-sm btn-primary set-menu"
    }
    ],
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

  $(".set-menu").click(async (e) =>{
    e.preventDefault();
    $(".save").attr("is_update",false);
    const lombaId = $("tr.selected").data("id"); 
    const isEdit = $("tr.selected td:eq(4)").text().trim();

    if (!lombaId) {
      swal({
        title: "Silahkan pilih menu perlombaan!",  
      });
      return;
    }
    if (parseInt($("tr.selected td a.btn-actions").attr('action')) === 0) {
      swal({
        title: "Tidak bisa set menu lomba yang belum di aktifkan"
      });
      return;
    }
    const title = $("tr.selected td:eq(1)").text();
    $(".modal-title").html("Pilih Juri untuk Mata Lomba "+title);
    $("input[name=id_mata_lomba]").val(lombaId);
    if(isEdit !== "") {
      $(".save").attr("is_update",true);
      $(".changeJuri2").hide();
      $(".changeJuri1").hide();
      const fetchDataJuri = await $.getJSON(`<?= base_url(); ?>/${controller}/fetchDataJuri/${lombaId}`);
      console.log(fetchDataJuri);
      const idUserJuri1 = fetchDataJuri.result[0].id_user;
      if (fetchDataJuri.count > 1) {
        const idUserJuri2 = fetchDataJuri.result[1].id_user;
        const id_juri = [fetchDataJuri.result[0].id_juri, fetchDataJuri.result[1].id_juri];
        $(".changeJuri2").show();
        $(".changeJuri1").show();
        $("select[name=juri1] option").removeAttr("selected").filter(`[value=${idUserJuri1}]`).attr("selected", true);
        $("select[name=juri2] option").removeAttr("selected").filter(`[value=${idUserJuri2}]`).attr("selected", true);
        $("input[type=radio]#untuk2Golongan2").attr('checked', true);
        
      } else {
        $("select[name=juri1] option").removeAttr("selected").filter(`[value=${idUserJuri1}]`).attr("selected", true);
        $(".changeJuri1").show();
        $("input[type=radio]#untuk2Golongan1").attr('checked', true);
      }
      
      $("#setMenuModal").modal("show");
    } else {
      $("#setMenuModal").modal("show");
    }
    
  });

  $(".btn-actions").click(async function(e) {
    e.preventDefault();
    const id = $(this).data("id");
    const title = $(this).data("title");
    const action = $(this).attr("action");
    console.log(action);

    let setAct;

    if (parseInt( action) === 0) {
      setAct = await $.ajax({
        url : `<?= base_url() ?>/${controller}/add`,
        data : {
          id : id,
          title : title
        },
        type : "POST",
        dataType : "JSON",
      });
      $(this).attr("action", "nonaktif");
    } else {
     setAct = await $.ajax({
      url : `<?= base_url() ?>/${controller}/delete`,
      data : {
        id : id,
        title : title
      },
      type : "POST",
      dataType : "JSON",
    });
     $(this).attr("action", "aktif");
   }

   if(setAct) {
    document.location.href= "<?= base_url() ?>"+controller;
  }  
});


  $(".changeJuri2").hide();
  $(".changeJuri1").hide();

  $(":radio").on('change',function(){
   if(parseInt($(this).val())){
     $("select[name=juri1] option:eq(0)").text("Pilih Juri");
     $(".changeJuri1").show(); 
     $(".changeJuri2").hide();   
   } else {
    $("select[name=juri1] option:eq(0)").text("Pilih Juri Putra");
    $(".changeJuri1").show();
    $(".changeJuri2").show();
  }
});


  formSetMenu.validate({
    errorElement : "span",
    rules : {
      untuk2Golongan : {
        required : true
      }
    },
    submitHandler : onSubmitHandler
  });
</script>