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
    // ->where("FIND_IN_SET(a.eselon,'II B')!=",0)
    ->where('a.eselon','II B')
    ->or_where('a.eselon','III A')
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

public function getPegawaiPenilaianPotensialAdministrator(){
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

        function getPegawaiNilaiPotensialPegawai($nip,$jt){
            $this->db->select('a.*,b.nipbaru')
                ->from('db_simata.t_penilaian_potensial a')
                ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                ->where('b.nipbaru', $nip)
                ->where('a.jabatan_target', $jt);
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

        public function getPenilaianPegawaiAdm(){
             $this->db->select('a.*,b.nama')
                            ->from('db_simata.t_penilaian a')
                            ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                            ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
                            ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
                            ->where('a.flag_active', 1);
                            if($_POST['jabatan_target_adm'] != ""){
                                $this->db->where('c.id_jabatanpeg', $_POST['jabatan_target_adm']);
                            }
                 return  $this->db->get()->result();
                         
        }

   
        public function getPenilaianPegawaiJpt(){
             $this->db->select('a.*,b.nama')
                            ->from('db_simata.t_penilaian a')
                            ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                            ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
                            ->where("FIND_IN_SET(c.eselon,'II B')!=",0)
                            ->where('a.flag_active', 1);
                            if($_POST['jabatan_target_jpt'] != ""){
                                $this->db->where('c.id_jabatanpeg', $_POST['jabatan_target_jpt']);
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
                $totaljam += $jam;
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
        $jabatan = $this->db->get()->result_array();
        return $jabatan;
        }

        function getPangkatGolPengawai($id,$eselon){
            
            $id_pangkat = null;
            $this->db->select('*')
                ->from('db_pegawai.pegpangkat a')
                ->where('a.id_pegawai', $id)
                ->where('a.flag_active', 1)
                ->order_by('a.tmtpangkat', 'desc')
                ->limit(1);
            $pangkat =  $this->db->get()->result_array();
            if($eselon == "III B"){
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
                    } else if($years == 2){
                        $id_pangkat = 100;
                    }

                }

            } else if("II B"){
                if($pangkat[0]['pangkat'] > 41 && $pangkat[0]['pangkat'] < 45) {
                    $id_pangkat = 96;
                } else if($pangkat[0]['pangkat'] =  41) {
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
                    } else if($years == 2){
                        $id_pangkat = 100;
                    }

                }
            }

            return $id_pangkat;
        }

        function getPengalamanOrganisasiPengawai($id){
            $this->db->select('*')
                ->from('db_pegawai.pegorganisasi a')
                ->where('a.id_pegawai', $id)
                ->where('a.flag_active', 1);
                // ->where('a.lingkup_timkerja', 1)
                // ->where('a.jabatan', 1);
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

        

        

        function getPenilaianKinerja($id,$tahun,$x){
            $this->db->select('*')
                ->from('db_pegawai.pegskp a')
                ->where('a.id_pegawai', $id)
                ->where('a.tahun', $tahun)
                ->order_by('a.tahun', 'desc')
                ->where('a.flag_active', 1)
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
                ->where('a.flag_active', 1);
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
         
            $cek =  $this->db->select('*')
                                    ->from('db_simata.t_penilaian_potensial a')
                                    ->where('a.id_peg', $data["id_peg"])
                                    ->where('a.jabatan_target', $this->input->post('jabatan_target'))
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
                $dataInsert['jabatan_target']      = $this->input->post('jabatan_target');
                $this->db->insert('db_simata.t_penilaian_potensial', $dataInsert);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            }

            $total_nilai = $datapost["nilai_assesment"] * 50 / 100;

            $this->db->where('id_peg', $datapost['id_peg'])
                     ->where('id_jabatan_target', $datapost['jabatan_target'])
                        ->update('db_simata.t_penilaian', 
                        ['res_potensial_cerdas' => $total_nilai]);
            

            $getAllNilaiPotensial =  $this->db->select('*')
                        ->from('db_simata.t_penilaian a')
                        ->where('a.id_peg', $datapost["id_peg"])
                        ->where('a.id_jabatan_target', $datapost['jabatan_target'])
                        ->where('a.flag_active', 1)
                        ->get()->result_array();

            $total_potensial = $getAllNilaiPotensial[0]['res_potensial_cerdas'] + $getAllNilaiPotensial[0]['res_potensial_rj'] + $getAllNilaiPotensial[0]['res_potensial_lainnya'];

            $this->db->where('id_peg', $datapost['id_peg'])
            ->where('id_jabatan_target', $datapost['jabatan_target'])
               ->update('db_simata.t_penilaian', 
               ['res_potensial_total' => $total_potensial]);
        
        
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
            $data["jabatan_target"] = $this->input->post('rj_jabatan_target');

            $cek =  $this->db->select('*')
                                    ->from('db_simata.t_penilaian_potensial a')
                                    ->where('a.id_peg', $data["id_peg"])
                                    ->where('a.jabatan_target', $this->input->post('rj_jabatan_target'))
                                    ->where('a.flag_active', 1)
                                    ->get()->result_array();

            if($cek){
                $this->db->where('id_peg', $data['id_peg'])
                         ->where('jabatan_target', $this->input->post('rj_jabatan_target'))
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
                     ->where('id_jabatan_target', $datapost['rj_jabatan_target']) 
                         ->update('db_simata.t_penilaian', 
                        ['res_potensial_rj' => $total_rj]);

            $getAllNilaiPotensial =  $this->db->select('*')
                        ->from('db_simata.t_penilaian a')
                        ->where('a.id_peg', $data["id_peg"])
                        ->where('a.id_jabatan_target', $datapost['rj_jabatan_target'])
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
                        
            $total_potensial = $getAllNilaiPotensial[0]['res_potensial_cerdas'] + $getAllNilaiPotensial[0]['res_potensial_rj'] + $getAllNilaiPotensial[0]['res_potensial_lainnya'];

            $this->db->where('id_peg', $data['id_peg'])
            ->where('id_jabatan_target', $datapost['rj_jabatan_target'])
               ->update('db_simata.t_penilaian', 
               ['res_potensial_total' => $total_potensial]);

                        
        
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
            // dd($datapost);
            
            $this->db->trans_begin();
        
            if($this->input->post('lainnya1') != 0){

            $total_rj = null;
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
            $data["jabatan_target"] = $this->input->post('lainnya_jabatan_target');

            $cek =  $this->db->select('*')
                                    ->from('db_simata.t_penilaian_potensial a')
                                    ->where('a.id_peg', $data["id_peg"])
                                    ->where('a.jabatan_target', $this->input->post('lainnya_jabatan_target'))
                                    ->where('a.flag_active', 1)
                                    ->get()->result_array();

            if($cek){
                $this->db->where('id_peg', $data['id_peg'])
                         ->where('jabatan_target', $this->input->post('lainnya_jabatan_target'))
                ->update('db_simata.t_penilaian_potensial', 
                ['pengalaman_organisasi' => $id_rekamjjk1,
                'aspirasi_karir' => $id_rekamjjk2,
                'asn_ceria' => $id_rekamjjk3
                 ]);
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            } else {
                $this->db->insert('db_simata.t_penilaian_potensial', $data);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

            }

            $this->db->where('id_peg', $data['id_peg'])
                     ->where('id_jabatan_target', $datapost['lainnya_jabatan_target']) 
                         ->update('db_simata.t_penilaian', 
                        ['res_potensial_lainnya' => $total_rj]);

            $getAllNilaiPotensial =  $this->db->select('*')
                        ->from('db_simata.t_penilaian a')
                        ->where('a.id_peg', $data["id_peg"])
                        ->where('a.id_jabatan_target', $datapost['lainnya_jabatan_target'])
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
                        
            $total_potensial = $getAllNilaiPotensial[0]['res_potensial_cerdas'] + $getAllNilaiPotensial[0]['res_potensial_rj'] + $getAllNilaiPotensial[0]['res_potensial_lainnya'];

            $this->db->where('id_peg', $data['id_peg'])
            ->where('id_jabatan_target', $datapost['lainnya_jabatan_target'])
               ->update('db_simata.t_penilaian', 
               ['res_potensial_total' => $total_potensial]);

                        
        
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
            ->join('db_pegawai.jabatan b', 'a.id_jabatan_target = b.id_jabatanpeg')
            ->where("FIND_IN_SET(b.eselon,'II B')!=",0)
            ->group_by('a.id_jabatan_target');
            return $this->db->get()->result_array(); 
        }

        public function getPegawaiPenilaianDetailNinebox($jenis_jab,$jt,$box){
             $this->db->select('*')
                            ->from('db_simata.t_penilaian a')
                            ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                            ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
                            ->where('a.flag_active', 1)
                            ->order_by('(a.res_kinerja) + (a.res_potensial_total) DESC');
                            if($box == 9){
                                $this->db->where('a.res_potensial_total >=', 85);
                                $this->db->where('a.res_kinerja >=', 85);
                            }
                            if($box == 8){
                                $this->db->where('a.res_potensial_total >=', 85);
                                $this->db->where('a.res_kinerja >=', 70);
                                $this->db->where('a.res_kinerja <', 85);
                            }
                            if($box == 7){
                                $this->db->where('a.res_potensial_total >=', 70);
                                $this->db->where('a.res_potensial_total <', 85);
                                $this->db->where('a.res_kinerja >=', 85);
                            }
                            if($box == 6){
                                $this->db->where('a.res_potensial_total >=', 85);
                                $this->db->where('a.res_kinerja <', 70);
                            }
                            if($box == 5){
                                $this->db->where('a.res_potensial_total >=', 70);
                                $this->db->where('a.res_potensial_total <', 85);
                                $this->db->where('a.res_kinerja >=', 70);
                                $this->db->where('a.res_kinerja <', 85);
                            }
                            if($box == 4){
                                $this->db->where('a.res_potensial_total <', 70);
                                $this->db->where('a.res_kinerja >=', 85);
                            }
                            if($box == 3){
                                $this->db->where('a.res_potensial_total >=', 70);
                                $this->db->where('a.res_potensial_total <', 85);
                                $this->db->where('a.res_kinerja <', 70);
                            }
                            if($box == 2){
                                $this->db->where('a.res_potensial_total <', 70);
                                $this->db->where('a.res_kinerja >=', 70);
                                $this->db->where('a.res_kinerja <', 85);
                            }
                            if($box == 1){
                                $this->db->where('a.res_potensial_total <', 70);
                                $this->db->where('a.res_kinerja <', 70);
                            }
                            if($jenis_jab == 1){
                                $this->db->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0);
                            }
                            if($jenis_jab == 2){
                                $this->db->where("FIND_IN_SET(c.eselon,'II B')!=",0);
                            }
                            if($jt != 0){
                                $this->db->where("id_jabatan_target",$jt);
                            }

            return  $this->db->get()->result_array();
        }


        
public function loadListProfilTalentaAdm(){
    return $this->db->select('*')
                    ->from('db_simata.t_penilaian a')
                    ->join('db_pegawai.pegawai b', 'a.id_peg = b.id_peg')
                    ->join('db_pegawai.jabatan c', 'a.id_jabatan_target = c.id_jabatanpeg')
                    ->where("FIND_IN_SET(c.eselon,'III A,III B')!=",0)
                    ->where('a.flag_active', 1)
                    ->order_by('a.id', 'asc') 
                    ->get()->result_array();
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
        ->where('b.nipbaru', $nip)
        ->where('a.jabatan_target', $jt);
        // ->limit(1);
    return $this->db->get()->row_array();
}
          
      
            
       
	}
?>