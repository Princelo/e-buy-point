<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPImageWorkshop\ImageWorkshop;

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct()
    {
        parent::__construct();
        check_access_right('login', $this->session);
        require('application/third_party/phpqrcode/qrlib.php');
        if($this->session->userdata('is_admin') == 1)
            redirect('admin/index');
    }

	public function index()
	{
        check_access_right('user', $this->session);
		$this->load->helper('url');
        $this->load->helper('form');
		$consumption_form_url = site_url(['consumption', 'input']);
		$consumer_validate_url = site_url(['validator', 'check_consumer_name']);
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
		$view_data = [];
		$view_data['consumption_form_url'] = $consumption_form_url;
		$view_data['consumer_validate_url'] = $consumer_validate_url;
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $this->load->model('Report_model', 'Report_model');
        $view_data['action_logs'] = $this->Report_model->getLastActionBySubMember(10);
        $query = $this->db->query("select name, address, tel, contact,return_profit,consumption_ratio from ".DB_PREFIX."supplier_location where id = ? limit 1",
            [$this->session->userdata('biz_id')]);
        $auth_data = $query->result()[0];
        $view_data['formula_local_score'] = $this->db->query("
                    select sum(score) total_score from fanwe_biz_consume_log where biz_id = ?
                    and biz_id != pid
                    and unix_timestamp(create_time) >=
                        case when (select max(unix_timestamp(create_time)) from fanwe_settle_biz_log where biz_id = ?)
                        is null then 0 else (select max(unix_timestamp(create_time)) from fanwe_settle_biz_log where biz_id = ?)
                        end
            ", [
                $this->session->userdata('biz_id'),
                $this->session->userdata('biz_id'),
                $this->session->userdata('biz_id'),
            ])->result()[0];
        $view_data['formula_local_volume'] = $this->db->query("
                    select sum(volume * ratio) total_volume from fanwe_biz_consume_log where biz_id = ?
                    and unix_timestamp(create_time) >=
                        case when (select max(unix_timestamp(create_time)) from fanwe_settle_biz_log where biz_id = ?)
                        is null then 0 else (select max(unix_timestamp(create_time)) from fanwe_settle_biz_log where biz_id = ?)
                        end
            ", [
            $this->session->userdata('biz_id'),
            $this->session->userdata('biz_id'),
            $this->session->userdata('biz_id'),
        ])->result()[0];
        $view_data['formula_sub'] = $this->db->query("
                    select sum(pscore) total_volume from fanwe_biz_consume_log where pid = ?
                    and unix_timestamp(create_time) >=
                        case when (select max(unix_timestamp(create_time)) from fanwe_settle_biz_log where biz_id = ?)
                        is null then 0 else (select max(unix_timestamp(create_time)) from fanwe_settle_biz_log where biz_id = ?)
                        end
            ", [
            $this->session->userdata('biz_id'),
            $this->session->userdata('biz_id'),
            $this->session->userdata('biz_id'),
        ])->result()[0];
        $view_data['auth_data'] = $auth_data;
        if (!file_exists(__DIR__.'/../../assets/qrcode/'.$this->session->userdata('biz_id').'qrcode.png')) {
            $this->__generate_qrcode();
        }
        if (!file_exists(__DIR__.'/../../assets/qrcode/'.$this->session->userdata('biz_id').'qrcode_share.png')) {
            $this->__generate_share_qrcode();
        }
        $view_data['qrcode_share'] = '/assets/'.$this->session->userdata('biz_id').'qrcode_share.png';
        $view_data['qrcode'] = '/assets/qrcode/'.$this->session->userdata('biz_id').'qrcode.png';
		$this->load->view('layout/default_header');
		$this->load->view('welcome/index', $view_data);
		$this->load->view('layout/default_footer');
	}

    public function sharing()
    {
        $this->load->view('welcome/sharing');
    }

    private function __generate_qrcode() {
        $codeContents = 'http://m-ebuy.com/index.php?ctl=user&act=register&p_biz_id='.$this->session->userdata('biz_id');
        $tempDir = __DIR__.'/../../assets/qrcode/';
        $fileName = $this->session->userdata('biz_id').'qrcode.jpg';
        $outerFrame = 4;
        $pixelPerPoint = 5;
        $jpegQuality = 100;

        // generating frame
        $frame = QRcode::text($codeContents, false, QR_ECLEVEL_H);

        // rendering frame with GD2 (that should be function by real impl.!!!)
        $h = count($frame);
        $w = strlen($frame[0]);

        $imgW = $w + 2*$outerFrame;
        $imgH = $h + 2*$outerFrame;

        $base_image = imagecreate($imgW, $imgH);

        $col[0] = imagecolorallocate($base_image,255,255,255); // BG, white
        //$col[1] = imagecolorallocate($base_image,0,0,255);     // FG, blue
        $col[1] = imagecolorallocate($base_image,0,0,0);     // FG, blue

        imagefill($base_image, 0, 0, $col[0]);

        for($y=0; $y<$h; $y++) {
            for($x=0; $x<$w; $x++) {
                if ($frame[$y][$x] == '1') {
                    imagesetpixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[1]);
                }
            }
        }

        // saving to file
        $target_image = imagecreate($imgW * $pixelPerPoint, $imgH * $pixelPerPoint);
        imagecopyresized(
            $target_image,
            $base_image,
            0, 0, 0, 0,
            $imgW * $pixelPerPoint, $imgH * $pixelPerPoint, $imgW, $imgH
        );
        imagedestroy($base_image);
        imagejpeg($target_image, $tempDir.$fileName, $jpegQuality);
        imagedestroy($target_image);

        $QRcodeLayer = ImageWorkshop::initFromPath('assets/qrcode/'.$this->session->userdata('biz_id').'qrcode.jpg');
        $QRcodeLayer->resize($QRcodeLayer::UNIT_PIXEL, $QRcodeLayer->getWidth()*2, $QRcodeLayer->getHeight()*2);
        $logoLayer = ImageWorkshop::initFromPath('assets/qrcode/logo.png');
        //$logoLayer->resize($logoLayer::UNIT_PIXEL, 150, 60);
        $QrcodeWidth = $QRcodeLayer->getWidth();
        $QrcodeHeight = $QRcodeLayer->getHeight();
        $logoWidth = $logoLayer->getWidth();
        $logoHeight = $logoLayer->getHeight();
        $x = $QrcodeWidth/2 - $logoWidth/2;
        $y = $QrcodeHeight/2 - $logoHeight/2;
        $QRcodeLayer->addLayer(0, $logoLayer, $x, $y);
        $QRcodeLayer->save('assets/qrcode/', $this->session->userdata('biz_id').'qrcode.png', true, null, 10);
    }

    private function __generate_share_qrcode()
    {
        QRcode::png('http://m-ebuy.com/index.php?ctl=user&act=register&p_biz_id='.$this->session->userdata('biz_id').'&sharing=1',
            'assets/qrcode/'.$this->session->userdata('biz_id').'qrcode_share.png', 'H', 10, 2);
    }

    public function download_qrcode()
    {
        $this->load->helper('download');
        $data = file_get_contents(__DIR__.'/../../assets/qrcode/'.$this->session->userdata('biz_id').'qrcode.png'); // Read the file's contents
        $name = '我的二维码.png';

        force_download($name, $data);
    }
}
