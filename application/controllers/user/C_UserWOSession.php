<?php

class C_UserWOSession extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('user/M_User', 'user');
        $this->load->model('rekap/M_Rekap', 'rekap');
        $this->load->model('master/M_Master', 'master');
        // if(!$this->general_library->isNotMenu()){
        //     redirect('logout');
        // };
    }

    public function personalChangePassword(){
        $data['flag_need_reset_pass'] = 1;
        $data['otp'] = $this->user->sendOtpResetPassword();
        render('user/V_UserChangePasswordNoss', null, null, $data);
    }

    public function requestSendOtp(){
        echo json_encode($this->user->requestSendOtp());
    }

    public function personalChangePasswordSubmit(){
        echo json_encode($this->user->changePassword($this->input->post()));
        
        // $this->session->set_flashdata('message', $message['message']);
        // redirect('user/setting');
    }

    public function forgetPassword(){
        renderVerifWhatsapp('user/V_UserForgetPassword', null, null, null);
    }

    public function submitForgetPassword(){
        echo json_encode($this->user->submitForgetPassword());
    }
}
