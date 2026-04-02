<?php

class C_Bacirita extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('bacirita/M_Bacirita', 'bacirita');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
        if($this->general_library->cekKinerja() == null) {
            redirect('kinerja/realisasi');
        }
    }

    public function manageKegiatan(){
        render('bacirita/V_ManageKegiatan', null, null, null);
    }

    public function saveDataKegiatan(){
        echo json_encode($this->bacirita->saveDataKegiatan($this->input->post()));
    }

    public function loadListKegiatan($id){
        $data['result'] = $this->bacirita->loadListKegiatan($id);
        $this->load->view('bacirita/V_ListKegiatanAdmin', $data);
    }

    public function modalLoadDetailKegiatan($id){
        $data['result'] = $this->bacirita->modalLoadDetailKegiatan($id);
        $data['total_peserta'] = $this->bacirita->getTotalPeserta($id);
        $this->load->view('bacirita/V_ModalEditKegiatan', $data);
    }

    public function editDataKegiatan(){
        echo json_encode($this->bacirita->editDataKegiatan($this->input->post()));
    }

    public function daftarKegiatan(){
        render('bacirita/V_home', null, null, null);
    }

     public function loadListWebinar($tab){
        $data['result'] = $this->bacirita->loadListKegiatan($tab);
        $this->load->view('bacirita/V_ListWebinar', $data);
    }

     public function detailWebinar($id){
        $data['webinar'] = $this->bacirita->loadDetailWebinar($id);
        render('bacirita/V_DetailWebinar', '', '', $data);
    }

    public function submitDaftarKegiatan($id_kegiatan,$id_m_user){
       echo json_encode($this->bacirita->submitDaftarKegiatan($id_kegiatan,$id_m_user));
    }

    public function presensiKegiatan($id_kegiatan,$id_m_user){
       echo json_encode($this->bacirita->presensiKegiatan($id_kegiatan,$id_m_user));
    }

    public function updloadTemplateSertifikat(){
        echo json_encode($this->bacirita->updloadTemplateSertifikat($this->input->post()));
    }

    public function saveCoordinateSertifikat($id){
        echo json_encode($this->bacirita->saveCoordinateSertifikat($id));
    }

    public function toggleFieldPreview($field, $flag_show, $id){
        echo json_encode($this->bacirita->toggleFieldPreview($field, $flag_show, $id));
    }

    public function toggleDownloadSertifikat($id, $state){
        echo json_encode($this->bacirita->toggleDownloadSertifikat($id, $state));
    }

    public function toggleBukaAbsensi($id, $state){
        echo json_encode($this->bacirita->toggleBukaAbsensi($id, $state));
    }

    public function generateSertifikat(){
        echo json_encode($this->bacirita->generateSertifikat());
    }

    public function verifSertifikat($randomString){
        $data['result'] = $this->bacirita->verifSertifikat($randomString);
        render('bacirita/V_DetailWebinar', '', '', $data);
    }

    public function downloadSertifikat(){
        $data = $this->input->post();
        echo json_encode($this->bacirita->downloadSertifikat($data));
    }

    public function loadPesertaKegiatan($id){
        $data['result'] = $this->bacirita->loadPesertaKegiatan($id);
        $this->load->view('bacirita/V_ListPesertaKegiatan', $data);
    }

}
