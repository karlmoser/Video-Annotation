<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends CI_Controller {

	public function index()
	{
		
	}

	public function register()
	{
		$this->load->helper('url');
		$this->load->model('User');
		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			echo '{error:1, msg:"Invalid Request Method"}';
		}
		   
		else if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$email 		= $this->input->post('email');
			$username 	= $this->input->post('username');
			$password 	= $this->input->post('password');
			$password2 	= $this->input->post('password2');



			if ( $email == FALSE || $username == FALSE || $password == FALSE || $password2 == FALSE )
			{
				redirect( '/admin/register?error=missingarguments', 'refresh' );
			} 

			else 
			{
				//Does a user already exist in the database with these credentials?
				$sql = 'SELECT *
						FROM users
						WHERE username = ?
						OR email = ?;';

				$params = array( $username, $email );
				$query = $this->db->query( $sql, $params );

				if( $query->num_rows() > 0 )
				{
					$error = array( 'error' => "Duplicate credentials, please try registering again with different credentials." );
					$this->load->view( 'parts/error', $error );
				}

				// Do the passwords match?
				else if( $password != $password2 )
				{
					$error = array( 'error' => "Your passwords didn't match, please try again." );
					$this->load->view( 'parts/error', $error );
				}

				// If no duplicate user and passwords match, add the user to the database
				else {
					$user = new User();
					$user->email = $email;
					$user->username = $username;
					$user->password = $password;

					$user->save();
					redirect( '/videos', 'refresh' );
				}
			}
		}
	}

	public function setProfilePicture()
	{
		/* Only POST methods work here */
		if($this->input->server('REQUEST_METHOD') == 'GET')
		{
			$error = array( 'error' => "Please use POST for forms!" );
			$this->load->view( 'parts/error', $error );
		}

		else if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$this->load->model( 'user' );
			$config['upload_path'] = './uploads/profile_pictures';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '1000';
			$config['max_width'] = '4096';
			$config['max_height'] = '4096';
			$config['file_name'] = $this->session->userdata('username');

			// BUG: Can't overwrite and throws an error.
			// $config['overwrite'] = TRUE;

			$this->load->library( 'upload', $config );

			if( !$this->upload->do_upload())
			{
				$error = array( 'error' => $this->upload->display_errors() );
				$this->load->view( 'parts/error', $error );
			}

			else
			{
				$data = array( 'upload_data' => $this->upload->data() );
				// var_dump($this->upload->data()); die;
				$user = User::init($this->session->userdata('id'));
				$user->profile_picture = '/uploads/profile_pictures/' . $config['file_name'];
				$user->save();

				redirect( '/admin/account', 'refresh' );
			}
		}
	}

	public function login()
	{
		$this->load->helper('url');
		$this->load->model('User');

		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			echo '{error:1, msg:"Invalid Request Method"}';
		}
		   
		else if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$username 	= $this->input->post('username');
			$password 	= $this->input->post('password');

			// Make sure the parameters exist
			if ( $username == FALSE || $password == FALSE )
			{
				$error = array( 'error' => "Please supply both a username and password!" );
				$this->load->view( 'parts/error', $error );
				return;
			}

			else
			{
				$sql = "SELECT *
						FROM users
						WHERE username = ?";
				$params = array($username);
				$query = $this->db->query( $sql, $params );

				if( $query->num_rows() == 0 )
				{
					$error = array( 'error' => "Invalid credentials. Please try logging in again." );
					$this->load->view( 'parts/error', $error );
					return;
				} 

				else
				{
					$result = $query->result();
					$result = $result[0];

					//If the credentials are correct, set the session data.
					if( $result->password == $password )
					{
						$sessiondata = array(
												"username"	=>	$username,
												"email"		=>	$result->email,
												"id"		=>	$result->id,
												"loggedin"	=>	TRUE
											);

						$this->session->set_userdata( $sessiondata );
						redirect( '/videos', 'refresh' );
					}

					//Otherwise, it's an error.
					else 
					{
						$error = array( 'error' => "Invalid credentials!" );
						$this->load->view( 'parts/error', $error );
					}
				}
			}
		}
	}

	public function changePassword()
	{
		$this->load->helper('url');
		$this->load->model('User');
		if ($this->input->server('REQUEST_METHOD') == 'GET')
		{
			echo '{error:1, msg:"Invalid Request Method"}';
		}
		   
		else if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$old_password 	= $this->input->post('old_password');
			$new_password 	= $this->input->post('new_password');
			$new_password2 	= $this->input->post('new_password2');

			if ( $old_password == FALSE || $new_password == FALSE || $new_password2 == FALSE )
			{
				redirect( '/admin/account?error=missingarguments', 'refresh' );
			} 

			else 
			{
				//Retrieve the current user
				$user = User::init($this->session->userdata('id'));

				//Do the old passwords match?
				if( $user->password != $old_password )
				{
					$error = array( 'error' => "Your old passwords didn't match, please try again." );
					$this->load->view( 'parts/error', $error );
					return;
				}

				// Do the new passwords match?
				else if( $new_password != $new_password2 )
				{
					$error = array( 'error' => "Your new passwords didn't match, please try again." );
					$this->load->view( 'parts/error', $error );
					return;
				}

				// If the passwords match, change the user's password.
				else {
					$user->password = $new_password;
					$user->save();

					redirect( '/admin/account', 'refresh' );
				}
			}
		}
	}

	public function uploadVideo()
	{
		/* Only POST methods work here */
		if($this->input->server('REQUEST_METHOD') == 'GET')
		{
			$error = array( 'error' => "Please use POST for forms!" );
			$this->load->view( 'parts/error', $error );
		}

		else if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$title 			= $this->input->post('title');
			$description 	= $this->input->post('description');
			$permissions	= $this->input->post('permissions');

			$filename = strtolower( str_replace( " ", "", $title ) );
			$filename = preg_replace('/[^a-zA-Z0-9]/s', '', $filename);

			$this->load->model( 'user' );
			$config['upload_path'] = './uploads/videos';
			$config['allowed_types'] = 'mp4|ogg|webm';
			$config['file_name'] = $filename;

			$this->load->library( 'upload', $config );

			if( !$this->upload->do_upload())
			{
				$error = array( 'error' => $this->upload->display_errors() );
				$this->load->view( 'parts/error', $error );
			}

			else
			{
				$data = array( 'upload_data' => $this->upload->data() );
				$uploadData = $this->upload->data();

				// var_dump($uploadData); die;
				
				//Save video location and metadata to database
				$this->load->model( 'video' );
				$video = new Video();
				$video->title 		= $title;
				$video->description = $description;
				$video->permissions = $permissions;
				$video->src 		= "/uploads/videos/" . $filename;
				$video->creator 	= $this->session->userdata('id');
				$video->type 		= $uploadData['file_type'];

				$video->save();

				redirect( '/videos', 'refresh' );
			}
		}
	}
}
