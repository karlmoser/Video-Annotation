<?php

/**
 * @author Zach Sherman <shermaza@oregonstate.edu>
 */

class Annotation extends CI_Model {

	/*
	| -------------------------------------------------------------------
	| Public Class Variables (Properties)
	| -------------------------------------------------------------------
	*/

	public $id;
	public $video;
    public $user;
    public $start_time;
    public $end_time;
    public $position;

    function __construct()
    {
        parent::__construct();

        //Assign default values
        $this->id = -1;
        $this->video = NULL;
        $this->user = NULL;
        $this->start_time = 0;
        $this->end_time= 0;
        $this->position = 'top-left';
    }

    /*
	| -------------------------------------------------------------------
	| Static Class Functions
	| -------------------------------------------------------------------
	*/

    public static function init( $_id )
    {
        $annotation = new Annotation();
        $annotation->get( $_id );
        return $annotation;
    }

    public static function getOverlaysByVideo( $_video_id )
    {
        $CI =& get_instance();

        $CI->load->model('Video');
        $video = Video::init( $_video_id );

        /* In the future, other annotation types can be merged together and then json encoded. */
        $CI->load->model('TextAnnotation');
        $textAnnotations = TextAnnotation::getOverlayArrayByVideo( $_video_id );
        $annotations = array_merge( $textAnnotations );
        return json_encode($annotations);
    }

    /*
	| -------------------------------------------------------------------
	| Public Methods
	| -------------------------------------------------------------------
	*/

    public function get( $_id )
    {
        $this->load->model('User');
        $this->load->model('Video');
        
        $sql = 'SELECT *
                FROM annotations
                WHERE id = ?';

        $params = array($_id);

        $query = $this->db->query($sql, $params);
        $result = $query->result();

        $this->id            = (int) $result[0]->id;
        $this->video         = Video::init($result[0]->video_id);
        $this->user          = User::init($result[0]->user_id);
        $this->start_time    = (double) $result[0]->start_time;
        $this->end_time      = (double) $result[0]->end_time;
        $this->position      = $result[0]->position;
    }

    public function save()
    {
    	/* Two cases - The annotation already exists, or it doesn't */

        // Doesn't exist yet -- Insert it
        if( $this->id == -1 )
        {
            $sql = 'INSERT INTO annotations (video_id, user_id, start_time, end_time, position)
                    VALUES (?, ?, ?, ?, ?);';
            $params = array( $this->video->id, $this->user->id, $this->start_time, $this->end_time, $this->position );
            $query = $this->db->query( $sql, $params );

            return $this->db->insert_id();
        }

        // Already exists -- Update it
        else 
        {
            $sql = 'UPDATE videos
                    SET video_id = ?, user_id = ?, start_time = ?, end_time = ?, position = ?
                    WHERE id = ?';
            $params = array( $this->video->id, $this->user->id, $this->start_time, $this->end_time, $this->position, $this->id );
            $query = $this->db->query( $sql, $params );

            return $this->id;
        }
    }
}