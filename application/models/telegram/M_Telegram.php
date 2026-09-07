<?php
    require FCPATH . '/vendor/autoload.php';

    class M_Telegram extends CI_Model
	{
        public $bios_serial_num;

        public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function log($data){
            $this->db->insert('t_log_webhook_telegram', [
                'response' => $data['response']
            ]);
        }

	}
?>