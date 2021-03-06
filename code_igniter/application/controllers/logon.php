<?php
/**
#  Copyright 2003-2015 Opmantek Limited (www.opmantek.com)
#
#  ALL CODE MODIFICATIONS MUST BE SENT TO CODE@OPMANTEK.COM
#
#  This file is part of Open-AudIT.
#
#  Open-AudIT is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as published
#  by the Free Software Foundation, either version 3 of the License, or
#  (at your option) any later version.
#
#  Open-AudIT is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
#
#  You should have received a copy of the GNU Affero General Public License
#  along with Open-AudIT (most likely in a file named LICENSE).
#  If not, see <http://www.gnu.org/licenses/>
#
#  For further information on Open-AudIT or for a license other than AGPL please see
#  www.opmantek.com or email contact@opmantek.com
#
# *****************************************************************************
*
* @category  Controller
* @package   Open-AudIT
* @author    Mark Unwin <marku@opmantek.com>
* @copyright 2014 Opmantek
* @license   http://www.gnu.org/licenses/agpl-3.0.html aGPL v3
* @version   1.14.2

* @link      http://www.open-audit.org
*/

/**
* Base Object Input
*
* @access   public
* @category Object
* @package  Open-AudIT
* @author   Mark Unwin <marku@opmantek.com>
* @license  http://www.gnu.org/licenses/agpl-3.0.html aGPL v3
* @link     http://www.open-audit.org
* @return   NULL
 */
class logon extends CI_Controller
{
    /**
    * Constructor
    *
    * @access    public
    * @return    NULL
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('log');
        $log = new stdClass();
        $log->status = 'start';
        $log->function = strtolower(__METHOD__);
        stdlog($log);

        $this->load->helper('url');
        $this->load->helper('error');
        $this->load->library('session');
        $this->load->model('m_configuration');
        $this->m_configuration->load();

        $log = new stdClass();
        $log->severity = 7;
        $log->file = 'system';
        $log->message = '';

        # get the output format
        $format = '';
        $http_accept = @$_SERVER['HTTP_ACCEPT'];
        if (strpos($http_accept, 'application/json') !== false) {
            $format = 'json';
            $log->message = 'Set format to ' . $format . ', according to HEADERS.';
            stdlog($log);
        }
        if (strpos($http_accept, 'html') !== false) {
            $format = 'screen';
            $log->message = 'Set format to ' . $format . ', according to HEADERS.';
            stdlog($log);
        }
        if (isset($_GET['format'])) {
            $format = $_GET['format'];
            $log->message = 'Set format to ' . $format . ', according to GET.';
            stdlog($log);
        }
        if (isset($_POST['format'])) {
            $format = $_POST['format'];
            $log->message = 'Set format to ' . $format . ', according to POST.';
            stdlog($log);
        }
        if ($format == '') {
            $format = 'json';
            $log->message = 'Set format to ' . $format . ', because default.';
            stdlog($log);
        }

        # initialise our properties
        $this->response = new stdClass();
        $this->response->meta = new stdClass();
        $this->response->meta->action = '';
        $this->response->meta->baseurl = $this->config->config['base_url'];
        $this->response->meta->collection = 'logon';
        $this->response->meta->current = 'y';
        $this->response->meta->debug = false;
        $this->response->meta->filtered = '';
        $this->response->meta->format = $format;
        $this->response->meta->groupby = '';
        $this->response->meta->header = 'HTTP/1.1 200 OK';
        $this->response->meta->id = null;
        $this->response->meta->ids = 0;
        $this->response->meta->include = '';
        $this->response->meta->limit = '';
        $this->response->meta->offset = 0;
        $this->response->meta->properties = '';
        $this->response->meta->query_string = '';
        $REQUEST_METHOD = strtoupper($this->input->server('REQUEST_METHOD'));
        $this->response->meta->request_method = $REQUEST_METHOD;
        $this->response->meta->sort = '';
        $this->response->meta->sub_resource = '';
        $this->response->meta->sub_resource_id = 0;
        $this->response->meta->total = 0;
        $this->response->meta->version = 1;
        $this->response->meta->filter = array();
        $this->response->meta->internal = new stdClass();
        $this->response->meta->received_data = array();
        $this->response->meta->sql = array();
        $this->response->links = array();
        $this->response->included = array();
    }

    /**
    * Index that is unused
    *
    * @access public
    * @return NULL
    */
    public function index()
    {
        if (strtoupper($this->input->server('REQUEST_METHOD')) == 'GET') {
            $temp = @$this->session->userdata('user_id');
            if (!empty($temp)) {
                if ($this->response->meta->format != 'json') {
                    redirect('summaries');
                } else {
                    print_r(json_encode($this->response));
                }
            }
            $this->check_defaults();
            $this->response->meta->action = 'create';
            $this->load->view('v_logon', $this->response);
        } else {
            // NOTE - had to NOT use 'logon' as it confuses PHP checkers that think it's the constructor
            $this->login();
        }
    }

    /**
    * Index that is unused
    *
    * @access public
    * @return NULL
    */
    public function login()
    {

        $temp = @$this->session->userdata('user_id');
        if (!empty($temp)) {
            if ($this->response->meta->format != 'json') {
                #echo "<pre>\n"; print_r($this->session->all_userdata());
                redirect('summaries');
            } else {
                print_r(json_encode($this->response));
            }
        }

        $this->load->model('m_logon');
        $this->m_logon->logon();

        if ($this->config->config['internal_version'] < $this->config->config['web_internal_version']) {
            redirect('database');
            exit();
        }
        #$this->response->meta->format = 'json';
        $this->user->id = intval($this->user->id);
        #$this->user->org_id = intval($this->user->org_id);
        #echo "<pre>\n"; print_r($this->user); exit();

        #echo "<pre>\n"; print_r($this->response); exit();
        if ($this->response->meta->format != 'json') {
            $url = @$this->session->userdata('url');
            if (!empty($url)) {
                redirect($this->session->userdata('url'));
            } else {
                redirect('summaries');
            }
        } else {
            $this->user->roles = json_decode($this->user->roles);
            print_r(json_encode($this->user));
        }
    }

    public function logoff()
    {
        $this->session->sess_destroy();
        redirect('logon');
    }

    public function check_defaults()
    {

        // Delete any old sessions stored int he DB
        $sql = "/* logon::check_defaults */ " . "DELETE FROM oa_user_sessions WHERE last_activity < UNIX_TIMESTAMP(NOW() - INTERVAL 7 DAY)";
        $query = $this->db->query($sql);

        // Remove any olds los as per config
        if ($this->db->table_exists('logs') and !empty($this->config->config['log_retain_level_0'])) {
            $sql = "/* logon::check_defaults */ " . "DELETE FROM `logs` WHERE `severity` = 0 AND `timestamp` < UNIX_TIMESTAMP(NOW() - INTERVAL " . intval($this->config->config['log_retain_level_0']) . " DAY)";
            $query = $this->db->query($sql);

            $sql = "/* logon::check_defaults */ " . "DELETE FROM `logs` WHERE `severity` = 1 AND `timestamp` < UNIX_TIMESTAMP(NOW() - INTERVAL " . intval($this->config->config['log_retain_level_1']) . " DAY)";
            $query = $this->db->query($sql);

            $sql = "/* logon::check_defaults */ " . "DELETE FROM `logs` WHERE `severity` = 2 AND `timestamp` < UNIX_TIMESTAMP(NOW() - INTERVAL " . intval($this->config->config['log_retain_level_2']) . " DAY)";
            $query = $this->db->query($sql);

            $sql = "/* logon::check_defaults */ " . "DELETE FROM `logs` WHERE `severity` = 3 AND `timestamp` < UNIX_TIMESTAMP(NOW() - INTERVAL " . intval($this->config->config['log_retain_level_3']) . " DAY)";
            $query = $this->db->query($sql);

            $sql = "/* logon::check_defaults */ " . "DELETE FROM `logs` WHERE `severity` = 4 AND `timestamp` < UNIX_TIMESTAMP(NOW() - INTERVAL " . intval($this->config->config['log_retain_level_4']) . " DAY)";
            $query = $this->db->query($sql);

            $sql = "/* logon::check_defaults */ " . "DELETE FROM `logs` WHERE `severity` = 5 AND `timestamp` < UNIX_TIMESTAMP(NOW() - INTERVAL " . intval($this->config->config['log_retain_level_5']) . " DAY)";
            $query = $this->db->query($sql);

            $sql = "/* logon::check_defaults */ " . "DELETE FROM `logs` WHERE `severity` = 6 AND `timestamp` < UNIX_TIMESTAMP(NOW() - INTERVAL " . intval($this->config->config['log_retain_level_6']) . " DAY)";
            $query = $this->db->query($sql);

            $sql = "/* logon::check_defaults */ " . "DELETE FROM `logs` WHERE `severity` = 7 AND `timestamp` < UNIX_TIMESTAMP(NOW() - INTERVAL " . intval($this->config->config['log_retain_level_7']) . " DAY)";
            $query = $this->db->query($sql);
        }


        // Insert the local server subnet into the /networks
        foreach ($this->m_configuration->read_subnet() as $subnet) {
            $this->load->model('m_networks');
            $network = new stdClass();
            $network->name = $subnet;
            $network->org_id = 0;
            $network->description = 'Auto inserted local server subnet';
            $this->m_networks->upsert($network);
            unset($network);
        }

        // Get the license type and set our logo
        $license = '';
        $oae_url = $this->config->config['oae_url'];
        if ($oae_url > '') {
            if (substr($oae_url, -1, 1) != '/') {
                $oae_url = $oae_url.'/';
            }
            // if we already have http... in the oae_url variable, no need to do anything.
            if (strpos(strtolower($oae_url), 'http') === false) {
                // if we ONLY have a link thus - "/oae/omk" we assume the OAE install is on the same machine.
                // Make sure we have a leading /
                if (substr($oae_url, 0, 1) != '/') {
                    $oae_url = '/'.$oae_url;
                }
                // need to create a link to OAE on port 8042 to check the license
                // we cannot detect and use the browser http[s] as it may being used in the client browser,
                //     but stripped by a https offload or proxy
                $oae_license_url = 'http://localhost'.$oae_url.'license';
                // we create a link for the browser using the same address + the path & file in oae_url
                if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
                    $oae_url = 'https://'.$_SERVER['HTTP_HOST'].$oae_url;
                } else {
                    $oae_url = 'http://'.$_SERVER['HTTP_HOST'].$oae_url;
                }
            } else {
                // we already have a URL like http://something/omk/oae/ - leave it alone
                $oae_license_url = $oae_url.'license';
            }

            ini_set('default_socket_timeout', 3);
            // get the license status from the OAE API
            // license status are: valid, invalid, expired, none
            $license = @file_get_contents($oae_license_url, false);
            if ($license !== false) {
                $license = json_decode($license);
                if (json_last_error()) {
                    $license = new stdClass();
                    $license->license = 'none';
                }
            } else {
                $license = new stdClass();
                $license->license = 'none';
            }
        } else {
            $license = new stdClass();
            $license->license = 'none';
        }

        if ($license->license != 'none' and $license->license != 'commercial' and $license->license != 'free') {
            $license->license = 'none';
        }
        $this->m_configuration->update('oae_license', (string)$license->license, 'system');
        if ($license->license == 'commercial' or $license->license == 'free') {
            $this->m_configuration->update('logo', 'logo-banner-oae', 'system');
        } else {
            $this->m_configuration->update('logo', 'logo-banner-oac-oae', 'system');
        }
    }
}
// End of file input.php
// Location: ./controllers/input.php
