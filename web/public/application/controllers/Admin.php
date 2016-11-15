<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		$this->login();
	}

	public function account()
	{
		$this->viewhelpers->forceLoggedIn();

		$this->load->model('User');

		$user = User::init( $this->session->userdata('id') );

		$friendsNavData['following'] = $user->followingList();
		$contentData['friendsNav'] = $this->load->view( 'parts/friendsNav', $friendsNavData, TRUE );

		$user = User::init($this->session->userdata('id'));
		$contentData['user'] = $user;
		$videoNavData['user'] = $user;
		$contentData['videoNav'] = $this->load->view( 'parts/videoNav', $videoNavData, TRUE );

		$bannerData['loginText'] = $this->viewhelpers->loginText();

		$data['title'] = "Annotated.io - My Account";
		$data['banner'] = $this->load->view( 'parts/banner', $bannerData, TRUE );
		$data['content'] = $this->load->view( 'parts/account', $contentData, TRUE );
		$this->load->view( 'base', $data );
	}

	public function messages()
	{
		$this->load->model( 'Message' );
		$this->viewhelpers->forceLoggedIn();

		$bannerData['loginText'] = $this->viewhelpers->loginText();

		$contentData['messages'] = Message::getAll( $this->session->userdata('id') );

		$data['title'] = "Annotated.io - Messages";
		$data['banner'] = $this->load->view( 'parts/banner', $bannerData, TRUE );
		$data['content'] = $this->load->view( 'parts/messages', $contentData, TRUE );

		$this->load->view( 'base', $data );
	}

	public function login()
	{
		//If logged in, redirect to the video home page
		if( $this->session->userdata('loggedin') )
		{
			redirect( '/videos', 'refresh' );
		}


		$bannerData['loginText'] = $this->viewhelpers->loginText();

		$data['title'] = "Annotated.io - Login";
		$data['banner'] = $this->load->view( 'parts/banner', $bannerData, TRUE );
		$data['content'] = $this->load->view( 'parts/login', NULL, TRUE );

		$this->load->view( 'base', $data );
	}

	public function logout()
	{
		$this->viewhelpers->forceLoggedIn();

		$this->load->helper( 'url' );
		$sessiondata = array( "loggedin"	=>	FALSE );
		$this->session->set_userdata( $sessiondata );

		redirect( '/admin/login', 'refresh' );
	}

	public function register()
	{
		$bannerData['loginText'] = $this->viewhelpers->loginText();

		$data['title'] = "Annotated.io - Register";
		$data['banner'] = $this->load->view( 'parts/banner', $bannerData, TRUE );
		$data['content'] = $this->load->view( 'parts/register', NULL, TRUE );

		$this->load->view( 'base', $data );
	}

	public function forgot()
	{
		$bannerData['loginText'] = $this->viewhelpers->loginText();

		$data['title'] = "Annotated.io - Forgot Password";
		$data['banner'] = $this->load->view( 'parts/banner', $banerData, TRUE );
		$data['content'] = $this->load->view( 'parts/forgot', NULL, TRUE );
	
		$this->load->view( 'base', $data );
	}
}
