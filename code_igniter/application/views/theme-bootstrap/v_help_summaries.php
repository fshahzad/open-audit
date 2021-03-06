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
 * @version   1.14.2

 *
 * @copyright Copyright (c) 2014, Opmantek
 * @license http://www.gnu.org/licenses/agpl-3.0.html aGPL v3
 */
?>
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title"><?php echo __("Default Summaries"); ?></h3></div>
    <div class="panel-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Table</th>
                    <th>Column</th>
                    <th>Extra Columns</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>Device Classes</td>
                    <td>system</td>
                    <td>class</td>
                    <td></td>
                </tr>

                <tr>
                    <td>Device Status</td>
                    <td>system</td>
                    <td>status</td>
                    <td></td>
                </tr>

                <tr>
                    <td>Device Types</td>
                    <td>system</td>
                    <td>type</td>
                    <td></td>
                </tr>

                <tr>
                    <td>DNS Domains</td>
                    <td>system</td>
                    <td>dns_domain</td>
                    <td></td>
                </tr>

                <tr>
                    <td>Form Factors</td>
                    <td>system</td>
                    <td>form_factor</td>
                    <td>system.form_factor,system.class</td>
                </tr>

                <tr>
                    <td>Manufacturers</td>
                    <td>system</td>
                    <td>manufacturer</td>
                    <td>system.model</td>
                </tr>

                <tr>
                    <td>Operating Systems</td>
                    <td>system</td>
                    <td>os_family</td>
                    <td></td>
                </tr>

                <tr>
                    <td>Server Types</td>
                    <td>server</td>
                    <td>type</td>
                    <td>server.name,server.full_name,server.version,server.status</td>
                </tr>

                <tr>
                    <td>Services</td>
                    <td>services</td>
                    <td>name</td>
                    <td>service.name,service.state</td>
                </tr>

                <tr>
                    <td>Software</td>
                    <td>software</td>
                    <td>name</td>
                    <td>software.name,software.version</td>
                </tr>

                <tr>
                    <td>Software Keys</td>
                    <td>software_key</td>
                    <td>name</td>
                    <td>software_key.name,software_key.string,software_key.rel,software_key.edition</td>
                </tr>

                <tr>
                    <td>Active Directory OU's</td>
                    <td>windows</td>
                    <td>active_directory_ou</td>
                    <td>windows.active_directory_ou,windows.client_site_name</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>