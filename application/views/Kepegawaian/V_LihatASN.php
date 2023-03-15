<?php
  $params_exp_app = $this->general_library->getParams('PARAM_EXP_APP');
  $list_role = $this->general_library->getListRole();
  $active_role = $this->general_library->getActiveRole();
?>
<style>
/* #profile_pict {
    max-width: 150px;
    max-height: 150px;
    animation: zoom-in-zoom-out 5s ease infinite;
} */

@keyframes zoom-in-zoom-out {
  0% {
    transform: scale(1, 1);
  }
  50% {
    transform: scale(1.1, 1.1);
  }
  100% {
    transform: scale(1, 1);
  }
}
</style>


<div class="container-fluid p-0">
<div class="row">
    <div class="col-12 text-left">
    
    
          
       <style>

        img.logo {
          height: 200px; width: 400px; margin-bottom:20px;
         }
        @media screen and (max-width: 600px) {
        h4 {
          font-size: 17px;
        /* display:none; */
        }

        img.logo {
          /* height: 150px;  */
          height : auto;
          width: 2509px; 
          /* height: 100%; 
          width: 200%; */
          /* margin-left: 50;  */
          margin-bottom:20px;
           /* display:none; */
        }
     
       }

       

       </style>

<div class="card">
					  <table width="1101" border="0" align="left">
                                          
                                          <tr>
                                            <td width="29">&nbsp;</td>
                                            <td width="1062" colspan="3">&nbsp;</td>
                                          </tr>
                                          
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="3">
 <div class="tabs-to-dropdown">
  <div class="nav-wrapper d-flex align-items-center justify-content-between">
    <ul class="nav nav-pills d-none d-md-flex" id="pills-tab" role="tablist">
	
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="pills-company-tab" data-toggle="pill" href="#pills-company" role="tab" aria-controls="pills-company" aria-selected="true"><i class="la la-user"></i> Profil</a>      </li>
	  <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-pangkat-tab" data-toggle="pill" href="#pills-pangkat" role="tab" aria-controls="pills-pangkat" aria-selected="false"><i class="la la-star"></i> Pangkat</a>      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-product-tab" data-toggle="pill" href="#pills-product" role="tab" aria-controls="pills-product" aria-selected="false"><i class="la la-graduation-cap"></i> Pendidikan</a>      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-news-tab" data-toggle="pill" href="#pills-news" role="tab" aria-controls="pills-news" aria-selected="false"><i class="la la-building"></i> Jabatan</a>      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false"><i class="la la-certificate"></i> Diklat</a>      </li>
		  <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-berkala-tab" data-toggle="pill" href="#pills-berkala" role="tab" aria-controls="pills-berkala" aria-selected="false"><i class="la la-money"></i> Gaji Berkala</a>      </li>
    </ul>
  </div>

  <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-company" role="tabpanel" aria-labelledby="pills-company-tab">
      <div class="container-fluid">
      <div class="table-responsive">

          <table width="985" border="0">
            <tr>
              <td width="152">Nama</td>
              <td width="13">:</td>
              <td width="806">
				<?= getNamaPegawaiFull($profil_pegawai) ?></td>
            </tr>
            <tr>
              <td>Tempat/Tgl Lahir </td>
              <td>:</td>
              <td><?= $profil_pegawai['tptlahir']?> / <?= formatDateNamaBulan($profil_pegawai['tgllahir'])?><td>
            </tr>
            <tr>
              <td>NIP</td>
              <td>:</td>
              <td><?= $profil_pegawai['nipbaru']?></td>
            </tr>
            <tr>
              <td>Jenis Kelamin </td>
              <td>:</td>
              <td><?= $profil_pegawai['jk']?></td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td>:</td>
              <td><?= $profil_pegawai['alamat']?></td>
            </tr>
            <tr>
              <td>Agama</td>
              <td>:</td>
              <td><?= $profil_pegawai['nm_agama']?></td>
            </tr>
            <tr>
              <td>Pendidikan</td>
              <td>:</td>
              <td><?= $profil_pegawai['nm_tktpendidikan']?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Pangkat / TMT </td>
              <td>:</td>
              <td><?php echo $profil_pegawai['nm_pangkat']?> /
                <?php 
											if ($profil_pegawai['tmtpangkat'] =='0000-00-00')
											{
											echo "-";
											}
											else
											{
											echo format_indo(date($profil_pegawai['tmtpangkat']->tmtpangkat)); 
											}
											?></td>
            </tr>
            <tr>
              <td>TMT Gaji Berkala </td>
              <td>:</td>
              <td><?php 
											if ($profil_pegawai['tmtgjberkala']=='0000-00-00')
											{
											
												echo "-";
											}
											else
											{
											echo formatDateNamaBulan($profil_pegawai['tmtgjberkala']); 
											}
											?></td>
            </tr>
            <tr>
              <td>Jabatan / TMT </td>
              <td>:</td>
              <td><?php echo $profil_pegawai['nama_jabatan']?> /
                <?php 
											if ($profil_pegawai['tmtjabatan']=='0000-00-00')
											{
											echo "-";
											}
											else
											{
											echo formatDateNamaBulan($profil_pegawai['tmtjabatan']); 
											}
											?></td>
            </tr>
            <tr>
              <td>Unit Kerja </td>
              <td>:</td>
              <td><?php echo $profil_pegawai['nm_unitkerja']?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td>NIK </td>
              <td>:</td>
              <td><?= $profil_pegawai['nik']?></td>
            </tr>
            <tr>
              <td>No HP </td>
              <td>:</td>
              <td><?= $profil_pegawai['handphone']?></td>
            </tr>
            <tr>
              <td>Email </td>
              <td>:</td>
              <td><?= $profil_pegawai['email'] ?></td>
            </tr>
          </table>
      </div>	
      </div>
      </div>
	<div class="tab-pane fade" id="pills-pangkat" role="tabpanel" aria-labelledby="pills-pangkat-tab">
      <div class="container-fluid">
        <div class="table-responsive">
        <table class="table table-striped table-sm">
										<thead class="thead-dark">
											<tr>
												<th width="20">No</th>
												<th width="258">Pangkat</th>
												<th width="185">TMT Pangkat </th>
												<th width="205">Masa Kerja </th>
												<th width="96">Nomor SK </th>
												<th width="184">Tanggal SK </th>
												<th width="60">File</th>													
											</tr>
										</thead>   
										<tbody>	
											<?php $i=1;foreach($data['rpangkat']->result() as $value):?>
											<tr>
												<td><?php echo $i?></td>
												<td><?php echo $value->nm_pangkat?></td>
												<td>
												<?php 
											if ($value->tmtpangkat=='0000-00-00')
											{
											echo "-";
											}
											else
											{
											echo format_indo(date($value->tmtpangkat));
											}
											?>												</td>
												<td><?php echo $value->masakerjapangkat?></td>
												<td><?php echo $value->nosk?></td>
												<td><?php 
											if ($value->tglsk=='0000-00-00')
											{
											echo "-";
											}
											else
											{
											echo format_indo(date($value->tglsk));
											}
											?></td>
												<td>
												<?php 
											if ($value->gambarsk==NULL)
											{
											echo "";
											}
											else
											{
											echo "<a target=_blank href="; echo base_url()."arsipelektronik/".$value->gambarsk; echo ">Download</a>";
											}
											?>												</td>
											</tr>
											<?php $i++;endforeach;?>
										</tbody>
										</table>
									</div>	</div>
    </div>
    <div class="tab-pane fade" id="pills-product" role="tabpanel" aria-labelledby="pills-product-tab">
      <div class="container-fluid">
        <table width="758" class="table table-striped table-sm">
          <thead class="thead-dark">
            <tr>
              <th width="22">No</th>
              <th width="83">Pendidikan</th>
              <th width="60">Jurusan</th>
              <th width="70">Fakultas </th>
              <th width="115">Nama Sekolah  </th>
              <th width="98">Tahun Lulus </th>
              <th width="210">Nomor /Tgl Ijazah  </th>
              <th width="64">File</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1;foreach($data['rpendidikan']->result() as $value):?>
            <tr>
              <td><?php echo $i?></td>
              <td><?php echo $value->nm_tktpendidikanb?></td>
              <td><?php echo $value->jurusan?></td>
              <td><?php echo $value->fakultas?></td>
              <td><?php echo $value->namasekolah?></td>
              <td><?php echo $value->tahunlulus?></td>
              <td><?php echo $value->noijasah?> /
                <?php 
											if ($value->tglijasah=='0000-00-00')
											{
											echo "-";
											}
											else
											{
											echo format_indo(date($value->tglijasah));
											}
											?></td>
              <td><?php 
											if ($value->gambarsk==NULL)
											{
											echo "";
											}
											else
											{
											echo "<a target=_blank href="; echo base_url()."arsippendidikan/".$value->gambarsk; echo ">Download</a>";
											}
											?> </td>
            </tr>
            <?php $i++;endforeach;?>
          </tbody>
        </table>
        </div>
    </div>
    <div class="tab-pane fade" id="pills-news" role="tabpanel" aria-labelledby="pills-news-tab">
      <div class="container-fluid">
        <table class="table table-striped table-sm">
          <thead class="thead-dark">
            <tr>
              <th width="20">No</th>
              <th width="244">Jabatan</th>
              <th width="97">TMT Jabatan </th>
              <th width="251">PD </th>
              <th width="121">Nomor SK </th>
              <th width="113">Tanggal SK </th>
              <th width="67">File</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1;foreach($data['rjabatan']->result() as $value):?>
            <tr>
              <td><?php echo $i?></td>
              <td><?php echo $value->nm_jabatan?></td>
              <td><?php 
											if ($value->tmtjabatan=='0000-00-00')
											{
											echo "-";
											}
											else
											{
											echo format_indo(date($value->tmtjabatan));
											}
											?>              </td>
              <td><?php echo $value->skpd?></td>
              <td><?php echo $value->nosk?></td>
              <td><?php 
											if ($value->tglsk=='0000-00-00')
											{
											echo "-";
											}
											else
											{
											echo format_indo(date($value->tglsk));
											}
											?></td>
              <td>
			  <?php 
											if ($value->gambarsk==NULL)
											{
											echo "";
											}
											else
											{
											echo "<a target=_blank href="; echo base_url()."arsipjabatan/".$value->gambarsk; echo ">Download</a>";
											}
											?>
			  </td>
            </tr>
            <?php $i++;endforeach;?>
          </tbody>
        </table>
        </div>
    </div>
	 <!-- <div class="tab-pane fade" id="pills-berkala" role="tabpanel" aria-labelledby="pills-berkala-tab">
      <div class="container-fluid">
        <table width="964" class="table table-striped table-sm">
          <thead class="thead-dark">
            <tr>
              <th width="24">No</th>
              <th width="254">Pangkat</th>
              <th width="179">TMT Gaji Berkala </th>
              <th width="70">Masa Kerja </th>
              <th width="164">Nomor SK </th>
              <th width="178">Tanggal SK </th>
              <th width="63">File</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1;foreach($data['rberkala']->result() as $value):?>
            <tr>
              <td><?php echo $i?></td>
              <td><?php echo $value->nm_pangkat?></td>
              <td><?php 
											if ($value->tmtgajiberkala=='0000-00-00')
											{
											echo "-";
											}
											else
											{
											echo format_indo(date($value->tmtgajiberkala));
											}
											?>
              </td>
              <td><?php echo $value->masakerja?></td>
              <td><?php echo $value->nosk?></td>
              <td><?php 
											if ($value->tglsk=='0000-00-00')
											{
											echo "-";
											}
											else
											{
											echo format_indo(date($value->tglsk));
											}
											?></td>
              <td><?php 
											if ($value->gambarsk==NULL)
											{
											echo "";
											}
											else
											{
											echo "<a target=_blank href="; echo base_url()."arsipgjberkala/".$value->gambarsk; echo ">Download</a>";
											}
											?></td>
            </tr>
            <?php $i++;endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div> -->
</div>										
						<div class="col-md-12">
							<form name="frmDaftar" action="#" class="">
							<div class="card-body">									
								<input type="hidden" id="token" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
								<div class="form-group row">
									
									<div class="col-md-3"></div>
									<div class="col-md-6">
									
									    
									</div>
										
								</div>								 
							</div>
							
							</form>	
						</div>
						  
		
	</div>
		
    
 
</div>

</div>

