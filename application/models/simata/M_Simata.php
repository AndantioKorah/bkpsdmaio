<?php
	class M_Simata extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function delete($fieldName, $fieldValue, $tableName)
        {
            $this->db->where($fieldName, $fieldValue)
                        ->update($tableName, ['flag_active' => 0, 'updated_by' => $this->general_library->getId()]);
        }

        public function getAllWithOrder($tableName, $orderBy = 'created_date', $whatType = 'desc')
        {
            $this->db->select('*')
            // ->where('id !=', 0)
            // ->where('flag_active', 1)
            ->order_by($orderBy, $whatType)
            ->from($tableName);
            return $this->db->get()->result_array(); 
        }

        public function getMasterUnsurPenilaian(){
            return $this->db->select('*')
                            ->from('db_simata.m_unsur_penilaian a')
                            ->where('a.flag_active', 1)
                            ->order_by('id', 'asc')
                            ->get()->result_array();
        }

        function getDataSubUnsurPenilaian($id)
            {        
                $this->db->select('id, nm_sub_unsur_penilaian');
                $this->db->where('id_m_unsur_penilaian', $id);
                $this->db->order_by('id', 'asc');
                $fetched_records = $this->db->get('db_simata.m_sub_unsur_penilaian');
                $datasubunsur = $fetched_records->result_array();

                $data = array();
                foreach ($datasubunsur as $sub) {
                    $data[] = array("id" => $sub['id'], "nm_sub_unsur_penilaian" => $sub['nm_sub_unsur_penilaian']);
                }
                return $data;
            }


            public function submitTambahIndikator(){
    
                $datapost = $this->input->post();
                
                $this->db->trans_begin();
            
               
                $data["id_sub_unsur_penilaian"] = $datapost["sub_unsur_penilaian"];
                $data["nm_indikator"] = $datapost["indikator"];
                $data["bobot"] = $datapost["bobot"];
                $this->db->insert('db_simata.m_indikator_penilaian', $data);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

            
            
                if($this->db->trans_status() == FALSE){
                    $this->db->trans_rollback();
                    // $res['code'] = 1;
                    // $res['message'] = 'Terjadi Kesalahan';
                    // $res['data'] = null;
                    $res = array('msg' => 'Data gagal disimpan', 'success' => false);
                } else {
                    $this->db->trans_commit();
                }
            
                return $res;
            }

            public function getMasterIndikator(){
                return $this->db->select('a.*')
                                ->from('db_simata.m_indikator_penilaian a')  
                                ->where('a.flag_active', 1)
                                ->get()->result_array();
            }

            public function getMasterSubUnsurPenilaian(){
                return $this->db->select('a.*')
                                ->from('db_simata.m_sub_unsur_penilaian a')  
                                ->where('a.flag_active', 1)
                                ->get()->result_array();
            }

            function getIndikator($id){
                $this->db->select('a.*')
                    ->from('db_simata.m_indikator_penilaian a')
                    ->where('a.id', $id);
                return $this->db->get()->row_array();
            }

            

            public function updateIndikator(){
                $res['code'] = 0;
                $res['message'] = 'ok';
                $res['data'] = null;
            
                $this->db->trans_begin();
            
                $datapost = $this->input->post();
                $this->db->where('id', $datapost['edit_id'])
                        ->update('db_simata.m_indikator_penilaian', ['nm_indikator' => $datapost['edit_nm_indikator'], 
                                                            'bobot' => $datapost['edit_bobot'],  
                                                             'updated_by' => $this->general_library->getId()]);
                        $res = array('msg' => 'Berhasil Update Data', 'success' => true);
                  
                    
                if($this->db->trans_status() == FALSE){
                    $this->db->trans_rollback();
                    $res['code'] = 1;
                    $res['message'] = 'Terjadi Kesalahan';
                    $res['data'] = null;
                } else {
                    $this->db->trans_commit();
                }
            
                return $res;
            }


            public function getKriteriaPenilaian($id){
                return $this->db->select('a.*')
                                ->from('db_simata.m_kriteria_penilaian a')  
                                ->where('a.id_m_indikator_penilaian', $id)
                                ->where('a.flag_active', 1)
                                ->get()->result_array();
            }


            public function submitTambahKriteria(){
    
                $datapost = $this->input->post();
                
                $this->db->trans_begin();
            
               
                $data["id_m_indikator_penilaian"] = $datapost["id_m_indikator_penilaian"];
                $data["nm_kriteria"] = $datapost["kriteria"];
                $data["skor"] = $datapost["skor"];
                $this->db->insert('db_simata.m_kriteria_penilaian', $data);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

            
            
                if($this->db->trans_status() == FALSE){
                    $this->db->trans_rollback();
                    // $res['code'] = 1;
                    // $res['message'] = 'Terjadi Kesalahan';
                    // $res['data'] = null;
                    $res = array('msg' => 'Data gagal disimpan', 'success' => false);
                } else {
                    $this->db->trans_commit();
                }
            
                return $res;
            }

            public function updateKriteria($id, $data) {


            
            $this->db->trans_begin();
        
            $this->db->where('id', $id);
            $this->db->update('db_simata.m_kriteria_penilaian', $data);  
            $res = array('msg' => 'Data berhasil diubah', 'success' => true);

        
        
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                // $res['code'] = 1;
                // $res['message'] = 'Terjadi Kesalahan';
                // $res['data'] = null;
                $res = array('msg' => 'Data gagal diubah', 'success' => false);
            } else {
                $this->db->trans_commit();
            }
        
            return $res;
        }


        public function submitTambahInterval(){
    
            $datapost = $this->input->post();
            
            $this->db->trans_begin();
        
           
            $data["id_m_unsur_penilaian"] = $datapost["id_m_unsur_penilaian"];
            $data["kriteria"] = $datapost["kriteria"];
            $data["dari"] = $datapost["dari"];
            $data["sampai"] = $datapost["sampai"];
            $this->db->insert('db_simata.m_interval_penilaian', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

        
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                // $res['code'] = 1;
                // $res['message'] = 'Terjadi Kesalahan';
                // $res['data'] = null;
                $res = array('msg' => 'Data gagal disimpan', 'success' => false);
            } else {
                $this->db->trans_commit();
            }
        
            return $res;
        }

        public function getMasterInterval(){
            return $this->db->select('a.*')
                            ->from('db_simata.m_interval_penilaian a')  
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
        }



        public function updateInterval(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;
        
            $this->db->trans_begin();
        
            $datapost = $this->input->post();
            $this->db->where('id', $datapost['edit_interval_id'])
                    ->update('db_simata.m_interval_penilaian', ['kriteria' => $datapost['edit_interval_kriteria'], 
                                                        'dari' => $datapost['edit_interval_dari'],
                                                        'sampai' => $datapost['edit_interval_sampai'],  
                                                         'updated_by' => $this->general_library->getId()]);
                    $res = array('msg' => 'Berhasil Update Data', 'success' => true);
              
                
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $res['code'] = 1;
                $res['message'] = 'Terjadi Kesalahan';
                $res['data'] = null;
            } else {
                $this->db->trans_commit();
            }
        
            return $res;
        }

        function getPegawaiDinilaiToAdministrator($id){
            $id_pangkat = array(33,34);
            $this->db->select('TIMESTAMPDIFF(year,a.tmtjabatan, now()) as masakerjajabatan , a.id_peg, a.nipbaru, a.nama,a.gelar1,a.gelar2, b.nama_jabatan, a.tmtjabatan, c.nm_pangkat')
                ->from('db_pegawai.pegawai a')
                ->join('db_pegawai.jabatan b', 'a.jabatan = b.id_jabatanpeg')
                ->join('db_pegawai.pangkat c', 'a.pangkat = c.id_pangkat')
                // ->where('b.eselon like', '%IV%')
                // ->where("FIND_IN_SET(b.eselon,'IV A,IV B,III B')!=",0)
                // ->group_start()
                // ->where('TIMESTAMPDIFF(year,a.tmtjabatan, now()) >=', '3')
                // ->where("FIND_IN_SET(b.eselon,'IV A,IV B,Non Eselon')!=",0)
                // ->or_where_in('a.pangkat',$id_pangkat)
                // ->group_end()
                // ->where_in('a.pangkat', $id_pangkat)
                // ->where('b.nama_jabatan !=', 'Pelaksana')
                // ->where('b.eselon !=', 'III B')
                ->where('a.id_m_status_pegawai', 1)
                ->where('a.skpd', $id)
                ->order_by('b.eselon', 'asc');
            return $this->db->get()->result_array();
        }

        function getPegawaiDinilaiToJpt($id){
            $id_pangkat = array(41,42,43,34);
            $this->db->select('TIMESTAMPDIFF(year,a.tmtjabatan, now()) as masakerjajabatan , a.id_peg, a.nipbaru, a.nama,a.gelar1,a.gelar2, b.nama_jabatan, a.tmtjabatan, c.nm_pangkat')
                ->from('db_pegawai.pegawai  a')
                ->join('db_pegawai.jabatan b', 'a.jabatan = b.id_jabatanpeg')
                ->join('db_pegawai.pangkat c', 'a.pangkat = c.id_pangkat')
                // ->group_start()
                // ->where('TIMESTAMPDIFF(year,a.tmtjabatan, now()) >=', '3')
                // ->where("FIND_IN_SET(b.eselon,'II B,III A,III B,Non Eselon')!=",0)
                // ->or_where_in('a.pangkat',$id_pangkat)
                // ->group_end()
                ->where_in('a.pangkat', $id_pangkat)
                ->where('b.nama_jabatan !=', 'Pelaksana')
                ->where("FIND_IN_SET(b.eselon,'II B,III A,III B')!=",0)
                ->where('a.id_m_status_pegawai', 1)
                // ->where('b.eselon', 'III B')
                ->where('a.skpd', $id)
                ->order_by('a.pangkat', 'desc');
            return $this->db->get()->result_array();
        }
        
        function getJabatanTargetPegawai(){
            $this->db->select('a.*,b.nama_jabatan,c.nm_unitkerja')
                ->from('db_simata.t_jabatan_target a')
                ->join('db_pegawai.jabatan b', 'a.jabatan_target = b.id_jabatanpeg')
                ->join('db_pegawai.unitkerja c', 'b.id_unitkerja = c.id_unitkerja')
                // ->where('a.id_peg ', 'PEG0000000ei390')
                
                ->where('a.flag_active', 1);
            return $this->db->get()->result_array();
        }
        
             
function getNamaJabatanAdministrator(){
    $this->db->select('*')
    // ->where('id !=', 0)
    // ->where('flag_active', 1)
    ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
    // ->where("FIND_IN_SET(a.eselon,'III B')!=",0)
    ->where_in('a.eselon',["II A", "II B", "III A", "III B"])
    ->group_by('a.nama_jabatan')
    ->from('db_pegawai.jabatan a');
    return $this->db->get()->result_array(); 

}

function getNamaJabatanJpt(){
    $this->db->select('*')
    // ->where('id !=', 0)
    // ->where('flag_active', 1)
    ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
    // ->join('db_simata.t_jabatan_target c', 'a.id_jabatanpeg = c.jabatan_target')
    // ->where("FIND_IN_SET(a.eselon,'II B')!=",0)
    // ->where('a.eselon','II B')
    // ->or_where('a.eselon','III A')
    ->where_in('a.eselon', ["II A", "II B"])
    ->group_by('a.nama_jabatan')
    ->from('db_pegawai.jabatan a');
    return $this->db->get()->result_array(); 
}



function getJabatanTargetJpt(){
    $this->db->select('*')
    // ->where('id !=', 0)
    ->where('c.flag_active', 1)
    ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
    ->join('db_simata.t_jabatan_target c', 'a.id_jabatanpeg = c.jabatan_target')
    // ->where("FIND_IN_SET(a.eselon,'II B')!=",0)
    // ->where('a.eselon','II B')
    // ->or_where('a.eselon','III A')
    ->where_in('a.eselon', ["II A", "II B"])
    ->group_by('a.nama_jabatan')
    ->from('db_pegawai.jabatan a');
    return $this->db->get()->result_array(); 

}


 function submitJabatanTarget(){
 
 $jtarget = [];
 $jtarget = $this->input->post('jabatan_target');
 $id_peg = $this->input->post('id_pegawai');
 $tab = $this->input->post('tab');
 for ($count = 0; $count < count($jtarget); $count++) {
    $jt = $jtarget[$count];
  
    
    $data["id_peg"] = $id_peg;
    $data["jabatan_target"] = $jt;
    $data["created_by"] = $this->general_library->getId();
  
    
    $this->db->insert('db_simata.t_jabatan_target', $data);
    $res = array('msg' => 'Data berhasil disimpan', 'success' => true,'tab' => $tab);

    }    
    
    return $res;
}


public function getPegawaiPenilaianKinerjaAdministratorGroupBy(){
    return $this->db->select('*')
                    ->from('db_simata.t_penilaian a')
                    ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                    ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
                    ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
                    ->where('a.flag_active', 1)
                    ->order_by('a.id', 'asc')
                    ->group_by('a.id_peg') 
                    ->get()->result_array();    
}

public function getPegawaiPenilaianKinerjaJptGroupBy(){
    return $this->db->select('*')
                    ->from('db_simata.t_penilaian a')
                    ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                    ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
                    ->where('a.flag_active', 1)
                    ->where('c.eselon', "II B")
                    ->order_by('a.id', 'asc')
                    ->group_by('a.id_peg') 
                    ->get()->result_array();    
}




public function getPegawaiPenilaianKinerjaAdministrator(){
    return $this->db->select('a.*,b.*,c.*,(SELECT d.nama_jabatan from db_pegawai.jabatan as d
    where b.jabatan = d.id_jabatanpeg limit 1) as jabatan_sekarang')
                    ->from('db_simata.t_penilaian a')
                    ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                    ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
                    ->join('db_pegawai.jabatan e', 'b.jabatan = e.id_jabatanpeg')
                    // ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
                    ->where_in('e.eselon',["III A", "III B"])
                    ->where('a.flag_active', 1)
                    ->order_by('a.id', 'asc') 
                    ->group_by('a.id_peg') 
                    ->get()->result_array();
}

public function getPegawaiPenilaianPotensialAdministrator(){
    return $this->db->select('a.*,b.*,c.*,(SELECT d.nama_jabatan from db_pegawai.jabatan as d
    where b.jabatan = d.id_jabatanpeg limit 1) as jabatan_sekarang')
                    ->from('db_simata.t_penilaian a')
                    ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                    ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
                    ->join('db_pegawai.jabatan e', 'b.jabatan = e.id_jabatanpeg')
                    // ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
                    ->where_in('e.eselon',["III A", "III B"])
                    ->where('a.flag_active', 1)
                    ->order_by('a.id', 'asc') 
                    ->group_by('a.id_peg') 
                    ->get()->result_array();
}

// public function getPegawaiPenilaianKinerjaJpt(){
//     return $this->db->select('a.*,b.*,c.*,(SELECT d.nama_jabatan from db_pegawai.jabatan as d
//     where b.jabatan = d.id_jabatanpeg limit 1) as jabatan_sekarang')
//                     ->from('db_simata.t_penilaian a')
//                     ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
//                     ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
//                     ->join('db_pegawai.jabatan e', 'b.jabatan = e.id_jabatanpeg')
//                     // ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
//                     ->where_in('e.eselon',["II A", "II B"])
//                     ->where('a.flag_active', 1)
//                     ->order_by('a.id', 'asc')
//                     ->group_by('a.id_peg') 
//                     ->get()->result_array();
// }

public function getPegawaiPenilaianKinerjaJpt($id,$penilaian,$jenis_pengisian){
     $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang')
                    ->from('db_pegawai.pegawai a')
                    ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                    // ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
                    // ->where_in('c.eselon',["II A", "II B"])
                    ->where('a.id_m_status_pegawai', 1)
                    // ->where('a.flag_active', 1)
                    ->order_by('c.eselon', 'asc')
                    ->group_by('a.id_peg');
                    if($id == 1){
                        $this->db->where_in('c.eselon', ["III B", "III A"]);
                    }

                    if($id == 2){
                        $this->db->where_in('c.eselon', ["II B", "II A"]);
                    }

                    if($id == 3){
                        $this->db->where_in('c.eselon', ["IV A", "IV B"]);
                    }
                    if($id == 4){
                        $this->db->where_in('c.jenis_jabatan', ["JFU"]);
                        $this->db->where('c.id_jabatanpeg !=', '9050030JS010');
                    }
                    // dd($jenis_pengisian);
             
             
                    $query = $this->db->get()->result_array();
                  
                    if($penilaian == 1){
                       
                    $currentYear = date('Y'); 
                    $previous1Year = $currentYear - 1;   
                    $previous2Year = $currentYear - 2;  

                    if($id == 2 || $id == 1 || $id == 3 || $id == 4){
                    foreach ($query as $rs) {
                        // //    assesment
                        // $nilaiassesment = $this->getNilaiAssesment($rs['id_pegawai']); 
                        // if($nilaiassesment){
                        // $nilaiass = $nilaiassesment['nilai_assesment'];
                        // } else {
                        // $nilaiass = 0;
                        // }
                        // $total_nilai =  $nilaiass * 50 / 100;

                        // $cekceass =  $this->db->select('*')
                        //     ->from('db_simata.t_penilaian_potensial a')
                        //     ->where('a.id_peg', $rs['id_pegawai'])
                        //     ->where('a.nilai_assesment is not null')
                        //     ->where('a.flag_active', 1)
                        //     ->where('a.jenjang_jabatan', $jenis_pengisian)
                        //     ->get()->result_array();
   

                        // if($cekceass){
                        //     $this->db->where('id_peg', $rs['id_pegawai'])
                        //     ->where('jenjang_jabatan', $jenis_pengisian)
                        //     ->update('db_simata.t_penilaian_potensial', 
                        //     ['nilai_assesment' => $nilaiass,
                        //     'jenjang_jabatan' => $jenis_pengisian
                        //         ]);
                        //         $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                        // } else {

                        //     $dataInsert['id_peg']      = $rs['id_pegawai'];
                        //     $dataInsert['nilai_assesment']      = $nilaiass;
                        //     $dataInsert['jenjang_jabatan']      = $jenis_pengisian;
                        //     $this->db->insert('db_simata.t_penilaian_potensial', $dataInsert);
                        //     $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                        // }


                        // $getAllNilaiPotensial =  $this->db->select('*')
                        //             ->from('db_simata.t_penilaian a')
                        //             ->where('a.id_peg', $rs['id_pegawai'])
                        //             ->where('a.flag_active', 1)
                        //             ->where('a.jenjang_jabatan', $jenis_pengisian)
                        //             ->get()->result_array();

                        // if($getAllNilaiPotensial){
                        //     foreach ($getAllNilaiPotensial as $rs2) {
                        
                        //         $total_potensial = $rs2['res_potensial_cerdas'] + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];
                            
                        //         $this->db->where('id_peg', $rs['id_pegawai'])
                        //         ->where('jenjang_jabatan', $jenis_pengisian)
                        //         ->update('db_simata.t_penilaian', 
                        //         ['res_potensial_total' => $total_potensial,
                        //         'res_potensial_cerdas' => $total_nilai,
                        //         'jenjang_jabatan' => $jenis_pengisian
                        //         ]);
                                        
                        //     }
                        // } else {
                        //     $dataInsert2['id_peg']      = $rs['id_pegawai'];
                        //     $dataInsert2['res_potensial_cerdas']      = $total_nilai;
                        //     $dataInsert2['res_potensial_total']      = $total_nilai;
                        //     $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                        //     $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                        // }
                        
                        // //   tutup assesment

                    $total_kinerja = 0;
                       $kriteria1 = $this->getPenilaianKinerja($rs['id_pegawai'],$previous1Year,1); 
                       $kriteria2 = $this->getPenilaianKinerja($rs['id_pegawai'],$previous2Year,2); 
                       $kriteria3 = $this->getInovasiPegawai($rs['id_pegawai']); 
                       $kriteria4 = $this->getPengalamanTimPegawai($rs['id_pegawai']); 
                       $kriteria5 = $this->getPenugasanPengawai($rs['id_pegawai']); 

                    //   if($rs['id_pegawai'] == 'PEG0000000eh992'){
                    //     dd($kriteria4);
                    //    }




                       $data["id_peg"] = $rs['id_pegawai'];
                       $data["kriteria1"] = $kriteria1;
                       $data["kriteria2"] = $kriteria2;
                       $data["kriteria3"] = $kriteria3;
                       $data["kriteria4"] = $kriteria4;
                       $data["kriteria5"] = $kriteria5;
                       $data["kriteria5"] = $kriteria5;
                     

                       $skor1 =  $this->getSkor($kriteria1); 
                       $bobot1 = $this->getBobot($kriteria1); 
                       $total_kinerja1 = $skor1  * $bobot1 / 100;   
                          
                       $skor2 =  $this->getSkor($kriteria2); 
                       $bobot2 = $this->getBobot($kriteria2); 
                       $total_kinerja2 = $skor2  * $bobot2 / 100; 

                       $skor3 =  $this->getSkor($kriteria3); 
                       $bobot3 = $this->getBobot($kriteria3); 
                       $total_kinerja3 = $skor3  * $bobot3 / 100;   
                          
                       $skor4 =  $this->getSkor($kriteria4); 
                       $bobot4 = $this->getBobot($kriteria4); 
                       $total_kinerja4 = $skor4  * $bobot4 / 100; 

                       $skor5 =  $this->getSkor($kriteria5); 
                       $bobot5 = $this->getBobot($kriteria5); 
                       $total_kinerja5 = $skor5  * $bobot5 / 100;
                       
       
                       $total_kinerja = $total_kinerja1 + $total_kinerja2 + $total_kinerja3 + $total_kinerja4 + $total_kinerja5;
                   

                    $cek =  $this->db->select('*')
                    ->from('db_simata.t_penilaian_kinerja a')
                    ->where('a.id_peg', $rs['id_pegawai'])
                    ->where('a.flag_active', 1)
                    ->get()->result_array();

                    if($cek){
                        $this->db->where('id_peg', $rs['id_pegawai'])
                        ->update('db_simata.t_penilaian_kinerja', 
                        ['kriteria1' => $kriteria1,
                        'kriteria2' => $kriteria2,
                        'kriteria3' => $kriteria3,
                        'kriteria4' => $kriteria4,
                        'kriteria5' => $kriteria5,
                            ]);
                            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                    } else {
                        $this->db->insert('db_simata.t_penilaian_kinerja', $data);
                        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
        
                    }

                    
            $cekPenilaian =  $this->db->select('*')
            ->from('db_simata.t_penilaian a')
            ->where('a.id_peg', $rs['id_pegawai'])
            ->where('a.jenjang_jabatan', $jenis_pengisian)
            ->where('a.flag_active', 1)
            ->get()->result_array();
            


            if($cekPenilaian){
                $this->db->where('id_peg', $rs['id_pegawai'])
                ->where('jenjang_jabatan', $jenis_pengisian)
                ->update('db_simata.t_penilaian', 
                ['res_kinerja' => $total_kinerja]);
            } else {
                $datapenilaian["id_peg"] = $rs['id_pegawai'];
                $datapenilaian["created_by"] = $this->general_library->getId();
                $datapenilaian["res_kinerja"] = $total_kinerja;
                $datapenilaian["jenjang_jabatan"] = $jenis_pengisian;
                $this->db->insert('db_simata.t_penilaian', $datapenilaian);
                
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

            }

                    }
                    }

                    $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang')
                    ->from('db_pegawai.pegawai a')
                    ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                    // ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
                    // ->where_in('c.eselon',["II A", "II B"])
                    ->where('a.id_m_status_pegawai', 1)
                    // ->where('a.flag_active', 1)
                    ->order_by('c.eselon', 'asc')
                    ->group_by('a.id_peg');

                    if($id == 1){
                        $this->db->where_in('c.eselon', ["III B", "III A"]);
                    }

                    if($id == 2){
                        $this->db->where_in('c.eselon', ["II B", "II A"]);
                    }

                    if($id == 3){
                        $this->db->where_in('c.eselon', ["IV A", "IV B"]);
                    }

                    if($id == 4){
                        $this->db->where_in('c.jenis_jabatan', ["JFU"]);
                    }
             
             
                    $query = $this->db->get()->result_array();

                }

            return $query;
            }


            public function getPegawaiPenilaianPotensialJptBU($id,$jenis_pengisian,$penilaian,$eselon){
                $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang')
                               ->from('db_pegawai.pegawai a')
                               ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                               ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                               // ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
                               // ->where_in('c.eselon',["II A", "II B"])
                               ->where('a.id_m_status_pegawai', 1)
                               ->where('b.jenjang_jabatan', $jenis_pengisian)
                               // ->where('a.flag_active', 1)
                               ->order_by('c.eselon', 'asc')
                               ->group_by('a.id_peg');
           
                               if($id == 1){
                                   $this->db->where_in('c.eselon', ["III B", "III A"]);
                               }
           
                               if($id == 2){
                                   $this->db->where_in('c.eselon', ["II B", "II A"]);
                               }
           
                               if($id == 3){
                                   $this->db->where_in('c.eselon', ["IV A", "IV B"]);
                               }
                        
                        
                               $query = $this->db->get()->result_array();
                              if($penilaian != 0){
                                // dd(1);
                               foreach ($query as $rs) {
                                // $id_peg = "IDPeg97";
                               
                            if($penilaian == 1){
                            //    assesment
                                $nilaiassesment = $this->getNilaiAssesment($rs['id_pegawai']); 
                                if($nilaiassesment){
                                $nilaiass = $nilaiassesment['nilai_assesment'];
                                } else {
                                $nilaiass = 0;
                                }
                                $total_nilai =  $nilaiass * 50 / 100;

                                $cekceass =  $this->db->select('*')
                                    ->from('db_simata.t_penilaian_potensial a')
                                    ->where('a.id_peg', $rs['id_pegawai'])
                                    ->where('a.nilai_assesment is not null')
                                    ->where('a.flag_active', 1)
                                    ->get()->result_array();
           

                                if($cekceass){
                                    $this->db->where('id_peg', $rs['id_pegawai'])
                                    ->update('db_simata.t_penilaian_potensial', 
                                    ['nilai_assesment' => $nilaiass
                                        ]);
                                        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                                } else {

                                    $dataInsert['id_peg']      = $rs['id_pegawai'];
                                    $dataInsert['nilai_assesment']      = $nilaiass;
                                    $this->db->insert('db_simata.t_penilaian_potensial', $dataInsert);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                                }


                                $getAllNilaiPotensial =  $this->db->select('*')
                                            ->from('db_simata.t_penilaian a')
                                            ->where('a.id_peg', $rs['id_pegawai'])
                                            ->where('a.flag_active', 1)
                                            ->get()->result_array();

                                if($getAllNilaiPotensial){
                                    foreach ($getAllNilaiPotensial as $rs2) {
                                
                                        $total_potensial = $rs2['res_potensial_cerdas'] + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];
                                    
                                        $this->db->where('id_peg', $rs['id_pegawai'])
                                        ->update('db_simata.t_penilaian', 
                                        ['res_potensial_total' => $total_potensial,
                                        'res_potensial_cerdas' => $total_nilai
                                        ]);
                                                
                                    }
                                } else {
                                    $dataInsert2['id_peg']      = $rs['id_pegawai'];
                                    $dataInsert2['res_potensial_cerdas']      = $total_nilai;
                                    $dataInsert2['res_potensial_total']      = $total_nilai;
                                    $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                                }
                                
                                //   tutup assesment
                            }
                            if($penilaian == 2){
                                // rekam jejak
                                    // $updateMasakerja = $this->updateMasakerja($rs['id_pegawai']);
                                    $id_rekamjjk1 = $this->getPendidikanFormal($rs['id_pegawai']); 
                                    $id_rekamjjk2 = $this->getPangkatGolPengawai($rs['id_pegawai'],$id,$jenis_pengisian);
                                    $id_rekamjjk3 = $this->getMasaKerjaJabatan($rs['id_pegawai'],$id,$rs['eselon'],$jenis_pengisian); 
                                    $id_rekamjjk4 = $this->getDiklatPengawai($rs['id_pegawai'],$id,$rs['eselon'],$jenis_pengisian); 
                                    $id_rekamjjk5 = $this->getJPKompetensi($rs['id_pegawai']); 
                                    $id_rekamjjk6 = $this->getPenghargaan($rs['id_pegawai']); 
                                    $id_rekamjjk7 = $this->getHukdisPengawai($rs['id_pegawai']); 
                                        
                                    $id_pertimbangan1 = $this->getPengalamanOrganisasiPengawai($rs['id_pegawai']);


         
                                $skor1 =  $this->getSkor($id_rekamjjk1); 
                                $bobot1 = $this->getBobot($id_rekamjjk1); 
                                $total_rj1 = $skor1  * $bobot1 / 100;   
                                    
                                $skor2 =  $this->getSkor($id_rekamjjk2); 
                                $bobot2 = $this->getBobot($id_rekamjjk2); 
                                $total_rj2 = $skor2  * $bobot2 / 100; 

                                $skor3 =  $this->getSkor($id_rekamjjk3); 
                                $bobot3 = $this->getBobot($id_rekamjjk3); 
                                $total_rj3 = $skor3  * $bobot3 / 100;   
                                    
                                $skor4 =  $this->getSkor($id_rekamjjk4); 
                                $bobot4 = $this->getBobot($id_rekamjjk4); 
                                $total_rj4 = $skor4  * $bobot4 / 100; 

                                $skor5 =  $this->getSkor($id_rekamjjk5); 
                                $bobot5 = $this->getBobot($id_rekamjjk5); 
                                $total_rj5 = $skor5  * $bobot5 / 100;

                                $skor6 =  $this->getSkor($id_rekamjjk6); 
                                $bobot6 = $this->getBobot($id_rekamjjk6); 
                                $total_rj6 = $skor6  * $bobot6 / 100;

                                $skor7 =  $this->getSkor($id_rekamjjk7); 
                                $bobot7 = $this->getBobot($id_rekamjjk7); 
                                $total_rj7 = $skor7  * $bobot7 / 100;

                                $skor8 =  $this->getSkor($id_pertimbangan1); 
                                $bobot8 = $this->getBobot($id_pertimbangan1); 
                                $total_pertimbangan_lainnya1 = $skor8  * $bobot8 / 100;
                                
                                $total_rj = $total_rj1 + $total_rj2 + $total_rj3 + $total_rj4 + $total_rj5 + + $total_rj6 + + $total_rj7;
                                $total_pertimbangan_lainnya = $total_pertimbangan_lainnya1;
                    
                                    $data["id_peg"] = $rs['id_pegawai'];
                                    $data["pendidikan_formal"] = $id_rekamjjk1;
                                    $data["pangkat_gol"] = $id_rekamjjk2;
                                    $data["masa_kerja_jabatan"] = $id_rekamjjk3;
                                    $data["diklat"] = $id_rekamjjk4;
                                    $data["kompetensi20_jp"] = $id_rekamjjk5;
                                    $data["penghargaan"] = $id_rekamjjk6;
                                    $data["riwayat_hukdis"] = $id_rekamjjk7;
                                    // $data['nilai_assesment'] = $nilaiass;
                                    $data["pengalaman_organisasi"] = $id_pertimbangan1;
                        // $data["jabatan_target"] = $this->input->post('rj_jabatan_target');

                        $cekkrj =  $this->db->select('*')
                                                ->from('db_simata.t_penilaian_potensial a')
                                                ->where('a.id_peg', $rs['id_pegawai'])
                                                ->where('a.flag_active', 1)
                                                ->where('a.nilai_assesment is not null')
                                                ->get()->result_array();

                        if($cekkrj){
                            $this->db->where('id_peg', $rs['id_pegawai'])
                            ->update('db_simata.t_penilaian_potensial', 
                            ['pendidikan_formal' => $id_rekamjjk1,
                            'pangkat_gol' => $id_rekamjjk2,
                            'masa_kerja_jabatan' => $id_rekamjjk3,
                            'diklat' => $id_rekamjjk4,
                            'kompetensi20_jp' => $id_rekamjjk5,
                            'penghargaan' => $id_rekamjjk6,
                            'riwayat_hukdis' => $id_rekamjjk7,
                            // 'nilai_assesment' => $nilaiass,
                            'pengalaman_organisasi' => $id_pertimbangan1,
                                ]);
                                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                                } else {
                                    $this->db->insert('db_simata.t_penilaian_potensial', $data);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

                                }

                                     $this->db->where('id_peg', $rs['id_pegawai'])
                                    //  ->where('id_jabatan_target', $datapost['rj_jabatan_target']) 
                                    ->update('db_simata.t_penilaian', 
                                    ['res_potensial_rj' => $total_rj]);

                                     $getAllNilaiPotensial =  $this->db->select('*')
                                    ->from('db_simata.t_penilaian a')
                                    ->where('a.id_peg', $rs['id_pegawai'])
                                    // ->where('a.id_jabatan_target', $datapost['rj_jabatan_target'])
                                    ->where('a.flag_active', 1)
                                    ->get()->result_array();
                        
                                    if($getAllNilaiPotensial){
                                    // $total_potensial = $getAllNilaiPotensial[0]['res_potensial_cerdas'] + $getAllNilaiPotensial[0]['res_potensial_rj'] + $getAllNilaiPotensial[0]['res_potensial_lainnya'];

                                        foreach ($getAllNilaiPotensial as $rs2) {
                                        $total_potensial = $rs['res_potensial_cerdas'] + $total_rj + $total_pertimbangan_lainnya;
                                        $this->db->where('id_peg', $rs['id_pegawai'])
                                        // ->where('id_jabatan_target', $rs2['id_jabatan_target'])
                                        ->update('db_simata.t_penilaian', 
                                        ['res_potensial_total' => $total_potensial,
                                        'res_potensial_rj' => $total_rj,
                                        // 'res_potensial_cerdas' => $total_nilai,
                                        'res_potensial_lainnya' => $total_pertimbangan_lainnya]);
                                                    
                                        }
                                    } else {
                                        $dataInsert2['id_peg']      = $rs['id_pegawai'];
                                        $dataInsert2['res_potensial_rj']      = $total_rj;
                                        // $dataInsert2['res_potensial_cerdas']      = $total_nilai;
                                        $dataInsert2['res_potensial_total']      = $total_rj;
                                        $dataInsert2['res_potensial_lainnya']      = $total_pertimbangan_lainnya;
                                        $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                                    }
    
                                // tutup rekam jejak
                               }
                               }
                               $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang')
                               ->from('db_pegawai.pegawai a')
                               ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                               ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                               ->where('a.id_m_status_pegawai', 1)
                               ->where('b.jenjang_jabatan', $jenis_pengisian)
                               ->order_by('c.eselon', 'asc')
                               ->group_by('a.id_peg');
           
                               if($id == 1){
                                   $this->db->where_in('c.eselon', ["III B", "III A"]);
                               }
           
                               if($id == 2){
                                   $this->db->where_in('c.eselon', ["II B", "II A"]);
                               }
           
                               if($id == 3){
                                   $this->db->where_in('c.eselon', ["IV A", "IV B"]);
                               }
                    
                               $query = $this->db->get()->result_array();

                            }

                       return $query;
                       }

            function getSkor($id){
                $skor = null;
                 $this->db->select('a.*,b.bobot')
                ->where('a.id', $id)
                ->join('db_simata.m_indikator_penilaian b', 'a.id_m_indikator_penilaian = b.id')
                ->from('db_simata.m_kriteria_penilaian a');
                $query = $this->db->get()->result_array(); 
                
                if($query){
                    $skor = $query[0]['skor'];
                }
                return $skor;
            }


            function getBobot($id){
                $bobot = null;
                $this->db->select('a.*,b.bobot')
               ->where('a.id', $id)
               ->join('db_simata.m_indikator_penilaian b', 'a.id_m_indikator_penilaian = b.id')
               ->from('db_simata.m_kriteria_penilaian a');
               $query = $this->db->get()->result_array(); 

               if($query){
                $bobot = $query[0]['bobot'];
            }
            return $bobot;
           }

        function getKriteriaKinerja1(){
            $this->db->select('a.*,b.bobot')
            ->where('a.id_m_indikator_penilaian', 19)
            ->join('db_simata.m_indikator_penilaian b', 'a.id_m_indikator_penilaian = b.id')
            ->from('db_simata.m_kriteria_penilaian a');
            return $this->db->get()->result_array(); 
        }

        function getKriteriaKinerja2(){
            $this->db->select('a.*,b.bobot')
            ->where('a.id_m_indikator_penilaian', 20)
            ->join('db_simata.m_indikator_penilaian b', 'a.id_m_indikator_penilaian = b.id')
            ->from('db_simata.m_kriteria_penilaian a');
            return $this->db->get()->result_array(); 
        }

        function getKriteriaKinerja3(){
            $this->db->select('a.*,b.bobot')
            ->where('a.id_m_indikator_penilaian', 21)
            ->join('db_simata.m_indikator_penilaian b', 'a.id_m_indikator_penilaian = b.id')
            ->from('db_simata.m_kriteria_penilaian a');
            return $this->db->get()->result_array(); 
        }

        function getKriteriaKinerja4(){
            $this->db->select('a.*,b.bobot')
            ->where('a.id_m_indikator_penilaian', 22)
            ->join('db_simata.m_indikator_penilaian b', 'a.id_m_indikator_penilaian = b.id')
            ->from('db_simata.m_kriteria_penilaian a');
            return $this->db->get()->result_array(); 
        }

        function getKriteriaKinerja5(){
            $this->db->select('a.*,b.bobot')
            ->where('a.id_m_indikator_penilaian', 23)
            ->join('db_simata.m_indikator_penilaian b', 'a.id_m_indikator_penilaian = b.id')
            ->from('db_simata.m_kriteria_penilaian a');
            return $this->db->get()->result_array(); 
        }

        public function submitPenilaianKinerja(){
    
            $datapost = $this->input->post();
            $this->db->trans_begin();
            $total_kinerja = null;
            // if($this->input->post('kriteria1') != 0){
            // $krit = $this->input->post('kriteria1');
            // $kriteria = explode(",", $krit);
            // $id_kriteria = $kriteria[0];
            // $skor = $kriteria[1];
            // $bobot = $kriteria[2];
           
           
            for($x=1;$x<=5;$x++){
                $krit = $this->input->post('kriteria'.$x.'');
                  $kriteria = explode(",", $krit);
                  $id_kriteria = $kriteria[0];
                  $skor = $kriteria[1];
                  $bobot = $kriteria[2];
                  $total_kinerja += $skor * $bobot / 100;   
            }
        //  }

           $krit1 = $this->input->post('kriteria1');
           $kriteria1 = explode(",", $krit1);
           $id_kriteria1 = $kriteria1[0];

           $krit2 = $this->input->post('kriteria2');
           $kriteria2 = explode(",", $krit2);
           $id_kriteria2 = $kriteria2[0];

           $krit3 = $this->input->post('kriteria3');
           $kriteria3 = explode(",", $krit3);
           $id_kriteria3 = $kriteria3[0];

           $krit4 = $this->input->post('kriteria4');
           $kriteria4 = explode(",", $krit4);
           $id_kriteria4 = $kriteria4[0];

           $krit5 = $this->input->post('kriteria5');
           $kriteria5 = explode(",", $krit5);
           $id_kriteria5 = $kriteria5[0];
           

            $data["id_peg"] = $datapost["id_peg"];
            $data["kriteria1"] = $id_kriteria1;
            $data["kriteria2"] = $id_kriteria2;
            $data["kriteria3"] = $id_kriteria3;
            $data["kriteria4"] = $id_kriteria4;
            $data["kriteria5"] = $id_kriteria5;

            $cek =  $this->db->select('*')
                                    ->from('db_simata.t_penilaian_kinerja a')
                                    ->where('a.id_peg', $data["id_peg"])
                                    ->where('a.flag_active', 1)
                                    ->get()->result_array();

            if($cek){
                $this->db->where('id_peg', $datapost['id_peg'])
                ->update('db_simata.t_penilaian_kinerja', 
                ['kriteria1' => $id_kriteria1,
                'kriteria2' => $id_kriteria2,
                'kriteria3' => $id_kriteria3,
                'kriteria4' => $id_kriteria4,
                'kriteria5' => $id_kriteria5,
                    ]);
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            } else {
                $this->db->insert('db_simata.t_penilaian_kinerja', $data);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

            }

            $cekPenilaian =  $this->db->select('*')
            ->from('db_simata.t_penilaian a')
            ->where('a.id_peg', $data["id_peg"])
            ->where('a.flag_active', 1)
            ->get()->result_array();


            if($cekPenilaian){
                $this->db->where('id_peg', $datapost['id_peg'])
                ->update('db_simata.t_penilaian', 
                ['res_kinerja' => $total_kinerja]);
            } else {
                $datapenilaian["id_peg"] = $data["id_peg"];
                $datapenilaian["created_by"] = $this->general_library->getId();
                $datapenilaian["res_kinerja"] = $total_kinerja;
                $this->db->insert('db_simata.t_penilaian', $datapenilaian);
                
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

            }

          

          

        
        
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                // $res['code'] = 1;
                // $res['message'] = 'Terjadi Kesalahan';
                // $res['data'] = null;
                $res = array('msg' => 'Data gagal disimpan', 'success' => false);
            } else {
                $this->db->trans_commit();
            }
        
            return $res;
        }

        function getPegawaiNilaiKinerjaPegawai($nip){
            $this->db->select('a.*,b.nipbaru')
                ->from('db_simata.t_penilaian_kinerja a')
                ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                ->where('b.nipbaru', $nip);
                // ->limit(1);
            return $this->db->get()->row_array();
        }

        function getPegawaiNilaiPotensialPegawai($nip,$jenis_pengisian){
            $this->db->select('a.*,b.nipbaru')
                ->from('db_simata.t_penilaian_potensial a')
                ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                ->where('b.nipbaru', $nip)
                ->where('a.jenjang_jabatan', $jenis_pengisian);
                // ->limit(1);
            return $this->db->get()->row_array();
        }

        function getListIntervalKinerja(){
            $this->db->select('*')
                ->from('db_simata.m_interval_penilaian a')
                ->where('a.id_m_unsur_penilaian', 1)
                ->where('a.flag_active', 1);
                // ->limit(1);
            return $this->db->get()->result_array();
        }

        function getListIntervalPotensial(){
            $this->db->select('*')
                ->from('db_simata.m_interval_penilaian a')
                ->where('a.id_m_unsur_penilaian', 2)
                ->where('a.flag_active', 1);
                // ->limit(1);
            return $this->db->get()->result_array();
        }

        // public function getPenilaianPegawaiAdm(){
        //      $this->db->select('a.*,b.nama')
        //                     ->from('db_simata.t_penilaian a')
        //                     ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
        //                     ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
        //                     ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                     // ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
        //                     ->where_in('d.eselon', ["III A", "III B"])
        //                     ->where('a.flag_active', 1)
        //                     ->group_by('a.id_peg');
        //                     if($_POST['jabatan_target_jpt'] != ""){
        //                         $this->db->where('c.id_jabatanpeg', $_POST['jabatan_target_jpt']);
        //                     }
        //          return  $this->db->get()->result();
                         
        // }

        public function getPenilaianPegawaiAdm($jenis_pengisian){
            // $this->db->select('a.*,c.res_kinerja,c.res_potensial_cerdas,c.res_potensial_rj,c.res_potensial_lainnya')
            $this->db->select('a.id_peg as id_pegawai,c.*')
                          
            ->from('db_pegawai.pegawai a')
                        //    ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                           ->join('db_simata.t_penilaian c', 'a.id_peg = c.id_peg','left')
                           ->join('db_pegawai.jabatan d', 'a.jabatan = d.id_jabatanpeg')
                           ->join('db_simata.t_jabatan_target d', 'c.id_peg = d.id_peg','left')
                           // ->where("FIND_IN_SET(c.eselon,'II B')!=",0)
                           ->where_in('d.eselon', ["III A", "III B"])
                           ->where('a.id_m_status_pegawai', 1)
                           ->where('c.jenjang_jabatan', $jenis_pengisian)
                           ->group_by('a.id_peg');
                           if($_POST['jabatan_target_jpt'] != ""){
                               $this->db->where('d.jabatan_target', $_POST['jabatan_target_jpt']);
                           }
               return  $this->db->get()->result();
       }

       public function getPenilaianPegawaiPengawas($jenis_pengisian){
        // $this->db->select('a.*,c.res_kinerja,c.res_potensial_cerdas,c.res_potensial_rj,c.res_potensial_lainnya')
        $this->db->select('a.id_peg as id_pegawai,c.*')
                      
        ->from('db_pegawai.pegawai a')
                    //    ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                       ->join('db_simata.t_penilaian c', 'a.id_peg = c.id_peg','left')
                       ->join('db_pegawai.jabatan d', 'a.jabatan = d.id_jabatanpeg')
                       ->join('db_simata.t_jabatan_target d', 'c.id_peg = d.id_peg','left')
                       // ->where("FIND_IN_SET(c.eselon,'II B')!=",0)
                       ->where_in('d.eselon', ["IV A", "IV B"])
                       ->where('a.id_m_status_pegawai', 1)
                       ->where('c.jenjang_jabatan', $jenis_pengisian)
                       ->group_by('a.id_peg');
                       if($_POST['jabatan_target_jpt'] != ""){
                           $this->db->where('d.jabatan_target', $_POST['jabatan_target_jpt']);
                       }
           return  $this->db->get()->result();
   }

   public function getPenilaianPegawaiPelaksana($jenis_pengisian){
    // $this->db->select('a.*,c.res_kinerja,c.res_potensial_cerdas,c.res_potensial_rj,c.res_potensial_lainnya')
    $this->db->select('a.id_peg as id_pegawai,c.*')
                  
    ->from('db_pegawai.pegawai a')
                //    ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                   ->join('db_simata.t_penilaian c', 'a.id_peg = c.id_peg','left')
                   ->join('db_pegawai.jabatan d', 'a.jabatan = d.id_jabatanpeg')
                   ->join('db_simata.t_jabatan_target d', 'c.id_peg = d.id_peg','left')
                   // ->where("FIND_IN_SET(c.eselon,'II B')!=",0)
                   ->where('d.jenis_jabatan', "JFU")
                   ->where('a.id_m_status_pegawai', 1)
                   ->where('c.jenjang_jabatan', $jenis_pengisian)
                   ->group_by('a.id_peg');
                   if($_POST['jabatan_target_jpt'] != ""){
                       $this->db->where('d.jabatan_target', $_POST['jabatan_target_jpt']);
                   }
       return  $this->db->get()->result();
}


   
        // public function getPenilaianPegawaiJpt(){
        //      $this->db->select('a.*,b.nama')
        //                     ->from('db_simata.t_penilaian a')
        //                     ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
        //                     // ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
        //                     ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                     // ->where("FIND_IN_SET(c.eselon,'II B')!=",0)
        //                     ->where_in('d.eselon', ["II A", "II B"])
        //                     ->where('a.flag_active', 1)
        //                     ->group_by('a.id_peg');
        //                     if($_POST['jabatan_target_jpt'] != ""){
        //                         $this->db->where('c.id_jabatanpeg', $_POST['jabatan_target_jpt']);
        //                     }
        //         return  $this->db->get()->result();
        // }

        public function getPenilaianPegawaiJpt($jenis_pengisian){
            // $this->db->select('a.*,c.res_kinerja,c.res_potensial_cerdas,c.res_potensial_rj,c.res_potensial_lainnya')
            $this->db->select('a.nama,a.id_peg as id_pegawai,c.*')
                         
            ->from('db_pegawai.pegawai a')
                        //    ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                           ->join('db_simata.t_penilaian c', 'a.id_peg = c.id_peg','left')
                           ->join('db_pegawai.jabatan d', 'a.jabatan = d.id_jabatanpeg')
                           ->join('db_simata.t_jabatan_target d', 'c.id_peg = d.id_peg','left')
                           // ->where("FIND_IN_SET(c.eselon,'II B')!=",0)
                           ->where_in('d.eselon', ["II A", "II B"])
                           ->where('a.id_m_status_pegawai', 1)
                           ->where('c.jenjang_jabatan', $jenis_pengisian)
                           ->group_by('a.id_peg');
                           if($_POST['jabatan_target_jpt'] != ""){
                               $this->db->where('d.jabatan_target', $_POST['jabatan_target_jpt']);
                           }
               return  $this->db->get()->result();
       }



        function getNilaiAssesment($id){
            $this->db->select('*')
                ->from('db_pegawai.pegassesment a')
                ->where('a.id_pegawai', $id)
                ->order_by('a.tahun', 'desc')
                ->where('a.flag_active', 1)
                ->limit(1);
            return $this->db->get()->row_array();
        }

        function getPendidikanFormal($id){
            $this->db->select('a.pendidikan')
                ->from('db_pegawai.pegawai a')
                ->where('a.id_peg', $id)
                ->limit(1);
            $pendidikan =  $this->db->get()->row_array();

            $id_pendidikan = null;
            if($pendidikan['pendidikan'] == "9000"){
                $id_pendidikan = 91;  
            } else if($pendidikan['pendidikan'] == "8000"){
                $id_pendidikan = 92;
            } else if($pendidikan['pendidikan'] == "7000" || $pendidikan['pendidikan'] == "6000") {
                $id_pendidikan = 93;
            } else if($pendidikan['pendidikan'] == "5000") {
                $id_pendidikan = 94;
            } else if($pendidikan['pendidikan'] == "2000"){
                $id_pendidikan = 95;
            }
            return $id_pendidikan;
        }

        function getPenghargaan($id){
            $this->db->select('a.pemberi')
                ->from('db_pegawai.pegpenghargaan a')
                ->where('a.id_pegawai', $id)
                ->where('a.status', 2)
                ->where('a.flag_active', 1);
            $penghargaan =  $this->db->get()->result_array();

            $id_penghargaan = null;
            $qty1 = 0;
            $qty2 = 0;
            $qty3 = 0;
            $qty4 = 0;
         
            foreach ($penghargaan as $peng) {
               if($peng['pemberi'] == 1 ){ 
                $qty1++;
               } 
               if($peng['pemberi'] == 2 ){ 
                $qty2++;
               } 
               if($peng['pemberi'] == 3 ){ 
                $qty3++;
               } 
               if($peng['pemberi'] == 4 ){ 
                $qty4++;
               } 
            }
           
            if($qty1 != 0){
                $id_penghargaan = 111; 
            } else if($qty2 != 0) {
                $id_penghargaan = 112;
            } else if($qty3 != 0) {
                $id_penghargaan = 113;
            } else if($qty4 != 0) {
                $id_penghargaan = 114;
            }

            return $id_penghargaan;
        }

        function getJPKompetensi($id){
            $currentYear = date('Y'); 
            $previous1Year = $currentYear - 1;   

            $this->db->select('a.jam')
                ->from('db_pegawai.pegdiklat a')
                ->where('a.id_pegawai', $id)
                ->where('year(a.tglmulai)', $previous1Year)
                ->where('a.status', 2)
                ->where('a.flag_active', 1);
            $jpkompetensi =  $this->db->get()->result_array();


            $id_jpkompetensi = null;
            $totaljam = 0;
            if($jpkompetensi){
            foreach ($jpkompetensi as $jp) {
                $string = $jp['jam'];
                $jam = filter_var($string, FILTER_SANITIZE_NUMBER_INT);
                if($jam){
                    if($jam != "-"){
                        $totaljam += $jam;
                    }
                }
                
              
             }
            }
         
             if($totaljam > 20){
                $id_jpkompetensi = 108;
             } else if($totaljam == 20) {
                $id_jpkompetensi = 109;
             } else if($totaljam < 20){
             $id_jpkompetensi = 110;
             }

             return $id_jpkompetensi;

        }

        function getEselonJT($jt){
            $this->db->select('*')
            ->from('db_pegawai.jabatan a')
            ->where('a.id_jabatanpeg', $jt);
        $jabatan = $this->db->get()->row_array();
        return $jabatan;
        }

        function getPangkatGolPengawai($id,$kode,$jenis_pengisian){
        //   dd($kode);
            
            $id_pangkat = null;
            $this->db->select('a.pangkat,a.tmtpangkat')
                ->from('db_pegawai.pegpangkat a')
                ->where('a.id_pegawai', $id)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->order_by('a.tmtpangkat', 'desc')
                ->limit(1);
            $pangkat =  $this->db->get()->result_array();
          
            if($pangkat){
            if($kode == 1){
              
                if($pangkat[0]['pangkat'] > 33 && $pangkat[0]['pangkat'] < 45) {
                   
                    if($jenis_pengisian == 3){
                       
                        if($pangkat[0]['pangkat'] > 41 && $pangkat[0]['pangkat'] < 45) {
                            $id_pangkat = 96;
                        } else {
                            $sdate = $pangkat[0]['tmtpangkat'];
                            $edate = date('Y-m-d');
                            $date_diff = abs(strtotime($edate) - strtotime($sdate));
                            $years = floor($date_diff / (365*60*60*24));
                            $months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
                            $days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        
                            if($years >= 5) {
                                $id_pangkat = 97;
                            } else if($years == 4){
                                $id_pangkat = 98;
                            } else if($years == 3){
                                $id_pangkat = 99;
                            } else if($years <= 2){
                                $id_pangkat = 100;
                            }
                        }
                       
                       
                    } else if($jenis_pengisian == 2){
                        $id_pangkat = 96;
                    }
                   
                } else if($pangkat[0]['pangkat'] =  33) {
                    $sdate = $pangkat[0]['tmtpangkat'];
                    $edate = date('Y-m-d');
                    $date_diff = abs(strtotime($edate) - strtotime($sdate));
                    $years = floor($date_diff / (365*60*60*24));
                    $months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                    if($years >= 5) {
                        $id_pangkat = 97;
                    } else if($years == 4){
                        $id_pangkat = 98;
                    } else if($years == 3){
                        $id_pangkat = 99;
                    } else if($years <= 2){
                        $id_pangkat = 100;
                    }

                }

            } else if($kode == 2){
              
            //   if($id == 'IDPeg167'){
            //     dd($pangkat);
            //   }
           
                if($pangkat[0]['pangkat'] > 41 && $pangkat[0]['pangkat'] < 45) {
                    $id_pangkat = 96;
                } else if($pangkat[0]['pangkat'] =  41) {
                   
                    $sdate = $pangkat[0]['tmtpangkat'];
                    $edate = date('Y-m-d');
                    $date_diff = abs(strtotime($edate) - strtotime($sdate));
                    $years = floor($date_diff / (365*60*60*24));
                    $months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    // dd($years);
                    if($years >= 5) {
                        $id_pangkat = 97;
                    } else if($years == 4){
                        $id_pangkat = 98;
                    } else if($years == 3){
                        $id_pangkat = 99;
                    } else if($years <= 2){
                        $id_pangkat = 100;
                    }

                }
            } else if($kode == 3) {
                if($jenis_pengisian == 2){
                    if($pangkat[0]['pangkat'] > 33 && $pangkat[0]['pangkat'] < 45) {
                        $id_pangkat = 96;
                } else if($pangkat[0]['pangkat'] =  33) {
                    $sdate = $pangkat[0]['tmtpangkat'];
                    $edate = date('Y-m-d');
                    $date_diff = abs(strtotime($edate) - strtotime($sdate));
                    $years = floor($date_diff / (365*60*60*24));
                    $months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                    if($years >= 5) {
                        $id_pangkat = 97;
                    } else if($years == 4){
                        $id_pangkat = 98;
                    } else if($years == 3){
                        $id_pangkat = 99;
                    } else if($years <= 2){
                        $id_pangkat = 100;
                    }

                }
                } else if($jenis_pengisian == 1) {
                    if($pangkat[0]['pangkat'] > 31 && $pangkat[0]['pangkat'] < 45) {
                        $id_pangkat = 96;
                } else if($pangkat[0]['pangkat'] ==  31) {
                    $sdate = $pangkat[0]['tmtpangkat'];
                    $edate = date('Y-m-d');
                    $date_diff = abs(strtotime($edate) - strtotime($sdate));
                    $years = floor($date_diff / (365*60*60*24));
                    $months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                    if($years >= 5) {
                        $id_pangkat = 97;
                    } else if($years == 4){
                        $id_pangkat = 98;
                    } else if($years == 3){
                        $id_pangkat = 99;
                    } else if($years <= 2){
                        $id_pangkat = 100;
                    }
                }
                }
               

            } else if($kode == 4) {
            //   dd($pangkat[0]['pangkat']);
                if($pangkat[0]['pangkat'] > 31 && $pangkat[0]['pangkat'] < 45) {
                        $id_pangkat = 96;
                } else if($pangkat[0]['pangkat'] ==  31) {
                    
                    $sdate = $pangkat[0]['tmtpangkat'];
                    $edate = date('Y-m-d');
                    $date_diff = abs(strtotime($edate) - strtotime($sdate));
                    $years = floor($date_diff / (365*60*60*24));
                    $months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                    if($years >= 5) {
                        $id_pangkat = 97;
                    } else if($years == 4){
                        $id_pangkat = 98;
                    } else if($years == 3){
                        $id_pangkat = 99;
                    } else if($years <= 2){
                        $id_pangkat = 100;
                    }
                }

            }
        }
        // dd($id_pangkat);

            return $id_pangkat;
        }

        function getPengalamanOrganisasiPengawai($id){
            $this->db->select('*')
                ->from('db_pegawai.pegorganisasi a')
                ->where('a.id_pegawai', $id)
                ->where('a.flag_active', 1)
                // ->where('a.lingkup_timkerja', 1)
                ->where('a.status', 2);
            $organisasi = $this->db->get()->result_array();

            $id_org = null;
            $qty1 = 0;
            $qty2 = 0;
            $qty3 = 0;
            $qty4 = 0;
            $qty5 = 0;
         
            foreach ($organisasi as $org) {
               if($org['jenis_organisasi'] == 8 && $org['id_jabatan_organisasi'] == 1){ 
                 $qty1++;
               } else if($org['id_jabatan_organisasi'] == 1){      
                 $qty2++;
               } else if($org['jenis_organisasi'] == 8 && $org['id_jabatan_organisasi'] == 2 || $org['id_jabatan_organisasi'] == 3 || $org['id_jabatan_organisasi'] == 4 || $org['id_jabatan_organisasi'] == 8) {
                 $qty3++;
               } else if($org['id_jabatan_organisasi'] == 2 || $org['id_jabatan_organisasi'] == 3 || $org['id_jabatan_organisasi'] == 4 || $org['id_jabatan_organisasi'] == 8) {
                 $qty4++;
               } else if($org['jenis_organisasi'] == 8 && $org['id_jabatan_organisasi'] == 5){
                 $qty5++;
               } else if($org['id_jabatan_organisasi'] == 5){
                 $qty5++;
               }
            }

            if($qty1 > 0){
                $id_org = 119;
            } else if($qty2 > 0){
                $id_org = 120;
            } else if($qty3 > 0){
                $id_org = 121;
            } else if($qty4 > 0){
                $id_org = 122;
            } else if($qty5 > 0){
                $id_org = 123;
            }
            return $id_org;
        }

    //     function getDiklatPengawai($id,$jenis_pengisian,$eselonpegawai,$jabatanpegawai){
            
    //         $id_diklat = null;
    
    //         if($eselonjt == "II B"){
    //         $this->db->select('*')
    //             ->from('db_pegawai.pegdiklatx a')
    //             ->where('a.id_pegawai', $id)
    //             ->where('a.jenjang_diklat', 3)
    //             ->where('a.flag_active', 1);
    //         $diklat = $this->db->get()->result_array();
    //         if($diklat){
    //             $id_diklat = 105;
    //         }
    //         } else if($eselonjt == "III B" || $eselonjt == "III A"){
    //         $this->db->select('*')
    //             ->from('db_pegawai.pegdiklat a')
    //             ->where('a.id_pegawai', $id)
    //             ->where('a.jenjang_diklat', 2)
    //             ->where('a.flag_active', 1);
    //         $diklat = $this->db->get()->result_array();
    //         if($diklat){
    //             $id_diklat = 105;
    //         }
    //         }

    //         if($id_diklat == null){
    //         if($eselonpegawai == "III B" || $eselonpegawai == "III A"){
    //             $this->db->select('*')
    //             ->from('db_pegawai.pegdiklat a')
    //             ->where('a.id_pegawai', $id)
    //             ->where('a.jenjang_diklat', 2)
    //             ->where('a.flag_active', 1);
    //             $diklat = $this->db->get()->result_array();
    //             if($diklat){
    //                 $id_diklat = 106;
    //             } else {
    //                 $this->db->select('*')
    //                 ->from('db_pegawai.pegdiklat a')
    //                 ->where('a.id_pegawai', $id)
    //                 ->where('a.jenjang_diklat', 1)
    //                 ->where('a.flag_active', 1);
    //                 $diklat = $this->db->get()->result_array();
    //                 if($diklat){
    //                     $id_diklat = 107;
    //                 } 
    //             }
    //         } else if($eselonpegawai == "II B"){
    //             $this->db->select('*')
    //             ->from('db_pegawai.pegdiklat a')
    //             ->where('a.id_pegawai', $id)
    //             ->where('a.jenjang_diklat', 3)
    //             ->where('a.flag_active', 1);
    //             $diklat = $this->db->get()->result_array();
    //             if($diklat){
    //                 $id_diklat = 106;
    //             } else {
    //                 $this->db->select('*')
    //                 ->from('db_pegawai.pegdiklat a')
    //                 ->where('a.id_pegawai', $id)
    //                 ->where('a.jenjang_diklat', 2)
    //                 ->where('a.flag_active', 1);
    //                 $diklat = $this->db->get()->result_array();
    //                 if($diklat){
    //                     $id_diklat = 107;
    //                 } 
    //             }
    //         } else if($eselonpegawai == "IV A"){
    //             $this->db->select('*')
    //             ->from('db_pegawai.pegdiklat a')
    //             ->where('a.id_pegawai', $id)
    //             ->where('a.jenjang_diklat', 1)
    //             ->where('a.flag_active', 1);
    //             $diklat = $this->db->get()->result_array();
    //             if($diklat){
    //                 $id_diklat = 106;
    //             }
    //         } 
    //     }

    //     if($id_diklat == null){
    //        if($eselonpegawai == "Non Eselon"){
    //         if(strpos($jabatanpegawai, "Muda")) { 
                
    //             if($eselonjt == "II B"){
    //                 $this->db->select('*')
    //                     ->from('db_pegawai.pegdiklat a')
    //                     ->where('a.id_pegawai', $id)
    //                     ->where('a.jenjang_diklat', 9)
    //                     ->where('a.flag_active', 1);
    //                 $diklat = $this->db->get()->result_array();
    //                 if($diklat){
    //                     $id_diklat = 105;
    //                 }
    //                 } else if($eselonjt == "III B" || $eselonjt == "III A"){
    //                 $this->db->select('*')
    //                     ->from('db_pegawai.pegdiklat a')
    //                     ->where('a.id_pegawai', $id)
    //                     ->where('a.jenjang_diklat', 8)
    //                     ->where('a.flag_active', 1);
    //                 $diklat = $this->db->get()->result_array();
    //                 if($diklat){
    //                     $id_diklat = 105;
    //                 }
    //                 }

    //             if($id_diklat == null){
    //                 $this->db->select('*')
    //                     ->from('db_pegawai.pegdiklat a')
    //                     ->where('a.id_pegawai', $id)
    //                     ->where('a.jenjang_diklat', 7)
    //                     ->where('a.flag_active', 1);
    //                 $diklat = $this->db->get()->result_array();
    //                 if($diklat){
    //                     $id_diklat = 106;
    //                 }
    //             }

    //         } else if(strpos($jabatanpegawai, "Madya")) { 
    //             $this->db->select('*')
    //             ->from('db_pegawai.pegdiklat a')
    //             ->where('a.id_pegawai', $id)
    //             ->where('a.jenjang_diklat', 9)
    //             ->where('a.flag_active', 1);
    //             $diklat = $this->db->get()->result_array();
    //             if($diklat){
    //                 $id_diklat = 106;
    //             } else {
    //                 $this->db->select('*')
    //                 ->from('db_pegawai.pegdiklat a')
    //                 ->where('a.id_pegawai', $id)
    //                 ->where('a.jenjang_diklat', 8)
    //                 ->where('a.flag_active', 1);
    //                 $diklat = $this->db->get()->result_array();
    //                 if($diklat){
    //                     $id_diklat = 107;
    //                 } 
    //             }
    //         }
           
    //        }
    //     }
    //     return $id_diklat;   
    // }

    function getDiklatPengawai($id,$jenis_pengisian,$eselonpegawai,$jabatanpegawai){
            
        $id_diklat = null;
        if($jenis_pengisian == 3){
            if($eselonpegawai == "III B" || $eselonpegawai == "III A"){
                $this->db->select('a.id')
                ->from('db_pegawai.pegdiklat a')
                ->where('a.id_pegawai', $id)
                ->where('a.jenjang_diklat', 3)
                ->where('a.status', 2)
                ->where('a.flag_active', 1);
                $diklat = $this->db->get()->result_array();
                if($diklat){
                    $id_diklat = 105;
                } else {
                    $this->db->select('a.id')
                    ->from('db_pegawai.pegdiklat a')
                    ->where('a.id_pegawai', $id)
                    ->where('a.jenjang_diklat', 2)
                    ->where('a.status', 2)
                    ->where('a.flag_active', 1);
                    $diklat = $this->db->get()->result_array();
                    if($diklat){
                        $id_diklat = 106;
                    } else {
                        $this->db->select('a.id')
                        ->from('db_pegawai.pegdiklat a')
                        ->where('a.id_pegawai', $id)
                        ->where('a.jenjang_diklat', 1)
                        ->where('a.status', 2)
                        ->where('a.flag_active', 1);
                        $diklat = $this->db->get()->result_array();
                        if($diklat){
                            $id_diklat = 107;
                        }  
                    }
                }
            } else if($eselonpegawai == "II B"){
                $this->db->select('a.id')
                ->from('db_pegawai.pegdiklat a')
                ->where('a.id_pegawai', $id)
                ->where('a.jenjang_diklat', 3)
                ->where('a.status', 2)
                ->where('a.flag_active', 1);
                $diklat = $this->db->get()->result_array();
                if($diklat){
                    $id_diklat = 105;
                } else {
                    $this->db->select('a.id')
                    ->from('db_pegawai.pegdiklat a')
                    ->where('a.id_pegawai', $id)
                    ->where('a.jenjang_diklat', 2)
                    ->where('a.status', 2)
                    ->where('a.flag_active', 1);
                    $diklat = $this->db->get()->result_array();
                    if($diklat){
                        $id_diklat = 107;
                    } 
                }
            }
        } else if($jenis_pengisian == 2){
            if($eselonpegawai == "III B" || $eselonpegawai == "III A"){
                $this->db->select('a.id')
                ->from('db_pegawai.pegdiklat a')
                ->where('a.id_pegawai', $id)
                ->where('a.jenjang_diklat', 2)
                ->where('a.status', 2)
                ->where('a.flag_active', 1);
                $diklat = $this->db->get()->result_array();
                if($diklat){
                    $id_diklat = 105;
                } else {
                    $this->db->select('a.id')
                    ->from('db_pegawai.pegdiklat a')
                    ->where('a.id_pegawai', $id)
                    ->where('a.jenjang_diklat', 1)
                    ->where('a.status', 2)
                    ->where('a.flag_active', 1);
                    $diklat = $this->db->get()->result_array();
                    if($diklat){
                        $id_diklat = 107;
                    }
                }
            } else if($eselonpegawai == "IV A" || $eselonpegawai == "IV A"){
                $this->db->select('a.id')
                    ->from('db_pegawai.pegdiklat a')
                    ->where('a.id_pegawai', $id)
                    ->where('a.jenjang_diklat', 2)
                    ->where('a.status', 2)
                    ->where('a.flag_active', 1);
                    $diklat = $this->db->get()->result_array();
                    if($diklat){
                        $id_diklat = 105;
                    } else {
                        $this->db->select('a.id')
                        ->from('db_pegawai.pegdiklat a')
                        ->where('a.id_pegawai', $id)
                        ->where('a.jenjang_diklat', 1)
                        ->where('a.status', 2)
                        ->where('a.flag_active', 1);
                        $diklat = $this->db->get()->result_array();
                        if($diklat){
                            $id_diklat = 106;
                        }
                    }
                }
           } else if($jenis_pengisian == 1) {
            if($eselonpegawai == "IV A" || $eselonpegawai == "IV A"){
                $this->db->select('a.id')
                    ->from('db_pegawai.pegdiklat a')
                    ->where('a.id_pegawai', $id)
                    ->where('a.jenjang_diklat', 1)
                    ->where('a.status', 2)
                    ->where('a.flag_active', 1);
                    $diklat = $this->db->get()->result_array();
                    if($diklat){
                        $id_diklat = 105;
                    } else {
                        $this->db->select('a.id')
                        ->from('db_pegawai.pegdiklat a')
                        ->where('a.id_pegawai', $id)
                        ->where('a.jenjang_diklat', 10)
                        ->where('a.status', 2)
                        ->where('a.flag_active', 1);
                        $diklat = $this->db->get()->result_array();
                        if($diklat){
                            $id_diklat = 107;
                        }
                    }
                } else {
                $this->db->select('a.id')
                            ->from('db_pegawai.pegdiklat a')
                            ->where('a.id_pegawai', $id)
                            ->where('a.jenjang_diklat', 10)
                            ->where('a.flag_active', 1);
                            $diklat = $this->db->get()->result_array();
                            if($diklat){
                                $id_diklat = 106;
                            } 
                }

            // $this->db->select('a.id')
            // ->from('db_pegawai.pegdiklat a')
            // ->where('a.id_pegawai', $id)
            // ->where('a.jenjang_diklat', 10)
            // ->where('a.flag_active', 1);
            // $diklat = $this->db->get()->result_array();
            // if($diklat){
            //     $id_diklat = 106;
            // } 
           }
         
    
    return $id_diklat;   
}

    function getHukdisPengawai($id){
        $this->db->select('a.tglsurat')
            ->from('db_pegawai.pegdisiplin a')
            ->where('a.id_pegawai', $id)
            ->where('a.flag_active', 1);
        $hukdis = $this->db->get()->row_array();
        // dd($hukdis);
        $id_hukdis = null;
        if($hukdis){
            $yearHukdis = date('Y', strtotime($hukdis['tglsurat']));
            $currentYear = date('Y-m-d'); 
            $sdate = $hukdis['tglsurat'];
            $edate = date('Y-m-d');
            $date_diff = abs(strtotime($edate) - strtotime($sdate));
            $years = floor($date_diff / (365*60*60*24));
            $months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            if($years > 10){
                $id_hukdis = 115;
            } else if($years >= 10){
                $id_hukdis = 116;
            } else if($years > 5){
                $id_hukdis = 117;
            } else if($years > 2){
                $id_hukdis = 118;
            }
        } else {
        $id_hukdis = 115;
        }
        // dd($id_hukdis);
    return $id_hukdis;   
    }

    function getMasaKerjaJabatanOld($id,$kode,$eselonpegawai,$jenis_pengisian){
        $eselon[] = null;
        $id_masakerja = null;

        if($kode == 2){
            $eselon = ["II B", "II A"];
        }
        if($kode == 1){
            $eselon = ["III B", "III A"];
        }


        $this->db->select('*')
            ->from('db_pegawai.pegjabatan a')
            ->join('db_pegawai.jabatan b', 'a.id_jabatan = b.id_jabatanpeg','left')
            ->join('db_pegawai.eselon c', 'a.eselon = c.id_eselon','left')
            ->where('a.id_pegawai', $id)
            ->where('a.status', 2)
            ->where('a.tmtjabatan !=', "0000-00-00")
            ->where_not_in('a.ket ', ["Plt", "Plh"])
            ->where_not_in('a.statusjabatan',[2,3] )
            ->where_in('a.flag_active', [1,2])
            ->order_by('a.tmtjabatan', 'asc');
        $jabatan = $this->db->get()->result_array();
        // dd($jabatan);
        $eselon_peg =0;
        $tglawal = null;
        $tglakhir = null;
        $id_pegjabatan = 0;
        $x= 0;
        $i= 0;
        foreach ($jabatan as $jab) {  
            // dd($jab['id_eselon']);
          if($jab['id_eselon'] == "4" || $jab['id_eselon'] == "5"){
            $x++;
            if($x == 1){
                $tglawal = $jab['tmtjabatan'];
                $tglakhir = $jab['tmtjabatan'];
            } else {
                $tglakhir = $jab['tmtjabatan']; 
            }
          
          } else if($jab['id_eselon'] == "6" || $jab['id_eselon'] == "7") {
            $i++;
            if($i == 1){
                $tglawal = $jab['tmtjabatan'];
                $tglakhir = $jab['tmtjabatan'];
            } else {
                $tglakhir = $jab['tmtjabatan']; 
            }
          } 
        //   else if($jab['id_eselon'] == "8" || $jab['id_eselon'] == "9") {
        //     $i++;
        //     if($i == 1){
        //         $tglawal = $jab['tmtjabatan'];
        //         $tglakhir = $jab['tmtjabatan'];
        //     } else {
        //         $tglakhir = $jab['tmtjabatan']; 
        //     }
        //   }  
         }


         $this->db->select('a.tmtjabatan')
         ->from('db_pegawai.pegjabatan a')
         ->join('db_pegawai.jabatan b', 'a.id_jabatan = b.id_jabatanpeg','left')
         ->join('db_pegawai.eselon c', 'a.eselon = c.id_eselon','left')
         ->where('a.id_pegawai', $id)
         ->where('a.status', 2)
         ->where_not_in('a.ket ', ["Plt", "Plh"])
         ->where('tmtjabatan >', $tglakhir)
        //  ->where('a.statusjabatan !=', 2)
        ->where_not_in('a.statusjabatan',[2,3] )
         ->where_in('a.flag_active', [1,2]);
         $cekJabTerakhir = $this->db->get()->result_array();
         

         $sdate = $tglawal;
         if($cekJabTerakhir){
            $edate = $cekJabTerakhir[0]['tmtjabatan'];
         } else {
            $edate = date('Y-m-d');
         }
         $date_diff = abs(strtotime($edate) - strtotime($sdate));
         $years = floor($date_diff / (365*60*60*24));

        //  dd($years);
         if(in_array($eselonpegawai, $eselon)){
           if($eselonpegawai == "II B" || $eselonpegawai == "II A" AND  $jenis_pengisian == 3){
            if($years > 5){
                $id_masakerja = 101;
            } else if($years >= 3 AND $years <= 5){
                $id_masakerja = 102;
            } else if($years == 2){
                $id_masakerja = 103;
            } else if($years < 2){
                $id_masakerja = 104;
            }
           } else if($eselonpegawai == "III B" || $eselonpegawai == "III A" AND  $jenis_pengisian == 3){
            if($years > 5){
                $id_masakerja = 129;
            } else if($years >= 3 AND $years <= 5){
                $id_masakerja = 130;
            } else if($years == 2){
                $id_masakerja = 131;
            } else if($years < 2){
                $id_masakerja = 132;
            }
           } else if($eselonpegawai == "III B" || $eselonpegawai == "III A" AND  $jenis_pengisian == 2){
            if($years > 5){
                $id_masakerja = 101;
            } else if($years >= 3 AND $years <= 5){
                $id_masakerja = 102;
            } else if($years == 2){
                $id_masakerja = 103;
            } else if($years < 2){
                $id_masakerja = 104;
            }
           }

         } else {
            if($years > 5){
                $id_masakerja = 129;
            } else if($years >= 3 AND $years <= 5){
                $id_masakerja = 130;
            } else if($years == 2){
                $id_masakerja = 131;
            } else if($years < 2){
                $id_masakerja = 132;
            }
         } 
        
        //  $id_masakerja = null;
    return $id_masakerja;   
    }

    function getMasaKerjaJabatan($id,$kode,$eselonpegawai,$jenis_pengisian){
        $eselon[] = null;
       
        $id_masakerja = null;

        if($kode == 2){
            $eselon = ["II B", "II A"];
        }
        if($kode == 1){
            $eselon = ["III B", "III A"];
        }
        if($kode == 3){
            $eselon = ["IV B", "IV A"];
        }



        $this->db->select('sum(a.masa_kerja_bulan) as masa_kerja')
            ->from('db_pegawai.pegjabatan a')
            ->join('db_pegawai.jabatan b', 'a.id_jabatan = b.id_jabatanpeg','left')
            ->join('db_pegawai.eselon c', 'a.eselon = c.id_eselon','left')
            ->where('a.id_pegawai', $id)
            ->where('a.status', 2)
            ->where('a.tmtjabatan !=', "0000-00-00")
            ->where_not_in('a.ket ', ["Plt", "Plh"])
            ->where_not_in('a.statusjabatan',[2,3] )
            ->where_in('a.flag_active', [1,2])
            ->order_by('a.tmtjabatan', 'asc');

            
            if($kode == 2){
                $this->db->where_in('c.id_eselon', [4,5]);
            }

            if($kode == 1){
                $this->db->where_in('c.id_eselon', [6,7]);
            }

            if($kode == 3){
                $this->db->where_in('c.id_eselon', [8,9]);
                // $this->db->group_start();
                // $this->db->where_in('c.id_eselon', [8,9]);
                // $this->db->or_where_in('b.kelas_jabatan', [9]);
                // $this->db->group_end();

            }
            if($kode == 4){
                $this->db->where_in('b.jenis_jabatan', ["JFU"]);
            }

            
            



        $jabatan = $this->db->get()->result_array();
        
        $bulan = $jabatan[0]['masa_kerja'];
        $years = $bulan / 12;
       
        
         if(in_array($eselonpegawai, $eselon)){
              
           if($eselonpegawai == "II B" || $eselonpegawai == "II A" AND  $jenis_pengisian == 3){
            if($years > 5){
                $id_masakerja = 101;
            } else if($years >= 3 AND $years <= 5){
                $id_masakerja = 102;
            } else if($years >= 2){
                $id_masakerja = 103;
            } else if($years < 2){
                $id_masakerja = 104;
            }
           } else if($eselonpegawai == "III B" || $eselonpegawai == "III A" AND  $jenis_pengisian == 3){
            if($years > 5){
                $id_masakerja = 129;
            } else if($years >= 3 AND $years <= 5){
                $id_masakerja = 130;
            } else if($years >= 2){
                $id_masakerja = 131;
            } else if($years < 2){
                $id_masakerja = 132;
            }
           } else if($eselonpegawai == "III B" || $eselonpegawai == "III A" AND  $jenis_pengisian == 2){
            if($years > 5){
                $id_masakerja = 101;
            } else if($years >= 3 AND $years <= 5){
                $id_masakerja = 102;
            } else if($years >= 2){
                $id_masakerja = 103;
            } else if($years < 2){
                $id_masakerja = 104;
            }
           } else if($eselonpegawai == "IV A" || $eselonpegawai == "IV B" AND  $jenis_pengisian == 2){
            // dd($years);
            if($years > 5){
                $id_masakerja = 129;
            } else if($years >= 3 AND $years <= 5){
                $id_masakerja = 130;
            } else if($years >= 2){
                $id_masakerja = 131;
            } else if($years < 2){
                $id_masakerja = 132;
            }
           } else if($eselonpegawai == "IV A" || $eselonpegawai == "IV B" AND  $jenis_pengisian == 1){
            // dd($years);
            if($years > 5){
                $id_masakerja = 101;
            } else if($years >= 3 AND $years <= 5){
                $id_masakerja = 102;
            } else if($years >= 2){
                $id_masakerja = 103;
            } else if($years < 2){
                $id_masakerja = 104;
            }
           }

         } else {
            if($years > 5){
                $id_masakerja = 129;
            } else if($years >= 3 AND $years <= 5){
                $id_masakerja = 130;
            } else if($years == 2){
                $id_masakerja = 131;
            } else if($years < 2){
                $id_masakerja = 132;
            }
         } 
        //  dd($id_masakerja);
        //  $id_masakerja = null;
    return $id_masakerja;   
    }

    function getPenugasanPengawai($id){
        $this->db->select('*')
            ->from('db_pegawai.pegjabatan a')
            ->join('db_pegawai.jabatan b', 'a.id_jabatan = b.id_jabatanpeg')
            ->join('db_pegawai.unitkerja c', 'b.id_unitkerja = c.id_unitkerja')
            ->join('db_pegawai.unitkerjamaster d', 'c.id_unitkerjamaster = d.id_unitkerjamaster')
            ->where('a.id_pegawai', $id)
            // ->where('b.eselon', $eselon)
            // ->where('a.statusjabatan', 2)
             ->group_start()
             ->where_in('a.statusjabatan', [2,3])
             ->or_where_in('a.ket',["PLT", "Plt", "plt", "Plh", "PLH"])
             ->group_end()
            ->where('a.status', 2)
            ->where('a.flag_active', 1);
        $penugasan = $this->db->get()->result_array();
        // dd($penugasan);
       
        $id_penugasan = null;
        $qty1 = 0;
        $qty2 = 0;

        if($penugasan){
            foreach ($penugasan as $peng) {  
                if($peng['eselon'] == "II B" || $peng['eselon'] == "II A"){ 
                    if($peng['statusjabatan'] == 2) {
                        $qty1++;
                    } else {
                        $qty2++;
                    }
                 
                } 
                if($peng['eselon'] == "III B" || $peng['eselon'] == "III A"){ 
                if($peng['eselon'] == "III A" && $peng['id_unitkerjamaster'] == "1000000" || $peng['eselon'] == "III A"){
                    if($peng['statusjabatan'] == 2) {
                        $qty1++;
                    } else {
                        $qty2++;
                    }
                } else {
                    $qty2++;
                }
                }
                if($peng['eselon'] == "IV A"){ 
                    // dd($peng);
                    if($peng['statusjabatan'] == 2) {
                        if($peng['pejabat'] == "Walikota Manado" || $peng['pejabat'] == "WALIKOTA" || $peng['pejabat'] == "WALI KOTA" || $peng['pejabat'] == "WALIKOTA MANADO ANDREI ANGOUW" || $peng['pejabat'] == "ANDREI ANGOUW" || $peng['pejabat'] == "Wali Kota Manado"){ 
                            $qty1++;
                        }
                    } 
                 
                }  
             }

            if($qty1 != 0){
                $id_penugasan = 88; 
            } else if($qty2 != 0) {
                $id_penugasan = 89;
            } 
  
        }
        if($id_penugasan == null){
            $this->db->select('*')
            ->from('db_pegawai.pegdatalain a')
            ->where('a.id_pegawai', $id)
            ->where('a.status', 2)
            ->where_in('a.jenispenugasan', [98,99])
            ->where('a.flag_active', 1);
           $pegpenugasan = $this->db->get()->result_array();
           if($pegpenugasan){
            $id_penugasan = 90;
           }
        }
    return $id_penugasan;   
    }

        

        function getPenilaianKinerja($id,$tahun,$x){
            $this->db->select('*')
                ->from('db_pegawai.pegskp a')
                ->where('a.id_pegawai', $id)
                ->where('a.tahun', $tahun)
                ->order_by('a.tahun', 'desc')
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->limit(1);
            $pk = $this->db->get()->row_array();
            // $id_predikat = $this->general_library->getIdPenilaianKinerjaSimata($pk['predikat'],$x);
            
            $predikat = null;
            if($pk){
            $id_predikat = $pk['predikat'];
            if($x == 1){
                if($id_predikat == "Sangat Baik" || $id_predikat == "SANGAT BAIK"){
                    $predikat = "66";
                } else if($id_predikat == "Baik" || $id_predikat == "BAIK"){
                    $predikat = "67";
                } else if($id_predikat == "Butuh Perbaikan" || $id_predikat == "BUTUH PERBAIKAN"){
                    $predikat = "68";
                } else if($id_predikat == "Kurang" || $id_predikat == "KURANG" || $id_predikat == "KURANG / MISONDUCT"){
                    $predikat = "69";
                } else if($id_predikat == "Sangat Kurang" || $id_predikat == "SANGAT KURANG"){
                    $predikat = "70";
                } 
            } else {
                if($id_predikat == "Sangat Baik" || $id_predikat == "SANGAT BAIK"){
                    $predikat = "71";
                } else if($id_predikat == "Baik" || $id_predikat == "BAIK"){
                    $predikat = "72";
                } else if($id_predikat == "Butuh Perbaikan" || $id_predikat == "BUTUH PERBAIKAN"){
                    $predikat = "73";
                } else if($id_predikat == "Kurang" || $id_predikat == "KURANG" || $id_predikat == "KURANG / MISONDUCT"){
                    $predikat = "74";
                } else if($id_predikat == "Sangat Kurang" || $id_predikat == "SANGAT KURANG"){
                    $predikat = "75";
                } 
            }
            }
        
            return $predikat;
        }

        function getInovasiPegawai($id){
            $this->db->select('*')
                ->from('db_pegawai.peginovasi a')
                ->where('a.id_pegawai', $id)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->limit(1);
            $inovasi = $this->db->get()->row_array();
            if($inovasi){
            $id_inovasi = $inovasi['kriteria_inovasi'];
            $inovasi = null;
            if($id_inovasi == "1"){
                $inovasi = "76";
            } else if($id_inovasi == "2"){
                $inovasi = "77";
            } else if($id_inovasi == "3"){
                $inovasi = "78";
            } else {
                $inovasi = "129";
            } 
        }
        return $inovasi;
            
        }

        function getPengalamanTimPegawai($id){
            $this->db->select('*')
                ->from('db_pegawai.pegtimkerja a')
                ->where('a.id_pegawai', $id)
                ->where('a.flag_active', 1)
                ->where('a.status', 2);
                // ->where('a.lingkup_timkerja', 1)
                // ->where('a.jabatan', 1);
            $timkerja = $this->db->get()->result_array();

         

            $id_tim_kerja = null;
            $qty1 = 0; // Jumlah tim kerja lingkup perangkat daerah
            $qty2 = 0; // Jumlah tim kerja lingkup unit kerja
            $ketuaTimUnitKerja = 0;
            // Lingkup Pemerintah Daerah 
            foreach ($timkerja as $tim) {
               if($tim['lingkup_timkerja'] == 1 && $tim['jabatan'] == 1){ 
                $id_tim_kerja = 79;
               } else if($tim['lingkup_timkerja'] == 1 && $tim['jabatan'] == 2){      
                $id_tim_kerja = 80;
               } 
            }
           
            if($id_tim_kerja == null){
                foreach ($timkerja as $tim) {
                    if($tim['lingkup_timkerja'] == 2){ 
                    $qty1++;
                    } 
                    if($tim['lingkup_timkerja'] == 3 && $tim['jabatan'] == 1){ 
                        $ketuaTimUnitKerja = 1;
                        }
                    if($tim['lingkup_timkerja'] == 3){ 
                    $qty2++;
                    }
                }

            // Lingkup Perangkat Daerah 
            if($qty1 != 0) {
                    if($qty1 == 1) {
                        $id_tim_kerja = 83;
                    } else if($qty1 == 2 || $qty1 == 3) {
                        $id_tim_kerja = 82;
                    } else if($qty1 >= 3) {
                        $id_tim_kerja = 81;
                    }

            // Lingkup Unit KerjagetNilaiAssesment 
            } else if($ketuaTimUnitKerja == 1){
                $id_tim_kerja = 84;
            } else if($qty2 != 0)
            if($qty2 == 1) {
                $id_tim_kerja = 87;
            } else if($qty2 == 2 || $qty2 == 3) {
                $id_tim_kerja = 86;
            } else if($qty2 >= 3) {
                $id_tim_kerja = 85;
            }
            }

            return $id_tim_kerja;
        }

        


        public function submitPenilaianPotensialCerdas(){
    
            $datapost = $this->input->post();
            
            $this->db->trans_begin();
            $data["id_peg"] = $datapost["id_peg"];
            $total_nilai = $datapost["nilai_assesment"] * 50 / 100;
            $cek =  $this->db->select('*')
                                    ->from('db_simata.t_penilaian_potensial a')
                                    ->where('a.id_peg', $data["id_peg"])
                                    // ->where('a.jabatan_target', $this->input->post('jabatan_target'))
                                    ->where('a.nilai_assesment is not null')
                                    ->where('a.flag_active', 1)
                                    ->get()->result_array();
           

            if($cek){
                $this->db->where('id_peg', $datapost['id_peg'])
                ->update('db_simata.t_penilaian_potensial', 
                ['nilai_assesment' => $this->input->post('nilai_assesment')
                    ]);
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            } else {

                $dataInsert['id_peg']      = $data["id_peg"];
                $dataInsert['nilai_assesment']      = $this->input->post('nilai_assesment');
                // $dataInsert['jabatan_target']      = $rs['id_jabatan_target'];
                $this->db->insert('db_simata.t_penilaian_potensial', $dataInsert);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            }


            $getAllNilaiPotensial =  $this->db->select('*')
                        ->from('db_simata.t_penilaian a')
                        ->where('a.id_peg', $datapost["id_peg"])
                        // ->where('a.id_jabatan_target', $datapost['jabatan_target'])
                        ->where('a.flag_active', 1)
                        ->get()->result_array();

            if($getAllNilaiPotensial){
                foreach ($getAllNilaiPotensial as $rs2) {
              
                    $total_potensial = $rs2['res_potensial_cerdas'] + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];
                   
                    $this->db->where('id_peg', $datapost['id_peg'])
                    // ->where('id_jabatan_target', $rs2['id_jabatan_target'])
                       ->update('db_simata.t_penilaian', 
                       ['res_potensial_total' => $total_potensial,
                       'res_potensial_cerdas' => $total_nilai
                    ]);
                            
                }
            } else {
                $dataInsert2['id_peg']      = $data["id_peg"];
                $dataInsert2['res_potensial_cerdas']      = $total_nilai;
                $dataInsert2['res_potensial_total']      = $total_nilai;
                $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
            }



            // $total_potensial = $getAllNilaiPotensial[0]['res_potensial_cerdas'] + $getAllNilaiPotensial[0]['res_potensial_rj'] + $getAllNilaiPotensial[0]['res_potensial_lainnya'];

            // $this->db->where('id_peg', $datapost['id_peg'])
            // ->where('id_jabatan_target', $datapost['jabatan_target'])
            //    ->update('db_simata.t_penilaian', 
            //    ['res_potensial_total' => $total_potensial]);
        
        
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $res = array('msg' => 'Data gagal disimpan', 'success' => false);
            } else {
                $this->db->trans_commit();
            }
        
            return $res;
        }

        function getKriteriaPotensial($id){
            $this->db->select('a.*,b.bobot')
            ->where('a.id_m_indikator_penilaian',$id)
            ->join('db_simata.m_indikator_penilaian b', 'a.id_m_indikator_penilaian = b.id')
            ->from('db_simata.m_kriteria_penilaian a');
            return $this->db->get()->result_array(); 
        }
          

        public function submitPenilaianPotensialRj(){
    
            $datapost = $this->input->post();
            // dd($datapost);
            $jenis_pengisian = $this->input->post('rj_jenis_pengisian');
          
            
            $this->db->trans_begin();
        
            // if($this->input->post('rekamjjk1') != 0){

            $total_rj = null;
            for($x=1;$x<=7;$x++){
                $rj = $this->input->post('rekamjjk'.$x.'');
                  $rekamjjk = explode(",", $rj);
                  $id_rekamjjk = $rekamjjk[0];
                  $skor = $rekamjjk[1];
                  $bobot = $rekamjjk[2];
                  $total_rj += $skor * $bobot / 100;   
            }
        //   }

           $rekjak1 = $this->input->post('rekamjjk1');
           $rekamjjk1 = explode(",", $rekjak1);
           $id_rekamjjk1 = $rekamjjk1[0];

           $rekjak2 = $this->input->post('rekamjjk2');
           $rekamjjk2 = explode(",", $rekjak2);
           $id_rekamjjk2 = $rekamjjk2[0];

           $rekjak3 = $this->input->post('rekamjjk3');
           $rekamjjk3 = explode(",", $rekjak3);
           $id_rekamjjk3 = $rekamjjk3[0];

           $rekjak4 = $this->input->post('rekamjjk4');
           $rekamjjk4 = explode(",", $rekjak4);
           $id_rekamjjk4 = $rekamjjk4[0];

           $rekjak5 = $this->input->post('rekamjjk5');
           $rekamjjk5 = explode(",", $rekjak5);
           $id_rekamjjk5 = $rekamjjk5[0];

           $rekjak6 = $this->input->post('rekamjjk6');
           $rekamjjk6 = explode(",", $rekjak6);
           $id_rekamjjk6 = $rekamjjk6[0];

           $rekjak7 = $this->input->post('rekamjjk7');
           $rekamjjk7 = explode(",", $rekjak7);
           $id_rekamjjk7 = $rekamjjk7[0];
           

            $data["id_peg"] = $datapost["rj_id_peg"];
            $data["pendidikan_formal"] = $id_rekamjjk1;
            $data["pangkat_gol"] = $id_rekamjjk2;
            $data["masa_kerja_jabatan"] = $id_rekamjjk3;
            $data["diklat"] = $id_rekamjjk4;
            $data["kompetensi20_jp"] = $id_rekamjjk5;
            $data["penghargaan"] = $id_rekamjjk6;
            $data["riwayat_hukdis"] = $id_rekamjjk7;
            $data["jenjang_jabatan"] = $jenis_pengisian;
            // $data["jabatan_target"] = $this->input->post('rj_jabatan_target');

            $cek =  $this->db->select('*')
                                    ->from('db_simata.t_penilaian_potensial a')
                                    ->where('a.id_peg', $data["id_peg"])
                                    ->where('a.jenjang_jabatan', $jenis_pengisian)
                                    // ->where('a.jabatan_target', $this->input->post('rj_jabatan_target'))
                                    ->where('a.flag_active', 1)
                                    ->get()->result_array();
           
            if($cek){
                $this->db->where('id_peg', $data['id_peg'])
                //  ->where('jabatan_target', $this->input->post('rj_jabatan_target'))
                ->update('db_simata.t_penilaian_potensial', 
                ['pendidikan_formal' => $id_rekamjjk1,
                'pangkat_gol' => $id_rekamjjk2,
                'masa_kerja_jabatan' => $id_rekamjjk3,
                'diklat' => $id_rekamjjk4,
                'kompetensi20_jp' => $id_rekamjjk5,
                'penghargaan' => $id_rekamjjk6,
                'riwayat_hukdis' => $id_rekamjjk7,
                'jenjang_jabatan' => $jenis_pengisian
                    ]);
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            } else {
                $this->db->insert('db_simata.t_penilaian_potensial', $data);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

            }

            $this->db->where('id_peg', $data['id_peg'])
                      ->where('jenjang_jabatan', $jenis_pengisian)
                    //  ->where('id_jabatan_target', $datapost['rj_jabatan_target']) 
                         ->update('db_simata.t_penilaian', 
                        ['res_potensial_rj' => $total_rj]);

            $getAllNilaiPotensial =  $this->db->select('*')
                        ->from('db_simata.t_penilaian a')
                        ->where('a.id_peg', $data["id_peg"])
                        ->where('a.jenjang_jabatan', $jenis_pengisian)
                        // ->where('a.id_jabatan_target', $datapost['rj_jabatan_target'])
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
            
                        if($getAllNilaiPotensial){
            $total_potensial = $getAllNilaiPotensial[0]['res_potensial_cerdas'] + $getAllNilaiPotensial[0]['res_potensial_rj'] + $getAllNilaiPotensial[0]['res_potensial_lainnya'];

                            foreach ($getAllNilaiPotensial as $rs2) {
                            $total_potensial = $rs2['res_potensial_cerdas'] + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];
                            $this->db->where('id_peg', $data['id_peg'])
                            ->where('jenjang_jabatan', $jenis_pengisian)
                            // ->where('id_jabatan_target', $rs2['id_jabatan_target'])
                               ->update('db_simata.t_penilaian', 
                               ['res_potensial_total' => $total_potensial,
                               'res_potensial_rj' => $total_rj]);
                                        
                            }
                        } else {
                            $dataInsert2['id_peg']      = $data["id_peg"];
                            $dataInsert2['res_potensial_rj']      = $total_rj;
                            $dataInsert2['res_potensial_total']      = $total_rj;
                            $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                            $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                        }
    
                        
        
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                // $res['code'] = 1;
                // $res['message'] = 'Terjadi Kesalahan';
                // $res['data'] = null;
                $res = array('msg' => 'Data gagal disimpan', 'success' => false);
            } else {
                $this->db->trans_commit();
            }
        
            return $res;
        }


        public function submitPenilaianPotensialLainnya(){
    
            $datapost = $this->input->post();
            $jenis_pengisian = $this->input->post('lainnya_jenis_pengisian');
            
            $this->db->trans_begin();
            $total_rj = null;
            if($this->input->post('lainnya1')){
            
          
            for($x=1;$x<=3;$x++){
                $rj = $this->input->post('lainnya'.$x.'');
                  $rekamjjk = explode(",", $rj);
                  $id_rekamjjk = $rekamjjk[0];
                  $skor = $rekamjjk[1];
                  $bobot = $rekamjjk[2];
                  $total_rj += $skor * $bobot / 100;   
            }
          }

           $rekjak1 = $this->input->post('lainnya1');
           $rekamjjk1 = explode(",", $rekjak1);
           $id_rekamjjk1 = $rekamjjk1[0];

           $rekjak2 = $this->input->post('lainnya2');
           $rekamjjk2 = explode(",", $rekjak2);
           $id_rekamjjk2 = $rekamjjk2[0];

           $rekjak3 = $this->input->post('lainnya3');
           $rekamjjk3 = explode(",", $rekjak3);
           $id_rekamjjk3 = $rekamjjk3[0];

           

            $data["id_peg"] = $datapost["lainnya_id_peg"];
            $data["pengalaman_organisasi"] = $id_rekamjjk1;
            $data["aspirasi_karir"] = $id_rekamjjk2;
            $data["asn_ceria"] = $id_rekamjjk3;
            $data["jenjang_jabatan"] = $jenis_pengisian;

            $cek =  $this->db->select('*')
                                    ->from('db_simata.t_penilaian_potensial a')
                                    ->where('a.id_peg', $data["id_peg"])
                                    ->where('a.jenjang_jabatan', $jenis_pengisian)
                                    // ->where('a.jabatan_target', $this->input->post('lainnya_jabatan_target'))
                                    ->where('a.flag_active', 1)
                                    ->get()->result_array();

            if($cek){
                $this->db->where('id_peg', $data['id_peg'])
                ->where('jenjang_jabatan', $jenis_pengisian)
                        //  ->where('jabatan_target', $this->input->post('lainnya_jabatan_target'))
                ->update('db_simata.t_penilaian_potensial', 
                ['pengalaman_organisasi' => $id_rekamjjk1,
                'aspirasi_karir' => $id_rekamjjk2,
                'asn_ceria' => $id_rekamjjk3
                 ]);
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            } else {
                // $getJabatanTarget =  $this->db->select('*')
                // ->from('db_simata.t_penilaian a')
                // ->where('a.id_peg', $data["id_peg"])
                // ->where('a.flag_active', 1)
                // ->get()->result_array();

                // foreach ($getJabatanTarget as $rs) {
                //     $data["jabatan_target"] = $rs['id_jabatan_target'];
                //     $this->db->insert('db_simata.t_penilaian_potensial', $data);
                // }
                // // $this->db->insert('db_simata.t_penilaian_potensial', $data);
                // $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

                $this->db->insert('db_simata.t_penilaian_potensial', $data);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

            }

            $this->db->where('id_peg', $data['id_peg'])
            ->where('jenjang_jabatan', $jenis_pengisian)
               ->update('db_simata.t_penilaian', 
              ['res_potensial_lainnya' => $total_rj]);

            // $this->db->where('id_peg', $data['id_peg'])
            //         //  ->where('id_jabatan_target', $datapost['lainnya_jabatan_target']) 
            //              ->update('db_simata.t_penilaian', 
            //             ['res_potensial_lainnya' => $total_rj]);

            $getAllNilaiPotensial =  $this->db->select('*')
                        ->from('db_simata.t_penilaian a')
                        ->where('a.id_peg', $data["id_peg"])
                        ->where('a.jenjang_jabatan', $jenis_pengisian)
                        // ->where('a.id_jabatan_target', $datapost['lainnya_jabatan_target'])
                        ->where('a.flag_active', 1)
                        ->get()->result_array();



                        if($getAllNilaiPotensial){
                            foreach ($getAllNilaiPotensial as $rs2) {
                            $total_potensial = $rs2['res_potensial_cerdas'] + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];
                            $this->db->where('id_peg', $data['id_peg'])
                            ->where('jenjang_jabatan', $jenis_pengisian)
                            ->where('id_jabatan_target', $rs2['id_jabatan_target'])
                               ->update('db_simata.t_penilaian', 
                               ['res_potensial_total' => $total_potensial,
                               'res_potensial_lainnya' => $total_rj]);
                                        
                            }
                        } else {
                            $dataInsert2['id_peg']      = $data["id_peg"];
                            $dataInsert2['res_potensial_lainnya']      = $total_rj;
                            $dataInsert2['res_potensial_total']      = $total_rj;
                            $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                            $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                        }
                        
        
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                // $res['code'] = 1;
                // $res['message'] = 'Terjadi Kesalahan';
                // $res['data'] = null;
                $res = array('msg' => 'Data gagal disimpan', 'success' => false);
            } else {
                $this->db->trans_commit();
            }
        
            return $res;
        }

        function getJabatanTargetNineBoxAdm(){
            $this->db->select('*')
            ->from('db_simata.t_penilaian a')
            ->join('db_pegawai.jabatan b', 'a.id_jabatan_target = b.id_jabatanpeg')
            ->where("FIND_IN_SET(b.eselon,'III A,III B')!=",0)
            ->group_by('a.id_jabatan_target');
            return $this->db->get()->result_array(); 
        }

        function getJabatanTargetNineBoxJpt(){
            $this->db->select('*')
            ->from('db_simata.t_penilaian a')
            ->join('db_simata.t_jabatan_target b', 'a.id_peg = b.id_peg', 'left')
            ->join('db_pegawai.jabatan c', 'c.id_jabatanpeg = b.jabatan_target')
            ->where_in('c.eselon', ["II A", "II B"])
            ->group_by('b.jabatan_target');
            return $this->db->get()->result_array(); 
        }

        // public function getPegawaiPenilaianDetailNinebox($jenis_jab,$jt,$box){
        //      $this->db->select('a.*,b.*,(SELECT d.nama_jabatan from db_pegawai.jabatan as d
        //      where b.jabatan = d.id_jabatanpeg limit 1) as jabatan_sekarang,  SUM(res_kinerja + res_potensial_total) as total')
        //                     ->from('db_simata.t_penilaianx a')
        //                     ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
        //                     // ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
        //                     ->join('db_pegawai.jabatan e', 'b.jabatan = e.id_jabatanpeg')
        //                     ->where('a.flag_active', 1)
        //                     ->group_by('a.id_peg')
                           
        //                     ->order_by('total', 'desc');
        //                     if($jenis_jab == 2){
        //                         $this->db->where_in('e.eselon', ["II A", "II B"]);
        //                     }
        //                     if($jenis_jab == 1){
        //                         $this->db->where_in('e.eselon', ["III A", "III B"]);
        //                     }
        //                     if($box == 9){
        //                         $this->db->where('a.res_potensial_total >=', 85);
        //                         $this->db->where('a.res_kinerja >=', 85);
        //                     }
        //                     if($box == 8){
        //                         $this->db->where('a.res_potensial_total >=', 85);
        //                         $this->db->where('a.res_kinerja >=', 70);
        //                         $this->db->where('a.res_kinerja <', 85);
        //                     }
        //                     if($box == 7){
        //                         $this->db->where('a.res_potensial_total >=', 70);
        //                         $this->db->where('a.res_potensial_total <', 85);
        //                         $this->db->where('a.res_kinerja >=', 85);
        //                     }
        //                     if($box == 6){
        //                         $this->db->where('a.res_potensial_total >=', 85);
        //                         $this->db->where('a.res_kinerja <', 70);
        //                     }
        //                     if($box == 5){
        //                         $this->db->where('a.res_potensial_total >=', 70);
        //                         $this->db->where('a.res_potensial_total <', 85);
        //                         $this->db->where('a.res_kinerja >=', 70);
        //                         $this->db->where('a.res_kinerja <', 85);
        //                     }
        //                     if($box == 4){
        //                         $this->db->where('a.res_potensial_total <', 70);
        //                         $this->db->where('a.res_kinerja >=', 85);
        //                     }
        //                     if($box == 3){
        //                         $this->db->where('a.res_potensial_total >=', 70);
        //                         $this->db->where('a.res_potensial_total <', 85);
        //                         $this->db->where('a.res_kinerja <', 70);
        //                     }
        //                     if($box == 2){
        //                         $this->db->where('a.res_potensial_total <', 70);
        //                         $this->db->where('a.res_kinerja >=', 70);
        //                         $this->db->where('a.res_kinerja <', 85);
        //                     }
        //                     if($box == 1){
        //                         $this->db->where('a.res_potensial_total <', 70);
        //                         $this->db->where('a.res_kinerja <', 70);
        //                     }
        //                     // if($jenis_jab == 1){
        //                     //     $this->db->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0);
        //                     // }
        //                     // if($jenis_jab == 2){
        //                     //     $this->db->where("FIND_IN_SET(c.eselon,'II B')!=",0);
        //                     // }
        //                     if($jt != 0){
        //                         $this->db->where("id_jabatan_target",$jt);
        //                     }

        //     return  $this->db->get()->result_array();
        // }


        public function getPegawaiPenilaianDetailNinebox($jenis_jab,$jt,$box,$jumlah,$jenis_pengisian){


            $getInterval =  $this->db->select('*')
            ->from('db_simata.m_interval_penilaian a')
            ->where('a.flag_active', 1)
            ->get()->result_array();
     

            $this->db->select('a.*,b.*,(SELECT d.nama_jabatan from db_pegawai.jabatan as d
            where a.jabatan = d.id_jabatanpeg limit 1) as jabatan_sekarang,  SUM(res_kinerja + res_potensial_total) as total')
                           ->from('db_pegawai.pegawai a')
                           ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg','left')
                           // ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
                           ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                           ->join('db_simata.t_jabatan_target f', 'b.id_peg = f.id_peg','left')
                           ->where('a.id_m_status_pegawai', 1)
                           ->where('b.jenjang_jabatan', $jenis_pengisian)
                           ->group_by('a.id_peg')
                          
                           ->order_by('total', 'desc');
                           if($jenis_jab == 2){
                               $this->db->where_in('e.eselon', ["II A", "II B"]);
                           }
                           if($jenis_jab == 1){
                               $this->db->where_in('e.eselon', ["III A", "III B"]);
                           }
                           if($jenis_jab == 3){
                            $this->db->where_in('e.eselon', ["IV A", "IV B"]);
                           }
                           if($jenis_jab == 4){
                            $this->db->where_in('e.jenis_jabatan', "JFU");

                           }

                           
                           if($box == 9){
                               $this->db->where('b.res_potensial_total >=', $getInterval[1]['dari']);
                               $this->db->where('b.res_kinerja >=', $getInterval[0]['dari']);
                           }
                           if($box == 8){
                               $this->db->where('b.res_potensial_total >=', $getInterval[1]['dari']);
                               $this->db->where('b.res_kinerja >=', $getInterval[2]['dari']);
                               $this->db->where('b.res_kinerja <', $getInterval[0]['dari']);
                           }
                           if($box == 7){
                               $this->db->where('b.res_potensial_total >=', $getInterval[4]['dari']);
                               $this->db->where('b.res_potensial_total <', $getInterval[1]['dari']);
                               $this->db->where('b.res_kinerja >=', $getInterval[0]['dari']);
                           }
                           if($box == 6){
                               $this->db->where('b.res_potensial_total >=', $getInterval[1]['dari']);
                               $this->db->where('b.res_kinerja <', $getInterval[2]['dari']);
                           }
                           if($box == 5){
                               $this->db->where('b.res_potensial_total >=', $getInterval[4]['dari']);
                               $this->db->where('b.res_potensial_total <', $getInterval[1]['dari']);
                               $this->db->where('b.res_kinerja >=', $getInterval[2]['dari']);
                               $this->db->where('b.res_kinerja <', $getInterval[0]['dari']);
                           }
                           if($box == 4){
                               $this->db->where('b.res_potensial_total <', $getInterval[4]['dari']);
                               $this->db->where('b.res_kinerja >=', $getInterval[0]['dari']);
                           }
                           if($box == 3){
                               $this->db->where('b.res_potensial_total >=', $getInterval[4]['dari']);
                               $this->db->where('b.res_potensial_total <', $getInterval[1]['dari']);
                               $this->db->where('b.res_kinerja <', $getInterval[2]['dari']);
                           }
                           if($box == 2){
                               $this->db->where('b.res_potensial_total <', $getInterval[4]['dari']);
                               $this->db->where('b.res_kinerja >=', $getInterval[2]['dari']);
                               $this->db->where('b.res_kinerja <', $getInterval[0]['dari']);
                           }
                           if($box == 1){
                            //    $this->db->where('b.res_potensial_total <', 70);
                            //    $this->db->where('b.res_kinerja <', 70);
                            $this->db->group_start();
                                  $this->db->where('b.res_potensial_total <', $getInterval[4]['dari']);
                                  $this->db->where('b.res_kinerja <', $getInterval[2]['dari']);
                                //   $this->db->where('b.res_kinerja >', 0);
                                  $this->db->or_where('b.res_potensial_total is null');
                                  $this->db->or_where('b.res_kinerja is null');
                                  $this->db->group_end();
                           } 

                    
                           // if($jenis_jab == 1){
                           //     $this->db->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0);
                           // }
                           // if($jenis_jab == 2){
                           //     $this->db->where("FIND_IN_SET(c.eselon,'II B')!=",0);
                           // }
                           if($jt != 0){
                               $this->db->where("f.jabatan_target",$jt);
                           }

           return  $this->db->get()->result_array();
       }

        
public function loadListProfilTalentaAdm($id,$jenis_pengisian){
     $this->db->select('a.*,b.*,e.nama_jabatan,e.eselon as es_jabatan,(SELECT d.nama_jabatan from db_pegawai.jabatan as d
     where a.jabatan = d.id_jabatanpeg limit 1) as jabatan_sekarang')
                    ->from('db_pegawai.pegawai a')
                    ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg','left')
                    // ->join('db_simata.t_jabatan_target f', 'f.id_peg = b.id_peg', 'left')
                    ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg','left')
                    // ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
                    ->where('a.id_m_status_pegawai', 1)
                    ->where('b.jenjang_jabatan', $jenis_pengisian)
                    ->order_by('e.eselon');
                    // ->group_by('a.id_peg');
                    if($id == 1){
                        $this->db->where_in('e.eselon', ["III A","III B"]);
                    }else if($id == 2){
                        $this->db->where_in('e.eselon', ["II A","II B"]);
                    }
    return $this->db->get()->result_array();
}

function getPegawaiNilaiKinerjaPT($nip){
    $this->db->select('`a`.*,
	`b`.`nipbaru`,
	 c.nm_kriteria as kinerja1,
	 c.skor as skor1,
	  d.nm_kriteria as kinerja2,
	 d.skor as skor2,
	 	  e.nm_kriteria as kinerja3,
	 e.skor as skor3,
	 	  f.nm_kriteria as kinerja4,
	 f.skor as skor4,
	 	  g.nm_kriteria as kinerja5,
	 g.skor as skor5')
        ->from('db_simata.t_penilaian_kinerja a')
        ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
        ->join('db_simata.m_kriteria_penilaian c', 'a.kriteria1 = c.id','left')
        ->join('db_simata.m_kriteria_penilaian d', 'a.kriteria2 = d.id','left')
        ->join('db_simata.m_kriteria_penilaian e', 'a.kriteria3 = e.id','left')
        ->join('db_simata.m_kriteria_penilaian f', 'a.kriteria4 = f.id','left')
        ->join('db_simata.m_kriteria_penilaian g', 'a.kriteria5 = g.id','left')
        ->where('b.nipbaru', $nip);
        // ->limit(1);
    return $this->db->get()->row_array();
}

function getPegawaiNilaiPotensialPT($nip,$jt){
    // dd($jt);
    $this->db->select('a.*,b.nipbaru,
    c.nm_kriteria as potensial1,
    c.skor as skor1,
     d.nm_kriteria as potensial2,
    d.skor as skor2,
          e.nm_kriteria as potensial3,
    e.skor as skor3,
          f.nm_kriteria as potensial4,
    f.skor as skor4,
          g.nm_kriteria as potensial5,
    g.skor as skor5,
    h.nm_kriteria as potensial6,
    h.skor as skor6,
    i.nm_kriteria as potensial7,
    i.skor as skor7,
    j.nm_kriteria as potensial8,
    j.skor as skor8,
    k.nm_kriteria as potensial9,
    k.skor as skor9,
    l.nm_kriteria as potensial10,
    l.skor as skor10')
        ->from('db_simata.t_penilaian_potensial a')
        ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
        ->join('db_simata.m_kriteria_penilaian c', 'a.pendidikan_formal = c.id','left')
        ->join('db_simata.m_kriteria_penilaian d', 'a.pangkat_gol = d.id','left')
        ->join('db_simata.m_kriteria_penilaian e', 'a.masa_kerja_jabatan = e.id','left')
        ->join('db_simata.m_kriteria_penilaian f', 'a.diklat = f.id','left')
        ->join('db_simata.m_kriteria_penilaian g', 'a.kompetensi20_jp = g.id','left')
        ->join('db_simata.m_kriteria_penilaian h', 'a.penghargaan = h.id','left')
        ->join('db_simata.m_kriteria_penilaian i', 'a.riwayat_hukdis = i.id','left')
        ->join('db_simata.m_kriteria_penilaian j', 'a.pengalaman_organisasi = j.id','left')
        ->join('db_simata.m_kriteria_penilaian k', 'a.aspirasi_karir = k.id','left')
        ->join('db_simata.m_kriteria_penilaian l', 'a.asn_ceria = l.id','left')
        ->where('b.nipbaru', $nip)
        ->where('a.jenjang_jabatan', $jt);
        // ->limit(1);
    return $this->db->get()->row_array();
}

function getMasterJabatan($id){
    $data = null; 
    // $query = $this->db->get_where('db_pegawai.jabatan',array('id_unitkerja' => $id));
    $this->db->select('*')
    ->where('a.id_unitkerja', $id)
    ->order_by('a.eselon','asc')
    ->from('db_pegawai.jabatan a');
    $query = $this->db->get(); 

        foreach($query->result_array() as $item)
        {
            $id_jabatanpeg = $item['id_jabatanpeg'];
            $this->db->select('a.id_m_rumpun_jabatan,a.id,b.nm_rumpun_jabatan')
            ->join('db_simata.m_rumpun_jabatan b', 'a.id_m_rumpun_jabatan = b.id')
            ->where('a.id_jabatan', $id_jabatanpeg)
            ->where('a.flag_active', 1)
            ->from('db_simata.t_rumpun_jabatan a');
            $result = $this->db->get()->result_array(); 
            $item['rumpun'] = $result;
            $data[] = $item;
        }

    return $data;

}

public function submitTambahRumpunJabatan(){
    
    $datapost = $this->input->post();
    
    $this->db->trans_begin();

    $exists = $this->db->select('*')
    ->from('db_simata.t_rumpun_jabatan a')
    ->where('a.id_jabatan', $datapost["id_jabatan"])
    ->where('a.id_m_rumpun_jabatan', $datapost["id_m_rumpun_jabatan"])
    ->where('a.flag_active', 1)
    ->get()->row_array();


    if($exists){
        $res = array('msg' => 'Rumpun Jabatan Sudah ada', 'success' => false);
    } else {
        $data["id_jabatan"] = $datapost["id_jabatan"];
        $data["id_m_rumpun_jabatan"] = $datapost["id_m_rumpun_jabatan"];
        $this->db->insert('db_simata.t_rumpun_jabatan', $data);
        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
    }


    if($this->db->trans_status() == FALSE){
        $this->db->trans_rollback();
        // $res['code'] = 1;
        // $res['message'] = 'Terjadi Kesalahan';
        // $res['data'] = null;
        $res = array('msg' => 'Data gagal disimpan', 'success' => false);
    } else {
        $this->db->trans_commit();
    }

    return $res;
}

public function getListRumpunJabatan($id){
    return $this->db->select('*,a.id as id_rumpun')
                    ->from('db_simata.t_rumpun_jabatan a') 
                    ->join('db_simata.m_rumpun_jabatan b', 'a.id_m_rumpun_jabatan = b.id') 
                    ->where('a.id_jabatan', $id)
                    ->where('a.flag_active', 1)
                    ->get()->result_array();
}

public function searchRumpunJabatan($data){
    $result = null;
    $this->db->select('*')
            ->from('db_simata.t_rumpun_jabatan as a')
            ->join('db_simata.m_rumpun_jabatan as b', 'a.id_m_rumpun_jabatan = b.id')
            ->join('db_pegawai.jabatan as c', 'a.id_jabatan = c.id_jabatanpeg')
            ->join('db_pegawai.eselon d', 'c.eselon = d.nm_eselon', 'left')
            ->join('db_pegawai.unitkerja e', 'c.id_unitkerja = e.id_unitkerja')
            ->where('a.flag_active', 1);
    if($data['rumpun'] != 0){
        $this->db->where('a.id_m_rumpun_jabatan', $data['rumpun']);
    }
    if(isset($data['eselon'])){
        $this->db->where_in('d.id_eselon', $data['eselon']);
    }

    $result = $this->db->get()->result_array();
    return $result;
}


function getSuksesor($jenis_jabatan,$jabatan_target_jpt,$jabatan_target_adm,$jp){


    $this->db->select('*')
    ->from('db_simata.m_interval_penilaian a')
    ->where('a.id_m_unsur_penilaian', 2)
    ->where('a.kriteria', 'Tinggi');
    $potensialtinggi =  $this->db->get()->row_array(); 

    $this->db->select('*')
    ->from('db_simata.m_interval_penilaian a')
    ->where('a.id_m_unsur_penilaian', 1)
    ->where('a.kriteria', 'Di atas ekspektasi');
    $kinerjadiatas =  $this->db->get()->row_array(); 


    $this->db->select('a.*,c.*,f.jabatan_target,g.nama_jabatan,e.eselon as es_jabatan, 
    (res_kinerja + res_potensial_total + IFNULL((select res_kompetensi from db_simata.t_penilaian_kompetensi as y where y.id_peg = a.id_peg and y.jabatan_target = f.jabatan_target),0)) as total,
    (res_kinerja + res_potensial_total) as total_talent_pool, h.res_kompetensi as nilai_kompetensi,
    (select res_kompetensi from db_simata.t_penilaian_kompetensi as z where z.id_peg = a.id_peg and z.jabatan_target = f.jabatan_target) as nilai_kompetensi,
    (SELECT d.nama_jabatan from db_pegawai.jabatan as d
    where c.jabatan = d.id_jabatanpeg limit 1) as jabatan_sekarang')
        ->from('db_simata.t_penilaian a')
        ->join('db_pegawai.pegawai as c', 'a.id_peg = c.id_peg')
        ->join('db_pegawai.jabatan as e', 'c.jabatan = e.id_jabatanpeg')
        ->join('db_simata.t_jabatan_target as f', 'a.id_peg = f.id_peg','left')
        ->join('db_pegawai.jabatan as g', 'f.jabatan_target = g.id_jabatanpeg')
        ->join('db_simata.t_penilaian_kompetensi as h', 'a.id_peg = h.id_peg','left')
        ->where('a.res_potensial_total >=', $potensialtinggi['dari'])
        ->where('a.res_kinerja >=', $kinerjadiatas['dari'])
        ->where('a.flag_active', 1)
        ->where('f.flag_active', 1)
        ->group_by('a.id_peg')
        ->order_by('total', 'desc')
        // ->order_by('total_talent_pool', 'desc')
        ->limit(3);

    // if($jp == 1){
    //     $this->db->where_in('e.eselon', ["II B", "II A"]);
    // }

    // if($jp == 2){
    //     $this->db->where_in('e.eselon', ["III B", "III A"]);
    // }
   
    if($jenis_jabatan == 2){
        $this->db->where('f.jabatan_target', $jabatan_target_jpt);
        $this->db->where_in('e.eselon', ["II B", "II A"]);
    }

    if($jenis_jabatan == 1){
        $this->db->where('f.jabatan_target', $jabatan_target_jpt);
        $this->db->where_in('e.eselon', ["III B", "III A"]);

    }

    $suksesor = $this->db->get()->result_array();

    return $suksesor;   
    }


    function getKriteriaKompetensi1(){
        $this->db->select('a.*,b.bobot')
        ->where('a.id_m_indikator_penilaian', 38)
        ->join('db_simata.m_indikator_penilaian b', 'a.id_m_indikator_penilaian = b.id')
        ->from('db_simata.m_kriteria_penilaian a');
        return $this->db->get()->result_array(); 
    }

    function getKriteriaKompetensi2(){
        $this->db->select('a.*,b.bobot')
        ->where('a.id_m_indikator_penilaian', 39)
        ->join('db_simata.m_indikator_penilaian b', 'a.id_m_indikator_penilaian = b.id')
        ->from('db_simata.m_kriteria_penilaian a');
        return $this->db->get()->result_array(); 
    }

    function getKriteriaKompetensi3(){
        $this->db->select('a.*,b.bobot')
        ->where('a.id_m_indikator_penilaian', 40)
        ->join('db_simata.m_indikator_penilaian b', 'a.id_m_indikator_penilaian = b.id')
        ->from('db_simata.m_kriteria_penilaian a');
        return $this->db->get()->result_array(); 
    }


    public function submitPenilaianKompetensi(){
    
        $datapost = $this->input->post();
        $this->db->trans_begin();
        $total_kompetensi = null;

       
       
        for($x=1;$x<=3;$x++){
            $krit = $this->input->post('kriteria'.$x.'');
              $kriteria = explode(",", $krit);
              $id_kriteria = $kriteria[0];
              $skor = $kriteria[1];
              $bobot = $kriteria[2];
              $total_kompetensi += $skor * $bobot / 100;   
        }
    //  }

       $krit1 = $this->input->post('kriteria1');
       $kriteria1 = explode(",", $krit1);
       $id_kriteria1 = $kriteria1[0];

       $krit2 = $this->input->post('kriteria2');
       $kriteria2 = explode(",", $krit2);
       $id_kriteria2 = $kriteria2[0];

       $krit3 = $this->input->post('kriteria3');
       $kriteria3 = explode(",", $krit3);
       $id_kriteria3 = $kriteria3[0];

     

        $data["id_peg"] = $datapost["id_peg"];
        $data["kriteria1"] = $id_kriteria1;
        $data["kriteria2"] = $id_kriteria2;
        $data["kriteria3"] = $id_kriteria3;
        $data["jabatan_target"] = $this->input->post('jabatan_target');
        $data["res_kompetensi"] = $total_kompetensi;

        $cek =  $this->db->select('*')
                                ->from('db_simata.t_penilaian_kompetensi a')
                                ->where('a.id_peg', $data["id_peg"])
                                ->where('a.jabatan_target', $this->input->post('jabatan_target'))
                                ->where('a.flag_active', 1)
                                ->get()->result_array();

        if($cek){
            $this->db->where('id_peg', $datapost['id_peg'])
            ->where('jabatan_target', $this->input->post('jabatan_target'))
            ->update('db_simata.t_penilaian_kompetensi', 
            ['kriteria1' => $id_kriteria1,
            'kriteria2' => $id_kriteria2,
            'kriteria3' => $id_kriteria3,
            'res_kompetensi' => $total_kompetensi
                ]);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
        } else {
            $this->db->insert('db_simata.t_penilaian_kompetensi', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

        }

        // $this->db->where('id_peg', $datapost['id_peg'])
        //       ->where('id_jabatan_target', $this->input->post('jabatan_target'))
        //             ->update('db_simata.t_penilaian', 
        //             ['res_kompetensi' => $total_kompetensi]);

    
    
        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            // $res['code'] = 1;
            // $res['message'] = 'Terjadi Kesalahan';
            // $res['data'] = null;
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;
    }

    function getPegawaiNilaiKompetensiPegawai($id_peg,$jt){
        $this->db->select('a.*')
            ->from('db_simata.t_penilaian_kompetensi a')
            ->where('a.id_peg', $id_peg)
            ->where('a.jabatan_target', $jt);
        return $this->db->get()->row_array();
    }

    function loadListTalentaIx($id){
          
        $this->db->select('*')
                      ->from('db_simata.t_penilaian a')
                      ->join('db_pegawai.pegawai b','a.id_peg = b.id_peg')
                      ->join('db_pegawai.pangkat c', 'b.pangkat = c.id_pangkat')
                      ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                      ->where('a.res_potensial_total >=', 77)
                      ->where('a.res_kinerja >=', 85)
                      ->where('a.flag_active', 1)
                      ->where('b.id_m_status_pegawai', 1)
                      ->group_by('a.id_peg')
                      ->order_by('b.pangkat desc, d.eselon');
                     

                    if($id == 2){
                        $this->db->where_in('d.eselon', ["II B", "II A"]);
                    }
                    if($id == 1){
                        $this->db->where_in('d.eselon', ["III B", "III A"]);
                    }

                      $query = $this->db->get()->result_array();
                      return $query;
  }

//     function loadListJabatanKosong($id){
          
//         $this->db->select('*')
//                       ->from('db_pegawai.jabatan a')
//                       ->join('db_pegawai.pegawai b','a.id_jabatanpeg = b.jabatan','left')
//                       ->group_start() //this will start grouping
//                       ->where('b.id_m_status_pegawai',8)
//                       ->or_where('b.nama is null')
//                       ->group_end(); //this will end grouping
                     

//                     if($id == 2){
//                         $this->db->where_in('a.eselon', ["II B", "II A"]);
//                     }
//                     if($id == 1){
//                         $this->db->where_in('a.eselon', ["III B", "III A"]);
//                     }

//                       $query = $this->db->get()->result_array();
//                       return $query;
//   }
       
        function createPenilaianKinerja($id,$tahun,$x){
            $this->db->select('*')
                ->from('db_pegawai.pegskp a')
                ->where('a.id_pegawai', $id)
                ->where('a.tahun', $tahun)
                ->order_by('a.tahun', 'desc')
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->limit(1);
            $pk = $this->db->get()->row_array();
            // $id_predikat = $this->general_library->getIdPenilaianKinerjaSimata($pk['predikat'],$x);
            
            $predikat = null;
            if($pk){
            $id_predikat = $pk['predikat'];
            if($x == 1){
                if($id_predikat == "Sangat Baik"){
                    $predikat = "66";
                } else if($id_predikat == "Baik"){
                    $predikat = "67";
                } else if($id_predikat == "Butuh Perbaikan"){
                    $predikat = "68";
                } else if($id_predikat == "Kurang"){
                    $predikat = "69";
                } else if($id_predikat == "Sangat Kurang"){
                    $predikat = "70";
                } 
            } else {
                if($id_predikat == "Sangat Baik"){
                    $predikat = "71";
                } else if($id_predikat == "Baik"){
                    $predikat = "72";
                } else if($id_predikat == "Butuh Perbaikan"){
                    $predikat = "73";
                } else if($id_predikat == "Kurang"){
                    $predikat = "74";
                } else if($id_predikat == "Sangat Kurang"){
                    $predikat = "75";
                } 
            }
            }

            return $predikat;
        }



        function updateMasakerja($id){
            $this->db->select('a.tmtjabatan,a.id')
            ->from('db_pegawai.pegjabatan a')
            // ->join('db_pegawai.jabatan b', 'a.id_jabatan = b.id_jabatanpeg','left')
            // ->join('db_pegawai.eselon c', 'a.eselon = c.id_eselon','left')
            ->where('a.id_pegawai', $id)
            ->where('a.status', 2)
            ->where('a.tmtjabatan !=', "0000-00-00")
            ->where_not_in('a.ket ', ["Plt", "Plh"])
            ->where_not_in('a.statusjabatan',[2,3] )
            ->where_in('a.flag_active', [1,2])
            ->order_by('a.tmtjabatan', 'desc');
         $jabatan = $this->db->get()->result_array();

         $x=0;
         $i=0;

         $previousValue = null;
         foreach ($jabatan as $rs) {
          

         if($x==0){
            $tglawal = $rs['tmtjabatan'];
            $tgl_akhir = date('Y-m-d');
            $previousValue = $rs['tmtjabatan'];
         } else {
            $tglawal = $rs['tmtjabatan'];
            $tgl_akhir = $previousValue;
            if($previousValue) {
                $tgl_akhir = $previousValue;
            }
            $previousValue = $rs['tmtjabatan'];
            // if($x==1){
            // dd($tglawal);
            // }
         }
        
        
         $sdate = $tglawal;
         $edate = $tgl_akhir;
         
         $date_diff = abs(strtotime($edate) - strtotime($sdate));
         $years = floor($date_diff / (365*60*60*24));
        //  $months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
        //  $months = date_diff($sdate, $edate);
        $date1 = $tglawal;
        $date2 = $tgl_akhir;
        
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);
        
        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);
        
        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);
        
        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
        

         $this->db->where('id', $rs['id'])
         ->update('db_pegawai.pegjabatan', 
         ['masa_kerja_bulan' => $diff]);
         $x++;


         }

         return $jabatan;

        }

        public function getPegawaiPenilaianPotensialJptTes($id,$jenis_pengisian,$penilaian){
            $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang')
                           ->from('db_pegawai.pegawai a')
                           ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                           ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                           // ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
                           // ->where_in('c.eselon',["II A", "II B"])
                           ->where('a.id_m_status_pegawai', 1)
                        //    ->where('b.jenjang_jabatan', $jenis_pengisian)
                           // ->where('a.flag_active', 1)
                           ->order_by('c.eselon', 'asc')
                           ->group_by('a.id_peg');
       
                           if($id == 1){
                               $this->db->where_in('c.eselon', ["III B", "III A"]);
                           }
       
                           if($id == 2){
                               $this->db->where_in('c.eselon', ["II B", "II A"]);
                           }
       
                           if($id == 3){
                               $this->db->where_in('c.eselon', ["IV A", "IV B"]);
                           }

                           if($id == 4){
                            $this->db->where_in('c.jenis_jabatan', ["JFU"]);
                           }
                        //    if($penilaian == 0){
                        //     $this->db->where('b.jenjang_jabatan', $jenis_pengisian);
                        //    }
                    
                    
                           $query = $this->db->get()->result_array();
                          
                            
                           foreach ($query as $rs) {
                            // $id_peg = "IDPeg97";
                           
                        if($penilaian == 0){
                        //    assesment
                            $nilaiassesment = $this->getNilaiAssesment($rs['id_pegawai']); 
                            if($nilaiassesment){
                            $nilaiass = $nilaiassesment['nilai_assesment'];
                            } else {
                            $nilaiass = 0;
                            }
                            $total_nilai =  $nilaiass * 50 / 100;

                            $cekceass =  $this->db->select('*')
                                ->from('db_simata.t_penilaian_potensial a')
                                ->where('a.id_peg', $rs['id_pegawai'])
                                ->where('a.nilai_assesment is not null')
                                ->where('a.flag_active', 1)
                                ->where('a.jenjang_jabatan', $jenis_pengisian)
                                ->get()->result_array();
       

                            if($cekceass){
                                $this->db->where('id_peg', $rs['id_pegawai'])
                                ->where('jenjang_jabatan', $jenis_pengisian)
                                ->update('db_simata.t_penilaian_potensial', 
                                ['nilai_assesment' => $nilaiass,
                                'jenjang_jabatan' => $jenis_pengisian
                                    ]);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                            } else {

                                $dataInsert['id_peg']      = $rs['id_pegawai'];
                                $dataInsert['nilai_assesment']      = $nilaiass;
                                $dataInsert['jenjang_jabatan']      = $jenis_pengisian;
                                $this->db->insert('db_simata.t_penilaian_potensial', $dataInsert);
                                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                            }


                            $getAllNilaiPotensial =  $this->db->select('*')
                                        ->from('db_simata.t_penilaian a')
                                        ->where('a.id_peg', $rs['id_pegawai'])
                                        ->where('a.flag_active', 1)
                                        ->where('a.jenjang_jabatan', $jenis_pengisian)
                                        ->get()->result_array();

                            if($getAllNilaiPotensial){
                                foreach ($getAllNilaiPotensial as $rs2) {
                            
                                    $total_potensial = $rs2['res_potensial_cerdas'] + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];
                                
                                    $this->db->where('id_peg', $rs['id_pegawai'])
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->update('db_simata.t_penilaian', 
                                    ['res_potensial_total' => $total_potensial,
                                    'res_potensial_cerdas' => $total_nilai,
                                    'jenjang_jabatan' => $jenis_pengisian
                                    ]);
                                            
                                }
                            } else {
                                $dataInsert2['id_peg']      = $rs['id_pegawai'];
                                $dataInsert2['res_potensial_cerdas']      = $total_nilai;
                                $dataInsert2['res_potensial_total']      = $total_nilai;
                                $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                                $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                            }
                            
                            //   tutup assesment
                        }
                        if($penilaian == 2){
                            $id_rekamjjk1 = $this->getPendidikanFormal($rs['id_pegawai']); 
                            
                            $skor1 =  $this->getSkor($id_rekamjjk1); 
                            $bobot1 = $this->getBobot($id_rekamjjk1); 
                            $total_rj1 = $skor1  * $bobot1 / 100; 
                            
                            $data["id_peg"] = $rs['id_pegawai'];
                            $data["pendidikan_formal"] = $id_rekamjjk1;
                            $data["nilai_pendidikan_formal"] = $total_rj1;
                            $data["jenjang_jabatan"] = $jenis_pengisian;

                            $cekkrj =  $this->db->select('*')
                            ->from('db_simata.t_penilaian_potensial a')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.nilai_assesment is not null')
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            if($cekkrj){
                                $this->db->where('id_peg', $rs['id_pegawai'])
                                ->where('jenjang_jabatan', $jenis_pengisian)
                                ->update('db_simata.t_penilaian_potensial', 
                                ['pendidikan_formal' => $id_rekamjjk1,
                                 'nilai_pendidikan_formal' => $total_rj1,
                                 'jenjang_jabatan' => $jenis_pengisian
                                    ]);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                             } else {
                                    $this->db->insert('db_simata.t_penilaian_potensial', $data);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

                            }

                           

                            $getAllNilaiPotensial =  $this->db->select('*')
                            ->from('db_simata.t_penilaian a')
                            ->join('db_simata.t_penilaian_potensial b', 'a.id_peg = b.id_peg', 'left')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->where('b.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            // if($rs['id_peg'] == "IDPeg3383"){
                            //     dd($getAllNilaiPotensial);
                            // }

                            if($getAllNilaiPotensial){
                            
                                    foreach ($getAllNilaiPotensial as $rs2) {
                                    $total_rj = $rs2['nilai_pendidikan_formal'] + $rs2['nilai_pangkat_gol'] +  $rs2['nilai_masa_kerja_jabatan'] + $rs2['nilai_diklat'] + $rs2['nilai_kompetensi20_jp'] + $rs2['nilai_penghargaan'] + $rs2['nilai_riwayat_hukdis'];
                                    $total_potensial = $rs2['res_potensial_cerdas'] + $total_rj + $rs2['res_potensial_lainnya'];
                                    $this->db->where('id_peg', $rs['id_pegawai'])
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->update('db_simata.t_penilaian', 
                                    ['res_potensial_total' => $total_potensial,
                                    'res_potensial_rj' => $total_rj,
                                    'res_potensial_lainnya' => $rs['res_potensial_lainnya']]);          
                                    }
                                } else {
                                    $dataInsert2['id_peg']      = $rs['id_pegawai'];
                                    $dataInsert2['res_potensial_rj']      = $total_rj1;
                                    $dataInsert2['res_potensial_total']      = $total_rj1;
                                    $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                                }

                        } else if($penilaian == 3){
                            $id_rekamjjk2 = $this->getPangkatGolPengawai($rs['id_pegawai'],$id,$jenis_pengisian);
                            $skor2 =  $this->getSkor($id_rekamjjk2); 
                            $bobot2 = $this->getBobot($id_rekamjjk2); 
                            $total_rj2 = $skor2  * $bobot2 / 100; 
                            $data["id_peg"] = $rs['id_pegawai'];
                            $data["pangkat_gol"] = $id_rekamjjk2;
                            $data["nilai_pangkat_gol"] = $total_rj2;
                            $data["jenjang_jabatan"] = $jenis_pengisian;

                            $cekkrj =  $this->db->select('*')
                            ->from('db_simata.t_penilaian_potensial a')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.nilai_assesment is not null')
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            if($cekkrj){
                                $this->db->where('id_peg', $rs['id_pegawai'])
                                ->where('jenjang_jabatan', $jenis_pengisian)
                                ->update('db_simata.t_penilaian_potensial', 
                                ['pangkat_gol' => $id_rekamjjk2, 
                                  'nilai_pangkat_gol' => $total_rj2,     
                                  'jenjang_jabatan' => $jenis_pengisian                        
                                    ]);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                             } else {
                                    $this->db->insert('db_simata.t_penilaian_potensial', $data);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

                            }


                            $getAllNilaiPotensial =  $this->db->select('*')
                            ->from('db_simata.t_penilaian a')
                            ->join('db_simata.t_penilaian_potensial b', 'a.id_peg = b.id_peg', 'left')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->where('b.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            if($getAllNilaiPotensial){
                                    foreach ($getAllNilaiPotensial as $rs2) {
                                        $total_rj = $rs2['nilai_pendidikan_formal'] + $rs2['nilai_pangkat_gol'] +  $rs2['nilai_masa_kerja_jabatan'] + $rs2['nilai_diklat'] + $rs2['nilai_kompetensi20_jp'] + $rs2['nilai_penghargaan'] + $rs2['nilai_riwayat_hukdis'];
                                    $total_potensial = $rs2['res_potensial_cerdas'] + $total_rj + $rs2['res_potensial_lainnya'];
                                    $this->db->where('id_peg', $rs['id_pegawai'])
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->update('db_simata.t_penilaian', 
                                    ['res_potensial_total' => $total_potensial,
                                    'res_potensial_rj' => $total_rj,
                                    'res_potensial_lainnya' => $rs['res_potensial_lainnya']]);
                                                
                                    }
                                } else {
                                    $dataInsert2['id_peg']      = $rs['id_pegawai'];
                                    $dataInsert2['res_potensial_rj']      = $total_rj2;
                                    $dataInsert2['res_potensial_total']      = $total_rj2;
                                    $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                                }

                        } else if($penilaian == 4){
                            $updateMasakerja = $this->updateMasakerja($rs['id_pegawai']);
                            $id_rekamjjk3 = $this->getMasaKerjaJabatan($rs['id_pegawai'],$id,$rs['eselon'],$jenis_pengisian); 
                            $skor3 =  $this->getSkor($id_rekamjjk3); 
                            $bobot3 = $this->getBobot($id_rekamjjk3); 
                            $total_rj3 = $skor3 * $bobot3 / 100; 
                            // if($rs['id_peg'] == "IDPeg3383"){
                            //     dd($total_rj3);
                            // }
                            $data["id_peg"] = $rs['id_pegawai'];
                            $data["masa_kerja_jabatan"] = $id_rekamjjk3;
                            $data["nilai_masa_kerja_jabatan"] = $total_rj3;
                            $data["jenjang_jabatan"] = $jenis_pengisian;

                            $cekkrj =  $this->db->select('*')
                            ->from('db_simata.t_penilaian_potensial a')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.nilai_assesment is not null')
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            if($cekkrj){
                                $this->db->where('id_peg', $rs['id_pegawai'])
                                ->where('jenjang_jabatan', $jenis_pengisian)
                                ->update('db_simata.t_penilaian_potensial', 
                                ['masa_kerja_jabatan' => $id_rekamjjk3,
                                'nilai_masa_kerja_jabatan' => $total_rj3,  
                                'jenjang_jabatan' => $jenis_pengisian                               
                                    ]);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                             } else {
                                    $this->db->insert('db_simata.t_penilaian_potensial', $data);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

                            }

                         

                            $getAllNilaiPotensial =  $this->db->select('*')
                            ->from('db_simata.t_penilaian a')
                            ->join('db_simata.t_penilaian_potensial b', 'a.id_peg = b.id_peg', 'left')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->where('b.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            if($getAllNilaiPotensial){
                                    foreach ($getAllNilaiPotensial as $rs2) {
                                        $total_rj = $rs2['nilai_pendidikan_formal'] + $rs2['nilai_pangkat_gol'] +  $rs2['nilai_masa_kerja_jabatan'] + $rs2['nilai_diklat'] + $rs2['nilai_kompetensi20_jp'] + $rs2['nilai_penghargaan'] + $rs2['nilai_riwayat_hukdis'];
                                        $total_potensial = $rs2['res_potensial_cerdas'] + $total_rj + $rs2['res_potensial_lainnya'];
                                    $this->db->where('id_peg', $rs['id_pegawai'])
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->update('db_simata.t_penilaian', 
                                    ['res_potensial_total' => $total_potensial,
                                    'res_potensial_rj' => $total_rj,
                                    'res_potensial_lainnya' => $rs['res_potensial_lainnya']]);
                                                
                                    }
                                } else {
                                    $dataInsert2['id_peg']      = $rs['id_pegawai'];
                                    $dataInsert2['res_potensial_rj']      = $total_rj3;
                                    $dataInsert2['res_potensial_total']      = $total_rj3;
                                    $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                                    $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                                }

                        } else if($penilaian == 5){
                            $id_rekamjjk3 = $this->getDiklatPengawai($rs['id_pegawai'],$id,$rs['eselon'],$jenis_pengisian); 
                            $skor3 =  $this->getSkor($id_rekamjjk3); 
                            $bobot3 = $this->getBobot($id_rekamjjk3); 
                            $total_rj3 = $skor3 * $bobot3 / 100; 
                            // if($rs['id_peg'] == "IDPeg3383"){
                            //     dd($total_rj3);
                            // }
                            $data["id_peg"] = $rs['id_pegawai'];
                            $data["diklat"] = $id_rekamjjk3;
                            $data["nilai_diklat"] = $total_rj3;
                            $data["jenjang_jabatan"] = $jenis_pengisian;

                            $cekkrj =  $this->db->select('*')
                            ->from('db_simata.t_penilaian_potensial a')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.nilai_assesment is not null')
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            if($cekkrj){
                                $this->db->where('id_peg', $rs['id_pegawai'])
                                ->where('jenjang_jabatan', $jenis_pengisian)
                                ->update('db_simata.t_penilaian_potensial', 
                                ['diklat' => $id_rekamjjk3,
                                'nilai_diklat' => $total_rj3,  
                                'jenjang_jabatan' => $jenis_pengisian                               
                                    ]);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                             } else {
                                    $this->db->insert('db_simata.t_penilaian_potensial', $data);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

                            }

                         

                            $getAllNilaiPotensial =  $this->db->select('*')
                            ->from('db_simata.t_penilaian a')
                            ->join('db_simata.t_penilaian_potensial b', 'a.id_peg = b.id_peg', 'left')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->where('b.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            if($getAllNilaiPotensial){
                                    foreach ($getAllNilaiPotensial as $rs2) {
                                        $total_rj = $rs2['nilai_pendidikan_formal'] + $rs2['nilai_pangkat_gol'] +  $rs2['nilai_masa_kerja_jabatan'] + $rs2['nilai_diklat'] + $rs2['nilai_kompetensi20_jp'] + $rs2['nilai_penghargaan'] + $rs2['nilai_riwayat_hukdis'];
                                        $total_potensial = $rs2['res_potensial_cerdas'] + $total_rj + $rs2['res_potensial_lainnya'];
                                    $this->db->where('id_peg', $rs['id_pegawai'])
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->update('db_simata.t_penilaian', 
                                    ['res_potensial_total' => $total_potensial,
                                    'res_potensial_rj' => $total_rj,
                                    'res_potensial_lainnya' => $rs['res_potensial_lainnya']]);
                                                
                                    }
                                } else {
                                    $dataInsert2['id_peg']      = $rs['id_pegawai'];
                                    $dataInsert2['res_potensial_rj']      = $total_rj3;
                                    $dataInsert2['res_potensial_total']      = $total_rj3;
                                    $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                                    $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                                }

                           } else if($penilaian == 6){
                            $id_rekamjjk3 = $this->getJPKompetensi($rs['id_pegawai']);
                            $skor3 =  $this->getSkor($id_rekamjjk3); 
                            $bobot3 = $this->getBobot($id_rekamjjk3); 
                            $total_rj3 = $skor3 * $bobot3 / 100; 
                            // if($rs['id_peg'] == "IDPeg3383"){
                            //     dd($total_rj3);
                            // }
                            $data["id_peg"] = $rs['id_pegawai'];
                            $data["kompetensi20_jp"] = $id_rekamjjk3;
                            $data["nilai_kompetensi20_jp"] = $total_rj3;
                            $data["jenjang_jabatan"] = $jenis_pengisian;

                            $cekkrj =  $this->db->select('*')
                            ->from('db_simata.t_penilaian_potensial a')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.nilai_assesment is not null')
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            if($cekkrj){
                                $this->db->where('id_peg', $rs['id_pegawai'])
                                ->where('jenjang_jabatan', $jenis_pengisian)
                                ->update('db_simata.t_penilaian_potensial', 
                                ['kompetensi20_jp' => $id_rekamjjk3,
                                'nilai_kompetensi20_jp' => $total_rj3,  
                                'jenjang_jabatan' => $jenis_pengisian                               
                                    ]);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                             } else {
                                    $this->db->insert('db_simata.t_penilaian_potensial', $data);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

                            }

                         

                            $getAllNilaiPotensial =  $this->db->select('*')
                            ->from('db_simata.t_penilaian a')
                            ->join('db_simata.t_penilaian_potensial b', 'a.id_peg = b.id_peg', 'left')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->where('b.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            if($getAllNilaiPotensial){
                                    foreach ($getAllNilaiPotensial as $rs2) {
                                        $total_rj = $rs2['nilai_pendidikan_formal'] + $rs2['nilai_pangkat_gol'] +  $rs2['nilai_masa_kerja_jabatan'] + $rs2['nilai_diklat'] + $rs2['nilai_kompetensi20_jp'] + $rs2['nilai_penghargaan'] + $rs2['nilai_riwayat_hukdis'];
                                        $total_potensial = $rs2['res_potensial_cerdas'] + $total_rj + $rs2['res_potensial_lainnya'];
                                    $this->db->where('id_peg', $rs['id_pegawai'])
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->update('db_simata.t_penilaian', 
                                    ['res_potensial_total' => $total_potensial,
                                    'res_potensial_rj' => $total_rj,
                                    'res_potensial_lainnya' => $rs['res_potensial_lainnya']]);
                                                
                                    }
                                } else {
                                    $dataInsert2['id_peg']      = $rs['id_pegawai'];
                                    $dataInsert2['res_potensial_rj']      = $total_rj3;
                                    $dataInsert2['res_potensial_total']      = $total_rj3;
                                    $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                                    $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                                }

                           } else if($penilaian == 7){
                            $id_rekamjjk3 = $this->getPenghargaan($rs['id_pegawai']);
                            $skor3 =  $this->getSkor($id_rekamjjk3); 
                            $bobot3 = $this->getBobot($id_rekamjjk3); 
                            $total_rj3 = $skor3 * $bobot3 / 100; 
                            // if($rs['id_peg'] == "IDPeg3383"){
                            //     dd($total_rj3);
                            // }
                            $data["id_peg"] = $rs['id_pegawai'];
                            $data["penghargaan"] = $id_rekamjjk3;
                            $data["nilai_penghargaan"] = $total_rj3;
                            $data["jenjang_jabatan"] = $jenis_pengisian;

                            $cekkrj =  $this->db->select('*')
                            ->from('db_simata.t_penilaian_potensial a')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.nilai_assesment is not null')
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            if($cekkrj){
                                $this->db->where('id_peg', $rs['id_pegawai'])
                                ->where('jenjang_jabatan', $jenis_pengisian)
                                ->update('db_simata.t_penilaian_potensial', 
                                ['penghargaan' => $id_rekamjjk3,
                                'nilai_penghargaan' => $total_rj3,  
                                'jenjang_jabatan' => $jenis_pengisian                               
                                    ]);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                             } else {
                                    $this->db->insert('db_simata.t_penilaian_potensial', $data);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

                            }

                         

                            $getAllNilaiPotensial =  $this->db->select('*')
                            ->from('db_simata.t_penilaian a')
                            ->join('db_simata.t_penilaian_potensial b', 'a.id_peg = b.id_peg', 'left')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->where('b.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            if($getAllNilaiPotensial){
                                    foreach ($getAllNilaiPotensial as $rs2) {
                                        $total_rj = $rs2['nilai_pendidikan_formal'] + $rs2['nilai_pangkat_gol'] +  $rs2['nilai_masa_kerja_jabatan'] + $rs2['nilai_diklat'] + $rs2['nilai_kompetensi20_jp'] + $rs2['nilai_penghargaan'] + $rs2['nilai_riwayat_hukdis'];
                                        $total_potensial = $rs2['res_potensial_cerdas'] + $total_rj + $rs2['res_potensial_lainnya'];
                                    $this->db->where('id_peg', $rs['id_pegawai'])
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->update('db_simata.t_penilaian', 
                                    ['res_potensial_total' => $total_potensial,
                                    'res_potensial_rj' => $total_rj,
                                    'res_potensial_lainnya' => $rs['res_potensial_lainnya']]);
                                                
                                    }
                                } else {
                                    $dataInsert2['id_peg']      = $rs['id_pegawai'];
                                    $dataInsert2['res_potensial_rj']      = $total_rj3;
                                    $dataInsert2['res_potensial_total']      = $total_rj3;
                                    $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                                    $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                                }

                           } else if($penilaian == 8){
                            $id_rekamjjk3 = $this->getHukdisPengawai($rs['id_pegawai']);
                            $skor3 =  $this->getSkor($id_rekamjjk3); 
                            $bobot3 = $this->getBobot($id_rekamjjk3); 
                            $total_rj3 = $skor3 * $bobot3 / 100; 
                           
                            $data["id_peg"] = $rs['id_pegawai'];
                            $data["riwayat_hukdis"] = $id_rekamjjk3;
                            $data["nilai_riwayat_hukdis"] = $total_rj3;
                            $data["jenjang_jabatan"] = $jenis_pengisian;

                            $cekkrj =  $this->db->select('*')
                            ->from('db_simata.t_penilaian_potensial a')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.nilai_assesment is not null')
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            if($cekkrj){
                                $this->db->where('id_peg', $rs['id_pegawai'])
                                ->where('jenjang_jabatan', $jenis_pengisian)
                                ->update('db_simata.t_penilaian_potensial', 
                                ['riwayat_hukdis' => $id_rekamjjk3,
                                'nilai_riwayat_hukdis' => $total_rj3,  
                                'jenjang_jabatan' => $jenis_pengisian                               
                                    ]);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                             } else {
                                    $this->db->insert('db_simata.t_penilaian_potensial', $data);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

                            }

                         

                            $getAllNilaiPotensial =  $this->db->select('*')
                            ->from('db_simata.t_penilaian a')
                            ->join('db_simata.t_penilaian_potensial b', 'a.id_peg = b.id_peg', 'left')
                            ->where('a.id_peg', $rs['id_pegawai'])
                            ->where('a.flag_active', 1)
                            ->where('a.jenjang_jabatan', $jenis_pengisian)
                            ->where('b.jenjang_jabatan', $jenis_pengisian)
                            ->get()->result_array();

                            if($getAllNilaiPotensial){
                                    foreach ($getAllNilaiPotensial as $rs2) {
                                        $total_rj = $rs2['nilai_pendidikan_formal'] + $rs2['nilai_pangkat_gol'] +  $rs2['nilai_masa_kerja_jabatan'] + $rs2['nilai_diklat'] + $rs2['nilai_kompetensi20_jp'] + $rs2['nilai_penghargaan'] + $rs2['nilai_riwayat_hukdis'];
                                        $total_potensial = $rs2['res_potensial_cerdas'] + $total_rj + $rs2['res_potensial_lainnya'];
                                    
                                        // if($rs['id_peg'] == "IDPeg3383"){
                                        //     $this->db->where('id_peg', $rs['id_pegawai'])
                                        //     ->where('jenjang_jabatan', $jenis_pengisian)
                                        //     ->update('db_simata.t_penilaian', 
                                        //     ['res_potensial_total' => $total_potensial,
                                        //     'res_potensial_rj' => $total_rj,
                                        //     'res_potensial_lainnya' => $rs['res_potensial_lainnya']]);
                                        // //  dd($total_potensial);
                                        // }
                                   
                                    $this->db->where('id_peg', $rs['id_pegawai'])
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->update('db_simata.t_penilaian', 
                                    ['res_potensial_total' => $total_potensial,
                                    'res_potensial_rj' => $total_rj,
                                    'res_potensial_lainnya' => $rs['res_potensial_lainnya']]);
                                                
                                    }
                                } else {
             
                                    // $dataInsert2['id_peg']      = $rs['id_pegawai'];
                                    // $dataInsert2['res_potensial_rj']      = $total_rj3;
                                    // $dataInsert2['res_potensial_total']      = $total_rj3;
                                    // $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                                    // $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                                }

                           }

                
                           
                           }

                           $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang')
                           ->from('db_pegawai.pegawai a')
                           ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                           ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                           ->where('a.id_m_status_pegawai', 1)
                           ->where('b.jenjang_jabatan', $jenis_pengisian)
                           ->order_by('c.eselon', 'asc')
                           ->group_by('a.id_peg');
       
                           if($id == 1){
                               $this->db->where_in('c.eselon', ["III B", "III A"]);
                           }
       
                           if($id == 2){
                               $this->db->where_in('c.eselon', ["II B", "II A"]);
                           }
       
                           if($id == 3){
                               $this->db->where_in('c.eselon', ["IV A", "IV B"]);
                           }

                           if($id == 4){
                            $this->db->where_in('c.jenis_jabatan', ["JFU"]);
                           }
                
                           $query = $this->db->get()->result_array();

                        

                   return $query;
                   }




                   public function getPegawaiPenilaianPotensialJpt($id,$jenis_pengisian,$penilaian,$eselon,$skpd){
                    // $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang,
                    // (select d.res_potensial_cerdas from db_simata.t_penilaian as d where a.id_peg = d.id_peg and d.flag_active = 1 and d.jenjang_jabatan = '.$jenis_pengisian.' limit 1) as res_potensial_cerdas,
                    // (select e.res_potensial_rj from db_simata.t_penilaian as e where a.id_peg = e.id_peg and e.flag_active = 1 and e.jenjang_jabatan = '.$jenis_pengisian.' limit 1) as res_potensial_rj,
                    // (select f.res_potensial_lainnya from db_simata.t_penilaian as f where a.id_peg = f.id_peg and f.flag_active = 1 and f.jenjang_jabatan = '.$jenis_pengisian.' limit 1) as res_potensial_lainnya')
                    $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang,
                    (select pertimbangan_pimpinan from db_simata.t_penilaian_pimpinan aa where aa.id_peg = a.id_peg and aa.flag_active = 1 limit 1) as pertimbangan_pimpinan,
                    (select id_m_kriteria_penilaian from db_simata.t_penilaian_sejawat bb where bb.id_peg = a.id_peg and bb.flag_active = 1 limit 1) as id_kriteria_penilaian')
                                   ->from('db_pegawai.pegawai a')
                                   ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                                   ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                   ->join('db_pegawai.eselon h', 'c.eselon = h.nm_eselon')
                                   ->where('a.id_m_status_pegawai', 1)
                                   ->where('b.jenjang_jabatan', $jenis_pengisian)
                                   ->order_by('c.eselon', 'asc')
                                   ->group_by('a.id_peg');
               
                                   if($eselon != 0){
                                       $this->db->where('h.id_eselon',$eselon);
                                   }

                                   if($skpd != 0){
                                    
                                    $this->db->join('db_pegawai.unitkerja i', 'a.skpd = i.id_unitkerja');
                                    $this->db->join('db_pegawai.unitkerjamaster j', 'i.id_unitkerjamaster = j.id_unitkerjamaster');
                                   if($skpd == "5000000") {
                                    $this->db->where_in('j.id_unitkerjamaster',['5002000','5003000','5010001','5004000','5005000','5006000','5007000','5008000','5009000','5001000','5011001']);
                                   } else if($skpd == "8000000"){
                                    $this->db->where_in('j.id_unitkerjamaster',['8000000','8010000','8020000']);
                                   } else {
                                    
                                    $this->db->where('j.id_unitkerjamaster',$skpd);
                                   }
                                   }
               
 
                                   $query = $this->db->get()->result_array();
                                  
                                  
                                   if($penilaian != 0){
                                   foreach ($query as $rs) {
                                  
                                    
                                     //    assesment
                                     $nilaiassesment = $this->getNilaiAssesment($rs['id_pegawai']); 
                                     if($nilaiassesment){
                                     $nilaiass = $nilaiassesment['nilai_assesment'];
                                     } else {
                                     $nilaiass = 0;
                                     }
                                     $total_nilai =  $nilaiass * 50 / 100;
     
                                     $cekceass =  $this->db->select('*')
                                         ->from('db_simata.t_penilaian_potensial a')
                                         ->where('a.id_peg', $rs['id_pegawai'])
                                         ->where('jenjang_jabatan', $jenis_pengisian)
                                         ->where('a.nilai_assesment is not null')
                                         ->where('a.flag_active', 1)
                                         ->get()->row_array();
                
                                     
                                     if($cekceass){
                                         $this->db->where('id_peg', $rs['id_pegawai'])
                                         ->where('jenjang_jabatan', $jenis_pengisian)
                                         ->update('db_simata.t_penilaian_potensial', 
                                         ['nilai_assesment' => $nilaiass
                                             ]);
                                             $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                                     } else {
     
                                         $dataInsert['id_peg']      = $rs['id_pegawai'];
                                         $dataInsert['nilai_assesment']      = $nilaiass;
                                         $dataInsert['jenjang_jabatan']      = $jenis_pengisian;
                                         $this->db->insert('db_simata.t_penilaian_potensial', $dataInsert);
                                         $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                                     }
     
     
                                     $getAllNilaiPotensial =  $this->db->select('*')
                                                 ->from('db_simata.t_penilaian a')
                                                 ->where('a.id_peg', $rs['id_pegawai'])
                                                 ->where('jenjang_jabatan', $jenis_pengisian)
                                                 ->where('a.flag_active', 1)
                                                 ->get()->result_array();
     
                                     if($getAllNilaiPotensial){
                                         foreach ($getAllNilaiPotensial as $rs2) {
                                     
                                             $total_potensial = $total_nilai + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];
                                         
                                             $this->db->where('id_peg', $rs['id_pegawai'])
                                             ->where('jenjang_jabatan', $jenis_pengisian)
                                             ->update('db_simata.t_penilaian', 
                                             ['res_potensial_total' => $total_potensial,
                                             'res_potensial_cerdas' => $total_nilai
                                             ]);
                                                     
                                         }
                                     } else {
                                         $dataInsert2['id_peg']      = $rs['id_pegawai'];
                                         $dataInsert2['res_potensial_cerdas']      = $total_nilai;
                                         $dataInsert2['res_potensial_total']      = $total_nilai;
                                         $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                                         $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                                     }
                                     
                                     //   tutup assesment
                                     
                                    // rekam jejak
                                        // $updateMasakerja = $this->updateMasakerja($rs['id_pegawai']);

                                        // testing
                                        $id_rekamjjk1 = $this->getPendidikanFormal($rs['id_pegawai']); 
                                        $id_rekamjjk2 = $this->getPangkatGolPengawai($rs['id_pegawai'],$id,$jenis_pengisian);
                                        $id_rekamjjk3 = $this->getMasaKerjaJabatan($rs['id_pegawai'],$id,$rs['eselon'],$jenis_pengisian); 
                                        $id_rekamjjk4 = $this->getDiklatPengawai($rs['id_pegawai'],$jenis_pengisian,$rs['eselon'],$jenis_pengisian); 
                                        $id_rekamjjk5 = $this->getJPKompetensi($rs['id_pegawai']); 
                                        $id_rekamjjk6 = $this->getPenghargaan($rs['id_pegawai']); 
                                        $id_rekamjjk7 = $this->getHukdisPengawai($rs['id_pegawai']); 
                                            
                                        $id_pertimbangan1 = $this->getPengalamanOrganisasiPengawai($rs['id_pegawai']);
                                        $id_pertimbangan2 = $rs['pertimbangan_pimpinan'];
                                        $id_pertimbangan3 = $rs['id_kriteria_penilaian'];

                                        // $id_pertimbangan2 = 124;
                                        // $id_pertimbangan3 = 126;
                                        
                                     
                                        // $id_rekamjjk1 = 93; 
                                        // $id_rekamjjk2 = 96;
                                        // $id_rekamjjk3 = 102; 
                                        // $id_rekamjjk4 = 106; 
                                        // $id_rekamjjk5 = 109; 
                                        // $id_rekamjjk6 = 111; 
                                        // $id_rekamjjk7 = 115; 
    
             
                                    $skor1 =  $this->getSkor($id_rekamjjk1); 
                                    $bobot1 = $this->getBobot($id_rekamjjk1); 
                                    $total_rj1 = $skor1  * $bobot1 / 100;   
                                        
                                    $skor2 =  $this->getSkor($id_rekamjjk2); 
                                    $bobot2 = $this->getBobot($id_rekamjjk2); 
                                    $total_rj2 = $skor2  * $bobot2 / 100; 
    
                                    $skor3 =  $this->getSkor($id_rekamjjk3); 
                                    $bobot3 = $this->getBobot($id_rekamjjk3); 
                                    $total_rj3 = $skor3  * $bobot3 / 100;   
                                        
                                    $skor4 =  $this->getSkor($id_rekamjjk4); 
                                    $bobot4 = $this->getBobot($id_rekamjjk4); 
                                    $total_rj4 = $skor4  * $bobot4 / 100; 
    
                                    $skor5 =  $this->getSkor($id_rekamjjk5); 
                                    $bobot5 = $this->getBobot($id_rekamjjk5); 
                                    $total_rj5 = $skor5  * $bobot5 / 100;
    
                                    $skor6 =  $this->getSkor($id_rekamjjk6); 
                                    $bobot6 = $this->getBobot($id_rekamjjk6); 
                                    $total_rj6 = $skor6  * $bobot6 / 100;
    
                                    $skor7 =  $this->getSkor($id_rekamjjk7); 
                                    $bobot7 = $this->getBobot($id_rekamjjk7); 
                                    $total_rj7 = $skor7  * $bobot7 / 100;
    
                                    $skor8 =  $this->getSkor($id_pertimbangan1); 
                                    $bobot8 = $this->getBobot($id_pertimbangan1); 
                                    $total_pertimbangan_lainnya1 = $skor8  * $bobot8 / 100;

                                    $skor9 =  $this->getSkor($id_pertimbangan2); 
                                    $bobot9 = $this->getBobot($id_pertimbangan2); 
                                    $total_pertimbangan_lainnya2 = $skor9  * $bobot9 / 100;

                                    $skor10 =  $this->getSkor($id_pertimbangan3); 
                                    $bobot10 = $this->getBobot($id_pertimbangan3); 
                                    $total_pertimbangan_lainnya3 = $skor10  * $bobot10 / 100;
                                    
                                    $total_rj = $total_rj1 + $total_rj2 + $total_rj3 + $total_rj4 + $total_rj5  + $total_rj6  + $total_rj7;
                                    $total_pertimbangan_lainnya = $total_pertimbangan_lainnya1 + $total_pertimbangan_lainnya2 + $total_pertimbangan_lainnya3;
                                    //  dd($total_pertimbangan_lainnya);
                                        $data["id_peg"] = $rs['id_pegawai'];
                                        $data["pendidikan_formal"] = $id_rekamjjk1;
                                        $data["pangkat_gol"] = $id_rekamjjk2;
                                        $data["masa_kerja_jabatan"] = $id_rekamjjk3;
                                        $data["diklat"] = $id_rekamjjk4;
                                        $data["kompetensi20_jp"] = $id_rekamjjk5;
                                        $data["penghargaan"] = $id_rekamjjk6;
                                        $data["riwayat_hukdis"] = $id_rekamjjk7;
                                        // $data['nilai_assesment'] = $nilaiass;
                                        $data["pengalaman_organisasi"] = $id_pertimbangan1;
                                        $data["aspirasi_karir"] = $id_pertimbangan2;
                                        $data["asn_ceria"] = $id_pertimbangan3;
                                        $data["jenjang_jabatan"] = $jenis_pengisian;

                                        
                            // $data["jabatan_target"] = $this->input->post('rj_jabatan_target');
    
                            $cekkrj =  $this->db->select('*')
                                                    ->from('db_simata.t_penilaian_potensial a')
                                                    ->where('a.id_peg', $rs['id_pegawai'])
                                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                                    ->where('a.flag_active', 1)
                                                    ->where('a.nilai_assesment is not null')
                                                    ->get()->result_array();
                                                    // dd($cekkrj);
    
                            if($cekkrj){
                                $this->db->where('id_peg', $rs['id_pegawai'])
                                ->where('jenjang_jabatan', $jenis_pengisian)
                                ->update('db_simata.t_penilaian_potensial', 
                                ['pendidikan_formal' => $id_rekamjjk1,
                                'pangkat_gol' => $id_rekamjjk2,
                                'masa_kerja_jabatan' => $id_rekamjjk3,
                                'diklat' => $id_rekamjjk4,
                                'kompetensi20_jp' => $id_rekamjjk5,
                                'penghargaan' => $id_rekamjjk6,
                                'riwayat_hukdis' => $id_rekamjjk7,
                                // 'nilai_assesment' => $nilaiass,
                                'pengalaman_organisasi' => $id_pertimbangan1,
                                'aspirasi_karir' => $id_pertimbangan2,
                                'asn_ceria' => $id_pertimbangan3,
                                'jenjang_jabatan' => $jenis_pengisian]);
                                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                                    } else {
                                        $this->db->insert('db_simata.t_penilaian_potensial', $data);
                                        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
    
                                    }
    
                                        //  $this->db->where('id_peg', $rs['id_pegawai'])
                                        //  ->where('jenjang_jabatan', $jenis_pengisian) 
                                        // ->update('db_simata.t_penilaian', 
                                        // ['res_potensial_rj' => $total_rj]);
    
                                         $getAllNilaiPotensial =  $this->db->select('*')
                                        ->from('db_simata.t_penilaian a')
                                        ->where('a.id_peg', $rs['id_pegawai'])
                                        ->where('a.jenjang_jabatan', $jenis_pengisian)
                                        ->where('a.flag_active', 1)
                                        ->get()->result_array();
                            
                                        if($getAllNilaiPotensial){
    
                                            foreach ($getAllNilaiPotensial as $rs2) {
                                            // $total_potensial = $total_nilai + $total_rj + $rs['res_potensial_lainnya'];
                                            $total_potensial = $total_nilai + $total_rj + $total_pertimbangan_lainnya;
                                            $this->db->where('id_peg', $rs['id_pegawai'])
                                            ->where('jenjang_jabatan', $jenis_pengisian)
                                            ->update('db_simata.t_penilaian', 
                                            ['res_potensial_total' => $total_potensial,
                                            'res_potensial_rj' => $total_rj,
                                            'res_potensial_lainnya' => $total_pertimbangan_lainnya,
                                            'jenjang_jabatan' => $jenis_pengisian]);
                                                        
                                            }
                                        } else {
                                            $dataInsert2['id_peg']      = $rs['id_pegawai'];
                                            $dataInsert2['res_potensial_rj']      = $total_rj;
                                            $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                                            $dataInsert2['res_potensial_total']      = $total_rj;
                                            $dataInsert2['res_potensial_lainnya']      = $total_pertimbangan_lainnya;
                                            $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                                        }
        
                                    // tutup rekam jejak
                                   
                                   }
                                }
                                
                                
                                   $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang')
                                   ->from('db_pegawai.pegawai a')
                                   ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                                   ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                   ->where('a.id_m_status_pegawai', 1)
                                   ->where('b.jenjang_jabatan', $jenis_pengisian)
                                   ->order_by('c.eselon', 'asc')
                                   ->group_by('a.id_peg');
               
                                   if($id == 1){
                                       $this->db->where_in('c.eselon', ["III B", "III A"]);
                                   }
               
                                   if($id == 2){
                                       $this->db->where_in('c.eselon', ["II B", "II A"]);
                                   }
               
                                   if($id == 3){
                                       $this->db->where_in('c.eselon', ["IV A", "IV B"]);
                                   }

                                   if($id == 4){
                                    $this->db->where_in('c.jenis_jabatan', ["JFU"]);
                                   }
                        
                                   $query = $this->db->get()->result_array();
    
                                
    
                           return $query;
                           }
                   
        function getMasterUnitkKerja(){
                            $this->db->select('*')
                            ->where_not_in('id_unitkerjamaster', ['0000000','9000000','9050000','5002000','5003000','','5004000','5005000','5006000','5006000','5007000','5008000','5009000','5001000','5011001','5010001','8000000','8010000','8020000','8030000'])
                            ->from('db_pegawai.unitkerjamaster a');
                            return $this->db->get()->result_array(); 
                        }


                        public function getPegawaiPenilaianPotensialMasaKerja($id,$jenis_pengisian,$penilaian,$eselon,$skpd){
                            // $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang,
                            // (select d.res_potensial_cerdas from db_simata.t_penilaian as d where a.id_peg = d.id_peg and d.flag_active = 1 and d.jenjang_jabatan = '.$jenis_pengisian.' limit 1) as res_potensial_cerdas,
                            // (select e.res_potensial_rj from db_simata.t_penilaian as e where a.id_peg = e.id_peg and e.flag_active = 1 and e.jenjang_jabatan = '.$jenis_pengisian.' limit 1) as res_potensial_rj,
                            // (select f.res_potensial_lainnya from db_simata.t_penilaian as f where a.id_peg = f.id_peg and f.flag_active = 1 and f.jenjang_jabatan = '.$jenis_pengisian.' limit 1) as res_potensial_lainnya')
                            $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang')
                                           ->from('db_pegawai.pegawai a')
                                           ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                                           ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                           ->join('db_pegawai.eselon h', 'c.eselon = h.nm_eselon')
                                           ->where('a.id_m_status_pegawai', 1)
                                           ->where('b.jenjang_jabatan', $jenis_pengisian)
                                           ->order_by('c.eselon', 'asc')
                                           ->group_by('a.id_peg');
                       
                                           if($eselon != 0){
                                               $this->db->where('h.id_eselon',$eselon);
                                           }
        
                                           if($skpd != 0){
                                            
                                            $this->db->join('db_pegawai.unitkerja i', 'a.skpd = i.id_unitkerja');
                                            $this->db->join('db_pegawai.unitkerjamaster j', 'i.id_unitkerjamaster = j.id_unitkerjamaster');
                                           if($skpd == "5000000") {
                                            $this->db->where_in('j.id_unitkerjamaster',['5002000','5003000','5010001','5004000','5005000','5006000','5007000','5008000','5009000','5001000','5011001']);
                                           } else if($skpd == "8000000"){
                                            $this->db->where_in('j.id_unitkerjamaster',['8000000','8010000','8020000']);
                                           } else {
                                            
                                            $this->db->where('j.id_unitkerjamaster',$skpd);
                                           }
                                           }
                       
         
                                           $query = $this->db->get()->result_array();
                                          
                                           if($penilaian != 0){
                                           foreach ($query as $rs) {
                                            
                                                $updateMasakerja = $this->updateMasakerja($rs['id_pegawai']);
        
                                               
                                           
                                           }
                                        }
                                        
                                   return $query;
                                   }
          
    

        public function loadPegawaiPenilaianPimpinan($data){
            $result = null;
            $list_id_pegawai = $this->getListIdPegawaiForPenilaianPimpinan($data);
            // dd($data);
            if($list_id_pegawai){
                $result = $this->db->select('*, a.id as id_m_user,
                (select pertimbangan_pimpinan from db_simata.t_penilaian_pimpinan aa where aa.id_peg = b.id_peg and aa.flag_active = 1 limit 1) as pertimbangan_pimpinan')
                                ->from('m_user a')
                                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                ->join('db_pegawai.jabatan c', 'b.jabatan = c.id_jabatanpeg')
                                ->join('m_bidang d', 'a.id_m_bidang = d.id', 'left')
                                ->join('db_pegawai.pangkat f', 'b.pangkat = f.id_pangkat')
                                ->join('db_pegawai.unitkerja g', 'b.skpd = g.id_unitkerja')
                                ->where_in('a.id', $list_id_pegawai)
                                ->where('id_m_status_pegawai', 1)
                                ->order_by('c.eselon', 'asc')
                                ->order_by('g.id_unitkerja', 'asc')
                                ->get()->result_array();
            }
            return $result;
        }

        public function loadPegawaiPenilaianSejawat($data){
            $result = null;
            $list_id_pegawai = $this->getListIdPegawaiForPenilaianSejawat($data);
            // dd($data);
            if($list_id_pegawai){
                $result = $this->db->select('*, a.id as id_m_user,
                (select berorientasi_pelayanan from db_simata.t_penilaian_sejawat_detail aa where aa.id_peg = b.id_peg and aa.flag_active = 1 and aa.id_pegpenilai = "'.$this->general_library->getIdPegSimpeg().'" limit 1) as berorientasi_pelayanan,
                (select akuntabel from db_simata.t_penilaian_sejawat_detail aa where aa.id_peg = b.id_peg and aa.flag_active = 1 and aa.id_pegpenilai = "'.$this->general_library->getIdPegSimpeg().'" limit 1) as akuntabel,
                (select kompeten from db_simata.t_penilaian_sejawat_detail aa where aa.id_peg = b.id_peg and aa.flag_active = 1 and aa.id_pegpenilai = "'.$this->general_library->getIdPegSimpeg().'" limit 1) as kompeten,
                (select harmonis from db_simata.t_penilaian_sejawat_detail aa where aa.id_peg = b.id_peg and aa.flag_active = 1 and aa.id_pegpenilai = "'.$this->general_library->getIdPegSimpeg().'" limit 1) as harmonis,
                (select loyal from db_simata.t_penilaian_sejawat_detail aa where aa.id_peg = b.id_peg and aa.flag_active = 1 and aa.id_pegpenilai = "'.$this->general_library->getIdPegSimpeg().'" limit 1) as loyal,
                (select adaptif from db_simata.t_penilaian_sejawat_detail aa where aa.id_peg = b.id_peg and aa.flag_active = 1 and aa.id_pegpenilai = "'.$this->general_library->getIdPegSimpeg().'" limit 1) as adaptif,
                (select kolaboratif from db_simata.t_penilaian_sejawat_detail aa where aa.id_peg = b.id_peg and aa.flag_active = 1 and aa.id_pegpenilai = "'.$this->general_library->getIdPegSimpeg().'" limit 1) as kolaboratif')
                                ->from('m_user a')
                                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                ->join('db_pegawai.jabatan c', 'b.jabatan = c.id_jabatanpeg')
                                ->join('m_bidang d', 'a.id_m_bidang = d.id', 'left')
                                ->join('db_pegawai.pangkat f', 'b.pangkat = f.id_pangkat')
                                ->join('db_pegawai.unitkerja g', 'b.skpd = g.id_unitkerja')
                                ->where_in('a.id', $list_id_pegawai)
                                ->where('id_m_status_pegawai', 1)
                                ->order_by('c.eselon', 'asc')
                                ->order_by('g.id_unitkerja', 'asc')
                                ->get()->result_array();
            }
            return $result;
        }


        public function getListIdPegawaiForPenilaianPimpinan($data = null, $return_data_pegawai = false){
            $role = $this->general_library->getRole();
            $eselon = $this->general_library->getIdEselon();
            
           

            $vt = $this->db->select('*')
                        ->from('t_verif_tambahan')
                        ->where('id_m_user', $this->general_library->getId())
                        ->where('flag_active', 1)
                        ->get()->result_array();
                        
            $list_user_tambahan = null;
            $list_bidang_tambahan = null;
            $list_pegawai_tambahan = null;
            if($vt){
                foreach($vt as $v){
                    if($v['id_m_bidang']){
                        $list_bidang_tambahan[] = $v['id_m_bidang'];
                    } else {
                        $list_user_tambahan[] = $v['id_m_user_verif'];
                    }
                }
            }
            $this_user = $this->db->select('a.*, b.*, c.nm_unitkerja, c.id_unitkerjamaster, d.nama_jabatan, e.nama_jabatan as nama_jabatan_tambahan')
                                ->from('m_user a')
                                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg', 'left')
                                ->join('db_pegawai.jabatan e', 'b.id_jabatan_tambahan = e.id_jabatanpeg', 'left')
                                ->where('a.id', $this->general_library->getId())
                                ->where('a.flag_active', 1)
                                ->where('id_m_status_pegawai', 1)
                                ->get()->row_array();
            $list_pegawai = null;
            // if($role == 'subkoordinator'){
            if($eselon == 8){
                //pegawai yang diverif adalah staf pelaksana di sub bidang yang sama
                $this->db->select('*, id as id_m_user')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            // ->where('a.id_m_sub_bidang', $this_user['id_m_sub_bidang'])
                            // ->where('id_m_bidang', $this_user['id_m_bidang'])
                            ->where('b.skpd = ', $this_user['skpd'])
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('a.flag_active', 1);
                            // ->get()->result_array();
                if(!stringStartWith('Kelurahan', $this_user['nm_unitkerja'])){ //jika lurah
                    $this->db->where('id_m_bidang', $this_user['id_m_bidang']);
                    $this->db->where('a.id_m_sub_bidang', $this_user['id_m_sub_bidang']);
                }
                $list_pegawai = $this->db->get()->result_array();
            // } else if($role == 'kepalabidang' || $role == 'sekretarisbadan'){
            } else if($eselon == 6 || $eselon == 7){
                //pegawai yang diverif adalah subkoordinator di bidang yang sama
                // $subbidang = $this->db->select('*')
                //                         ->from('m_sub_bidang a')
                //                         ->where('a.id', $this_user['id_m_bidang'])
                //                         ->where('a.flag_active', 1)
                //                         ->get()->row_array();
                $list_role = ['subkoordinator', 'staffpelaksana'];
                $this->db->select('a.*, c.*, d.*, e.skpd, a.id as id_m_user')
                    ->from('m_user a')
                    ->join('m_user_role c', 'a.id = c.id_m_user')
                    ->join('m_role d', 'c.id_m_role = d.id')
                    ->join('db_pegawai.pegawai e', 'a.username = e.nipbaru_ws')
                    ->join('db_pegawai.jabatan f', 'e.jabatan = f.id_jabatanpeg')
                    ->where('a.id !=', $this->general_library->getId())
                    ->where('a.flag_active', 1)
                    ->where('c.flag_active', 1);

                    if(stringStartWith("Bagian", $this_user['nm_unitkerja'])){
                        $this->db->where('e.skpd', $this_user['skpd']);
                        // $this->db->where('f.eselon', 'III B');
                    } else if(stringStartWith('Kecamatan', $this_user['nm_unitkerja'])){
                        $this->db->where('e.skpd', $this_user['skpd']);
                        $this->db->where('f.eselon', 'III B');
                    } else {
                        // $this->db->select('b.*')
                        $this->db->join('m_bidang b', 'a.id_m_bidang = b.id');
                        $this->db->where('b.id', $this_user['id_m_bidang']);
                        $this->db->where('e.skpd', $this_user['skpd']);
                        // $this->db->where('f.eselon', 'IV A');
                    }

                    $list_pegawai = $this->db->get()->result_array();
                    if(stringStartWith('Kecamatan', $this_user['nm_unitkerja'])){
                        $list_pegawai_tambahan =  $this->db->select('a.*, e.skpd, a.id as id_m_user')
                                                        ->from('m_user a')
                                                        // ->join('m_user_role c', 'a.id = c.id_m_user')
                                                        // ->join('m_role d', 'c.id_m_role = d.id')
                                                        ->join('db_pegawai.pegawai e', 'a.username = e.nipbaru_ws')
                                                        ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja')
                                                        ->join('db_pegawai.jabatan g', 'e.jabatan = g.id_jabatanpeg')
                                                        ->where('f.id_unitkerjamaster', $this_user['id_unitkerjamaster'])
                                                        ->where('a.id !=', $this->general_library->getId())
                                                        ->where('g.nama_jabatan LIKE', 'Lurah%')
                                                        ->where('a.flag_active', 1)
                                                        // ->where('c.flag_active', 1)
                                                        ->get()->result_array();
                        // dd($list_pegawai_tambahan);
                    }
                if($this_user['id_m_bidang'] == 58 || $this_user['id_m_bidang'] == 57){ // jika kabid SMP atau SD
                    $unitkerjamaster = '8020000';
                    if($this_user['id_m_bidang'] == 57){ // jika kabid SD, ambil semua kepala sekolah SD
                        $unitkerjamaster = '8010000';
                    }
                    $list_role_tambahan = ['kepalasekolah'];
                    $list_pegawai_tambahan = $this->db->select('*, a.id as id_m_user')
                                                        ->from('m_user a')
                                                        // ->join('m_sub_bidang b', 'a.id_m_bidang = b.id')
                                                        ->join('m_user_role c', 'a.id = c.id_m_user')
                                                        ->join('m_role d', 'c.id_m_role = d.id')
                                                        ->join('db_pegawai.pegawai e', 'a.username = e.nipbaru_ws')
                                                        ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja')
                                                        // ->where_in('d.role_name', $list_role_tambahan)
                                                        ->join('db_pegawai.jabatan g', 'e.jabatan = g.id_jabatanpeg')
                                                        ->where('f.id_unitkerjamaster', $unitkerjamaster)
                                                        ->where('g.nama_jabatan LIKE', 'Kepala Sekolah%')
                                                        ->where('a.id !=', $this->general_library->getId())
                                                        ->where('a.flag_active', 1)
                                                        ->where('c.flag_active', 1)
                                                        ->where('id_m_status_pegawai', 1)
                                                        ->get()->result_array();
                }
                
                if($list_pegawai_tambahan){
                    $count = count($list_pegawai);
                    foreach($list_pegawai_tambahan as $lpt){
                        $list_pegawai[$count] = $lpt;
                        $count++;
                    }
                }
            // } else if($role == 'kepalabadan'){
            // } else if($this->general_library->isKaban()){
            } else if($eselon == 5){
                if($data['filter'] == '0'){
                    $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            // ->join('m_user_role b', 'a.id = b.id_m_user')
                                            // ->join('m_role d', 'd.id = b.id_m_role')
                                            ->join('m_bidang c', 'c.id = a.id_m_bidang')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            ->join('db_pegawai.jabatan e', 'd.jabatan = e.id_jabatanpeg')
                                            ->join('db_pegawai.eselon f', 'e.eselon = f.nm_eselon')
                                            ->where('d.skpd', $this->general_library->getUnitKerjaPegawai())
                                            ->where('a.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->where_in('f.id_eselon', [6,7])
                                            ->where('c.flag_active', 1)
                                            ->where('id_m_status_pegawai', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
                                            // dd($list_pegawai);
                } else if($data['filter'] == 'eselon_tiga' || $data['filter'] == 'eselon_empat'){
                   
                    $list_bidang = null;
                    $bidang = $this->db->select('*')
                                    ->from('m_bidang')
                                    ->where('flag_active', 1)
                                    ->where('id_unitkerja', $this_user['skpd'])
                                    ->get()->result_array();
                    if($bidang){
                        foreach($bidang as $b){
                            $list_bidang[] = $b['id'];
                        }
                    }
                    
                    // $list_role = ['kepalabidang', 'sekretarisbadan'];
                    $list_eselon = ['III B', 'III A'];
                    if($data['filter'] == 'eselon_empat'){
                        // $list_role = ['subkoordinator'];
                        $list_eselon = ['IV A'];
                    }
                    
                    $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            // ->join('m_user_role b', 'a.id = b.id_m_user')
                                            // ->join('m_role d', 'd.id = b.id_m_role')
                                            ->join('m_bidang c', 'c.id = a.id_m_bidang')
                                            ->join('db_pegawai.pegawai d', 'd.nipbaru_ws = a.username')
                                            ->join('db_pegawai.jabatan e', 'e.id_jabatanpeg = d.jabatan')
                                            ->where('a.id !=', $this->general_library->getId())
                                            // ->where_in('d.role_name', $list_role)
                                            ->where_in('e.eselon',$list_eselon)
                                            ->where_in('c.id', $list_bidang)
                                            ->where('a.flag_active', 1)
                                            // ->where('b.flag_active', 1)
                                            ->where('c.flag_active', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
                } else {
                 
                    $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            // ->join('m_user_role b', 'a.id = b.id_m_user')
                                            // ->join('m_role d', 'd.id = b.id_m_role')
                                            ->join('m_bidang c', 'c.id = a.id_m_bidang')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            ->where('d.skpd', $this->general_library->getUnitKerjaPegawai())
                                            ->where('c.id', $data['filter'])
                                            ->where('a.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            // ->where('b.flag_active', 1)
                                            ->where('c.flag_active', 1)
                                            ->where('id_m_status_pegawai', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
                }
              
            } else if($this->general_library->isWalikota()){
                
                        $list_eselon = ['II B', 'II A'];
                        $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                                ->from('m_user a')
                                                // ->join('m_user_role b', 'a.id = b.id_m_user')
                                                // ->join('m_role c', 'c.id = b.id_m_role')
                                                ->join('db_pegawai.pegawai d', 'd.nipbaru_ws= a.username')
                                                ->join('db_pegawai.jabatan e', 'e.id_jabatanpeg = d.jabatan')
                                                // ->where_in('c.role_name', $list_role)
                                                ->where_in('e.eselon', $list_eselon)
                                                ->where('a.flag_active', 1)
                                                // ->where('b.flag_active', 1)
                                                ->where('a.flag_active', 1)
                                                ->order_by('e.eselon', 'asc')
                                                ->group_by('a.id')
                                                ->get()->result_array();
            
            } else if($this->general_library->isSetda()) {
                $list_eselon = ['III A'];
                        $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                                ->from('m_user a')
                                                // ->join('m_user_role b', 'a.id = b.id_m_user')
                                                // ->join('m_role c', 'c.id = b.id_m_role')
                                                ->join('db_pegawai.pegawai d', 'd.nipbaru_ws= a.username')
                                                ->join('db_pegawai.jabatan e', 'e.id_jabatanpeg = d.jabatan')
                                                ->join('db_pegawai.unitkerja f', 'd.skpd = f.id_unitkerja')
                                                ->where_in('f.id_unitkerjamaster',['5002000','5003000','5010001','5004000','5005000','5006000','5007000','5008000','5009000','5001000','5011001','1000000'])
                                                ->where_in('e.eselon', $list_eselon)
                                                ->where('a.flag_active', 1)
                                                // ->where('b.flag_active', 1)
                                                ->where('a.flag_active', 1)
                                                ->order_by('e.eselon', 'asc')
                                                ->group_by('a.id')
                                                ->get()->result_array();
               
            } else if(stringStartWith('Kepala Sekolah', $this_user['nama_jabatan'])
            || stringStartWith('Kepala Taman', $this_user['nama_jabatan'])
            || stringStartWith('Kepala Sekolah', $this_user['nama_jabatan_tambahan'])
            || stringStartWith('Kepala Taman', $this_user['nama_jabatan_tambahan'])
            ){ // jika kepsek
                $list_role = ['gurusekolah'];
                $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('m_user_role b', 'a.id = b.id_m_user')
                                            ->join('m_role c', 'c.id = b.id_m_role')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            // ->where_in('c.role_name', $list_role)
                                            ->where('d.skpd', $this->general_library->getUnitKerjaPegawai())
                                            ->where('a.id !=', $this->general_library->getId())
                                            ->where('a.flag_active', 1)
                                            ->where('b.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->where('id_m_status_pegawai', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
            } else if($this->general_library->isLurah()){
                // $list_role = ['gurusekolah'];
                $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('m_user_role b', 'a.id = b.id_m_user')
                                            ->join('m_role c', 'c.id = b.id_m_role')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            ->where('d.skpd', $this->general_library->getUnitKerjaPegawai())
                                            ->where('a.id !=', $this->general_library->getId())
                                            ->where('a.flag_active', 1)
                                            ->where('b.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->where('id_m_status_pegawai', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
            } else if($this->general_library->isCamat()){
                $list_role = ['lurah'];
                $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('m_user_role b', 'a.id = b.id_m_user')
                                            ->join('m_role c', 'c.id = b.id_m_role')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            ->join('db_pegawai.jabatan e', 'd.jabatan = e.id_jabatanpeg')
                                            ->where('d.skpd', $this->general_library->getUnitKerjaPegawai())
                                            ->where('a.id !=', $this->general_library->getId())
                                            ->where('a.flag_active', 1)
                                            ->where('b.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->where('id_m_status_pegawai', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
            } else if($this->general_library->isKepalaPd()){
                $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('m_user_role b', 'a.id = b.id_m_user')
                                            ->join('m_role c', 'c.id = b.id_m_role')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            ->where('d.skpd', $this->general_library->getUnitKerjaPegawai())
                                            ->where('a.id !=', $this->general_library->getId())
                                            ->where('a.flag_active', 1)
                                            ->where('b.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->where('id_m_status_pegawai', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
            }
            $list_id_pegawai = array();
            $list_data_pegawai = array();
            
            if($list_pegawai){
                foreach($list_pegawai as $lp){
                    $list_id_pegawai[] = $lp['id_m_user'];
                    $list_data_pegawai[] = $lp;
                }
            }

            if($list_user_tambahan){
                foreach($list_user_tambahan as $lut){
                    $list_id_pegawai[] = $lut;
                    $list_data_pegawai[] = $lut;
                }
            }

            if($list_bidang_tambahan){
                $pegawai = $this->db->select('*, a.id as id_m_user')
                                    ->from('m_user a')
                                    ->where_in('a.id_m_bidang', $list_bidang_tambahan)
                                    ->where('a.flag_active', 1)
                                    ->get()->result_array();

                if($pegawai){
                    foreach($pegawai as $p){
                        $list_id_pegawai[] = $p['id_m_user'];
                        $list_data_pegawai[] = $p;
                    }
                }
            }
            if($return_data_pegawai){
                return $list_data_pegawai;
            }
            // dd($list_id_pegawai);
            return $list_id_pegawai;
        }

        public function getListIdPegawaiForPenilaianSejawat($data = null, $return_data_pegawai = false){
            $role = $this->general_library->getRole();
            $eselon = $this->general_library->getIdEselon();
            // dd($eselon);
                                   
            $list_user_tambahan = null;
            $list_bidang_tambahan = null;
            $list_pegawai_tambahan = null;
            
            $this_user = $this->db->select('a.id_m_bidang,d.kelas_jabatan,d.jenis_jabatan,a.*, b.*, c.nm_unitkerja, c.id_unitkerjamaster, d.nama_jabatan, e.nama_jabatan as nama_jabatan_tambahan')
                                ->from('m_user a')
                                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg', 'left')
                                ->join('db_pegawai.jabatan e', 'b.id_jabatan_tambahan = e.id_jabatanpeg', 'left')
                                ->where('a.id', $this->general_library->getId())
                                ->where('a.flag_active', 1)
                                ->where('id_m_status_pegawai', 1)
                                ->get()->row_array();
            $list_pegawai = null;
            // if($role == 'subkoordinator'){
            if($eselon == 9){
                $this->db->select('*, id as id_m_user')
                ->from('m_user a')
                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                ->join('db_pegawai.jabatan c', 'b.jabatan = c.id_jabatanpeg')
                ->join('db_pegawai.unitkerja d', 'b.skpd = d.id_unitkerja')
                ->where('a.id !=', $this->general_library->getId())
                ->where('a.flag_active', 1);

                if(!stringStartWith('Kelurahan', $this_user['nm_unitkerja'])){ //jika lurah
                    $this->db->where('b.skpd ', $this_user['skpd']);
                    $this->db->where('c.eselon', 'IV B');
                } else {
                    $this->db->where('b.skpd ', $this_user['skpd']);
                    $this->db->where('c.eselon', 'IV B');
                }
                $list_pegawai = $this->db->get()->result_array();
            } else if($eselon == 8){
                $this->db->select('*, id as id_m_user')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.jabatan c', 'b.jabatan = c.id_jabatanpeg')
                            ->join('db_pegawai.unitkerja d', 'b.skpd = d.id_unitkerja')
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('a.flag_active', 1);

                if(!stringStartWith('Kelurahan', $this_user['nm_unitkerja'])){ //jika lurah
                    $this->db->where('b.skpd ', $this_user['skpd']);
                    $this->db->where('c.kelas_jabatan', 9);
                    // $this->db->where('c.eselon', 'IV A');
                } else {
                    $this->db->where('d.id_unitkerjamaster',$this_user['id_unitkerjamaster']);
                    $this->db->where('c.nama_jabatan like', '%Lurah%');
                    $this->db->where('c.eselon', 'IV A');
                }
                $list_pegawai = $this->db->get()->result_array();
            } else if($eselon == 6 || $eselon == 7){
                $this->db->select('a.*, c.*, d.*, e.skpd, a.id as id_m_user')
                    ->from('m_user a')
                    ->join('m_user_role c', 'a.id = c.id_m_user')
                    ->join('m_role d', 'c.id_m_role = d.id')
                    ->join('db_pegawai.pegawai e', 'a.username = e.nipbaru_ws')
                    ->join('db_pegawai.jabatan f', 'e.jabatan = f.id_jabatanpeg')
                    ->join('db_pegawai.unitkerja g', 'e.skpd = g.id_unitkerja')
                    ->where('a.id !=', $this->general_library->getId())
                    ->where('a.flag_active', 1)
                    ->where('c.flag_active', 1);

                    if(stringStartWith("Bagian", $this_user['nm_unitkerja'])){
                        $this->db->where('g.id_unitkerjamaster', '1000000');
                        $this->db->where('f.eselon', 'III A');
                    } else if(stringStartWith('Kecamatan', $this_user['nm_unitkerja'])){
                        $this->db->where_in('g.id_unitkerjamaster', ['5002000','5003000','5010001','5004000','5005000','5006000','5007000','5008000','5009000','5001000','5011001']);
                        $this->db->where('f.eselon', 'III A');
                    } else {
                        $this->db->where('e.skpd', $this_user['skpd']);
                        $this->db->where_in('f.eselon', ['III A', 'III B']);
                    }

                    $list_pegawai = $this->db->get()->result_array();
                   
                if($this_user['id_m_bidang'] == 58 || $this_user['id_m_bidang'] == 57){ // jika kabid SMP atau SD
                    $unitkerjamaster = '8020000';
                    if($this_user['id_m_bidang'] == 57){ // jika kabid SD, ambil semua kepala sekolah SD
                        $unitkerjamaster = '8010000';
                    }
                    $list_role_tambahan = ['kepalasekolah'];
                    $list_pegawai_tambahan = $this->db->select('*, a.id as id_m_user')
                                                        ->from('m_user a')
                                                        // ->join('m_sub_bidang b', 'a.id_m_bidang = b.id')
                                                        ->join('m_user_role c', 'a.id = c.id_m_user')
                                                        ->join('m_role d', 'c.id_m_role = d.id')
                                                        ->join('db_pegawai.pegawai e', 'a.username = e.nipbaru_ws')
                                                        ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja')
                                                        // ->where_in('d.role_name', $list_role_tambahan)
                                                        ->join('db_pegawai.jabatan g', 'e.jabatan = g.id_jabatanpeg')
                                                        ->where('f.id_unitkerjamaster', $unitkerjamaster)
                                                        ->where('g.nama_jabatan LIKE', 'Kepala Sekolah%')
                                                        ->where('a.id !=', $this->general_library->getId())
                                                        ->where('a.flag_active', 1)
                                                        ->where('c.flag_active', 1)
                                                        ->where('id_m_status_pegawai', 1)
                                                        ->get()->result_array();
                }
                
 
            } else if($eselon == 5){
                    $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            ->join('db_pegawai.jabatan e', 'd.jabatan = e.id_jabatanpeg')
                                            ->join('db_pegawai.eselon f', 'e.eselon = f.nm_eselon')
                                            ->where('a.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->where_in('f.id_eselon', [5])
                                            ->where('id_m_status_pegawai', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
              
            }  else if(stringStartWith('Kepala Sekolah', $this_user['nama_jabatan'])
            || stringStartWith('Kepala Taman', $this_user['nama_jabatan'])
            || stringStartWith('Kepala Sekolah', $this_user['nama_jabatan_tambahan'])
            || stringStartWith('Kepala Taman', $this_user['nama_jabatan_tambahan'])
            ){ // jika kepsek
                $list_role = ['gurusekolah'];
                $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('m_user_role b', 'a.id = b.id_m_user')
                                            ->join('m_role c', 'c.id = b.id_m_role')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            // ->where_in('c.role_name', $list_role)
                                            ->where('d.skpd', $this->general_library->getUnitKerjaPegawai())
                                            ->where('a.id !=', $this->general_library->getId())
                                            ->where('a.flag_active', 1)
                                            ->where('b.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->where('id_m_status_pegawai', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
            }  else if($eselon == 1){
                
                $this->db->select('*, id as id_m_user')
                ->from('m_user a')
                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                ->join('db_pegawai.jabatan c', 'b.jabatan = c.id_jabatanpeg')
                ->join('db_pegawai.unitkerja d', 'b.skpd = d.id_unitkerja')
                ->where('a.id !=', $this->general_library->getId())
                // ->where('b.skpd ', $this_user['skpd'])
                ->where('a.id_m_bidang ', $this_user['id_m_bidang'])
                ->where('a.flag_active', 1)
                ->where('b.statuspeg', 2);

                if($this_user['jenis_jabatan'] == 'JFT'){
                if($this_user['kelas_jabatan'] == 8){
                    $this->db->where_in('c.kelas_jabatan', [7,8]);
                } else if($this_user['kelas_jabatan'] == 9){
                    $this->db->group_start();
                    $this->db->where('c.kelas_jabatan', 9);
                    $this->db->group_end();
                }
                } else {
                    if(!stringStartWith('Kelurahan', $this_user['nm_unitkerja'])){ //jika lurah
                        $this->db->where_in('c.kelas_jabatan', [6,7,8]);
                    } else {
                        $this->db->where_in('c.kelas_jabatan', [7]);
                    }
                  
                }

                $list_pegawai = $this->db->get()->result_array();
            }
            $list_id_pegawai = array();
            $list_data_pegawai = array();
            
            if($list_pegawai){
                foreach($list_pegawai as $lp){
                    $list_id_pegawai[] = $lp['id_m_user'];
                    $list_data_pegawai[] = $lp;
                }
            }

        
            // dd($list_id_pegawai);
            return $list_id_pegawai;
        }
        
        
        public function submitPenilaianPimpinan(){
    
            $datapost = $this->input->post();
            
            $this->db->trans_begin();
            $id_pegawai = $datapost['id_peg'];
            $data["id_peg"] = $datapost["id_peg"];
            $data["pertimbangan_pimpinan"] = $datapost["nilai"];
            
             $cek =  $this->db->select('*')
                            ->from('db_simata.t_penilaian_pimpinan a')
                            ->where('a.id_peg', $id_pegawai)
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
   

               if($cek){
                $this->db->where('id_peg', $id_pegawai)
                ->update('db_simata.t_penilaian_pimpinan', $data);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                } else {
                    $this->db->insert('db_simata.t_penilaian_pimpinan', $data);
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                }

                
                $eselonPeg = $this->general_library->getEselonPegawai($id_pegawai);
                
                if($eselonPeg['eselon'] == "III A" || $eselonPeg['eselon'] == "III B"){
                $id = 1;
                $this->getPegawaiPenilaianPotensialPerPegawai($id_pegawai,3,$id);
                $this->getPegawaiPenilaianPotensialPerPegawai($id_pegawai,2,$id);
                } else if($eselonPeg['eselon'] == "II A" || $eselonPeg['eselon'] == "II B") {
                $id = 2;
                $this->getPegawaiPenilaianPotensialPerPegawai($id_pegawai,3,$id);
                } else if($eselonPeg['eselon'] == "IV A" || $eselonPeg['eselon'] == "IV B") {
                $id = 3;
                $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_pegawai,2,$id);
                $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_pegawai,1,$id);
                } else {
                $id = 4;
                $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_pegawai,1,$id);
                }

               
                
        
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                // $res['code'] = 1;
                // $res['message'] = 'Terjadi Kesalahan';
                // $res['data'] = null;
                $res = array('msg' => 'Data gagal disimpan', 'success' => false);
            } else {
                $this->db->trans_commit();
            }
        
            return $res;
        }

        public function submitPenilaianSejawat(){
    
            $datapost = $this->input->post();
         
            
            $this->db->trans_begin();
            $id_pegawai = $datapost['id_pegawai'];
            $data["id_peg"] = $datapost["id_pegawai"];
            $data["id_pegpenilai"] = $this->general_library->getIdPegSimpeg();

            $berorientasi_pelayanan = 0;
            $akuntabel = 0;
            $kompeten = 0;
            $harmonis = 0;
            $loyal = 0;
            $adaptif = 0;
            $kolaboratif = 0;

            if(isset($datapost["berorientasi_pelayanan"])){
            $data["berorientasi_pelayanan"] = $datapost["berorientasi_pelayanan"];
            $berorientasi_pelayanan =$datapost["berorientasi_pelayanan"];
            }
            if(isset($datapost["akuntabel"])){
            $data["akuntabel"] = $datapost["akuntabel"];
            $akuntabel = $datapost["akuntabel"];
            }
            if(isset($datapost["kompeten"])){
            $data["kompeten"] = $datapost["kompeten"];
            $kompeten = $datapost["kompeten"];
            }
            if(isset($datapost["harmonis"])){
            $data["harmonis"] = $datapost["harmonis"];
            $harmonis = $datapost["harmonis"];
            }
            if(isset($datapost["loyal"])){
            $data["loyal"] = $datapost["loyal"];
            $loyal = $datapost["loyal"];
            }
            if(isset($datapost["adaptif"])){
            $data["adaptif"] = $datapost["adaptif"];
            $adaptif = $datapost["adaptif"];
            }
            if(isset($datapost["kolaboratif"])){
            $data["kolaboratif"] = $datapost["kolaboratif"];
            $kolaboratif = $datapost["kolaboratif"];
            }

            $berakhlak =  $berorientasi_pelayanan + $akuntabel + $kompeten + $harmonis + $loyal + $adaptif + $kolaboratif;
            $total_nilai = $berakhlak / 7;    
            $data["total_nilai"] =  $total_nilai;  

             $cek =  $this->db->select('*, 
             (select sum(total_nilai) from db_simata.t_penilaian_sejawat_detail aa where aa.id_peg = a.id_peg and aa.flag_active = 1) as total')
                            ->from('db_simata.t_penilaian_sejawat_detail a')
                            ->where('a.id_peg', $id_pegawai)
                            ->where('a.id_pegpenilai', $this->general_library->getIdPegSimpeg())
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
                          
            if($cek){
                $this->db->where('id_peg', $id_pegawai)
                ->where('id_pegpenilai', $this->general_library->getIdPegSimpeg())
                ->update('db_simata.t_penilaian_sejawat_detail', $data);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                } else {
                    $this->db->insert('db_simata.t_penilaian_sejawat_detail', $data);                   
                }

                $cek2 =  $this->db->select('*,
                    (select sum(total_nilai) from db_simata.t_penilaian_sejawat_detail aa where aa.id_peg = a.id_peg and aa.flag_active = 1) as total,
                    (select count(id) from db_simata.t_penilaian_sejawat_detail aa where aa.id_peg = a.id_peg and aa.flag_active = 1) as jumlah_penilai')
                    ->from('db_simata.t_penilaian_sejawat a')
                    ->where('a.id_peg', $id_pegawai)
                    ->where('a.flag_active', 1)
                    ->get()->result_array();
                    
                  
                    $data2["id_peg"] = $datapost["id_pegawai"];
                   
                    if($cek2){
                        $total_nilai2 = $cek2[0]['total'] / $cek2[0]['jumlah_penilai'];
                        if($total_nilai2 <= 70){
                            $id_kriteria_penilaian = 128;
                        } else if($total_nilai2 > 70 && $total_nilai2 <= 90){
                            $id_kriteria_penilaian = 127;
                        } else if($total_nilai2 > 90){
                            $id_kriteria_penilaian = 126;
                        } 
                        $data2["total_nilai"] =  $total_nilai2;
                        $data2["id_m_kriteria_penilaian"] =  $id_kriteria_penilaian;
                        $this->db->where('id_peg', $id_pegawai)
                        ->update('db_simata.t_penilaian_sejawat', $data2);
                        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                    } else {
                        $total_nilai2 = $total_nilai / 1;
                        if($total_nilai2 <= 70){
                            $id_kriteria_penilaian = 128;
                        } else if($total_nilai2 > 70 && $total_nilai2 <= 90){
                            $id_kriteria_penilaian = 127;
                        } else if($total_nilai2 > 90){
                            $id_kriteria_penilaian = 126;
                        } 
                        $data2["total_nilai"] =  $total_nilai2;
                        $data2["id_m_kriteria_penilaian"] =  $id_kriteria_penilaian;
                    $this->db->insert('db_simata.t_penilaian_sejawat', $data2);
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                    }
            
                $eselonPeg = $this->general_library->getEselonPegawai($id_pegawai);
                
                if($eselonPeg['eselon'] == "III A" || $eselonPeg['eselon'] == "III B"){
                $id = 1;
                $this->getPegawaiPenilaianPotensialPerPegawai($id_pegawai,3,$id);
                $this->getPegawaiPenilaianPotensialPerPegawai($id_pegawai,2,$id);
                } else if($eselonPeg['eselon'] == "II A" || $eselonPeg['eselon'] == "II B") {
                $id = 2;
                $this->getPegawaiPenilaianPotensialPerPegawai($id_pegawai,3,$id);
                } else if($eselonPeg['eselon'] == "IV A" || $eselonPeg['eselon'] == "IV B") {
                $id = 3;
                $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_pegawai,2,$id);
                $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_pegawai,1,$id);
                } else {
                $id = 4;
                $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_pegawai,1,$id);
                }
                
                
                // else {
                // $id = 3;
                // }
        
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                // $res['code'] = 1;
                // $res['message'] = 'Terjadi Kesalahan';
                // $res['data'] = null;
                $res = array('msg' => 'Data gagal disimpan', 'success' => false);
            } else {
                $this->db->trans_commit();
            }
        
            return $res;
        }


        public function getPegawaiPenilaianPotensialPerPegawai($id_pegawai,$jenis_pengisian,$id){
          
            $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang,
            (select pertimbangan_pimpinan from db_simata.t_penilaian_pimpinan aa where aa.id_peg = a.id_peg and aa.flag_active = 1 limit 1) as pertimbangan_pimpinan,
            (select id_m_kriteria_penilaian from db_simata.t_penilaian_sejawat bb where bb.id_peg = a.id_peg and bb.flag_active = 1 limit 1) as id_kriteria_penilaian')
                           ->from('db_pegawai.pegawai a')
                           ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                           ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                           ->join('db_pegawai.eselon h', 'c.eselon = h.nm_eselon')
                           ->where('a.id_m_status_pegawai', 1)
                           ->where('a.id_peg', $id_pegawai)
                        //    ->where('b.jenjang_jabatan', $jenis_pengisian)
                           ->order_by('c.eselon', 'asc')
                           ->group_by('a.id_peg');
            $query = $this->db->get()->result_array();
            
            if($query){

                // kinerja 
                $currentYear = date('Y'); 
                $previous1Year = $currentYear - 1;   
                $previous2Year = $currentYear - 2;  

                $total_kinerja = 0;
                       $kriteria1 = $this->getPenilaianKinerja($id_pegawai,$previous1Year,1); 
                       $kriteria2 = $this->getPenilaianKinerja($id_pegawai,$previous2Year,2); 
                       $kriteria3 = $this->getInovasiPegawai($id_pegawai); 
                       $kriteria4 = $this->getPengalamanTimPegawai($id_pegawai); 
                       $kriteria5 = $this->getPenugasanPengawai($id_pegawai); 

                    //   if($id_pegawai == 'PEG0000000eh992'){
                    //     dd($kriteria4);
                    //    }

                       $data["id_peg"] = $id_pegawai;
                       $data["kriteria1"] = $kriteria1;
                       $data["kriteria2"] = $kriteria2;
                       $data["kriteria3"] = $kriteria3;
                       $data["kriteria4"] = $kriteria4;
                       $data["kriteria5"] = $kriteria5;
                       $data["kriteria5"] = $kriteria5;
                     

                       $skor1 =  $this->getSkor($kriteria1); 
                       $bobot1 = $this->getBobot($kriteria1); 
                       $total_kinerja1 = $skor1  * $bobot1 / 100;   
                          
                       $skor2 =  $this->getSkor($kriteria2); 
                       $bobot2 = $this->getBobot($kriteria2); 
                       $total_kinerja2 = $skor2  * $bobot2 / 100; 

                       $skor3 =  $this->getSkor($kriteria3); 
                       $bobot3 = $this->getBobot($kriteria3); 
                       $total_kinerja3 = $skor3  * $bobot3 / 100;   
                          
                       $skor4 =  $this->getSkor($kriteria4); 
                       $bobot4 = $this->getBobot($kriteria4); 
                       $total_kinerja4 = $skor4  * $bobot4 / 100; 

                       $skor5 =  $this->getSkor($kriteria5); 
                       $bobot5 = $this->getBobot($kriteria5); 
                       $total_kinerja5 = $skor5  * $bobot5 / 100;
                       
       
                       $total_kinerja = $total_kinerja1 + $total_kinerja2 + $total_kinerja3 + $total_kinerja4 + $total_kinerja5;

                    $cek =  $this->db->select('*')
                    ->from('db_simata.t_penilaian_kinerja a')
                    ->where('a.id_peg', $id_pegawai)
                    ->where('a.flag_active', 1)
                    ->get()->result_array();
                  

                    if($cek){
                        // dd(1);
                        $this->db->where('id_peg', $id_pegawai)
                        ->update('db_simata.t_penilaian_kinerja', 
                        ['kriteria1' => $kriteria1,
                        'kriteria2' => $kriteria2,
                        'kriteria3' => $kriteria3,
                        'kriteria4' => $kriteria4,
                        'kriteria5' => $kriteria5,
                            ]);
                            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                    } else {
                        $this->db->insert('db_simata.t_penilaian_kinerja', $data);
                        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
        
                    }

                    
            $cekPenilaian =  $this->db->select('*')
            ->from('db_simata.t_penilaian a')
            ->where('a.id_peg', $id_pegawai)
            ->where('a.jenjang_jabatan', $jenis_pengisian)
            ->where('a.flag_active', 1)
            ->get()->result_array();


            if($cekPenilaian){
                $this->db->where('id_peg', $id_pegawai)
                ->where('jenjang_jabatan', $jenis_pengisian)
                ->update('db_simata.t_penilaian', 
                ['res_kinerja' => $total_kinerja]);
            } else {
                $datapenilaian["id_peg"] = $id_pegawai;
                $datapenilaian["created_by"] = $this->general_library->getId();
                $datapenilaian["res_kinerja"] = $total_kinerja;
                $datapenilaian["jenjang_jabatan"] = $jenis_pengisian;
                $this->db->insert('db_simata.t_penilaian', $datapenilaian);
                
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

            }
                // tutup kinerja 
                             //    assesment
                             $nilaiassesment = $this->getNilaiAssesment($id_pegawai); 
                             if($nilaiassesment){
                             $nilaiass = $nilaiassesment['nilai_assesment'];
                             } else {
                             $nilaiass = 0;
                             }
                             $total_nilai =  $nilaiass * 50 / 100;

                             $cekceass =  $this->db->select('*')
                                 ->from('db_simata.t_penilaian_potensial a')
                                 ->where('a.id_peg', $id_pegawai)
                                 ->where('jenjang_jabatan', $jenis_pengisian)
                                 ->where('a.nilai_assesment is not null')
                                 ->where('a.flag_active', 1)
                                 ->get()->row_array();
        
                             
                             if($cekceass){
                                 $this->db->where('id_peg', $id_pegawai)
                                 ->where('jenjang_jabatan', $jenis_pengisian)
                                 ->update('db_simata.t_penilaian_potensial', 
                                 ['nilai_assesment' => $nilaiass
                                     ]);
                                     $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                             } else {

                                 $dataInsert['id_peg']      = $id_pegawai;
                                 $dataInsert['nilai_assesment']      = $nilaiass;
                                 $dataInsert['jenjang_jabatan']      = $jenis_pengisian;
                                 $this->db->insert('db_simata.t_penilaian_potensial', $dataInsert);
                                 $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                             }


                             $getAllNilaiPotensial =  $this->db->select('*')
                                         ->from('db_simata.t_penilaian a')
                                         ->where('a.id_peg', $id_pegawai)
                                         ->where('jenjang_jabatan', $jenis_pengisian)
                                         ->where('a.flag_active', 1)
                                         ->get()->result_array();

                             if($getAllNilaiPotensial){
                                 foreach ($getAllNilaiPotensial as $rs2) {
                             
                                     $total_potensial = $total_nilai + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];
                                 
                                     $this->db->where('id_peg', $id_pegawai)
                                     ->where('jenjang_jabatan', $jenis_pengisian)
                                     ->update('db_simata.t_penilaian', 
                                     ['res_potensial_total' => $total_potensial,
                                     'res_potensial_cerdas' => $total_nilai
                                     ]);
                                             
                                 }
                             } else {
                                 $dataInsert2['id_peg']      = $id_pegawai;
                                 $dataInsert2['res_potensial_cerdas']      = $total_nilai;
                                 $dataInsert2['res_potensial_total']      = $total_nilai;
                                 $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                                 $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                             }
                             
                             //   tutup assesment
                             
                            // rekam jejak
                                $updateMasakerja = $this->updateMasakerja($id_pegawai);

                                // testing
                                $id_rekamjjk1 = $this->getPendidikanFormal($id_pegawai); 
                                $id_rekamjjk2 = $this->getPangkatGolPengawai($id_pegawai,$id,$jenis_pengisian);
                                $id_rekamjjk3 = $this->getMasaKerjaJabatan($id_pegawai,$id,$query[0]['nm_eselon'],$jenis_pengisian); 
                                $id_rekamjjk4 = $this->getDiklatPengawai($id_pegawai,$jenis_pengisian,$query[0]['nm_eselon'],$jenis_pengisian); 
                                $id_rekamjjk5 = $this->getJPKompetensi($id_pegawai); 
                                $id_rekamjjk6 = $this->getPenghargaan($id_pegawai); 
                                $id_rekamjjk7 = $this->getHukdisPengawai($id_pegawai); 
                                    
                                $id_pertimbangan1 = $this->getPengalamanOrganisasiPengawai($id_pegawai);
                                // dd($id_pertimbangan1);
                                $id_pertimbangan2 = $query[0]['pertimbangan_pimpinan'];
                                $id_pertimbangan3 = $query[0]['id_kriteria_penilaian'];
                                // $id_pertimbangan2 = 124;
                                // $id_pertimbangan3 = 126;
                                
     
                            $skor1 =  $this->getSkor($id_rekamjjk1); 
                            $bobot1 = $this->getBobot($id_rekamjjk1); 
                            $total_rj1 = $skor1  * $bobot1 / 100;   
                                
                            $skor2 =  $this->getSkor($id_rekamjjk2); 
                            $bobot2 = $this->getBobot($id_rekamjjk2); 
                            $total_rj2 = $skor2  * $bobot2 / 100; 

                            $skor3 =  $this->getSkor($id_rekamjjk3); 
                            $bobot3 = $this->getBobot($id_rekamjjk3); 
                            $total_rj3 = $skor3  * $bobot3 / 100;   
                                
                            $skor4 =  $this->getSkor($id_rekamjjk4); 
                            $bobot4 = $this->getBobot($id_rekamjjk4); 
                            $total_rj4 = $skor4  * $bobot4 / 100; 

                            $skor5 =  $this->getSkor($id_rekamjjk5); 
                            $bobot5 = $this->getBobot($id_rekamjjk5); 
                            $total_rj5 = $skor5  * $bobot5 / 100;

                            $skor6 =  $this->getSkor($id_rekamjjk6); 
                            $bobot6 = $this->getBobot($id_rekamjjk6); 
                            $total_rj6 = $skor6  * $bobot6 / 100;

                            $skor7 =  $this->getSkor($id_rekamjjk7); 
                            $bobot7 = $this->getBobot($id_rekamjjk7); 
                            $total_rj7 = $skor7  * $bobot7 / 100;

                            $skor8 =  $this->getSkor($id_pertimbangan1); 
                            $bobot8 = $this->getBobot($id_pertimbangan1); 
                            $total_pertimbangan_lainnya1 = $skor8  * $bobot8 / 100;

                            $skor9 =  $this->getSkor($id_pertimbangan2); 
                            $bobot9 = $this->getBobot($id_pertimbangan2); 
                            $total_pertimbangan_lainnya2 = $skor9  * $bobot9 / 100;

                            $skor10 =  $this->getSkor($id_pertimbangan3); 
                            $bobot10 = $this->getBobot($id_pertimbangan3); 
                            $total_pertimbangan_lainnya3 = $skor10  * $bobot10 / 100;
                            
                            $total_rj = $total_rj1 + $total_rj2 + $total_rj3 + $total_rj4 + $total_rj5  + $total_rj6  + $total_rj7;
                            $total_pertimbangan_lainnya = $total_pertimbangan_lainnya1 + $total_pertimbangan_lainnya2 + $total_pertimbangan_lainnya3;
                                $data["id_peg"] = $id_pegawai;
                                $data["pendidikan_formal"] = $id_rekamjjk1;
                                $data["pangkat_gol"] = $id_rekamjjk2;
                                $data["masa_kerja_jabatan"] = $id_rekamjjk3;
                                $data["diklat"] = $id_rekamjjk4;
                                $data["kompetensi20_jp"] = $id_rekamjjk5;
                                $data["penghargaan"] = $id_rekamjjk6;
                                $data["riwayat_hukdis"] = $id_rekamjjk7;
                                $data["pengalaman_organisasi"] = $id_pertimbangan1;
                                $data["aspirasi_karir"] = $id_pertimbangan2;
                                $data["asn_ceria"] = $id_pertimbangan3;
                                $data["jenjang_jabatan"] = $jenis_pengisian;

                                

                    $cekkrj =  $this->db->select('*')
                                            ->from('db_simata.t_penilaian_potensial a')
                                            ->where('a.id_peg', $id_pegawai)
                                            ->where('jenjang_jabatan', $jenis_pengisian)
                                            ->where('a.flag_active', 1)
                                            ->where('a.nilai_assesment is not null')
                                            ->get()->result_array();

                    if($cekkrj){
                        $this->db->where('id_peg', $id_pegawai)
                        ->where('jenjang_jabatan', $jenis_pengisian)
                        ->update('db_simata.t_penilaian_potensial', 
                        ['pendidikan_formal' => $id_rekamjjk1,
                        'pangkat_gol' => $id_rekamjjk2,
                        'masa_kerja_jabatan' => $id_rekamjjk3,
                        'diklat' => $id_rekamjjk4,
                        'kompetensi20_jp' => $id_rekamjjk5,
                        'penghargaan' => $id_rekamjjk6,
                        'riwayat_hukdis' => $id_rekamjjk7,
                        'pengalaman_organisasi' => $id_pertimbangan1,
                        'aspirasi_karir' => $id_pertimbangan2,
                        'asn_ceria' => $id_pertimbangan3,
                        'jenjang_jabatan' => $jenis_pengisian]);
                            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                            } else {
                                $this->db->insert('db_simata.t_penilaian_potensial', $data);
                                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

                            }


                                 $getAllNilaiPotensial =  $this->db->select('*')
                                ->from('db_simata.t_penilaian a')
                                ->where('a.id_peg', $id_pegawai)
                                ->where('a.jenjang_jabatan', $jenis_pengisian)
                                ->where('a.flag_active', 1)
                                ->get()->result_array();
                    
                                if($getAllNilaiPotensial){

                                    foreach ($getAllNilaiPotensial as $rs2) {
                                    $total_potensial = $total_nilai + $total_rj + $total_pertimbangan_lainnya;
                                    $this->db->where('id_peg', $id_pegawai)
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->update('db_simata.t_penilaian', 
                                    ['res_potensial_total' => $total_potensial,
                                    'res_potensial_rj' => $total_rj,
                                    'res_potensial_lainnya' => $total_pertimbangan_lainnya,
                                    'jenjang_jabatan' => $jenis_pengisian]);
                                                
                                    }
                                } else {
                                    $dataInsert2['id_peg']      = $id_pegawai;
                                    $dataInsert2['res_potensial_rj']      = $total_rj;
                                    $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                                    $dataInsert2['res_potensial_total']      = $total_rj;
                                    $dataInsert2['res_potensial_lainnya']      = $total_pertimbangan_lainnya;
                                    $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                                }

                            // tutup rekam jejak
                    }  
                    
                    $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang,
                    (select pertimbangan_pimpinan from db_simata.t_penilaian_pimpinan aa where aa.id_peg = a.id_peg and aa.flag_active = 1 limit 1) as pertimbangan_pimpinan,
                    (select id_m_kriteria_penilaian from db_simata.t_penilaian_sejawat bb where bb.id_peg = a.id_peg and bb.flag_active = 1 limit 1) as id_kriteria_penilaian')
                                   ->from('db_pegawai.pegawai a')
                                   ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                                   ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                   ->join('db_pegawai.eselon h', 'c.eselon = h.nm_eselon')
                                   ->where('a.id_m_status_pegawai', 1)
                                   ->where('a.id_peg', $id_pegawai)
                                   ->where('b.jenjang_jabatan', $jenis_pengisian)
                                   ->order_by('c.eselon', 'asc')
                                   ->group_by('a.id_peg');
                    $query = $this->db->get()->result_array();

                   return $query;
                   }

    
                   function getInterval($unsur,$kriteria){
                    $this->db->select('*')
                    ->from('db_simata.m_interval_penilaian a')
                    ->where('a.id_m_unsur_penilaian', $unsur)
                    ->where('a.kriteria', $kriteria);
                    return $this->db->get()->row_array(); 
                }
                   

            
       
	}
?>