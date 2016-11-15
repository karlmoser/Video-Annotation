<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function index()
	{
		$this->main();
	}

	public function profile( $_username )
	{
		$this->viewhelpers->forceLoggedIn();

		$this->load->model('User');
		$this->load->model('Video');

		$user = new User();
		$user->getByUsername( $_username );

		$curUser = User::init( $this->session->userdata('id') );

		$contentData['user'] = $user;
		$bannerData['loginText'] = $this->viewhelpers->loginText();

		$videos = Video::getPublicUserVideos($user->id);
		$contentData['videos'] = $videos;

		// If the current logged in user is already following the user, display a disabled "Following" icon
		// If the current logged in user isn't following the user, display a "Follow" button
		if( $curUser->following( $user->id ) )
		{
			$following = "<script> var following = true; var self = false; </script>";
		}
		else
		{
			$following = "<script> var following = false; var self = false; </script>";
		}

		//You should not be able to follow yourself
		if( $curUser->id == $user->id )
		{
			$following = "<script> var following = false; var self = true; </script>";
		}

		$contentData['following'] = $following;

		$data['title'] = "Annotated.io - " . $_username;
		$data['banner'] = $this->load->view( 'parts/banner', $bannerData, TRUE );
		$data['content'] = $this->load->view( 'parts/profile', $contentData, TRUE );
		$this->load->view( 'base', $data );
	}

	public function annotations( $_username )
	{
		$this->viewhelpers->forceLoggedIn();

		$this->load->model('User');
		$this->load->model('Annotation');
		$this->load->model('Video');

		$user = new User();
		$user->getByUsername( $_username );

		$contentData['user'] = $user;
		$bannerData['loginText'] = $this->viewhelpers->loginText();

		$annotations = $user->annotations();
		$contentData['annotations'] = $annotations;

		$data['title'] = "Annotated.io - " . $_username . "'s Annotations";
		$data['banner'] = $this->load->view( 'parts/banner', $bannerData, TRUE );
		$data['content'] = $this->load->view( 'parts/annotations', $contentData, True );
		$this->load->view( 'base', $data );
	}
}
