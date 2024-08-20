<html>
    <style>
        #body_dpcp{
            font-family: Tahoma;
        }

        @media print {
            @page {
            }
        }

        .table_header{
            font-size: .65rem;
        }

        .sp_ttd{
            font-size: .65rem;
        }

        .table_content{
            display: inline-block;
            /* flex: 1; */
            width: 50%;
            font-size: .75rem;
        }

        .content_table_wrapper{
            width: 100%;
            display: inline-block;
        }

        .table_footer_sk{
            font-size: .65rem !important;
        }
    </style>
    <body id="body_dpcp">
        <table class="table_header" style="width: 100%">
            <tr>
                <td style="width: 15%;">INSTANSI INDUK</td>
                <td style="width: 3%;">:</td>
                <td style="width: 82%;">PEMERINTAH KOTA MANADO</td>
            </tr>
            <tr>
                <td style="width: 15%;">PROVINSI</td>
                <td style="width: 3%;">:</td>
                <td style="width: 82%;">SULAWESI UTARA</td>
            </tr>
            <tr>
                <td style="width: 15%;">KAB/KOTA</td>
                <td style="width: 3%;">:</td>
                <td style="width: 82%;">MANADO</td>
            </tr>
            <tr>
                <td style="width: 15%;">UNIT KERJA</td>
                <td style="width: 3%;">:</td>
                <td style="width: 82%;"><?=strtoupper($profil_pegawai['nm_unitkerja'])?></td>
            </tr>
            <tr>
                <td style="width: 15%;">PEMBAYARAN</td>
                <td style="width: 3%;">:</td>
                <td style="width: 82%;">BADAN KEUANGAN DAN ASET DAERAH (BKAD)</td>
            </tr>
            <tr>
                <td style="width: 15%;">BUP</td>
                <td style="width: 3%;">:</td>
                <td style="width: 82%;">asd</td>
            </tr>
        </table>
        <h4 style="margin-left: 15%;">DATA PERORANGAN CALON PENERIMA PENSIUN (DPCP) PEGAWAI NEGERI SIPIL</h4>
        <div class="content_table_wrapper">
            <div class="table_content" style="float: left;">
                <table style="width: 100%; font-size: .65rem;">
                    <tr valign="top">
                        <td colspan=1>1.</td>
                        <td colspan=4><span class="sp_content_font">KETERANGAN PRIBADI</span></td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 1%;"></td>
                        <td style="width: 2%;">A.</td>
                        <td style="width: 40%;">NAMA</td>
                        <td style="width: 3%;">:</td>
                        <td style="width: 56%;"><?=strtoupper(getNamaPegawaiFull($profil_pegawai))?></td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 1%;"></td>
                        <td style="width: 2%;">B.</td>
                        <td style="width: 40%;">NIP</td>
                        <td style="width: 3%;">:</td>
                        <td style="width: 56%;"><?=($profil_pegawai['nipbaru_ws'])?></td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 1%;"></td>
                        <td style="width: 2%;">C.</td>
                        <td style="width: 40%;">TEMPAT/TANGGAL LAHIR</td>
                        <td style="width: 3%;">:</td>
                        <td style="width: 56%;"><?=strtoupper($profil_pegawai['tptlahir'].' / '.formatDateOnlyForEdit2($profil_pegawai['tgllahir']))?></td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 1%;"></td>
                        <td style="width: 2%;">D.</td>
                        <td style="width: 40%;">JABATAN/PEKERJAAN</td>
                        <td style="width: 3%;">:</td>
                        <td style="width: 56%;"><?=strtoupper($berkas['sk_jabatan']['nm_jabatan'])?></td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 1%;"></td>
                        <td style="width: 2%;">E.</td>
                        <td style="width: 40%;">PANGKAT/GOL RUANG</td>
                        <td style="width: 3%;">:</td>
                        <td style="width: 56%;"><?=($berkas['sk_pangkat']['nm_pangkat']).' // '.formatDateOnlyForEdit2($berkas['sk_pangkat']['tmtpangkat'])?></td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 1%;"></td>
                        <td style="width: 2%;">F.</td>
                        <td style="width: 40%;">GAJI POKOK TERAKHIR</td>
                        <td style="width: 3%;">:</td>
                        <td style="width: 56%;"><?=formatCurrency($data_checklist_pensiun['gaji_pokok_pensiun'])?></td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 1%;"></td>
                        <td style="width: 2%;">G.</td>
                        <td style="width: 40%;">MASA KERJA GOLONGAN</td>
                        <td style="width: 3%;">:</td>
                        <td style="width: 56%;"><?=$data_checklist_pensiun['masa_kerja_golongan']?></td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 1%;"></td>
                        <td style="width: 2%;">H.</td>
                        <td style="width: 40%;">MASA KERJA PENSIUN</td>
                        <td style="width: 3%;">:</td>
                        <td style="width: 56%;"><?=$data_checklist_pensiun['masa_kerja_pensiun']?></td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 1%;"></td>
                        <td style="width: 2%;">I.</td>
                        <td style="width: 40%;">MASA KERJA SEBELUM DIANGKAT SEBAGAI PNS</td>
                        <td style="width: 3%;">:</td>
                        <td style="width: 56%;"><?=$data_checklist_pensiun['masa_kerja_sebelum_pns']?></td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 1%;"></td>
                        <td style="width: 2%;">J.</td>
                        <td style="width: 40%;">PENDIDIKAN SEBAGAI PENGANGKATAN PERTAMA</td>
                        <td style="width: 3%;">:</td>
                        <td style="width: 56%;"><?=$data_checklist_pensiun['pendidikan_pertama']?></td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 1%;"></td>
                        <td style="width: 2%;">K.</td>
                        <td style="width: 40%;">MULAI MASUK PNS</td>
                        <td style="width: 3%;">:</td>
                        <td style="width: 56%;"><?=($berkas['cpns'] ? formatDateOnlyForEdit2($berkas['cpns']['tmtcpns']) : null)?></td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 1%;" colspan=1>2.</td>
                        <td style="width: 99%;" colspan=4>KETERANGAN KELUARGA</td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 1%;"></td>
                        <td style="width: 2%;">A.</td>
                        <td colspan=3 style="width: 97%;">ISTERI/SUAMI</td>
                    </tr>
                    <tr>
                        <td style="width: 1%;"></td>
                        <td style="width: 2%;"></td>
                        <td style="width: 97%;" colspan=3>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="text-align: center; width: 5%;">NO</td>
                                    <td style="text-align: center; width: 35%;">NAMA</td>
                                    <td style="text-align: center; width: 15%;">TGL. LAHIR</td>
                                    <td style="text-align: center; width: 15%;">KAWIN TGL.</td>
                                    <td style="text-align: center; width: 25%;">ISTRI/SUAMI KE</td>
                                </tr>
                                <?php if($berkas['akte_nikah']){ $no = 1; foreach($berkas['akte_nikah'] as $ap){ ?>
                                    <tr>
                                        <td style="text-align: center;"><?=$no++;?></td>
                                        <td><?=$ap['namakel']?></td>
                                        <td style="text-align: center;"><?=formatDateOnlyForEdit2($ap['tgllahir'])?></td>
                                        <td style="text-align: center;"><?=$ap['tglnikah'] != null ? formatDateOnlyForEdit2($ap['tglnikah']) : '' ?></td>
                                        <td style="text-align: center;"><?=$ap['pasangan_ke'] != null ? ($ap['pasangan_ke']) : '' ?></td>
                                    </tr>
                                <?php } } ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="table_content" style="float: right;">
                <table style="width: 100%; font-size: 1rem;">
                    <tr valign="top">
                        <td style="width: 4%;"></td>
                        <td style="width: 5%;">B.</td>
                        <td colspan=3 style="width: 90%;">ANAK-ANAK</td>
                    </tr>
                    <tr>
                        <td colspan=2 style="width: 5%;"></td>
                        <td style="width: 95%;" colspan=3>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="text-align: center; width: 5%;">NO</td>
                                    <td style="text-align: center; width: 30%;">NAMA</td>
                                    <td style="text-align: center; width: 10%;">TGL. LAHIR</td>
                                    <td style="text-align: center; width: 10%;">KANDUNG</td>
                                    <td style="text-align: center; width: 10%;">TIRI</td>
                                    <td style="text-align: center; width: 10%;">ANGKAT</td>
                                    <td style="text-align: center; width: 30%;">NAMA AYAH/IBU</td>
                                </tr>
                                <?php if($berkas['akte_anak']){ $no = 1; foreach($berkas['akte_anak'] as $aa){ if($aa['statusanak'] == 1){ ?>
                                    <tr>
                                        <td style="text-align: center;"><?=$no++;?></td>
                                        <td><?=$aa['namakel']?></td>
                                        <td style="text-align: center;"><?=formatDateOnlyForEdit2($aa['tgllahir'])?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><?=$aa['nama_ortu_anak']?></td>
                                    </tr>
                                <?php } } } ?>
                            </table>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td colspan=1>3.</td>
                        <td colspan=4>ALAMAT</td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 4%;"></td>
                        <td style="width: 5%;">A.</td>
                        <td style="width: 25%;">ALAMAT SEKARANG :</td>
                        <td colspan=2 style="width: 65%;"><?=strtoupper($data_checklist_pensiun['alamat_sekarang'])?></td>
                    </tr>
                    <tr valign="top" style="padding-top: 0px; padding-bottom: 5px;">
                        <td colspan=2 style="width: 5%;"></td>
                        <td style="padding-top: 0px; padding-bottom: 5px; width: 32%;">KECAMATAN</td>
                        <td style="padding-top: 0px; padding-bottom: 5px; width: 31%;">KAB/KOTA</td>
                        <td style="padding-top: 0px; padding-bottom: 5px; width: 32%;">PROPINSI</td>
                    </tr>
                    <tr valign="top">
                        <td style="width: 4%;"></td>
                        <td style="width: 5%;">B.</td>
                        <td style="width: 90%;">ALAMAT SETELAH PENSIUN :</td>
                        <td colspan=2 style="width: 70%;"><?=strtoupper($data_checklist_pensiun['alamat_setelah_pensiun'])?></td>
                    </tr>
                    <tr valign="top">
                        <td colspan=2 style="width: 5%;"></td>
                        <td style="padding-top: 0px; padding-bottom: 5px; width: 32%;">KECAMATAN</td>
                        <td style="padding-top: 0px; padding-bottom: 5px; width: 31%;">KAB/KOTA</td>
                        <td style="padding-top: 0px; padding-bottom: 5px; width: 32%;">PROPINSI</td>
                    </tr>
                    <tr valign="top">
                        <td style="vertical-align: top; padding-top: 0px;" colspan=1>4.</td>
                        <td style="vertical-align: top; padding-top: 0px;" colspan=4>DENGAN INI SAYA MENYATAKAN AKAN MENGEMBALIKAN SELURUH BARANG INVENTARIS MILIK NEGARA SETELAH DIBERHENTIKAN DENGAN HORMAT SEBAGAI PEGAWAI NEGERI SIPIL DAN APABILA SAYA TIDAK MEMATUHINYA SAYA BERSEDIA DIAMBIL TINDAKAN SESUAI PERATURAN PERUNDANG-UNDANGAN YANG BERLAKU</td>
                    </tr>
                    <tr valign="top">
                        <td style="padding-top: 30px;" colspan=1></td>
                        <td style="padding-top: 30px;" colspan=4>DEMIKIAN DATA INI DIBUAT DENGAN SEBENARNYA</td>
                    </tr>
                </table>
            </div>
        </div>
        <table style="width: 100%; margin-top: 10px;">
            <tr>
                <td style="width: 33%;">
                </td>
                <td style="width: 33%;">&&</td>
                <td style="width: 33%; text-align: center;">
                    <span class="sp_ttd">MANADO, <?=strtoupper(formatDateNamaBulan(date('Y-m-d')))?></span><br>
                    <span class="sp_ttd">CALON PENERIMA PENSIUN</span>
                    <br><br><br>
                    <span class="sp_ttd"><?=getNamaPegawaiFull($profil_pegawai)?></span>
                </td>
            </tr>
        </table>
        <?php
            $this->load->view('adminkit/partials/V_FooterBsre');
        ?>
    </body>
</html>