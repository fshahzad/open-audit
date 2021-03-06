<?php
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

/**
 * @author Mark Unwin <marku@opmantek.com>
 *
 * 
 * @version   1.14.2

 *
 * @copyright Copyright (c) 2014, Opmantek
 * @license http://www.gnu.org/licenses/agpl-3.0.html aGPL v3
 */
class M_licenses extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->log = new stdClass();
        $this->log->status = 'reading data';
        $this->log->type = 'system';
    }

    public function create()
    {
        $this->log->function = strtolower(__METHOD__);
        $this->log->status = 'creating data';
        stdlog($this->log);
        $CI = & get_instance();
        if (empty($CI->response->meta->received_data->org_id)) {
            $CI->response->meta->received_data->org_id = 1;
        }
        $CI->response->meta->received_data->attributes->invoice_id = 0;
        $CI->response->meta->received_data->attributes->invoice_item_id = 0;
        $sql = "INSERT INTO `licenses` VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $data = array(  $CI->response->meta->received_data->attributes->org_id,
                        $CI->response->meta->received_data->attributes->invoice_id,
                        $CI->response->meta->received_data->attributes->invoice_item_id,
                        $CI->response->meta->received_data->attributes->name,
                        $CI->response->meta->received_data->attributes->description,
                        $CI->response->meta->received_data->attributes->match_string,
                        $CI->response->meta->received_data->attributes->type,
                        $CI->user->full_name);
        $id = intval($this->run_sql($sql, $data));
        return ($id);
    }

    public function read($id = '')
    {
        $this->log->function = strtolower(__METHOD__);
        stdlog($this->log);
        if ($id == '') {
            $CI = & get_instance();
            $id = intval($CI->response->meta->id);
        } else {
            $id = intval($id);
        }
        $sql = "SELECT * FROM licenses WHERE id = ?";
        $data = array($id);
        $result = $this->run_sql($sql, $data);
        $result = $this->format_data($result, 'licenses');
        return($result);
    }

    public function update()
    {
        $this->log->function = strtolower(__METHOD__);
        $this->log->status = 'updating data';
        stdlog($this->log);
        $log = new stdClass();
        $log->severity = 7;
        $log->file = 'system';
        $CI = & get_instance();

        $sql = 'UPDATE `licenses` SET ';
        $data = array();
        $log->message = json_encode($CI->response->meta->received_data);
        stdlog($log);
        if ( !empty($CI->response->meta->received_data->attributes->options)) {
            $received_options = new stdClass();
            foreach ($CI->response->meta->received_data->attributes->options as $key => $value) {
                    $received_options->$key = $value;
            }
            $select = "SELECT * FROM licenses WHERE id = ?";
            $existing_options = $this->run_sql($select, array($CI->response->meta->id));
            $existing_options = json_decode($existing_options[0]->options);
            $new_options = new stdClass();
            foreach ($existing_options as $existing_key => $existing_value) {
                if (!empty($received_options->$existing_key)) {
                    $new_options->$existing_key = $received_options->$existing_key;
                } else {
                    $new_options->$existing_key = $existing_options->$existing_key;
                }
            }
            $sql .= "`options` = ?, ";
            $data[] = (string)json_encode($new_options);
        }
        
        if (!empty($CI->response->meta->received_data->attributes->name)) {
            $sql .= "`name` = ?, ";
            $data[] = $CI->response->meta->received_data->attributes->name;
        }

        if (!empty($CI->response->meta->received_data->attributes->description)) {
            $sql .= "`description` = ?, ";
            $data[] = $CI->response->meta->received_data->attributes->description;
        }

        if ($sql == 'UPDATE `licenses` SET ') {
            # TODO - THROW AN ERROR, no credentials or name or description supplied for updating
        }
        $sql .= " `edited_by` = ?, `edited_date` = NOW() WHERE id = ?";
        $data[] = (string)$CI->user->full_name;
        $data[] = intval($CI->response->meta->id);
        $this->run_sql($sql, $data);
        return;
    }

    public function delete($id = '')
    {
        $this->log->function = strtolower(__METHOD__);
        $this->log->status = 'deleting data';
        stdlog($this->log);
        if ($id == '') {
            $CI = & get_instance();
            $id = intval($CI->response->meta->id);
        } else {
            $id = intval($id);
        }
        $sql = "DELETE FROM `licenses` WHERE id = ?";
        $data = array(intval($id));
        $this->run_sql($sql, $data);
        return true;
    }

    public function collection()
    {
        $this->log->function = strtolower(__METHOD__);
        stdlog($this->log);
        $CI = & get_instance();
        $sql = $this->collection_sql('licenses', 'sql');
        $result = $this->run_sql($sql, array());
        $result = $this->format_data($result, 'licenses');
        return ($result);
    }

    public function execute($id = 0)
    {
        if ($id = 0) {
            $CI = & get_instance();
            $id = $CI->response->meta->id;
        }
        $sql = "SELECT * FROM licenses WHERE id = " . intval($id);
        $result = $this->run_sql($sql, array());
        if (empty($result[0])) {
            // log an error, no matching license
            return;
        } else {
            $license = $result[0];
        }
        $sql = "SELECT system.id, system.name, software.name, software.version FROM system LEFT JOIN software ON (system.id = software.system_id AND software.current = 'y') WHERE software.name LIKE '%" . $license->match_string . "%'";
        $result = $this->run_sql($sql, array());
        return ($result);
    }

    private function count_data($result)
    {
        // do we have any retrieved rows?
        $CI = & get_instance();
        $trace = debug_backtrace();
        $caller = $trace[1];
        if (count($result) == 0) {
            log_error('ERR-0005', strtolower(@$caller['class'] . '::' . @$caller['function']));
        }
    }

}
