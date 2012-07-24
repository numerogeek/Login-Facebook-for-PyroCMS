<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_login extends Module
{

        public $version = '0.1';

        public function info()
        {
                return array(
                    'name' => array(
                        'en'          => 'Login',
                        'fr'          => 'Login'
                    ),
                    'description' => array(
                        'en'       => 'This is a PyroCMS module login.',
                        'fr'       => 'Module permettant la gestion de login Facebook'
                    ),
                    'frontend' => TRUE,
                    'backend'  => TRUE
                );
        }

        public function install()
        {
                
                $settings = array(
                    'login_setting' => array(
                        'slug'           => 'login_setting',
                        'title'          => 'Facebook Login',
                        'description'    => 'Used to redirect a user to a module after he has logged in with is Facebook',
                        'default'        => '1',
                        'value'          => '1',
                        'type'           => 'select',
                        '`options`'      => '1=Yes|0=No',
                        'is_required'    => 1,
                        'is_gui'         => 1,
                        'module'         => 'login'
                    ),
                    'login_redirect' => array(
                        'slug'           => 'login_redirect',
                        'title'          => 'Url to redirect to',
                        'description'    => 'Permet de rediriger l\'utilisateur vers un module',
                        'default'        => '',
                        'value'          => '',
                        'type'           => 'text',
                        '`options`'      => '',
                        'is_required'    => 1,
                        'is_gui'         => 1,
                        'module'         => 'login'
                    ),
                    'login_fb_scope' => array(
                        'slug'             => 'login_fb_scope',
                        'title'            => 'Facebook scope',
                        'description'      => 'Facebook scope parameters with comma-separated list of permissions." ',
                        'default'          => '',
                        'value'            => '',
                        'type'             => 'text',
                        '`options`'        => '',
                        'is_required'      => 1,
                        'is_gui'           => 1,
                        'module'           => 'login'
                    ),
                    'login_fb_display' => array(
                        'slug'           => 'login_fb_display',
                        'title'          => 'Display facebook',
                        'description'    => 'Facebook login display',
                        'default'        => '',
                        'value'          => '',
                        'type'           => 'text',
                        '`options`'      => '',
                        'is_required'    => 1,
                        'is_gui'         => 1,
                        'module'         => 'login'
                    ),
                    'login_fb_appid' => array(
                        'slug'               => 'login_fb_appid',
                        'title'              => 'Facebook App id',
                        'description'        => 'Your Facebook App ID',
                        'default'            => '',
                        'value'              => '',
                        'type'               => 'text',
                        '`options`'          => '',
                        'is_required'        => 1,
                        'is_gui'             => 1,
                        'module'             => 'login'
                    ),
                    'login_fb_appsecret' => array(
                        'slug'                 => 'login_fb_appsecret',
                        'title'                => 'Facebook App Secret',
                        'description'          => 'Your Facebook App Secret',
                        'default'              => '',
                        'value'                => '',
                        'type'                 => 'text',
                        '`options`'            => '',
                        'is_required'          => 1,
                        'is_gui'               => 1,
                        'module'               => 'login'
                    ),
                    'login_fb_redirecturl' => array(
                        'slug'        => 'login_fb_redirecturl',
                        'title'       => 'Facebook Redirect URI',
                        'description' => 'Facebook redirect URI',
                        'default'     => '',
                        'value'       => '',
                        'type'        => 'text',
                        '`options`'   => '',
                        'is_required' => 1,
                        'is_gui'      => 1,
                        'module'      => 'login'
                    )
                );

                foreach ($settings as $slug => $setting_info)
                {
                        log_message('debug', '-- Settings: installing ' . $slug);
                        $setting_info['slug'] = $slug;
                        if (!$this->db->insert('settings', $setting_info))
                        {
                                log_message('debug', '-- -- could not install ' . $slug);
                                die('here');
                                return false;
                        }
                }


               
                        $facebook_id=$this->streams->fields->get_field_assignments('facebook_id', 'users');
                        if (empty($facebook_id))
                        {
                                $fields = array(
                                        'name' => 'Facebook_id',
                                        'slug' => 'facebook_id',
                                        'namespace' => 'users',
                                        'type' => 'text',
                                        'assign'=>'profiles',
                                        'extra' => array('max_length' => 200)
                                );
                                $this->streams->fields->add_field($fields);
                                return true;
                        }
                        return true;
        }

        public function uninstall()
        {
               

                $facebook_id=$this->streams->fields->get_field_assignments('facebook_id', 'users');
                if (empty($facebook_id))
                {
                        $this->streams->fields->delete_field('facebook_id', 'users');
                }
                
                $this->db->delete('settings', array('module' => 'login'));
                {
                        return TRUE;
                }

        }

        public function upgrade($old_version)
        {
                
                return TRUE;
        }

        public function help()
        {
               
                return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
        }

}

