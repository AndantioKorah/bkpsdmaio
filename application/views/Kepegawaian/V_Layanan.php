<div class="container-fluid p-0">

<div class="row">
    <div class="col-12">
        
        <div class="card">
       
            <div class="card-body">
            <h1 class="h3 mb-3">Usul Layanan</h1>

            <form>

<div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Nomor Usul</label>
    <input type="text" class="form-control" id="">
  </div>

  <div class="mb-3">
    <label for="" class="form-label ">Tanggal Usul</label>
    <input type="text" class="form-control datepicker" id="" value="<?= date('Y-m-d');?>">
  </div>


  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Jenis Layanan</label>
    <select  class="form-control select2" data-dropdown-css-class="select2-navy" name="jenis_pengangkatan" id="jenis_pengangkatan" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_layanan){ foreach($jenis_layanan as $r){ ?>
                        <option value="<?=$r['kode']?>"><?=$r['nama']?></option>
                    <?php } } ?>
</select>
  </div>

  <div class="form-group">
    <label>File Pengantar</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file" name="file"   />
  </div>

 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>


<!-- tutup body q -->
</div>
</div>
</div>
</div>

<!-- monitor layanan  -->
<div class="row">
    <div class="col-12">  
        <div class="card">
            <div class="card-body">
            <h1 class="h3 mb-3">Monitor Usul Layanan</h1>
            <div di="list_usul_layanan"></div>
      

<!-- tutup body q -->
</div>
</div>
</div>
</div>

<script>
    $(function(){
        $('.select2').select2()
        $('#datatable').dataTable()
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
        }); 
</script>