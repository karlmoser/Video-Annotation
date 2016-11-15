<?php

/**
 * @author Zach Sherman <shermaza@oregonstate.edu>
 */

class Message extends CI_Model {

    /*
    | -------------------------------------------------------------------
    | Public Class Variables (Properties)
    | -------------------------------------------------------------------
    */

    public $id;
    public $recipient;
    public $sender;
    public $annotation;

    function __construct()
    {
        parent::__construct();

        //Assign default values
        $this->id = -1;
        $this->recipient = NULL;
        $this->sender = NULL;
        $this->annotation = NULL;
    }

    /*
    | -------------------------------------------------------------------
    | Static Class Functions
    | -------------------------------------------------------------------
    */

    public static function init( $_id )
    {
        $message = new Message();
        $message->get( $_id );
        return $message;
    }

    public static function getAll( $_user )
    {
        $CI =& get_instance();
        $CI->load->model('User');

        $sql = 'SELECT m.id
                FROM messages m
                WHERE m.recipient = ?';

        $user = User::init($_user);
        $params = array($user->id);

        $query = $CI->db->query( $sql, $params );


        $messages = array();
        foreach ($query->result() as $message) {
            $m = Message::init($message->id);
            array_push($messages, $m);
        }

        return $messages;
    }


    /*
    | -------------------------------------------------------------------
    | Public Methods
    | -------------------------------------------------------------------
    */

    public function get( $_id )
    {
        $this->load->model('User');
        $this->load->model('TextAnnotation');

        $sql = 'SELECT *
                FROM messages
                WHERE id = ?';

        $params = array( $_id );
        $query = $this->db->query( $sql, $params );

        $results = $query->result();
        $result = $results[0];
        $this->id = $_id;
        $this->recipient = User::init($result->recipient);
        $this->sender = User::init($result->sender);
        $this->annotation = TextAnnotation::init($result->annotation);
    }

    public function save()
    {
        /* Two cases - The message already exists, or it doesn't */

        // Doesn't exist yet -- Insert it
        if( $this->id == -1 )
        {
            $sql = 'INSERT INTO messages (recipient, sender, annotation)
                    VALUES (?, ?, ?);';
            $params = array( $this->recipient, $this->sender, $this->annotation );
            $query = $this->db->query( $sql, $params );
        }

        // Already exists -- Update it
        else 
        {
            $sql = 'UPDATE messages
                    SET recipient = ?, sender = ?, annotation = ?
                    WHERE id = ?';
            $params = array( $this->id, $this->recipient->id, $this->sender->id, $this->annotation->id );
            $query = $this->db->query( $sql, $params );
        }
    }

    public function delete()
    {
        
    }
}