<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bookdb extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	public function insert_user()
	{
		$data = array(
	   'first_name' => $this->input->post('first_name') ,
	   'last_name' => $this->input->post('last_name') ,
	   'alias' => $this->input->post('alias'),
	   'email' => $this->input->post('email') ,
	   'password' => md5($this->input->post('password')) ,
	   'created_at' => date('Y-m-d h:i:s')
		);
		$this->db->insert('users', $data);
	}
	public function set_id()
	{
		$query = "SELECT * FROM users WHERE email = '" . $this->input->post('email') . "'";
		$user = $this->db->query($query);
		if($user->result())
		{
			foreach ($user->result() as $key) {
				foreach ($key as $id => $value) {
					if($id === 'id')
					{
						$usernum = $value;
					}
				}
			}
		}
		$this->session->set_userdata('user_id', $usernum);
	}
	public function verify()
	{
		$query = "SELECT * FROM users WHERE email = '" . $this->input->post('emaillogin') . "'";
		$user = $this->db->query($query);
		if($user->result())
		{
			foreach ($user->result() as $row)
			{
				$id = $row->id;
			    $email = $row->email;
			    $password = $row->password;
			}
			if(md5($this->input->post('passwordlogin')) == $password)
			{
				$this->session->set_userdata('user_id', $id);
				return true;
			}
			else
			{
				$error = array('pwerror' => 'Incorrect Password. Try again.<br>');
				$this->load->view('index', $error);
			}
		}
		else
		{
			$error = array('emailerror' => 'Email does not exist. Please use New Users form.<br>');
			$this->load->view('index', $error);
		}
	}
	public function user_info()
	{
		$query = "SELECT first_name, last_name, email, alias FROM users WHERE id = '" . $this->session->userdata('user_id') . "'";
		$user = $this->db->query($query);
		foreach ($user->result() as $row)
			{
			    $first_name = $row->first_name;
			    $last_name = $row->last_name;
			    $email = $row->email;
			    $alias = $row->alias;
			}
			return array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'alias' => $alias);
	}
	public function book_reviews()
	{
		$query = "SELECT DISTINCT name, book_id FROM reviews JOIN books ON books.id = reviews.book_id WHERE reviews.user_id ='" . $this->session->userdata('user_id') . "'";
		$temp = $this->db->query($query);
		$reviewed = [];
		foreach ($temp->result() as $key => $value) 
		{
			$reviewed[] = array($value->book_id => $value->name);			
		}
		return $reviewed;
	}
	public function book_count()
	{
		$query = "SELECT COUNT(reviews.user_id) as total FROM reviews JOIN books ON books.id = reviews.book_id WHERE reviews.user_id ='" . $this->session->userdata('user_id') . "'";
		$temp = $this->db->query($query);
		foreach ($temp->result() as $key => $value) 
		{
			$total = $value->total;
		}
		return $total;
	}
	public function review()
	{
		$query = "SELECT books.id as book, first_name, name, author, review, rating, reviews.created_at as date, users.id as id FROM reviews LEFT JOIN books ON reviews.book_id = books.id LEFT JOIN users ON reviews.user_id = users.id ORDER BY reviews.id DESC LIMIT 3";
		$books = $this->db->query($query);
		return $books->result();
	}
	public function book()
	{
		$query = "SELECT id, name, author FROM books";
		$books = $this->db->query($query);
		return $books;
	}
	public function update()
	{
		$data = array('review' => $this->input->post('review'), 'book_id' => $this->input->post('book_id'), 'rating' => $this->input->post('rating'), 'user_id' => $this->session->userdata('user_id'), 'created_at' => date('Y-m-d h:i:s'));
		$this->db->insert('reviews', $data);
	}
	public function book_info($id)
	{
		$query = "SELECT *, reviews.id, reviews.created_at FROM books JOIN reviews ON books.id = reviews.book_id JOIN users ON reviews.user_id = users.id WHERE books.id = $id ORDER BY reviews.id DESC";
		$temp = $this->db->query($query);
		return $temp->result();
	}
	public function reviewed_books()
	{
		$query = "SELECT DISTINCT books.id, name FROM books JOIN reviews ON books.id = reviews.book_id";
		$books = $this->db->query($query);
		//var_dump($books->result());
		return $books->result();
	}
	public function author_list()
	{
		$query = "SELECT DISTINCT author FROM books ORDER BY author ASC";
		$authors = $this->db->query($query);
		$list = [];
		foreach ($authors->result() as $row) {
			array_push($list, $row->author);
		}
		return $list;
	}
	public function insert_book()
	{
		if($this->input->post('existing'))
		{
			$author = $this->input->post('existing');
		}
		else
		{
			$author = $this->input->post('author');
		}
		$title = $this->input->post('title');
		$review = $this->input->post('review');
		$rating = intval($this->input->post('rating'));
		$data = array('author' => $author, 'name' => $title, 'created_at' => date('Y-m-d h:i:s'));
		$verify = "SELECT id from books WHERE name = '$title' AND author = '$author'";
		$verified = $this->db->query($verify);
		$existing = 0;
		foreach ($verified->result() as $row) 
		{
			if($row->id)
			{
				$existing++;
			}
		}
		if($existing === 0)
		{
			$this->db->insert('books', $data);
			$book_num = $this->Bookdb->insert_review($title,$author,$review,$rating);
			redirect('/books/book/' . $book_num);
		}
		else
		{
			$error = array('error' => 'This book already exists!');
			$this->load->view('add', $error);
		}
	}
	public function insert_review($title,$author,$review,$rating)
	{
		$query = "SELECT id FROM books WHERE name = '$title' AND author = '$author' ORDER BY id DESC LIMIT 1";
		$book_id = $this->db->query($query);
		foreach ($book_id->result() as $row) 
		{
			$bookid = $row->id;
		}
		$data1 = array('review' => $review, 'rating' => $rating, 'created_at' => date('Y-m-d h:i:s'), 'book_id' => $bookid, 'user_id' => $this->session->userdata('user_id'));
		$this->db->insert('reviews', $data1);
		return $bookid;
	}
}
?>
