<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Books extends CI_Controller {

	public function __construct()
	{
		//$this->load->model('Bookdb');
		date_default_timezone_set('America/Los_Angeles');
		parent::__construct();
		//$this->output->enable_profiler();
	}
	public function index()
	{
		$this->load->view('book');
	}
	public function users($id)
	{
		$this->load->view('users');
	}
	public function view()
	{
		$this->load->view('books');
	}
	public function add()
	{
		$this->load->view('add');
	}
	public function create()
	{
		$this->Bookdb->insert_book();
	}
	public function update()
	{
		$this->Bookdb->update();
		redirect('/books/book/' . $this->input->post('book_id'));
	}
	public function delete($id)
	{
		$this->db->delete('reviews', array('id' => $id));
		if($this->session->flashdata('last_book'))
		{
			redirect("/books/book/" . $this->session->flashdata('last_book'));
		}
		else
		{
			$this->db->delete('books', array('id' => $this->session->flashdata('book')));
			redirect('/books/view');
		}
	}	
	public function book($id)
	{
		$bookid = array('id' => $id);
		$this->load->view('book', $bookid);
	}
	public function register()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]|valid_email');
		$this->form_validation->set_rules('alias', 'Alias', 'required|is_unique[users.alias]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
		$this->form_validation->set_rules('confirm', 'Password Confirmation', 'required|matches[password]');
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('index');
		}
		else
		{
			$this->Bookdb->insert_user();
			$this->Bookdb->set_id();
			redirect('/books/view');
		}
	}
	public function login()
	{
		$this->form_validation->set_rules('emaillogin', 'Email', 'required|callback_emaillogin_check');
		$this->form_validation->set_rules('passwordlogin', 'Password', 'required|callback_passwordlogin_check');
		$this->form_validation->set_message('emaillogin_check', 'Invalid Email. Try again.');
		$this->form_validation->set_message('passwordlogin_check', 'Incorrect Password.');
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('index');
		}
		else
		{
			$verified = $this->Bookdb->verify();
			if($verified)
			{
				redirect('/books/view');
			}
		}
	}
	public function logoff()
	{
		$this->session->sess_destroy();
		redirect('/');
	}
}

//end of books controller
