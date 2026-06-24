<div class="col-lg-12" style="margin: auto;">
  <center>
    <?php if($this->general_library->isProgrammer()){
      // dd($announcement[0]);
    } ?>
    <?php
    $total_data = count($announcement);
    $maxrandom = $total_data - 1;
    $number = random_int(0, $maxrandom)
    ?>
    <!-- <img id="announcement_image" style="max-height: 75vh; max-width: 90vw;" src="<?=base_url($announcement[$number]['url_file'])?>" /> -->
    <?php  foreach($announcement as $ann){ ?>
    <img id="announcement_image" style="max-height: 75vh; max-width: 90vw;" src="<?=base_url($ann['url_file'])?>" />
    <?php } ?>
  </center>
</div>

