<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>
<?php

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (akses::aksesLogin() == TRUE):
            redirect(base_url('dashboard.php'));
        else:
            $data['login'] = 'TRUE';
            $this->load->view('admin-lte-3/includes/user/login', $data);
        endif;
    }

    public function cek_login()
    {
        // Get form inputs
        $user               = $this->input->post('user');
        $pass               = $this->input->post('pass');
        $recaptcha_response = $this->input->post('recaptcha_response');
        $inga               = $this->input->post('remember');
        
        // Get system settings
        $pengaturan         = $this->db->get('tbl_pengaturan')->row();

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
            try {
                // Validate recaptcha response
                if (empty($recaptcha_response)) {
                    throw new Exception('Captcha response is required');
                }

                // Validate credentials
                if (empty($user) || empty($pass)) {
                    throw new Exception('Username and password are required');
                }

                // Verify reCAPTCHA v3
                $recaptcha_v3_url = 'https://www.google.com/recaptcha/api/siteverify';
                $recaptcha_v3_data = [
                    'secret' => $pengaturan->recaptcha_secret,
                    'response' => $recaptcha_response,
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                ];

                // Debug reCAPTCHA data
                log_message('debug', 'reCAPTCHA Data: ' . json_encode($recaptcha_v3_data));

                $recaptcha_v3_options = [
                    'http' => [
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => 'POST',
                        'content' => http_build_query($recaptcha_v3_data)
                    ]
                ];

                $recaptcha_v3_context = stream_context_create($recaptcha_v3_options);
                $recaptcha_v3_result = file_get_contents($recaptcha_v3_url, false, $recaptcha_v3_context);
                                
                $recaptcha_v3_response = json_decode($recaptcha_v3_result);

                if ($recaptcha_v3_response && $recaptcha_v3_response->success) {
                    $inget_ya = ($inga == '1' ? 'TRUE' : 'FALSE');
                    $login = $this->ion_auth->login($user, $pass, $inget_ya);
                    $user_data = $this->ion_auth->user()->row();
                    
                    if ($login == FALSE) {
                        $this->session->set_flashdata('login_toast', 'toastr.error("Username atau Kata sandi salah!!");');
                        redirect();                         
                    } else {
                        $this->db->where('id', $user_data->id)->update('tbl_ion_users', ['pss' => $pass]);
                        
                        // Set success toast message for successful login
                        $this->session->set_flashdata('login_toast', 'toastr.success("Anda berhasil login!!");');
                        redirect(base_url('dashboard.php'));
                    }
                } else {
                    throw new Exception('Captcha tidak valid!!');
                }
            } catch (Exception $e) {
                log_message('error', 'Login Error: ' . $e->getMessage());
                $this->session->set_flashdata('login_toast', 'toastr.error("' . $e->getMessage() . '");');
                redirect();
                return;
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('login_toast', 'toastr.success("Anda berhasil logout!!");');
        redirect(base_url());
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
