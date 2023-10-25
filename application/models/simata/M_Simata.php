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
                ->group_start()
                ->where('TIMESTAMPDIFF(year,a.tmtjabatan, now()) >=', '3')
                ->where("FIND_IN_SET(b.eselon,'IV A,IV B,Non Eselon')!=",0)
                ->or_where_in('a.pangkat',$id_pangkat)
                ->group_end()
                ->where_in('a.pangkat', $id_pangkat)
                ->where('b.nama_jabatan !=', 'Pelaksana')
                ->where('b.eselon !=', 'III B')
                ->where('a.skpd', $id);
            return $this->db->get()->result_array();
        }

        function getPegawaiDinilaiToJpt($id){
            $id_pangkat = array(41,42,34);
            $this->db->select('TIMESTAMPDIFF(year,a.tmtjabatan, now()) as masakerjajabatan , a.id_peg, a.nipbaru, a.nama,a.gelar1,a.gelar2, b.nama_jabatan, a.tmtjabatan, c.nm_pangkat')
                ->from('db_pegawai.pegawai  a')
                ->join('db_pegawai.jabatan b', 'a.jabatan = b.id_jabatanpeg')
                ->join('db_pegawai.pangkat c', 'a.pangkat = c.id_pangkat')
                // ->where('b.eselon like', '%IV%')
                // ->where("FIND_IN_SET(b.eselon,'IV A,IV B,III B')!=",0)
                ->group_start()
                ->where('TIMESTAMPDIFF(year,a.tmtjabatan, now()) >=', '3')
                ->where("FIND_IN_SET(b.eselon,'III A,III B,Non Eselon')!=",0)
                ->or_where_in('a.pangkat',$id_pangkat)
                ->group_end()
                ->where_in('a.pangkat', $id_pangkat)
                ->where('b.nama_jabatan !=', 'Pelaksana')
                ->where("FIND_IN_SET(b.eselon,'III A,III B')!=",0)

                // ->where('b.eselon', 'III B')
                ->where('a.skpd', $id)
                ->order_by('a.pangkat', 'desc');
            return $this->db->get()->result_array();
        }
        
        function getJabatanTargetPegawai(){
            $this->db->select('a.*,b.nama_jabatan,c.nm_unitkerja')
                ->from('db_simata.t_penilaian a')
                ->join('db_pegawai.jabatan b', 'a.id_jabatan_target = b.id_jabatanpeg')
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
    ->where("FIND_IN_SET(a.eselon,'III B')!=",0)
    ->group_by('a.nama_jabatan')
    ->from('db_pegawai.jabatan a');
    return $this->db->get()->result_array(); 

}

function getNamaJabatanJpt(){
    $this->db->select('*')
    // ->where('id !=', 0)
    // ->where('flag_active', 1)
    ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
    ->where("FIND_IN_SET(a.eselon,'II B')!=",0)
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
    $data["id_jabatan_target"] = $jt;
    $data["created_by"] = $this->general_library->getId();
  
    
    $this->db->insert('db_simata.t_penilaian', $data);
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
    return $this->db->select('*')
                    ->from('db_simata.t_penilaian a')
                    ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                    ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
                    ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
                    ->where('a.flag_active', 1)
                    ->order_by('a.id', 'asc') 
                    ->get()->result_array();
}

public function getPegawaiPenilaianKinerjaJpt(){
    return $this->db->select('*')
                    ->from('db_simata.t_penilaian a')
                    ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                    ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
                    ->where('c.eselon', "II B")
                    ->where('a.flag_active', 1)
                    ->order_by('a.id', 'asc') 
                    ->get()->result_array();
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
        
            if($this->input->post('kriteria1') != 0){
            // $krit = $this->input->post('kriteria1');
            // $kriteria = explode(",", $krit);
            // $id_kriteria = $kriteria[0];
            // $skor = $kriteria[1];
            // $bobot = $kriteria[2];
           
            $total_kinerja = null;
            for($x=1;$x<=5;$x++){
                $krit = $this->input->post('kriteria'.$x.'');
                  $kriteria = explode(",", $krit);
                  $id_kriteria = $kriteria[0];
                  $skor = $kriteria[1];
                  $bobot = $kriteria[2];
                  $total_kinerja += $skor * $bobot / 100;   
            }
          }

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



           
            $this->db->where('id_peg', $datapost['id_peg'])
                        ->update('db_simata.t_penilaian', 
                        ['res_kinerja' => $total_kinerja]);

        
        
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

        function getListIntervalKinerja(){
            $this->db->select('*')
                ->from('db_simata.m_interval_penilaian a')
                ->where('a.id_m_unsur_penilaian', 1)
                ->where('a.flag_active', 1);
                // ->limit(1);
            return $this->db->get()->result_array();
        }

        public function getPenilaianPegawai(){
            return $this->db->select('a.res_kinerja,a.res_potensial')
                            ->from('db_simata.t_penilaian a')
                            ->where('a.flag_active', 1)
                            ->get()->result();
        }


        function getNilaiAssesment($id){
            $this->db->select('*')
                ->from('db_pegawai.pegassesment a')
                ->where('a.id_pegawai', $id)
                ->order_by('a.tahun', 'desc')
                ->limit(1);
            return $this->db->get()->row_array();
        }
          
          
        
                     
            
       
	}
?>