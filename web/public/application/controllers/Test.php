<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		$this->login();
	}

	public function phpinfo()
	{
		echo phpinfo(); exit;
	}

	public function videojs()
	{
		$bannerData['loginText'] = $this->viewhelpers->loginText();

		$data['title'] = "Testing VideoJS";
		$data['banner'] = $this->load->view('parts/banner', $bannerData, TRUE);
		$data['content'] = $this->load->view('parts/videojs', NULL, TRUE);
		$this->load->view('base', $data);
	}
}
