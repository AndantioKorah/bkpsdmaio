<html>
    <style>
        #body_dpcp{
            font-family: Tahoma;
        }

        @media print {
            @page {
                size: 8.5in 5.5in;
                size: landscape;
            }
        }

        .table_header, .table_content_left, .table_suami_isteri{
            font-size: .75rem;
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
        <div class="div_content" style="width: 100%;">
            <table class="table_content_left" style="width: 50%;">
                <tr valign="top">
                    <td colspan=1>1.</td>
                    <td colspan=4>KETERANGAN PRIBADI</td>
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
                        <table style="width: 100%;" class="table_suami_isteri">
                            <tr>
                                <td style="text-align: center; width: 5%;">NO</td>
                                <td style="text-align: center; width: 35%;">NAMA</td>
                                <td style="text-align: center; width: 15%;">TGL. LAHIR</td>
                                <td style="text-align: center; width: 15%;">KAWIN TGL.</td>
                                <td style="text-align: center; width: 25%;">ISTRI/SUAMI KE</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>