<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class API extends CI_Controller {

	public function index()
	{
		
	}

	/**
	 * @brief Create and save a text annotation
	 * @details
	 *		String text - the text of the annotation
	 *		double start - the start time for the annotation
	 *		double end - the end time for the annotation
	 *		int video_id - the integer key for the video
	 *		string username - the username for the user annotating the video
	 * @return [description]
	 */
	public function annotateText()
	{
		$text 		= $this->input->post('text');
		$start 		= (double) $this->input->post('start');
		$end 		= (double) $this->input->post('end');
		$video_id 	= (int) $this->input->post('video_id');
		$user_id 	= $this->input->post('user_id');
		$position   = $this->input->post('position');

		//Check that all required input is present
		if( !$text || !$start || !$end || !$video_id || !$username || !$position )
		{
			$error = array( 'error' => "Missing or invalid parameters." );
			$this->load->view( 'parts/error', $error );
		}

		//Create a new annotation and text annotation model
		$this->load->model('Annotation');
		$this->load->model('TextAnnotation');
		$this->load->model('User');
		$this->load->model('Video');

		$annotation = new Annotation();
		$textAnnotation = new TextAnnotation();

		//Populate the new models
		$annotation->video 		= Video::init($video_id);
		$annotation->user    	= User::init($user_id);
		$annotation->start_time = $start;
		$annotation->end_time 	= $end;
		$annotation->position 	= $position;

		$annotationID = $annotation->save();

		$textAnnotation->annotation = Annotation::init($annotationID);
		$textAnnotation->text = $text;

		$annotation->save();
		$textAnnotation->save();
	}

	public function deleteAnnotation()
	{
		$id = $this->input->post('id');

		if( !$id )
		{
			$error = array('error' => 'Missing or invalid parameters.');
			$this->load->view( 'parts/error', $error );
		}

		$this->load->model('TextAnnotation');

		$TA = TextAnnotation::init( $id );

		$TA->delete();
	}

	public function getAnnotations()
	{
		$video_id = $this->input->post('video_id');

		if( !$video_id )
		{
			$error = array('error' => 'Missing or invalid parameters.');
			$this->load->view( 'parts/error', $error );
		}

		$this->load->model('Video');
		$video = Video::init($video_id);
		echo json_encode( $video->textAnnotations() );
	}

	//Return 1 if success
	//Return 0 if failure
	public function shareAnnotation()
	{
		$this->load->model('Message');
		$this->load->model('User');

		$annotation = (int) $this->input->post('_text_annotation');
		$to = $this->input->post('_to');
		$from = $this->input->post('_from');

		$to = User::initByUsername($to);
		$from = User::initByUsername($from);

		$message = new Message();
		$message->recipient = $to->id;
		$message->sender = $from->id;
		$message->annotation = $annotation;

		$message->save();

		echo 1;
	}


	/**
	 * @brief Follow a user
	 * 
	 * @input 
	 * 			int follower - the id of the calling user
	 * 			int user - the id of the person being followed
	 * 			
	 * @return 
	 */
	public function follow()
	{
		$this->load->model('User');

		$_follower = $this->input->post('follower');
		$_user = $this->input->post('user');

		$follower = User::init( $_follower );
		$user = User::init( $_user );

		$follower->follow( $user->id );
	}

	/**
	 * @brief Unollow a user
	 * 
	 * @input 
	 * 			int follower - the id of the calling user
	 * 			int user - the id of the person being followed
	 * 			
	 * @return 
	 */
	public function unfollow()
	{
		$this->load->model('User');

		$_follower = $this->input->post('follower');
		$_user = $this->input->post('user');

		$follower = User::init( $_follower );
		$user = User::init( $_user );

		$follower->unfollow( $user->id );
	}

	public function following()
	{
		
	}
}
