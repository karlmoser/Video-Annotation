<?php

/**
 * @author Zach Sherman <shermaza@oregonstate.edu>
 */

class Video extends CI_Model {

	/*
	| -------------------------------------------------------------------
	| Public Class Variables (Properties)
	| -------------------------------------------------------------------
	*/

	public $id;
	public $creator;
    public $title;
    public $description;
    public $src;
    public $type;
    public $permissions;
    public $thumbnail;

    function __construct()
    {
        parent::__construct();

        //Assign default values
        $this->id = -1;
        $this->title = "Video Title";
        $this->creator = -1;
        $this->description = "Video Description";
        $this->src = "/uploads/videos/defaultvideo.mp4";
        $this->thumbnail = "/img/default-video.png";
        $this->permissions = "private";
        $this->type = "video/mpeg";
    }

    /*
	| -------------------------------------------------------------------
	| Static Class Functions
	| -------------------------------------------------------------------
	*/

    public static function getTestVideos()
    {
        $videos = [];
        for ($i=0; $i < 10; $i++) { 
            $video = new Video();
            array_push($videos, $video);
        }

        return $videos;
    }

    public static function getUserVideos()
    {
        $CI =& get_instance();
        $sql = 'SELECT *
                FROM videos
                WHERE creator = ?';

        $params = array($CI->session->userdata('id'));
        $query = $CI->db->query( $sql, $params );

        return $query->result();
    }

    public static function getPublicUserVideos( $_id )
    {
        $CI =& get_instance();
        $sql = 'SELECT *
                FROM videos
                WHERE creator = ?
                AND permissions = "public";';

        $params = array( $_id );
        $query = $CI->db->query( $sql, $params );

        return $query->result();
    }

    public function get( $_id )
    {
        $sql = 'SELECT *
                FROM videos
                WHERE id = ?';

        $params = array($_id);

        $query = $this->db->query($sql, $params);
        $result = $query->result();

        $this->id               = (int) $result[0]->id;
        $this->creator          = (int) $result[0]->creator;
        $this->title            = $result[0]->title;
        $this->description      = $result[0]->description;
        $this->src              = $result[0]->src;
        $this->thumbnail        = $result[0]->thumbnail;
        $this->permissions      = $result[0]->permissions;
        $this->type             = $result[0]->type;
    }

    public static function init( $_id )
    {
        $video = new Video();
        $video->get( $_id );
        return $video;
    }

    /*
    | -------------------------------------------------------------------
    | Public Class Methods
    | -------------------------------------------------------------------
    */
    public function save()
    {
        /* Two cases - The video already exists, or it doesn't */

        // Doesn't exist yet -- Insert it
        if( $this->id == -1 )
        {
            $sql = 'INSERT INTO videos (creator, title, description, src, thumbnail, permissions, type)
                    VALUES (?, ?, ?, ?, ?, ?, ?);';
            $params = array( $this->creator, $this->title, $this->description, $this->src, $this->thumbnail, $this->permissions, $this->type );
            $query = $this->db->query( $sql, $params );
        }

        // Already exists -- Update it
        else 
        {
            $sql = 'UPDATE videos
                    SET creator=?, title=?, description=?, src=?, thumbnail=?, permissions=?, type=?
                    WHERE id = ?';
            $params = array( $this->creator, $this->title, $this->description, $this->src, $this->thumbnail, $this->permissions, $this->id );
            $query = $this->db->query( $sql, $params );
        }
    }

    public function textAnnotations(){
        $this->load->model('TextAnnotation');
        $sql = 'SELECT *
                FROM annotations
                JOIN annotations_text ON annotations.id = annotations_text.annotation_id
                WHERE annotations.video_id = ?
                ORDER BY annotations.start_time;';
        $params = array($this->id);
        $query = $this->db->query($sql, $params);

        $return = array();
        foreach ($query->result() as $result) {
            $text_annotation = TextAnnotation::init($result->id);
            array_push($return, $text_annotation);
        }

        return $return;
    }
}