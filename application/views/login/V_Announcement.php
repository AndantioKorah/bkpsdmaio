<div class="col-lg-12" style="margin: auto;">
  <center>
    <?php if($this->general_library->isProgrammer()){
      // dd($announcement[0]);
    } ?>
    <img id="announcement_image" style="max-height: 75vh; max-width: 90vw;" src="<?=base_url($announcement[0]['url_file'])?>" />
  </center>
</div>