<?php
    // require 'vendor/autoload.php';
    // require FCPATH . 'vendor/autoload.php';
    // use PhpOffice\PhpSpreadSheet\Spreadsheet;
    // use PhpOffice\PhpSpreadSheet\IOFactory;
    // require FCPATH . '/vendor/autoload.php';

    // use mpdf\mpdf;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


	class M_Siasn extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function sinkronIdSiasn($id_siladen, $id_siasn, $data){
            $this->db->where('id', $id_siladen)
                    ->update('db_pegawai.pegjabatan', [
                        'updated_by' => $this->general_library->getId(),
                        'id_siasn' => $id_siasn,
                        'id_unor_siasn' => $data['siasn'][$id_siasn]['unorId'],
                        'meta_data_siasn' => json_encode($data['siasn'][$id_siasn]),
                    ]);
        }

        public function mappingJabatanFungsional($flag_only_show){
            $siladen = $this->db->select('*')
                                ->from('db_pegawai.jabatan')
                                ->where('id_jabatan_siasn IS NULL')
                                ->where('jenis_jabatan', 'JFT')
                                ->order_by('nama_jabatan', 'asc')
                                ->get()->result_array();

            $jenjang1 = ['Mahir', 'Pemula', 'Penyelia', 'Terampil', 'Pelaksana', 'Lanjutan', 'Pelaksana Lanjutan', 'Pertama', 'Muda', 'Madya', 'Utama'];
            $jenjang2 = ['Ahli Pertama', 'Ahli Muda', 'Ahli Madya', 'Ahli Utama'];

            $list_jabatan = null;
            foreach($siladen as $sil){
                $new = "";
                foreach($jenjang2 as $j){
                    $new = str_replace($j, "", $sil['nama_jabatan']);
                    if($new != $sil['nama_jabatan']){
                        break;
                    }
                }
                $new2 = "";
                foreach($jenjang1 as $j2){
                    $new2 = str_replace($j2, "", $new);
                    if($new2 != $new){
                        break;
                    }
                }

                $list_jabatan[trim($new2)] = $new2;
            }

            foreach($list_jabatan as $lj){
                foreach($jenjang2 as $jj){
                    $nama_jabatan = strtoupper($lj.' '.$jj);
                }
            }

            // $siasn = null;
            // if($jenis == 'struktural'){
            //     $siasn = $this->db->select('*')
            //                     ->from('db_siasn.m_ref_jabatan_struktural')
            //                     ->order_by('nama_asc')
            //                     ->get()->result_array();
            // } else if($jenis == 'JFT'){
            //     $siasn = $this->db->select('*')
            //                     ->from('db_siasn.m_ref_jabatan_fungsional')
            //                     ->order_by('nama_asc')
            //                     ->get()->result_array();
            // } else {
            //     $siasn = $this->db->select('*')
            //                     ->from('db_siasn.m_ref_jabatan_pelaksana')
            //                     ->order_by('nama_asc')
            //                     ->get()->result_array();
            // }
        }

        public function mappingJabatanOld($jenis, $percent, $flag_only_show){
            $siladen = $this->db->select('*')
                                ->from('db_pegawai.jabatan')
                                ->where('id_jabatan_siasn IS NULL')
                                ->where('jenis_jabatan', $jenis)
                                ->get()->result_array();

            $siasn = null;
            if($jenis == 'struktural'){
                $siasn = $this->db->select('*')
                                ->from('db_siasn.m_ref_jabatan_struktural')
                                ->get()->result_array();
            } else if($jenis == 'JFT'){
                $siasn = $this->db->select('*')
                                ->from('db_siasn.m_ref_jabatan_fungsional')
                                ->get()->result_array();
            } else {
                $siasn = $this->db->select('*')
                                ->from('db_siasn.m_ref_jabatan_pelaksana')
                                ->get()->result_array();
            }

            foreach($siladen as $sil){
                foreach($siasn as $sia){
                    $sim = similar_text(strtoupper($sil['nama_jabatan']), strtoupper($sia['nama']), $sim);
                    if($sim >= $percent){
                        if($flag_only_show == 0){
                            $this->db->where('id_jabatanpeg', $sil['id_jabatanpeg'])
                                    ->update('db_pegawai.jabatan', [
                                        'id_jabatan_siasn' => $sia['id']
                                    ]);
                        }
                        echo $sil['nama_jabatan'].' -> '.$sia['nama'].'<br>';
                        break;
                    }
                }
            }
        }

        public function revertMappingJabatan($jenis, $percent, $flag_only_show){
            $this->db->select('a.*, b.nama')
                                ->from('db_pegawai.jabatan a')
                                ->where('id_jabatan_siasn IS NOT NULL')
                                ->where('jenis_jabatan', $jenis);
                                // ->get()->result_array();

            // $siasn = null;
            if($jenis == 'struktural'){
                $this->db->join('db_siasn.m_ref_jabatan_struktural b', 'a.id_jabatan_siasn = b.id');
            } else if($jenis == 'JFT'){
                $this->db->join('db_siasn.m_ref_jabatan_fungsional b', 'a.id_jabatan_siasn = b.id');
            } else {
                $this->db->join('db_siasn.m_ref_jabatan_pelaksana b', 'a.id_jabatan_siasn = b.id');
            }

            $siladen = $this->db->get()->result_array();

            foreach($siladen as $sil){
                $sim = similar_text(strtoupper($sil['nama_jabatan']), strtoupper($sil['nama']), $sim);
                if($sim < $percent){
                    if($flag_only_show == 0){
                        $this->db->where('id_jabatanpeg', $sil['id_jabatanpeg'])
                                ->update('db_pegawai.jabatan', [
                                    'id_jabatan_siasn' => null
                                ]);
                    }
                    echo $sil['nama_jabatan'].' -> '.$sil['nama'].'<br>';
                }
            }
        }
    }

?>