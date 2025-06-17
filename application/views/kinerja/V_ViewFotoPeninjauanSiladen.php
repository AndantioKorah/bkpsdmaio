
 <style>
    * {margin: 0; box-sizing: border-box;}

label:has([type=radio]) {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  border: 1px solid #aaa;
  padding: 0.5rem 0.5rem;
  border-radius: 1rem;
  transition: background-color 0.3s;
  width: 75%;
}

label:has([type=radio]:not(:disabled)) {
  cursor: pointer;
}

[type=radio] {
  /* appearance: none; */
  width: 1.2rem;
  height: 1.2rem;
  flex: 0 0 auto;
  border: inherit;
  border-radius: inherit;
   border-color: #14bf8b;
  color: #000;
  /* margin-top:-500px; */
}

label:has([type=radio]:checked) {
  border-color: #14bf8b;
  background-color: #14bf8b;
  color: #000;
}

[type=radio]:checked {
  border-color: #14bf8b;
  background: #fff url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1 1"><polyline points="0.15,0.5 0.4,0.75 0.85,0.25" style="fill:none;stroke:%2314bf8b;stroke-linecap:round;stroke-width:0.15;"/></svg>') no-repeat 50% / 1rem;
}
 </style>
 <?php foreach($result as $rs){ ?>
    <img src="<?=$rs['url']?>"  id="" class="mt-3" style="width:260px;height:410px;"  alt=""> <br>
    <b>Jam Kirim Siladen : <?=$rs['date_received']?> 
    <?php $date=date_create($rs['date_received']);?> </b>
     <!-- <input type="radio"  id="myCheck" checked="checked" name="radio" onclick="ambiljam('<?= date_format($date,'H:i') ?>')"><br>     -->
    <label>
  <input  type="radio"  id="myCheck" checked="checked" name="radio" onclick="ambiljam('<?= date_format($date,'H:i') ?>',<?=$id;?>)"> Ikut Jam Siladen
</label>
     <hr style="border-width: 5px;">
<?php } ?>




<script>
  function ambiljam(jam,id) {
  // Get the checkbox
  var checkBox = document.getElementById("myCheck");
  $('#verifjam_'+id).val(jam)
     $('#jam_'+id).val(jam);

//   if (checkBox.checked == true){
//    $('#verifjam_1').val(jam)
//      $('#jam_1').val(jam);
//   } else {
//     $('#verifjam_1').val(null)
//       $('#jam_1').val(null);
//   }
}
</script>
      
      