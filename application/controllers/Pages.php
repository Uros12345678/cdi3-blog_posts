<?php 

class Pages extends CI_Controller {

    public function view($param = null) {
        if($param == null) {
            $page = "home";

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
                show_404();
            }


            $data['title'] = "New Posts";
            $data['posts'] = $this->Posts_model->get_posts();
            $data['total'] = count($data['posts']);
            //print_r($data['total']);
            

            $this->load->view('templates/header');
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/footer');
        } else {
            $page = "single";

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
                show_404();
            }


            $data['posts'] = $this->Posts_model->get_posts_single($param);
            $data['title'] = $data['posts']['title'];
            $data['body'] = $data['posts']['body'];
            $data['date'] = $data['posts']['created_at'];
            $data['id'] = $data['posts']['id'];
            

            if($data['posts']) {
                $this->load->view('templates/header');
                $this->load->view('pages/'.$page, $data);
                $this->load->view('templates/modal');
                $this->load->view('templates/footer');
            } else {
                show_404();
            }
        }

    }

    // -> search <- \\
    public function search() {
                $page = "home";
                $param = $this->input->post('search');
                if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
                    show_404();
                }


                $data['title'] = "New Posts";
                $data['posts'] = $this->Posts_model->get_posts_search($param);
                $data['total'] = count($data['posts']);

                $this->load->view('templates/header');
                $this->load->view('pages/'.$page, $data);
                $this->load->view('templates/footer');
    }
    // -> End-search <- \\

    // -> login <- \\
    public function login() {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');

        if($this->form_validation->run() == FALSE) {
                        $page = "login";

                        if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
                            show_404();
                        }

                    
                        $this->load->view('templates/header');
                        $this->load->view('pages/'.$page);
                        $this->load->view('templates/footer');
                } else {
                    $user_id = $this->Posts_model->login();

                    if($user_id) {
                        $user_data = array(
                            'username' => $user_id['username'],
                            'lastname' => $user_id['lastname'],
                            'fullname' => $user_id['username'].' '.$user_id['lastname'],
                            'access' => $user_id['is_admin'],
                            'email' => $user_id['email'],
                            'logged_in' => true
                        );
                        $this->session->set_userdata($user_data);
                        $this->session->set_flashdata('user_loggedin','Your are now loged in as '.$this->session->fullname);
                        redirect(base_url());
                    } else {
                        $this->session->set_flashdata('failed_login','Login is invalid');
                        redirect('login');
                    }
         }
    }
    // -> End-login <- \\

    // -> logout User  <- \\
    public function logout() {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('lastname');
        $this->session->unset_userdata('fullname');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('access');
        $this->session->unset_userdata('logged_in');

        $this->session->set_flashdata('user_loggedout', 'You are now logged out');
        redirect('login');
    }
    // -> End-logout <- \\


    public function add() {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('body', 'body', 'required');

        if($this->form_validation->run() == FALSE) {
                        $page = "add";

                        if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
                            show_404();
                        }


                        $data['title'] = "Add New Post";
                    
                        $this->load->view('templates/header');
                        $this->load->view('pages/'.$page, $data);
                        $this->load->view('templates/footer');
         } else {
             $this->Posts_model->insert_post();
             $this->session->set_flashdata('post_added','New post was added');
             redirect(base_url());
         } 

    }

    public function edit($param) {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('body', 'body', 'required');

        if($this->form_validation->run() == FALSE) {
                        $page = "edit";

                        if(!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
                            show_404();
                        }

                        $data['title'] = "Edit Post";
                        $data['posts'] = $this->Posts_model->get_posts_edit($param);
                        $data['title'] = $data['posts']['title'];
                        $data['body'] = $data['posts']['body'];
                        $data['date'] = $data['posts']['created_at'];
                        $data['id'] = $data['posts']['id'];
                    
                        $this->load->view('templates/header');
                        $this->load->view('pages/'.$page, $data);
                        $this->load->view('templates/footer');
         } else {
             $this->Posts_model->update_post();
             $this->session->set_flashdata('post_updated','Post was updated');
             redirect(base_url().'edit/'.$param);
         } 
    }


    public function delete() {


        $this->Posts_model->delete_post();
        $this->session->set_flashdata('post_delete', 'Post was deleted successfully!');
        redirect(base_url());
    }
}