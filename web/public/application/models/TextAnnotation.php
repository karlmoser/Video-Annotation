<?php

/**
 * @author Zach Sherman <shermaza@oregonstate.edu>
 */

class TextAnnotation extends CI_Model {

    /*
    | -------------------------------------------------------------------
    | Public Class Variables (Properties)
    | -------------------------------------------------------------------
    */

    public $id;
    public $annotation;
    public $text;

    function __construct()
    {
        parent::__construct();

        //Assign default values
        $this->id = -1;
        $this->annotation = NULL;
        $this->text = NULL;
    }

    /*
    | -------------------------------------------------------------------
    | Static Class Functions
    | -------------------------------------------------------------------
    */

    public static function init( $_id )
    {
        $annotation = new TextAnnotation();
        $annotation->get( $_id );
        return $annotation;
    }

    /**
     * @brief Generates the all of the overlay annotations based on video
     * @return an array of objects in overlay form
     */
    public static function getOverlayArrayByVideo( $_video_id )
    {
        $CI =& get_instance();

        $CI->load->model('Video');
        $video = Video::init( $_video_id );

        $sql = 'SELECT *
                FROM annotations_text at
                JOIN annotations a ON a.id = at.annotation_id
                WHERE a.video_id = ?';

        $params = array( $video->id );
        $query = $CI->db->query( $sql, $params );

        $overlayArray = array();
        foreach ($query->result() as $result) {
            $item = new stdClass();
            $item->content  = $result->text;
            $item->start    = (double) $result->start_time;
            $item->end      = (double) $result->end_time;
            $item->align = $result->position;

            array_push( $overlayArray, $item );
        }

        return $overlayArray;
    }

    /*
    | -------------------------------------------------------------------
    | Public Methods
    | -------------------------------------------------------------------
    */

    public function get( $_id )
    {
        $this->load->model('Annotation');
        $sql = 'SELECT *
                FROM annotations_text
                WHERE id = ?';

        $params = array($_id);

        $query = $this->db->query($sql, $params);
        $result = $query->result();

        $this->id               = (int) $result[0]->id;
        $this->annotation       = Annotation::init($result[0]->annotation_id);
        $this->text             = $result[0]->text;
    }

    public function save()
    {
        /* Two cases - The annotation already exists, or it doesn't */

        // Doesn't exist yet -- Insert it
        if( $this->id == -1 )
        {
            $sql = 'INSERT INTO annotations_text (annotation_id, text)
                    VALUES (?, ?);';
            $params = array( $this->annotation->id, $this->text );
            $query = $this->db->query( $sql, $params );
        }

        // Already exists -- Update it
        else 
        {
            $sql = 'UPDATE annotations_text
                    SET annotation_id = ?, text = ?
                    WHERE id = ?';
            $params = array( $this->annotation->id, $this->text, $this->id );
            $query = $this->db->query( $sql, $params );
        }
    }

    public function delete()
    {
        /* Delete the base annotation */
        $sql = 'DELETE FROM annotations
                WHERE id = ?';
        $params = array($this->annotation->id);
        $query = $this->db->query($sql,$params);

        /* Delete the text annotation */
        $sql = 'DELETE FROM annotations_text
                WHERE id = ?';
        $params = array($this->id);
        $query = $this->db->query($sql,$params);
    }
}