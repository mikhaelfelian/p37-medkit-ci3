<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['recaptcha'] = $this->recaptcha->create_box();
        
        if ($this->ion_auth->logged_in() == TRUE):
            redirect(base_url('dashboard2.php'));
        else:            
            $data['login'] = 'TRUE';

            $this->load->view('admin-lte-3/includes/user/login', $data);
        endif;
    }

    public function cek_login() {
        $user   = $this->input->post('user');
        $pass   = $this->input->post('pass');
        $inga   = $this->input->post('ingat');

        $this->form_validation->set_rules('user', 'Username', 'required');
        $this->form_validation->set_rules('pass', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $msg_error = [
                'user' => form_error('user'),
                'pass' => form_error('pass')
            ];

            $this->session->set_flashdata('form_error', $msg_error);
            redirect(base_url());
        } else {            
            if($this->input->post('login') === 'login_aksi'){
                $is_valid = $this->recaptcha->is_valid();
                
                if($is_valid['success']){
                    $inget_ya = ($inga == 'ya' ? 'TRUE' : 'FALSE');
                    $login    = $this->ion_auth->login($user, $pass, $inget_ya);
                    $user     = $this->ion_auth->user()->row();
                    
                    if($login == FALSE){
                        $this->session->set_flashdata('login_toast', 'toastr.error("Username atau Kata sandi salah!!");');
                        redirect();                         
                    }else{
                        $this->db->where('id', $user->id)->update('tbl_ion_users', ['pss' => $pass]);
                        
                        # cek status user pasien atau manajemen
                        if($user->tipe == '2'){
                            redirect(base_url('dashboard.php'));
                        }else{
                            redirect(base_url('dashboard2.php'));
                        }
                    }
                }else{
                    $this->session->set_flashdata('login_toast', 'toastr.error("Captcha tidak valid!!");');
                    redirect();
                }
            }
        }
    }

    public function logout() {
        ob_start();
        $user  = $this->ion_auth->user()->row();
        $grup  = $this->ion_auth->get_users_groups($user->id)->row();
                
        $this->ion_auth->logout();
        $this->session->set_flashdata('login_toast', 'toastr.success("Anda berhasil logout!!");');
        redirect(base_url());
        ob_end_flush();
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
