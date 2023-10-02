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

 function submitJabatanTarget(){
 
 $jtarget = [];
 $jtarget = $this->input->post('jabatan_target');
 $id_peg = $this->input->post('id_pegawai');

 for ($count = 0; $count < count($jtarget); $count++) {
    $jt = $jtarget[$count];
  
    
    $data["id_peg"] = $id_peg;
    $data["id_jabatan_target"] = $jt;
    $data["created_by"] = $this->general_library->getId();
  
    
    $this->db->insert('db_simata.t_penilaian', $data);
    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

    return $res;

}

 
    
}


        

            
                     
            
       
	}
?>