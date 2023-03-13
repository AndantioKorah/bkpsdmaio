<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
  <meta name="description" content="Siladen - Pemerintah Kota. Manado">
  <meta name="keywords" content="siladen,manado">
  <meta name="author" content="Nur Muhamad Holik">
  <meta name="robots" content="noindex, nofollow">
  <title>ID Card - Siladen</title>
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url() ?>assets/img/favicon.png">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
  <!-- Fontawesome CSS -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-awesome.min.css">

  <!-- Lineawesome CSS -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/line-awesome.min.css">
  <!-- dataTablese CSS -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/select2.min.css">
  <!-- Main CSS -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-datetimepicker.min.css">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
			<script src="<?php echo base_url() ?>assets/js/html5shiv.min.js"></script>
			<script src="<?php echo base_url() ?>assets/js/respond.min.js"></script>
		<![endif]-->
  <style type="text/css">
    <!--
    .style1 {
      color: #FF0000
    }
    -->
  </style>
</head>

<body>
  <!-- Main Wrapper -->
  <div class="main-wrapper">
    <!-- Header-->
    <?php $this->load->view('header'); ?>
    <!-- Header -->
    <!-- Sidebar -->
    <?php $this->load->view('sidebar'); ?>
    <!-- /Sidebar -->
    <!-- Page Wrapper -->
    <div class="page-wrapper">
      <!-- Page Content -->
      <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="page-title">Welcome <?php echo $this->session->userdata('name') ?>!</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item ">OPD</li>
                <li class="breadcrumb-item active">Proses ID Card</li>
              </ul>
            </div>
          </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title mb-0">Proses Usul ID Card </h4>
              </div>
              <div class="card-body">

                <div align="center">
                  <h1><span class="style1"><strong><?php echo $data['pesan'] ?></strong></span> </h1>
                </div>
                <form action="<?php echo site_url() ?>/simpeg/kirimProsesPasPhoto/<?php echo $data['idusul'] ?>" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                  <table width="1160" border="0" align="left">
                    <tr>
                      <td width="9">&nbsp;</td>
                      <td width="200">Nama</td>
                      <td width="12">:</td>
                      <td width="507"><?php echo $data['asn']->gelar1; ?> <?php echo $data['asn']->nama; ?> <?php echo $data['asn']->gelar2; ?></td>
                      <td width="689" rowspan="9">
                        <div align="center"><img src="<?php echo base_url() ?>uploads/<?= $data['nip_baru'] ?>/<?= $data['pasphoto'] ?>" alt="" width="200" align="top"></div>
                      </td>
                    </tr>

                    <tr>
                      <td>&nbsp;</td>
                      <td>NIP</td>
                      <td>:</td>
                      <td><?php echo $data['nip_baru'] ?></td>
                    </tr>

                    <tr>
                      <td>&nbsp;</td>
                      <td>Jabatan </td>
                      <td>:</td>
                      <td><?php echo $data['asn']->nama_jabatan; ?></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Unit Kerja </td>
                      <td>:</td>
                      <td><?php echo $data['asn']->nm_unitkerja; ?></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Status</td>
                      <td>:</td>
                      <td>

                        <select class="form-control" name="status" id="status">
                          <option value="DIKIRIM">DIKIRIM</option>
                          <option value="DITOLAK">DITOLAK</option>
                          <option value="SELESAI">SELESAI</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Keterangan</td>
                      <td>:</td>
                      <td><span class="col-lg-16">
                          <input name="keterangan" value="" class="form-control" type="text" placeholder="Isi Keterangan">
                        </span></td>
                    </tr>

                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="3">&nbsp;</td>
                    </tr>

                    <tr>
                      <td height="21">&nbsp;</td>
                      <td colspan="3">&nbsp;</td>
                    </tr>


                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td width="689">
                        <div align="center"><span class="style1">*Foto Tidak Boleh Blur</span></div>
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td width="689">
                        <div align="center"><span class="style1">*Perhatikan Warna Latar Belakang Pas Photo </span></div>
                      </td>
                    </tr>



                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="3">
                        <div>
                          <button type="submit" class="btn btn-primary">Proses ID Card</button>
                        </div>
                      </td>
                      <td width="689">&nbsp;</td>
                    </tr>
                  </table>

                </form>
              </div>




            </div>
          </div><!-- card body!-->




        </div> <!-- card !-->
      </div> <!-- col!-->
    </div> <!-- row!-->
  </div>
  <!-- /Page Content -->



  </div>
  <!-- /Page Wrapper -->
  </div>
  <!-- /Main Wrapper -->

  <!-- jQuery -->
  <script src="<?php echo base_url() ?>assets/js/jquery-3.2.1.min.js"></script>
  <!-- Bootstrap Core JS -->
  <script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
  <!-- Slimscroll JS -->
  <script src="<?php echo base_url() ?>assets/js/jquery.slimscroll.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/select2.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/moment-with-locales.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/bootstrap-datetimepicker.min.js"></script>
  <!-- Custom JS -->
  <script src="<?php echo base_url() ?>assets/js/app.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {

      $(".unor").select2({
        placeholder: 'Masukan Nama Unit Organisasi',
        width: '100%',
        minimumInputLength: 6,
        ajax: {
          url: "<?php echo site_url() ?>/layanan/getUnitOrganisasi",
          dataType: 'json',
          type: 'GET',
          cache: "true",
          delay: 250,
          processResults: function(data) {
            return {
              results: $.map(data, function(obj) {
                return {
                  id: obj.id,
                  text: obj.nama
                };
              })
            };
          }
        }
      });

      <?php if ($data['show']) : ?>
        $("#unor").append("<option value='" + '<?php echo $UnitOrganisasiById->id ?>' + "' selected>" + '<?php echo $UnitOrganisasiById->parent . ' - ' . $UnitOrganisasiById->nama ?>' + "</option>");
        $('#unor').trigger('change');
      <?php endif ?>
    });
  </script>

</body>

</html>