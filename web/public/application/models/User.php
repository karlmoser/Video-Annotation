<?php

/**
 * @author Zach Sherman <shermaza@oregonstate.edu>
 */

class User extends CI_Model {

	/*
	| -------------------------------------------------------------------
	| Public Class Variables (Properties)
	| -------------------------------------------------------------------
	*/

	public $id;
	public $username;
	public $password;
	public $email;
    public $profile_picture;

    function __construct()
    {
        parent::__construct();

        //Assign default values
        $this->id = -1;
        $this->username = 'username';
        $this->password = 'password';
        $this->email = 'email';
        $this->profile_picture = '/img/default-profile.png';
    }

    /*
    | -------------------------------------------------------------------
    | Public Methods
    | -------------------------------------------------------------------
    */

    public function get( $_id )
    {
        $sql = 'SELECT *
                FROM users
                WHERE id = ?';

        $params = array($_id);

        $query = $this->db->query($sql, $params);

        $result = $query->result();

        $this->id               = (int) $result[0]->id;
        $this->username         = $result[0]->username;
        $this->password         = $result[0]->password;
        $this->email            = $result[0]->email;
        $this->profile_picture  = $result[0]->profile_picture;
    }

    /**
     * Is the user following another user?
     */
    public function following( $_id )
    {
        $sql = 'SELECT id
                FROM followers
                WHERE user = ?
                AND following = ?;';
        $params = array( $this->id, $_id );
        $query = $this->db->query( $sql, $params );

        return $query->num_rows() > 0 ? TRUE : FALSE;
    }

    /**
     * Follow another user
     */
    public function follow( $_id )
    {
        if( $this->following( $_id ))
        {
            //No point in creating another one...
        }
        else
        {
            $sql = 'INSERT INTO followers (user, following)
                    VALUES (?, ?);';
            $params = array( $this->id, $_id );
            $query = $this->db->query( $sql, $params );
        }
    }

    /**
     * Unfollow another user
     */
    public function unfollow( $_id )
    {
        if( $this->following( $_id ))
        {
            $sql = 'DELETE FROM followers
                    WHERE user = ? AND following = ?';
            $params = array( $this->id, $_id );
            $query = $this->db->query( $sql, $params );
        }
        else
        {
            //One does not simply unfollow that which is not followed
        }
    }

    /**
     * @brief get a list of this user's followers
     * @return [description]
     */
    public function followersList()
    {
        $sql = 'SELECT user
                FROM followers
                WHERE user = ?;';
        $params = array( $this->id );
        $query = $this->db->query( $sql, $params );

        $returnArray = array();
        foreach( $query->result() as $_user)
        {
            $user = User::init( $_user->user );
            array_push( $returnArray, $user );
        }

        return $returnArray;
    }

    /**
     * @brief get a list of the user's annotations
     */
    public function annotations()
    {

        $this->load->model('TextAnnotation');

        $sql = '-- Select all the annotations for a specific user
                SELECT atx.id
                FROM annotations a
                JOIN annotations_text atx ON atx.annotation_id = a.id
                WHERE a.user_id = ?;';
        $params = array( $this->id );
        $query = $this->db->query( $sql, $params );

        $returnArray = array();
        foreach( $query->result() as $_annotation)
        {
            $annotation = TextAnnotation::init($_annotation->id);
            array_push( $returnArray, $annotation );
        }

        return $returnArray;
    }

    public function followersCount()
    {
        $sql = 'SELECT user
                FROM followers
                WHERE user = ?;';
        $params = array( $this->id );
        $query = $this->db->query( $sql, $params );

        return $query->num_rows();
    }

    /**
     * @brief get a list of who this user is following
     * @return [description]
     */
    public function followingList()
    {
        $sql = 'SELECT following
                FROM followers
                WHERE user = ?;';
        $params = array( $this->id );
        $query = $this->db->query( $sql, $params );

        $returnArray = array();
        foreach( $query->result() as $_user)
        {
            $user = User::init( $_user->following );
            array_push( $returnArray, $user );
        }

        return $returnArray;
    }

    public function followingCount()
    {
        $sql = 'SELECT following
                FROM followers
                WHERE user = ?;';
        $params = array( $this->id );
        $query = $this->db->query( $sql, $params );

        return $query->num_rows();
    }

    /*
    | -------------------------------------------------------------------
    | Static Class Functions
    | -------------------------------------------------------------------
    */

    public static function init( $_id )
    {
        $user = new User();
        $user->get($_id);
        return $user;
    }

    public static function initByUsername( $_username )
    {
        $user = new User();
        $user->getByUsername( $_username );
        return $user;
    }

    public function save()
    {
        // Retrieve the user from the database for updating
    	$sql = 'SELECT *
                FROM users
                WHERE username = ?';

        $params = array( $this->username );
        $query = $this->db->query( $sql, $params );

        //If the user already exists, update it.
        if( $query->num_rows() > 0 )
        {
            $result = $query->result();
            $id = $result[0]->id;

            $sql = 'UPDATE users
                    SET username=?,email=?,password=?,profile_picture=?
                    WHERE id = ?';
            $params = array( $this->username, $this->email, $this->password, $this->profile_picture, $id );
            $query = $this->db->query( $sql, $params );
        }

        // Otherwise the user doesn't exist, and we need to create it.
        else 
        {
            $sql = 'INSERT INTO users (username, email, password, profile_picture)
                    VALUES (?, ?, ?, ?);';
            $params = array( $this->username, $this->email, $this->password, $this->profile_picture );
            $query = $this->db->query( $sql, $params );
        }
    }

    public function getByUsername( $_username )
    {
        $sql = 'SELECT *
                FROM users
                where username = ?';

        $params = array($_username);
        $query = $this->db->query( $sql, $params );
        $result = $query->result();

        $this->id               = (int) $result[0]->id;
        $this->username         = $result[0]->username;
        $this->password         = $result[0]->password;
        $this->email            = $result[0]->email;
        $this->profile_picture  = $result[0]->profile_picture;
    }

    public static function getTestUsers()
    {
        /*
            TEST DATA!!
            TODO: Replace with SQL seed data for test development
        */
        $friends = [];
        $names = ['Zita','Yong','Codi','Shon','Austin','Briana','Marin','Cecily','Helga','Inez'];
        for ($i=0; $i < 10; $i++) { 
            $friend = new User();
            $friend->username = $names[$i];
            $friend->profile_picture = "/img/default-profile.png";
            array_push($friends, $friend);
        }
        
        return $friends;
    }

    public static function getTestUser()
    {
        /*
            "Test" user
        */
        $user = new User();
        $user->username = "Username";
        $user->profile_picture = "/img/default-profile.png";
        return $user;
    }
}