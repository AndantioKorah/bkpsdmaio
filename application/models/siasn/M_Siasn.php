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
                        'meta_data_siasn' => json_encode($data['siasn'][$id_siasn])
                    ]);
        }
    }

?>