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

public function getPegawaiPenilaianKinerjaJpt($id){
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
             
             
                    $query = $this->db->get()->result_array();
                    // dd($query);


                    $currentYear = date('Y'); 
                    $previous1Year = $currentYear - 1;   
                    $previous2Year = $currentYear - 2;  

                    if($id == 2 || $id == 1){
                        // dd($query);
                    foreach ($query as $rs) {
                    $total_kinerja = 0;
                       $kriteria1 = $this->getPenilaianKinerja($rs['id_pegawai'],$previous1Year,1); 
                       $kriteria2 = $this->getPenilaianKinerja($rs['id_pegawai'],$previous2Year,2); 
                       $kriteria3 = $this->getInovasiPegawai($rs['id_pegawai']); 
                       $kriteria4 = $this->getPengalamanTimPegawai($rs['id_pegawai']); 
                       $kriteria5 = $this->getPenugasanPengawai($rs['id_pegawai']); 



                       $data["id_peg"] = $rs['id_pegawai'];
                       $data["kriteria1"] = $kriteria1;
                       $data["kriteria2"] = $kriteria2;
                       $data["kriteria3"] = $kriteria3;
                       $data["kriteria4"] = $kriteria4;
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
                       
                    //    if($rs['id_pegawai'] == 'PEG0000000eh992'){
                    //     dd($total_kinerja5);
                    //    }

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
            ->where('a.flag_active', 1)
            ->get()->result_array();
            


            if($cekPenilaian){
                $this->db->where('id_peg', $rs['id_pegawai'])
                ->update('db_simata.t_penilaian', 
                ['res_kinerja' => $total_kinerja]);
            } else {
                $datapenilaian["id_peg"] = $rs['id_pegawai'];
                $datapenilaian["created_by"] = $this->general_library->getId();
                $datapenilaian["res_kinerja"] = $total_kinerja;
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
             
             
                    $query2 = $this->db->get()->result_array();



            return $query2;
            }


            public function getPegawaiPenilaianPotensialJpt($id){
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
                        
                        
                               $query = $this->db->get()->result_array();

                               foreach ($query as $rs) {
                                // $id_peg = "IDPeg94";
                                $updateMasakerja = $this->updateMasakerja($rs['id_pegawai']);
                                $nilaiassesment = $this->getNilaiAssesment($rs['id_pegawai']); 
                                
                                
                                // dd($nilaiassesment['nilai_assesment']);
                                if($nilaiassesment){
                                $nilaiass = $nilaiassesment['nilai_assesment'];
                                } else {
                                $nilaiass = 0;
                                }
                                $total_nilai =  $nilaiass * 50 / 100;
                                $cek =  $this->db->select('*')
                                    ->from('db_simata.t_penilaian_potensial a')
                                    ->where('a.id_peg', $rs['id_pegawai'])
                                    ->where('a.nilai_assesment is not null')
                                    ->where('a.flag_active', 1)
                                    ->get()->result_array();
           

                                if($cek){
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
                               }

                               $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang')
                               ->from('db_pegawai.pegawai a')
                               ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                               ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                               ->where('a.id_m_status_pegawai', 1)
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
                        
                        
                               $query2 = $this->db->get()->result_array();
           
           
           
                       return $query2;
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

        function getPegawaiNilaiPotensialPegawai($nip){
            $this->db->select('a.*,b.nipbaru')
                ->from('db_simata.t_penilaian_potensial a')
                ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                ->where('b.nipbaru', $nip);
                // ->where('a.jabatan_target', $jt);
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

        public function getPenilaianPegawaiAdm(){
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

        public function getPenilaianPegawaiJpt(){
            // $this->db->select('a.*,c.res_kinerja,c.res_potensial_cerdas,c.res_potensial_rj,c.res_potensial_lainnya')
            $this->db->select('a.id_peg as id_pegawai,c.*')
                          
            ->from('db_pegawai.pegawai a')
                        //    ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                           ->join('db_simata.t_penilaian c', 'a.id_peg = c.id_peg','left')
                           ->join('db_pegawai.jabatan d', 'a.jabatan = d.id_jabatanpeg')
                           ->join('db_simata.t_jabatan_target d', 'c.id_peg = d.id_peg','left')
                           // ->where("FIND_IN_SET(c.eselon,'II B')!=",0)
                           ->where_in('d.eselon', ["II A", "II B"])
                           ->where('a.id_m_status_pegawai', 1)
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
            $this->db->select('*')
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
            $this->db->select('*')
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

            $this->db->select('*')
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
                if($jam != "-"){
                    $totaljam += $jam;
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
            
            
            $id_pangkat = null;
            $this->db->select('*')
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
            }
        }

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

        function getDiklatPengawai($id,$eselonjt,$eselonpegawai,$jabatanpegawai){
            
            $id_diklat = null;
            if($eselonjt == "II B"){
            $this->db->select('*')
                ->from('db_pegawai.pegdiklat a')
                ->where('a.id_pegawai', $id)
                ->where('a.jenjang_diklat', 3)
                ->where('a.flag_active', 1);
            $diklat = $this->db->get()->result_array();
            if($diklat){
                $id_diklat = 105;
            }
            } else if($eselonjt == "III B" || $eselonjt == "III A"){
            $this->db->select('*')
                ->from('db_pegawai.pegdiklat a')
                ->where('a.id_pegawai', $id)
                ->where('a.jenjang_diklat', 2)
                ->where('a.flag_active', 1);
            $diklat = $this->db->get()->result_array();
            if($diklat){
                $id_diklat = 105;
            }
            }

            if($id_diklat == null){
            if($eselonpegawai == "III B" || $eselonpegawai == "III A"){
                $this->db->select('*')
                ->from('db_pegawai.pegdiklat a')
                ->where('a.id_pegawai', $id)
                ->where('a.jenjang_diklat', 2)
                ->where('a.flag_active', 1);
                $diklat = $this->db->get()->result_array();
                if($diklat){
                    $id_diklat = 106;
                } else {
                    $this->db->select('*')
                    ->from('db_pegawai.pegdiklat a')
                    ->where('a.id_pegawai', $id)
                    ->where('a.jenjang_diklat', 1)
                    ->where('a.flag_active', 1);
                    $diklat = $this->db->get()->result_array();
                    if($diklat){
                        $id_diklat = 107;
                    } 
                }
            } else if($eselonpegawai == "II B"){
                $this->db->select('*')
                ->from('db_pegawai.pegdiklat a')
                ->where('a.id_pegawai', $id)
                ->where('a.jenjang_diklat', 3)
                ->where('a.flag_active', 1);
                $diklat = $this->db->get()->result_array();
                if($diklat){
                    $id_diklat = 106;
                } else {
                    $this->db->select('*')
                    ->from('db_pegawai.pegdiklat a')
                    ->where('a.id_pegawai', $id)
                    ->where('a.jenjang_diklat', 2)
                    ->where('a.flag_active', 1);
                    $diklat = $this->db->get()->result_array();
                    if($diklat){
                        $id_diklat = 107;
                    } 
                }
            } else if($eselonpegawai == "IV A"){
                $this->db->select('*')
                ->from('db_pegawai.pegdiklat a')
                ->where('a.id_pegawai', $id)
                ->where('a.jenjang_diklat', 1)
                ->where('a.flag_active', 1);
                $diklat = $this->db->get()->result_array();
                if($diklat){
                    $id_diklat = 106;
                }
            } 
        }

        if($id_diklat == null){
           if($eselonpegawai == "Non Eselon"){
            if(strpos($jabatanpegawai, "Muda")) { 
                
                if($eselonjt == "II B"){
                    $this->db->select('*')
                        ->from('db_pegawai.pegdiklat a')
                        ->where('a.id_pegawai', $id)
                        ->where('a.jenjang_diklat', 9)
                        ->where('a.flag_active', 1);
                    $diklat = $this->db->get()->result_array();
                    if($diklat){
                        $id_diklat = 105;
                    }
                    } else if($eselonjt == "III B" || $eselonjt == "III A"){
                    $this->db->select('*')
                        ->from('db_pegawai.pegdiklat a')
                        ->where('a.id_pegawai', $id)
                        ->where('a.jenjang_diklat', 8)
                        ->where('a.flag_active', 1);
                    $diklat = $this->db->get()->result_array();
                    if($diklat){
                        $id_diklat = 105;
                    }
                    }

                if($id_diklat == null){
                    $this->db->select('*')
                        ->from('db_pegawai.pegdiklat a')
                        ->where('a.id_pegawai', $id)
                        ->where('a.jenjang_diklat', 7)
                        ->where('a.flag_active', 1);
                    $diklat = $this->db->get()->result_array();
                    if($diklat){
                        $id_diklat = 106;
                    }
                }

            } else if(strpos($jabatanpegawai, "Madya")) { 
                $this->db->select('*')
                ->from('db_pegawai.pegdiklat a')
                ->where('a.id_pegawai', $id)
                ->where('a.jenjang_diklat', 9)
                ->where('a.flag_active', 1);
                $diklat = $this->db->get()->result_array();
                if($diklat){
                    $id_diklat = 106;
                } else {
                    $this->db->select('*')
                    ->from('db_pegawai.pegdiklat a')
                    ->where('a.id_pegawai', $id)
                    ->where('a.jenjang_diklat', 8)
                    ->where('a.flag_active', 1);
                    $diklat = $this->db->get()->result_array();
                    if($diklat){
                        $id_diklat = 107;
                    } 
                }
            }
           
           }
        }
        return $id_diklat;   
    }

    function getHukdisPengawai($id){
        $this->db->select('*')
            ->from('db_pegawai.pegdisiplin a')
            ->where('a.id_pegawai', $id)
            ->where('a.flag_active', 1);
        $hukdis = $this->db->get()->row_array();
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
    return $id_hukdis;   
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

    function getPenugasanPengawai($id){
        $this->db->select('*')
            ->from('db_pegawai.pegjabatan a')
            ->join('db_pegawai.jabatan b', 'a.id_jabatan = b.id_jabatanpeg')
            ->where('a.id_pegawai', $id)
            // ->where('b.eselon', $eselon)
            // ->where('a.statusjabatan', 2)
             ->group_start()
             ->where('a.statusjabatan', 2)
             ->or_where_in('a.ket',["PLT", "Plt", "plt"])
             ->group_end()
            ->where('a.status', 2)
            ->where('a.flag_active', 1);
        $penugasan = $this->db->get()->result_array();
       
        $id_penugasan = null;
        $qty1 = 0;
        $qty2 = 0;

        if($penugasan){
            foreach ($penugasan as $peng) {  
                if($peng['eselon'] == "II B" || $peng['eselon'] == "II A"){ 
                 $qty1++;
                } 
                if($peng['eselon'] == "III B" || $peng['eselon'] == "III A"){ 
                 $qty2++;
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
            ->where('a.jenispenugasan', 99)
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
            // $data["jabatan_target"] = $this->input->post('rj_jabatan_target');

            $cek =  $this->db->select('*')
                                    ->from('db_simata.t_penilaian_potensial a')
                                    ->where('a.id_peg', $data["id_peg"])
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
                'riwayat_hukdis' => $id_rekamjjk7
                    ]);
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            } else {
                $this->db->insert('db_simata.t_penilaian_potensial', $data);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

            }

            $this->db->where('id_peg', $data['id_peg'])
                    //  ->where('id_jabatan_target', $datapost['rj_jabatan_target']) 
                         ->update('db_simata.t_penilaian', 
                        ['res_potensial_rj' => $total_rj]);

            $getAllNilaiPotensial =  $this->db->select('*')
                        ->from('db_simata.t_penilaian a')
                        ->where('a.id_peg', $data["id_peg"])
                        // ->where('a.id_jabatan_target', $datapost['rj_jabatan_target'])
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
            
                        if($getAllNilaiPotensial){
            $total_potensial = $getAllNilaiPotensial[0]['res_potensial_cerdas'] + $getAllNilaiPotensial[0]['res_potensial_rj'] + $getAllNilaiPotensial[0]['res_potensial_lainnya'];

                            foreach ($getAllNilaiPotensial as $rs2) {
                            $total_potensial = $rs2['res_potensial_cerdas'] + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];
                            $this->db->where('id_peg', $data['id_peg'])
                            // ->where('id_jabatan_target', $rs2['id_jabatan_target'])
                               ->update('db_simata.t_penilaian', 
                               ['res_potensial_total' => $total_potensial,
                               'res_potensial_rj' => $total_rj]);
                                        
                            }
                        } else {
                            $dataInsert2['id_peg']      = $data["id_peg"];
                            $dataInsert2['res_potensial_rj']      = $total_rj;
                            $dataInsert2['res_potensial_total']      = $total_rj;
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
          

            $cek =  $this->db->select('*')
                                    ->from('db_simata.t_penilaian_potensial a')
                                    ->where('a.id_peg', $data["id_peg"])
                                    // ->where('a.jabatan_target', $this->input->post('lainnya_jabatan_target'))
                                    ->where('a.flag_active', 1)
                                    ->get()->result_array();

            if($cek){
                $this->db->where('id_peg', $data['id_peg'])
                        //  ->where('jabatan_target', $this->input->post('lainnya_jabatan_target'))
                ->update('db_simata.t_penilaian_potensial', 
                ['pengalaman_organisasi' => $id_rekamjjk1,
                'aspirasi_karir' => $id_rekamjjk2,
                'asn_ceria' => $id_rekamjjk3
                 ]);
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            } else {
                $getJabatanTarget =  $this->db->select('*')
                ->from('db_simata.t_penilaian a')
                ->where('a.id_peg', $data["id_peg"])
                ->where('a.flag_active', 1)
                ->get()->result_array();

                foreach ($getJabatanTarget as $rs) {
                    $data["jabatan_target"] = $rs['id_jabatan_target'];
                    $this->db->insert('db_simata.t_penilaian_potensial', $data);
                }
                // $this->db->insert('db_simata.t_penilaian_potensial', $data);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

            }

            // $this->db->where('id_peg', $data['id_peg'])
            //         //  ->where('id_jabatan_target', $datapost['lainnya_jabatan_target']) 
            //              ->update('db_simata.t_penilaian', 
            //             ['res_potensial_lainnya' => $total_rj]);

            $getAllNilaiPotensial =  $this->db->select('*')
                        ->from('db_simata.t_penilaian a')
                        ->where('a.id_peg', $data["id_peg"])
                        // ->where('a.id_jabatan_target', $datapost['lainnya_jabatan_target'])
                        ->where('a.flag_active', 1)
                        ->get()->result_array();



                        if($getAllNilaiPotensial){
                            foreach ($getAllNilaiPotensial as $rs2) {
                            $total_potensial = $rs2['res_potensial_cerdas'] + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];
                            $this->db->where('id_peg', $data['id_peg'])
                            ->where('id_jabatan_target', $rs2['id_jabatan_target'])
                               ->update('db_simata.t_penilaian', 
                               ['res_potensial_total' => $total_potensial,
                               'res_potensial_lainnya' => $total_rj]);
                                        
                            }
                        } else {
                            $dataInsert2['id_peg']      = $data["id_peg"];
                            $dataInsert2['res_potensial_lainnya']      = $total_rj;
                            $dataInsert2['res_potensial_total']      = $total_rj;
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


        public function getPegawaiPenilaianDetailNinebox($jenis_jab,$jt,$box){
            $this->db->select('a.*,b.*,(SELECT d.nama_jabatan from db_pegawai.jabatan as d
            where a.jabatan = d.id_jabatanpeg limit 1) as jabatan_sekarang,  SUM(res_kinerja + res_potensial_total) as total')
                           ->from('db_pegawai.pegawai a')
                           ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg','left')
                           // ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
                           ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                           ->join('db_simata.t_jabatan_target f', 'b.id_peg = f.id_peg','left')
                           ->where('a.id_m_status_pegawai', 1)
                           ->group_by('a.id_peg')
                          
                           ->order_by('total', 'desc');
                           if($jenis_jab == 2){
                               $this->db->where_in('e.eselon', ["II A", "II B"]);
                           }
                           if($jenis_jab == 1){
                               $this->db->where_in('e.eselon', ["III A", "III B"]);
                           }
                           if($box == 9){
                               $this->db->where('b.res_potensial_total >=', 85);
                               $this->db->where('b.res_kinerja >=', 85);
                           }
                           if($box == 8){
                               $this->db->where('b.res_potensial_total >=', 85);
                               $this->db->where('b.res_kinerja >=', 70);
                               $this->db->where('b.res_kinerja <', 85);
                           }
                           if($box == 7){
                               $this->db->where('b.res_potensial_total >=', 70);
                               $this->db->where('b.res_potensial_total <', 85);
                               $this->db->where('b.res_kinerja >=', 85);
                           }
                           if($box == 6){
                               $this->db->where('b.res_potensial_total >=', 85);
                               $this->db->where('b.res_kinerja <', 70);
                           }
                           if($box == 5){
                               $this->db->where('b.res_potensial_total >=', 70);
                               $this->db->where('b.res_potensial_total <', 85);
                               $this->db->where('b.res_kinerja >=', 70);
                               $this->db->where('b.res_kinerja <', 85);
                           }
                           if($box == 4){
                               $this->db->where('b.res_potensial_total <', 70);
                               $this->db->where('b.res_kinerja >=', 85);
                           }
                           if($box == 3){
                               $this->db->where('b.res_potensial_total >=', 70);
                               $this->db->where('b.res_potensial_total <', 85);
                               $this->db->where('b.res_kinerja <', 70);
                           }
                           if($box == 2){
                               $this->db->where('b.res_potensial_total <', 70);
                               $this->db->where('b.res_kinerja >=', 70);
                               $this->db->where('b.res_kinerja <', 85);
                           }
                           if($box == 1){
                            //    $this->db->where('b.res_potensial_total <', 70);
                            //    $this->db->where('b.res_kinerja <', 70);
                            $this->db->group_start();
                                  $this->db->where('b.res_potensial_total <', 70);
                                  $this->db->where('b.res_kinerja <', 70);
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

        
public function loadListProfilTalentaAdm($id){
     $this->db->select('f.flag_active as fa,a.*,b.*,e.nama_jabatan,e.eselon as es_jabatan,(SELECT d.nama_jabatan from db_pegawai.jabatan as d
     where a.jabatan = d.id_jabatanpeg limit 1) as jabatan_sekarang,
     (SELECT y.nama_jabatan from db_pegawai.jabatan as y
     where f.jabatan_target = y.id_jabatanpeg limit 1) as jabatan_target,')
                    ->from('db_pegawai.pegawai a')
                    ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg','left')
                    ->join('db_simata.t_jabatan_target f', 'f.id_peg = b.id_peg', 'left')
                    ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg','left')
                    // ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
                    ->where('a.id_m_status_pegawai', 1)
                    // ->where('f.flag_active', 1);
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
        ->where('b.nipbaru', $nip);
        // ->where('a.jabatan_target', $jt);
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


    $this->db->select('a.*,c.*,f.jabatan_target,g.nama_jabatan,e.eselon as es_jabatan, 
    (res_kinerja + res_potensial_total + (select res_kompetensi from db_simata.t_penilaian_kompetensi as y where y.id_peg = a.id_peg and y.jabatan_target = f.jabatan_target)) as total,
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
        ->where('a.res_potensial_total >=', 85)
        ->where('a.res_kinerja >=', 85)
        ->where('a.flag_active', 1)
        ->where('f.flag_active', 1)
        ->group_by('a.id_peg')
        ->order_by('total', 'desc')
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
                      ->where('a.res_potensial_total >=', 85)
                      ->where('a.res_kinerja >=', 85)
                      ->where('a.flag_active', 1)
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
            ->order_by('a.tmtjabatan', 'desc');
         $jabatan = $this->db->get()->result_array();

         $x=0;
         $i=0;

         $previousValue = null;
         foreach ($jabatan as $rs) {
          

         if($x==0){
            $tglawal = $rs['tmtjabatan'];
            $tgl_akhir = date('Y-m-d');
         } else {
           
            if($previousValue) {
                $tglawal = $rs['tmtjabatan'];
                $tgl_akhir = $previousValue." ";
            }
            $previousValue = $rs['tmtjabatan'];
         }
        
         
     

        

         $sdate = $tglawal;
         $edate = $tgl_akhir;
         
         $date_diff = abs(strtotime($edate) - strtotime($sdate));
         $years = floor($date_diff / (365*60*60*24));
         $months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));

         $tes = "$years"."."."$months";
        //  dd($tes);
          
         $masa_kerja = $years - $rs['masa_kerja_tahun'];

         $this->db->where('id', $rs['id'])
         ->update('db_pegawai.pegjabatan', 
         ['masa_kerja_tahun' => $tes]);
         $x++;


         }

         return $jabatan;

        }

          
      
            
       
	}
?>