<?php
	class M_Kepegawaian extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function get_datatables_lihat_dokumen_pns($cariBy,$cariName,$unor)
        {
            
            // $idunor  = $this->arsip->getIdPerangkatDaerah();
            $idunor  = 4018000;
            // var_dump($idunor);
            // die();
            $this->db->select('dokumen_upload.*,pegawai.nama, dokumen.nama_dokumen, users.first_name,dokumen_status.nama_status ');
            // $this->db->from('dokumen_upload');
            $this->db->join('simpeg_manado.pegawai ', 'REPLACE(TRIM(pegawai.nipbaru)," ","") = dokumen_upload.nip', 'left');
            $this->db->join('dokumen', 'dokumen.id_dokumen = dokumen_upload.id_dokumen', 'left');
            $this->db->join('users', 'users.id = dokumen_upload.upload_by', 'left');
            $this->db->join('dokumen_status', 'dokumen_status.id_status = dokumen_upload.status_dokumen', 'left');	
            $this->db->or_where('dokumen_upload.nip',$cariName);
            if ($idunor <> NULL)
            {
            $this->db->where('pegawai.skpd',$idunor);
            }
            if ($idunor =='4018000')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "0000000" AND "9900000"');
            }
            else if ($idunor =='3010000')
            {
            $this->db->where('pegawai.skpd',"3010000");
            $this->db->or_where('pegawai.skpd BETWEEN "7000000" AND "8400000"');
    
            }
            else if ($idunor =='3012000')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "6000000" AND "7900000"');
            }
            else if ($idunor =='1030525')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "1000000" AND "2900000"');
            }
            else if ($idunor =='5001001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5001000" AND "5001100"');
            }	
            else if ($idunor =='5002001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5002000" AND "5002100"');
            }
            else if ($idunor =='5003001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5003000" AND "5003100"');
            }
            else if ($idunor =='5004001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5004000" AND "5004100"');
            }
            else if ($idunor =='5005001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5005009" AND "5005013"');
            }
            else if ($idunor =='5006001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5006000" AND "5006100"');
            }
            else if ($idunor =='5007001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5007000" AND "5007100"');
            }
            else if ($idunor =='5008001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5008000" AND "5008100"');
            }
            else if ($idunor =='5009001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5009000" AND "5009100"');
            }
            else if ($idunor =='5010001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5005002" AND "5005008"');
            }	
            else if ($idunor =='5011001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5011001" AND "5011101"');
            }
    
            $i = 0;		
        
            // foreach ($this->column_search_lihat_dokumen_pns as $item) // loop column 
            // {
            //     if($_GET['search']['value']) // if datatable send POST for search
            //     {				
            //         if($i===0) // first loop
            //         {
            //             $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
            //             $this->db->like($item, $_GET['search']['value']);
            //         }
            //         else
            //         {
            //             $this->db->or_like($item, $_GET['search']['value']);
            //         }
    
            //         if(count($this->column_search_lihat_dokumen_pns) - 1 == $i) //last loop
            //             $this->db->group_end(); //close bracket
            //     }
            //     $i++;
            // }
            
            // if(isset($_GET['order'])) // here order processing
            // {
            //     $this->db->order_by($this->column_order_lihat_dokumen_pns[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
            // } 
            // else if(isset($this->order_lihat_dokumen_pns))
            // {
            //     $order = $this->order_lihat_dokumen_pns;
            //     $this->db->order_by(key($order), $order[key($order)]);
            // }
            
            if($cariBy == 1)
            {
                $this->db->where('dokumen_upload.nip',$cariName);	
            }
            
            if(!empty($unor))
            {
                $this->db->where('dokumen_upload.last_unor',$unor);
            }
            $query = $this->db->get('dokumen_upload');
            return $query->result();
            
        }

       

       

	}
?>