<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->login();
	}
	public function members()
	{
		if($this->session->userdata('is_logged_in'))
		{
			$this->load->view("members");
		}
		else
		{
			redirect('main/restricted');
		}
	}
	public function restricted(){
		$this->load->view("restricted");
	}
	public function login(){
		$this->load->view('login');
	}
	public function signup(){
		$this->load->view('signup');
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('main/login');
	}
	public function login_validation(){
		$this->load->library("form_validation");
		$this->form_validation->set_rules("email","Email","required|trim|callback_validate_credentials");
		$this->form_validation->set_rules("password","Password","required|md5|trim");
		if($this->form_validation->run()){
			$data = array(
				'email' => $this->input->post('email'),
				'is_logged_in' => 1
				);
			$this->session->set_userdata($data);
			redirect("main/members");
		}else{
			$this->load->view('login');
		}

	}
	public function signup_validation(){
		$this->load->library("form_validation");
		$this->form_validation->set_rules("email","Email","required|trim|valid_email|is_unique[user.email]");
		$this->form_validation->set_rules("password","Password","required|trim");
		$this->form_validation->set_rules("cpassword","Password","required|trim|matches[password]");
		$this->form_validation->set_message("is_unique","This email address is already exsists");
		if($this->form_validation->run()){
			$key = md5(uniqid());
			$emailConfig = array(
	
  'mailtype' => 'html',
  
				);
			$this->load->library("email",$emailConfig);
			$this->email->from("ivan@myweb.com","Ivan");
			$this->email->to($this->input->post("email"));
			$this->email->subject("Confirm your account");

			$message = "<p>Thank your for signing up!</p>";
			$message = "<p><a href = '".base_url()."main/register_user/$key'>Click Here</a> to confirm your account</p>";
			$this->email->message($message);
			if($this->email->send()){
				echo "The email has been sent";
			}
			else
			{
				show_error($this->email->print_debugger());
			}
		}else{
			echo "not pass";
			$this->load->view('signup');
		}

	}

	public function validate_credentials(){
		$this->load->model('model_users');
		if($this->model_users->can_log_in()){
			return true;

		}
		else
		{
			$this->form_validation->set_message("validate_credentials","Incorrect username/password");
			return false;
		}
	}

}
