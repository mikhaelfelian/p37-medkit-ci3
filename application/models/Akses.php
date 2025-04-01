<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/**
 * Akses Model
 * 
 * This model handles access control functionality for the application
 * 
 * @author     Mikhael Felian Waskito
 * @github     mikhaelfelian
 * @modified   2025-04-01
 */


class Akses extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    // Cek Sudah login belun
    public static function aksesLogin() {
        $CI =& get_instance();
        if (!$CI->ion_auth->logged_in()):
            return FALSE;
        else:
            $user   = $CI->ion_auth->user()->row();
            $grup   = $CI->ion_auth->get_users_groups()->row();
            
            if ($grup->name != 'pasien'):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
    
    // Cek Sudah login belun ebagai pasien
    public static function aksesLoginP() {
        $CI =& get_instance();
        if (!$CI->ion_auth->logged_in()):
            return FALSE;
        else:
            $user   = $CI->ion_auth->user()->row();
            $grup   = $CI->ion_auth->get_users_groups()->row();
            
            if ($grup->name == 'pasien'):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
    
    // Cek Root
    public static function aksesRoot() {
        $CI =& get_instance();
        if (!$CI->ion_auth->is_admin()):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    

    public static function hakSA() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'superadmin'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakOwner() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'owner'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakOwner2() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'owner2'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakAdminM() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'adminm'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakAdmin() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'admin'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakPurchasing() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'purchasing'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakSales() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'sales'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakGudang() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'gudang'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakKasir() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'kasir'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakDokter() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'dokter'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakPerawat() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'perawat' OR $grup->name == 'perawat_ranap'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakFarmasi() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'farmasi'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakAnalis() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'analis'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakRad() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'radiografer'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakGizi() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'gizi'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakFisioterapi() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'fisioterapi'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public static function hakPasien() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'pasien'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function menuAksesTop() {
        $user = $this->ion_auth->user()->row();
        $grup = $this->ion_auth->get_users_groups($user->id)->row();
        
        switch ($grup->name){
            case 'superadmin':
                $this->load->view('admin-lte-3/includes/menu/menu_top_sadmin');
                break;
            
            case 'owner':
                $this->load->view('admin-lte-3/includes/menu/menu_top_owner');
                break;
            
            case 'owner2':
                $this->load->view('admin-lte-3/includes/menu/menu_top_owner2');
                break;
            
            case 'adminm':
                $this->load->view('admin-lte-3/includes/menu/menu_top_admin');
                break;
            
            case 'admin':
                $this->load->view('admin-lte-3/includes/menu/menu_top_admin');
                break;
            
            case 'sales':
                $this->load->view('admin-lte-3/includes/menu/menu_top_sales');
                break;
            
            case 'purchasing':
                $this->load->view('admin-lte-3/includes/menu/menu_top_purchasing');
                break;
            
            case 'gudang':
                $this->load->view('admin-lte-3/includes/menu/menu_top_gudang');
                break;
            
            case 'kasir':
                $this->load->view('admin-lte-3/includes/menu/menu_top_kasir');
                break;
            
            default:
                $this->load->view('admin-lte-3/includes/menu/menu_top_sadmin');
                break;
        }
    }
    
    public static function notifAkses() {
        $CI =& get_instance();
        $user = $CI->ion_auth->user()->row();
        $grup = $CI->ion_auth->get_users_groups($user->id)->row();
        
        switch ($grup->name){
            case 'dokter':
                $CI->load->view('admin-lte-3/includes/menu/notif_dokter');
                break;

            case 'gudang':
                $CI->load->view('admin-lte-3/includes/menu/notif_gudang');
                break;
        }
    }
    
    function menuAkses() {
        $user = $this->ion_auth->user()->row();
        $grup = $this->ion_auth->get_users_groups($user->id)->row();
        
        switch ($grup->name){
            case 'superadmin':
                $this->load->view('admin-lte-2/includes/menu/menu_sadmin');
                break;
            
            case 'owner':
                $this->load->view('admin-lte-2/includes/menu/menu_owner');
                break;
            
            case 'owner2':
                $this->load->view('admin-lte-2/includes/menu/menu_owner2');
                break;
            
            case 'adminm':
                $this->load->view('admin-lte-2/includes/menu/menu_admin');
                break;
            
            case 'admin':
                $this->load->view('admin-lte-2/includes/menu/menu_admin');
                break;
            
            case 'sales':
                $this->load->view('admin-lte-2/includes/menu/menu_sales');
                break;
            
            case 'purchasing':
                $this->load->view('admin-lte-2/includes/menu/menu_purchasing');
                break;
            
            case 'gudang':
                $this->load->view('admin-lte-2/includes/menu/menu_gudang');
                break;
            
            case 'kasir':
                $this->load->view('admin-lte-2/includes/menu/menu_kasir');
                break;
            
            default:
                $this->load->view('admin-lte-2/includes/menu/menu');
                break;
        }
    }
        
    function menuAksesSidebar() {
        $user = $this->ion_auth->user()->row();
        $grup = $this->ion_auth->get_users_groups($user->id)->row();
        
        switch ($grup->name){
            case 'superadmin':
                $this->load->view('admin-lte-3/includes/menu/menu_side_sadmin');
                break;
            
            case 'owner':
                $this->load->view('admin-lte-3/includes/menu/menu_side_owner');
                break;
            
            case 'owner2':
                $this->load->view('admin-lte-3/includes/menu/menu_side_owner2');
                break;
            
            case 'adminm':
                $this->load->view('admin-lte-3/includes/menu/menu_side_admin');
                break;
            
            case 'admin':
                $this->load->view('admin-lte-3/includes/menu/menu_side_admin');
                break;
            
            case 'sales':
                $this->load->view('admin-lte-3/includes/menu/menu_side_sales');
                break;
            
            case 'purchasing':
                $this->load->view('admin-lte-3/includes/menu/menu_side_purchasing');
                break;
            
            case 'gudang':
                $this->load->view('admin-lte-3/includes/menu/menu_side_gudang');
                break;
            
            case 'kasir':
                $this->load->view('admin-lte-3/includes/menu/menu_side_kasir');
                break;
            
            default:
                $this->load->view('admin-lte-3/includes/menu/menu_side_sadmin');
                break;
        }
    }
    
    function contentAkses() {
        $user = $this->ion_auth->user()->row();
        $grup = $this->ion_auth->get_users_groups($user->id)->row();
        
        switch ($grup->name){
            case 'superadmin':
                $this->load->view('admin-lte-2/includes/menu/content_sadmin');
                break;
            
            case 'owner':
                $this->load->view('admin-lte-2/includes/menu/content_owner');
                break;
            
            case 'owner2':
                $this->load->view('admin-lte-2/includes/menu/content_owner2');
                break;
            
            case 'adminm':
                $this->load->view('admin-lte-2/includes/menu/content_admin');
                break;
            
            case 'admin':
                $this->load->view('admin-lte-2/includes/menu/content_admin');
                break;
            
            case 'sales':
                $this->load->view('admin-lte-2/includes/menu/content_sales');
                break;
            
            case 'purchasing':
                $this->load->view('admin-lte-2/includes/menu/content_purchasing');
                break;
            
            case 'gudang':
                $this->load->view('admin-lte-2/includes/menu/content_gudang');
                break;
            
            case 'kasir':
                $this->load->view('admin-lte-2/includes/menu/content_kasir');
                break;
            
            case 'pasien':
                $this->load->view('admin-lte-2/includes/menu/content_pasien');
                break;
            
            default:
                $this->load->view('admin-lte-2/includes/menu/content');
                break;
        }
    }
}
