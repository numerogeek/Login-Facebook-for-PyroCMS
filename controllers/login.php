<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This is a login module for PyroCMS
 *
 * @author              Khalil TABBAL
 * @link                http://www.khalil-tabbal.com
 * @package             GWADAWEB
 * @subpackage          LOGIN
 */
class login extends Public_Controller
{

        public function __construct()
        {
                parent::__construct();

                $this->load->model('login_m');
                $this->lang->load('login');
                $this->load->model(array('users/user_m', 'users/profile_m'));

                $this->load->spark('facebook/0.0.1');
//                $this->load->spark('console/0.7.0');
        }

        public function index()
        {
                // check if a facebook user is logged in
                $facebook_user = $this->facebook->getUser();

                if ($facebook_user)
                {
                        $params = array(
                            'facebook_id' => $facebook_user
                        );

                        // check if there is a corresponding user with this Facebook ID in our users profiles
                        $pyrocms_user = $this->profile_m->get_profile($params);

                        if ($pyrocms_user)
                        {
                                // we force login the user
                                $this->ion_auth->force_login($pyrocms_user->user_id, FALSE);


                                // we redirect the user just logged in
                                if (Settings::get('login_setting') == 1)
                                {
                                        redirect(Settings::get('login_redirect') .'/'. $pyrocms_user->user_id);
                                }
                                else
                                {
                                        $this->template
                                                ->title($this->module_details['name'])
                                                ->build('loggedin');
                                }
                        }
                        else
                        {
                                try
                                {
                                        $facebook_user_profile = $this->facebook->api('/me');

                                        $facebook_id = $facebook_user_profile['id'];
                                        $email       = $facebook_user_profile['email'];
                                        $first_name  = $facebook_user_profile['first_name'];
                                        $last_name   = $facebook_user_profile['last_name'];

                                        $display_name = $first_name . ' ' . $last_name;
                                        $username     = strtolower($first_name) . '-' . strtolower($last_name);

                                        if (isset($facebook_user_profile['gender']))
                                        {
                                                $gender = substr($facebook_user_profile['gender'], 0, 1);
                                        }
                                        else
                                        {
                                                $gender = NULL;
                                        }
                                        if (isset($facebook_user_profile['location']['name']))
                                        {
                                                $address_line3 = $facebook_user_profile['location']['name'];
                                        }
                                        else
                                        {
                                                $address_line3 = NULL;
                                        }


                                        $additional_data = array(
                                            'created_by'    => '1',
                                            'display_name'  => $display_name,
                                            'first_name'    => $first_name,
                                            'last_name'     => $last_name,
                                            'gender'        => $gender,
                                            'lang'          => 'fr',
                                            'address_line3' => $address_line3,
                                            'facebook_id'   => $facebook_id,
                                        );


                                        $pyrocms_user_id = $this->ion_auth->register($username, NULL, $email, '2', $additional_data);

                                        $params = array(
                                            'email'       => $email
                                        );
                                        $pyrocms_user = $this->user_m->get($params);

                                        $this->ion_auth->force_login($pyrocms_user->user_id, FALSE);

                                        $value = $this->ion_auth->logged_in();


                                        // we redirect the user just logged in
                                        if (Settings::get('login_setting') == 1)
                                        {
                                                redirect(Settings::get('login_redirect') .'/'. $pyrocms_user->user_id);
                                        }
                                        else
                                        {
                                                $this->template
                                                        ->title($this->module_details['name'])
                                                        ->build('loggedin');
                                        }
                                }
                                catch (FacebookApiException $e)
                                {

                                        $this->template
                                                ->title($this->module_details['name'])
                                                ->build('login');
                                }
                        }
                }
                else
                {
                        
                }
        }

}