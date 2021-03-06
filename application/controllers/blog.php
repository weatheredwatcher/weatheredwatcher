<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->spark('markdown/1.2.0');
    
	}
		
	function index()
	{
		$this->load->helper('inflector');
		$this->load->library('pagination');
		$this->load->model('Blog_model', 'blog');
		$this->load->library('typography');
		
			$config = array();
	        $config["base_url"] = base_url() . "blog";
	        $config["total_rows"] = $this->blog->record_count();
	        $config["per_page"] = 10;
	        $config["uri_segment"] = 2;
	        $config['full_tag_open'] = '<div class="pagination"><ul>';
            $config['full_tag_close'] = '</ul></div>';
            $config['cur_tag_open']  = '<li class="active">';
            $config['cur_tag_close'] = '</li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
	        
            $this->pagination->initialize($config);
	 
	        $page = $this->uri->segment(2, 0);
	        $data["results"] = $this->blog->get_entries($config["per_page"], $page);
	        $data["links"] = $this->pagination->create_links();

		//$data['entries'] = $this->blog->get_last_ten_entries();
		$this->load->view('blog/blog_main', $data);
		
	
	}
	
	function page()
	{
	
		$slug = $this->uri->segment(3);
		$this->load->model('Blog_model', 'blog');
		$data['entries'] = $this->blog->get_entry_by_slug($slug);
		$this->load->view('blog/blog_page', $data);
	
	
	
	}
	
	
}

?>