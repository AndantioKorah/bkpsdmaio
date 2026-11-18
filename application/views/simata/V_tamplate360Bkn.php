<?php if($data){ ?>
  <style>
        *,
::before,
::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
/* body {
  min-height: 100svh;
  background-color: #022C22;
  display: grid;
  place-content: center;
} */
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}
.rating {
  
  --star-size: clamp(2rem, 5vw, 5rem);
  --star-clr-inactive: rgba(196, 194, 194, 0.7);
  /* --star-clr-active: rgb(245, 158, 11); */
  --star-clr-active: #222e3c;
  --star-clr-hover: rgba(97, 1, 15, 0.2);
  --star-clip-path: polygon(
    50% 0%,
    61% 35%,
    98% 35%,
    68% 57%,
    79% 91%,
    50% 70%,
    21% 91%,
    32% 57%,
    2% 35%,
    39% 35%
  );
  /* display: flex; */
  /* align-items: center; */
  gap: 0.5rem;
}

label {
  position: relative;
  cursor: pointer;
  width: var(--star-size);
  height: var(--star-size);
}
label::before {
  content: "";
  position: absolute;
  inset: 50%;
  border-radius: 50%;
  background-color: var(--star-clr-hover);
  transition: rotate 450ms ease-in-out, inset 300ms ease-in-out;
  clip-path: var(--star-clip-path);
}
label:hover::before {
  inset: -1rem;
  rotate: 45deg;
}
label::after {
  content: "";
  position: absolute;
  inset: 0;
  background-color: var(--star-clr-inactive);
  clip-path: var(--star-clip-path);
  transition: 300ms ease-in-out;
  scale: 0.75;
}
label:has(~ label:hover)::after,
label:has(~ label > :checked)::after,
label:has(:checked)::after,
label:hover::after {
  background-color: var(--star-clr-active); 
  scale: 1;
}

label:hover ~ label::after {
  scale: 0.75;
}
label:active::before {
  inset: -2rem;
}

hr.new5 {
  /* border: 3px solid green; */
  border: 1px solid #fff;
  /* color: green; */
  /* border-radius: 2px; */
}

h3 {
  color: #222e3c;
}
      </style>
   
    <div class="col-lg-12 table-responsive">
    <table class="table table-striped" id="table_tamplate">
            <thead>
                <th class="text-left">NO</th>
                <th class="text-left">NIP</th>
                <th class="text-left">Peran Penilai</th>
                <th class="text-left">Berorientasi Pelayanan</th>
                <th class="text-left">Akuntabel</th>
                <th class="text-left">Kompeten</th>
                <th class="text-left">Harmonis</th>
                <th class="text-left">Loyal</th>
                <th class="text-left">Adaptif</th>
                <th class="text-left">Kolaboratif</th>
            </thead>
            <tbody>
            <?php $no=1; foreach($data as $p){?>
                <tr>
                    <td class="text-left"><?=$no++;?></td>
                    <td class="text-left"><?=$p['nipbaru_ws']?></td>
                    <td class="text-left"><?=$p['peran_penilai']?></td>
                    <td class="text-left"><?=$p['berorientasi_pelayanan']/20;?></td>
                    <td class="text-left"><?=$p['akuntabel']/20;?></td>
                    <td class="text-left"><?=$p['kompeten']/20;?></td>
                    <td class="text-left"><?=$p['harmonis']/20;?></td>
                    <td class="text-left"><?=$p['loyal']/20;?></td>
                    <td class="text-left"><?=$p['adaptif']/20;?></td>
                    <td class="text-left"><?=$p['kolaboratif']/20;?></td>
                </tr>
            <?php } ?>
            </tbody>
          
        </table>
    </div>
 
    <script>

  $(function(){
    $('#table_tamplate').DataTable({
    "aLengthMenu": [[100, 75, -1], [100, 75, "All"]],
     });
    
  })






    </script>
<?php } else { ?>

<p>Tidak ada data</p>
<?php } ?>