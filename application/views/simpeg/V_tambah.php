<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Siladen - Pemerintah Kota. Manado">
    <meta name="keywords" content="siladen,manado">
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
                                <li class="breadcrumb-item active">Tambah Usul</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Usul ID Card </h4>
                            </div>
                            <div class="card-body">

                                <div align="center">
                                    dd (afasf);
                                    <h1><span class="style1"><strong><?php echo $data['pesan'] ?></strong></span> </h1>
                                </div>
                                <form action="<?php echo site_url() ?>kepegawaian/C_pasphoto/kirimUsul" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                                    <table width="1160" border="0" align="left">
                                        <tr>
                                            <td width="9">&nbsp;</td>
                                            <td width="200">Nama</td>
                                            <td width="12">:</td>
                                            <td width="507"><?php echo $data['asn']->gelar1; ?> <?php echo $data['asn']->nama; ?> <?php echo $data['asn']->gelar2; ?></td>
                                            <td width="689" rowspan="16">
                                                <div align="center"><img src="<?php echo base_url() ?>uploads/<?= $data['nip_baru'] ?>/<?= $data['pasphoto'] ?>" alt="" width="200" align="top"></div>
                                                <p>&nbsp;</p>
                                                <p>&nbsp;</p>
                                                <p>&nbsp;</p>
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
                                            <td><?php echo $data['nama_jabatan'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>Unit Kerja </td>
                                            <td>:</td>
                                            <td><?php echo $data['nm_unitkerja'] ?></td>
                                        </tr>

                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="3">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="3"><span class="style1">*Pastikan Data diatas dan foto disamping sudah sesuai karena akan tertera pada ID Card anda</span></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="3"><span class="style1">*Bila ada data diatas yang tidak sesuai, silakan menghubungi BKPSDM Kota Manado </span></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="3">Warna Latar Belakang Pas Foto </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>JPT / Eselon II</td>
                                            <td>:</td>
                                            <td>Warna Merah </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>Administrator / Eselon III</td>
                                            <td>:</td>
                                            <td>Warna Biru </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>Pengawas / Eselon IV</td>
                                            <td>:</td>
                                            <td>Warna Hijau </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>Fungsional Tertentu </td>
                                            <td>:</td>
                                            <td>Warna Abu-Abu </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>Fungsional Umum/Pelaksana </td>
                                            <td>:</td>
                                            <td>Warna Oranye </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="3">
                                                <div>
                                                    <button type="submit" class="btn btn-primary">Kirim Usul</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                </form>
                            </div>



                            <div class="card-header">
                                <h4 class="card-title mb-0">Daftar Usulan </h4>
                            </div>


                            <table class="table table-striped table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Usul</th>
                                        <th>Status</th>
                                        <th>Tanggal Progres</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($data['dokumen']->result() as $value) : ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo format_indo(date($value->created_date)); ?></td>
                                            <td><?php echo $value->usul_status ?></td>
                                            <td><?php echo format_indo(date($value->revisi_date)); ?></td>
                                            <td><?php echo $value->keterangan ?></td>

                                            <td><?php

                                                if ($value->usul_status == 'DIKIRIM') {
                                                    echo "<a href=deleteUsul/$value->id_usul target=_parent onClick='return confirm(\"Yakin Data akan dihapus?\")'><i class=\"fa fa-remove m-r-5\"></i>Hapus</a> ";
                                                }

                                                ?></td>
                                        </tr>
                                    <?php $i++;
                                    endforeach; ?>
                                </tbody>
                            </table>

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