<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videos extends CI_Controller {

	public function index()
	{
		$this->main();
	}

	public function upload()
	{
		$this->viewhelpers->forceLoggedIn();

		$this->load->model('User');
		$this->load->model('Video');

		$user = User::init($this->session->userdata('id'));

		$friendsNavData['following'] = $user->followingList();
		$contentData['friendsNav'] = $this->load->view( 'parts/friendsNav', $friendsNavData, TRUE );

		$videoNavData['user'] = $user;
		$contentData['videoNav'] = $this->load->view( 'parts/videoNav', $videoNavData, TRUE );

		$videos = Video::getTestVideos();
		$contentData['videos'] = $videos;

		$bannerData['loginText'] = $this->viewhelpers->loginText();

		$data['title'] = "Annotated.io - Upload Video";
		$data['banner'] = $this->load->view( 'parts/banner', $bannerData, TRUE );
		$data['content'] = $this->load->view( 'parts/upload', $contentData, TRUE );

		$this->load->view( 'base', $data );
	}

	public function main()
	{
		$this->viewhelpers->forceLoggedIn();

		$this->load->model('user');
		$this->load->model('video');

		$user = User::init($this->session->userdata('id'));

		$friendsNavData['following'] = $user->followingList();
		$contentData['friendsNav'] = $this->load->view( 'parts/friendsNav', $friendsNavData, TRUE );

		$videoNavData['user'] = $user;
		$contentData['videoNav'] = $this->load->view( 'parts/videoNav', $videoNavData, TRUE );

		$videos = Video::getUserVideos();
		$contentData['videos'] = $videos;

		$bannerData['loginText'] = $this->viewhelpers->loginText();

		$data['title'] = "Annotated.io - Videos";
		$data['banner'] = $this->load->view( 'parts/banner', $bannerData, TRUE );
		$data['content'] = $this->load->view( 'parts/main', $contentData, TRUE );

		$this->load->view( 'base', $data );
	}

	public function top()
	{
		$this->viewhelpers->forceLoggedIn();

		$this->load->model('User');
		$this->load->model('Video');

		$user = User::init($this->session->userdata('id'));

		$friendsNavData['following'] = $user->followingList();
		$contentData['friendsNav'] = $this->load->view( 'parts/friendsNav', $friendsNavData, TRUE );

		$videoNavData['user'] = $user;
		$contentData['videoNav'] = $this->load->view( 'parts/videoNav', $videoNavData, TRUE );

		$videos = Video::getTestVideos();
		$contentData['videos'] = $videos;

		$bannerData['loginText'] = $this->viewhelpers->loginText();

		$data['title'] = "Annotated.io - Videos";
		$data['banner'] = $this->load->view( 'parts/banner', $bannerData, TRUE );
		$data['content'] = $this->load->view( 'parts/main', $contentData, TRUE );

		$this->load->view( 'base', $data );
	}

	public function single( $_id )
	{
		$this->load->model('Annotation');

		$this->viewhelpers->forceLoggedIn();

		$this->load->model('user');
		$this->load->model('video');

		$video = Video::init( $_id );
		$singleVideoData['video'] = $video;
		$singleVideoData['overlays'] = Annotation::getOverlaysByVideo( $video->id );
		$singleVideoData['user'] = User::init($video->creator);
		$singleVideoData['annotations'] = $video->textAnnotations();
		$singleVideoData['description'] = $video->description;

		$bannerData['loginText'] = $this->viewhelpers->loginText();

		$data['title'] = "Annotated.io - " . $video->title;
		$data['banner'] = $this->load->view( 'parts/banner', $bannerData, TRUE );
		$data['content'] = $this->load->view( 'parts/singleVideo', $singleVideoData, TRUE );

		$this->load->view( 'base', $data );
	}
}
