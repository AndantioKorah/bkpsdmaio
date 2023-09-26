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

            function getKriteriaPenilaian($id){
                $this->db->select('a.*')
                    ->from('db_simata.m_kriteria_penilaian a')
                    ->where('a.id', $id);
                return $this->db->get()->row_array();
            }
       
	}
?>