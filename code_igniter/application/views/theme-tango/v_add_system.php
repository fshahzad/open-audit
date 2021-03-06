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
if (isset($error_message)) {
    $error_message = "<font color='red'>&nbsp;".$error_message."</font>";
} else {
    $error_message = "";
}
echo form_open('admin_system/add_system')."\n";
?>
<fieldset id="org_details" class='niceforms'>
    <legend><span style='font-size: 12pt;'>&nbsp;<?php echo __('System Details')?></span></legend>
    <img class='section_image' src='<?php echo $oa_theme_images;?>/48_home.png' alt='' title='' />
    <p><?php echo $error_message; ?>&nbsp;</p>
    <p><label for='type'><?php echo __("Type")?>: </label>
        <select id='type' name='type' tabindex='1' style='width: 135px' onchange='select_device();'>
            <?php foreach ($device_types as $key => $value) {
                echo "<option value='$key'>".__("$value")."</option>\n";
            } ?>
        </select>
    </p>
    <p><label for='notes1'> </label><span id='notes1' style='color: blue;'>*</span> You must have at least one of the blue attributes.<br />
       <label for='notes2'> </label><span id='notes2' style='color: red;'>*</span> You must have a red attribute.</p>
    <div id="details"></div>

</fieldset>
<?php echo form_close(); ?>

<?php
$location_form = "";
foreach ($locations as $location) {
    $location_form .= "<option value='".$location->id."'>".$location->name."<\/option>";
}
$location_form = "<label for='location_id'>Location<\/label><select id='location_id' name='location_id' style='width: 250px'>".$location_form."<\/select><br />";

$org_form = "";
foreach ($orgs as $org) {
    $org_form .= "<option value='".$org->id."'>".$org->name."<\/option>";
}
$org_form = "<label for='org_id'>Organisation<\/label><select id='org_id' name='org_id' style='width: 250px'>".$org_form."<\/select><br />";

$os_group_form = "";
foreach ($os_group as $item) {
    $os_group_form .= "<option value='".$item->os_group."'>".$item->os_group."<\/option>";
}
$os_group_form = "<label for='os_group_2'> <\/label><select id='os_group_2' name='os_group_2' style='width: 250px'>".$os_group_form."<\/select><br />";

$os_family_form = "";
foreach ($os_family as $item) {
    $os_family_form .= "<option value='".$item->os_family."'>".$item->os_family."<\/option>";
}
$os_family_form = "<label for='os_family'> <\/label><select id='os_family' name='os_family' style='width: 250px'>".$os_family_form."<\/select><br />";

$os_name_form = "";
foreach ($os_name as $item) {
    $os_name_form .= "<option value='".$item->os_name."'>".$item->os_name."<\/option>";
}
$os_name_form = "<label for='os_name_2'> <\/label><select id='os_name_2' name='os_name_2' style='width: 250px'>".$os_name_form."<\/select><br />";

?>
<!-- TODO: validate the various attributes that MUST be submitted, are - client side -->

<script type="text/javascript">
<?php if (isset($error_message)) {
    echo "error_message = \"".$error_message."\";\n";
} else {
    echo "error_message = \"\";";
} ?>


if (error_message > "") {
        document.getElementById("type").value = "<?php if (isset($form)) { echo $form['type']; } ?>";
        select_device();
        <?php if (isset($form)) {
            foreach ($form as $key => $value) {
                echo "\tdocument.getElementById(\"$key\").value = \"$value\"\n";
            }
        }?>
    }

function select_device()
{
    status_text = "";
    device_type = document.getElementById("type").value;
    document.getElementById("details").innerHTML = status_text;
    switch (device_type)
    {
        case "mobile modem":
        case "cell phone":
        case "satellite phone":
        case "phone":
            status_text = "<table><tr><td valign=\"top\">";
            status_text = status_text + "<label for='description'><?php echo __('Description'); ?><\/label><input type='text' id='description' name='description' size='20' \/><br \/>";
            status_text = status_text + "<?php echo $location_form;?>";
            status_text = status_text + "<?php echo $org_form;?>";
            status_text = status_text + "<label for='owner'><?php echo __('Allocated To')?><\/label><input type='text' id='owner' name='owner' size='20' \/><br \/>";
            status_text = status_text + "<label for='manufacturer'><?php echo __('Manufacturer')?><\/label><input type='text' id='manufacturer' name='manufacturer' size='20' \/><br \/>";
            status_text = status_text + "<label for='model'><?php echo __('Model')?><\/label><input type='text' id='model' name='model' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial'><?php echo __('Serial')?><\/label><input type='text' id='serial' name='serial' size='20' \/><span style='color: red;'>*<\/span><br \/>";
            status_text = status_text + "<label for='asset_number'><?php echo __('Asset Number')?><\/label><input type='text' id='asset_number' name='asset_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='status'><?php echo __('Status')?><\/label><select id='status' name='status' style='width: 135px' ><option selected value='production'>Production<\/option><option value='retired'>Retired<\/option><option value='maintenance'>Maintenance<\/option><option value='deleted'>Deleted<\/option><option value='unallocated'>Unallocated<\/option><option value='lost'>Lost<\/option><\/select><br \/>";
            status_text = status_text + "<label for='environment'><?php echo __('Environment')?><\/label><select id='environment' name='environment' ><option selected value='production'>Production<\/option><option value='pre-prod'>PreProduction<\/option><option value='test'>Testing<\/option><option value='uat'>User Acceptance Testing<\/option><option value='eval'>Evaluation<\/option><option value='dev'>Development<\/option><option value='dr'>Disaster Recovery<\/option><\/select><br \/>";
            status_text = status_text + "<label for='purchase_order_number'><?php echo __('PO Number')?><\/label><input type='text' id='purchase_order_number' name='purchase_order_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_cost_center'><?php echo __('Cost Center')?><\/label><input type='text' id='purchase_cost_center' name='purchase_cost_center' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_vendor'><?php echo __('Vendor')?><\/label><input type='text' id='purchase_vendor' name='purchase_vendor' size='20' \/><br \/>";
            status_text = status_text + "<\/td><td valign=\"top\">";
            status_text = status_text + "<label for='purchase_date'><?php echo __('Purchase Date')?><\/label><input type='text' id='purchase_date' name='purchase_date' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='purchase_amount'><?php echo __('Purchase Amount')?><\/label><input type='text' id='purchase_amount' name='purchase_amount' size='20' \/><br \/>";
            status_text = status_text + "<label for='warranty_duration'><?php echo __('Warranty Duration')?><\/label><input type='text' id='warranty_duration' name='warranty_duration' size='20' title='in months' \/><br \/>";
            status_text = status_text + "<label for='warranty_expires'><?php echo __('Warranty Expiration Date')?><\/label><input type='text' id='warranty_expires' name='warranty_expires' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='service_number'><?php echo __('Phone Number')?><\/label><input type='text' id='service_number' name='service_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='service_provider'><?php echo __('Service Provider')?><\/label><input type='text' id='service_provider' name='service_provider' size='20' \/><br \/>";
            status_text = status_text + "<label for='service_type'><?php echo __('Service Type')?><\/label><select id='service_type' name='service_type' style='width: 135px' ><option value=''>&nbsp;<\/option><option value='voice'>Voice only<\/option><option value='data'>Data only<\/option><option value='voice and data'>Voice and Data<\/option><\/select><br \/>";
            status_text = status_text + "<label for='service_plan'><?php echo __('Service Plan')?><\/label><input type='text' id='service_plan' name='service_plan' size='20' title='$49 / month, etc' \/><br \/>";
            status_text = status_text + "<label for='service_network'><?php echo __('Service Network')?><\/label><input type='text' id='service_network' name='service_network' size='20' title='GSM, 2G, 3G, NextG, 4G, etc' \/><br \/>";
            status_text = status_text + "<label for='unlock_pin'><?php echo __('Phone PIN')?><\/label><input type='text' id='unlock_pin' name='unlock_pin' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial_imei'><?php echo __('IMEI Serial')?><\/label><input type='text' id='serial_imei' name='serial_imei' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial_sim'><?php echo __('SIM Serial')?><\/label><input type='text' id='serial_sim' name='serial_sim' size='20' \/><br \/>";
            status_text = status_text + "<\/td><\/tr><\/table>";
            status_text = status_text + "<br \/><p><label for='submit'>&nbsp;<\/label><input type='submit' name='submit' value='<?php echo __('Submit'); ?>' id='submit' \/><\/p>";
            break;

        case "smart phone":
            status_text = "<table><tr><td valign=\"top\">";
            status_text = status_text + "<label for='os_family'><?php echo __('OS Family'); ?><\/label><select id='os_family' name='os_family' style='width: 135px' ><option value=' '>&nbsp;<\/option><option value='android'>Android<\/option><option value='apple'>Apple<\/option><option value='blackberry'>Blackberry<\/option><option value='other'>Other<\/option><option value='windows phone'>Windows Phone<\/option><\/select><br \/>";
            status_text = status_text + "<label for='os_name'><?php echo __('OS Name'); ?><\/label><input type='text' id='os_name' name='os_name' size='20' title='4' \/><br \/>";
            status_text = status_text + "<label for='description'><?php echo __('Description'); ?><\/label><input type='text' id='description' name='description' size='20' \/><br \/>";
            status_text = status_text + "<?php echo $location_form;?>";
            status_text = status_text + "<?php echo $org_form;?>";
            status_text = status_text + "<label for='owner'><?php echo __('Allocated To'); ?><\/label><input type='text' id='owner' name='owner' size='20' \/><br \/>";
            status_text = status_text + "<label for='manufacturer'><?php echo __('Manufacturer'); ?><\/label><input type='text' id='manufacturer' name='manufacturer' size='20' \/><br \/>";
            status_text = status_text + "<label for='model'><?php echo __('Model'); ?><\/label><input type='text' id='model' name='model' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial'><?php echo __('Serial'); ?><\/label><input type='text' id='serial' name='serial' size='20' \/><span style='color: red;'>*<\/span><br \/>";
            status_text = status_text + "<label for='asset_number'><?php echo __('Asset Number'); ?><\/label><input type='text' id='asset_number' name='asset_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='status'><?php echo __('Status'); ?><\/label><select id='status' name='status' style='width: 135px' ><option selected value='production'>Production<\/option><option value='retired'>Retired<\/option><option value='maintenance'>Maintenance<\/option><option value='deleted'>Deleted<\/option><option value='unallocated'>Unallocated<\/option><option value='lost'>Lost<\/option><\/select><br \/>";
            status_text = status_text + "<label for='environment'><?php echo __('Environment'); ?><\/label><select id='environment' name='environment' ><option selected value='production'>Production<\/option><option value='pre-prod'>PreProduction<\/option><option value='test'>Testing<\/option><option value='uat'>User Acceptance Testing<\/option><option value='eval'>Evaluation<\/option><option value='dev'>Development<\/option><option value='dr'>Disaster Recovery<\/option><\/select><br \/>";
            status_text = status_text + "<label for='purchase_order_number'><?php echo __('PO Number'); ?><\/label><input type='text' id='purchase_order_number' name='purchase_order_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_cost_center'><?php echo __('Cost Center'); ?><\/label><input type='text' id='purchase_cost_center' name='purchase_cost_center' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_vendor'><?php echo __('Vendor'); ?><\/label><input type='text' id='purchase_vendor' name='purchase_vendor' size='20' \/><br \/>";
            status_text = status_text + "<\/td><td valign=\"top\">";
            status_text = status_text + "<label for='purchase_date'><?php echo __('Purchase Date'); ?><\/label><input type='text' id='purchase_date' name='purchase_date' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='purchase_amount'><?php echo __('Purchase Amount'); ?><\/label><input type='text' id='purchase_amount' name='purchase_amount' size='20' \/><br \/>";
            status_text = status_text + "<label for='warranty_duration'><?php echo __('Warranty Duration'); ?><\/label><input type='text' id='warranty_duration' name='warranty_duration' size='20' title='in months' \/><br \/>";
            status_text = status_text + "<label for='warranty_expires'><?php echo __('Warranty Expiration Date'); ?><\/label><input type='text' id='warranty_expires' name='warranty_expires' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='service_number'><?php echo __('Phone Number'); ?><\/label><input type='text' id='service_number' name='service_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='service_provider'><?php echo __('Service Provider'); ?><\/label><input type='text' id='service_provider' name='service_provider' size='20' \/><br \/>";
            status_text = status_text + "<label for='service_type'><?php echo __('Service Type'); ?><\/label><select id='service_type' name='service_type' style='width: 135px' ><option value=''>&nbsp;<\/option><option value='voice'>Voice only<\/option><option value='data'>Data only<\/option><option value='voice and data'>Voice and Data<\/option><\/select><br \/>";
            status_text = status_text + "<label for='service_plan'><?php echo __('Service Plan'); ?><\/label><input type='text' id='service_plan' name='service_plan' size='20' title='$49 / month, etc' \/><br \/>";
            status_text = status_text + "<label for='service_network'><?php echo __('Service Network'); ?><\/label><input type='text' id='service_network' name='service_network' size='20' title='GSM, 2G, 3G, NextG, 4G, etc' \/><br \/>";
            status_text = status_text + "<label for='unlock_pin'><?php echo __('Phone PIN'); ?><\/label><input type='text' id='unlock_pin' name='unlock_pin' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial_imei'><?php echo __('IMEI Serial'); ?><\/label><input type='text' id='serial_imei' name='serial_imei' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial_sim'><?php echo __('SIM Serial'); ?><\/label><input type='text' id='serial_sim' name='serial_sim' size='20' \/><br \/>";
            status_text = status_text + "<\/td><\/tr><\/table>";
            status_text = status_text + "<br \/><p><label for='submit'>&nbsp;<\/label><input type='submit' name='submit' value='<?php echo __('Submit'); ?>' id='submit' \/><\/p>";
            break;

        case "ip phone":
            status_text = "<table><tr><td valign=\"top\">";
            status_text = status_text + "<label for='hostname'>Hostname<\/label><input type='text' id='hostname' name='hostname' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<label for='description'>Description<\/label><input type='text' id='description' name='description' size='20' \/><br \/>";
            status_text = status_text + "<label for='ip'>IP Address<\/label><input type='text' id='ip' name='ip' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<?php echo $location_form;?>";
            status_text = status_text + "<?php echo $org_form;?>";
            status_text = status_text + "<label for='owner'>Allocated To<\/label><input type='text' id='owner' name='owner' size='20' \/><br \/>";
            status_text = status_text + "<label for='manufacturer'>Manufacturer<\/label><input type='text' id='manufacturer' name='manufacturer' size='20' \/><br \/>";
            status_text = status_text + "<label for='model'>Model<\/label><input type='text' id='model' name='model' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial'>Serial<\/label><input type='text' id='serial' name='serial' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<label for='asset_number'>Asset Number<\/label><input type='text' id='asset_number' name='asset_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='status'>Status<\/label><select id='status' name='status' style='width: 135px' ><option selected value='production'>Production<\/option><option value='retired'>Retired<\/option><option value='maintenance'>Maintenance<\/option><option value='deleted'>Deleted<\/option><option value='unallocated'>Unallocated<\/option><option value='lost'>Lost<\/option><\/select><br \/>";
            status_text = status_text + "<label for='environment'>Environment<\/label><select id='environment' name='environment' ><option selected value='production'>Production<\/option><option value='pre-prod'>PreProduction<\/option><option value='test'>Testing<\/option><option value='uat'>User Acceptance Testing<\/option><option value='eval'>Evaluation<\/option><option value='dev'>Development<\/option><option value='dr'>Disaster Recovery<\/option><\/select><br \/>";
            status_text = status_text + "<label for='purchase_order_number'>PO Number<\/label><input type='text' id='purchase_order_number' name='purchase_order_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_cost_center'>Cost Center<\/label><input type='text' id='purchase_cost_center' name='purchase_cost_center' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_vendor'>Vendor<\/label><input type='text' id='purchase_vendor' name='purchase_vendor' size='20' \/><br \/>";
            status_text = status_text + "<\/td><td valign=\"top\">";
            status_text = status_text + "<label for='purchase_date'>Purchase Date<\/label><input type='text' id='purchase_date' name='purchase_date' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='purchase_amount'>Purchase Amount<\/label><input type='text' id='purchase_amount' name='purchase_amount' size='20' \/><br \/>";
            status_text = status_text + "<label for='warranty_duration'>Warranty Duration<\/label><input type='text' id='warranty_duration' name='warranty_duration' size='20' title='in months' \/><br \/>";
            status_text = status_text + "<label for='warranty_expires'>Warranty Expiration Date<\/label><input type='text' id='warranty_expires' name='warranty_expires' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='service_number'>Phone Number<\/label><input type='text' id='service_number' name='service_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='service_provider'>Service Provider<\/label><input type='text' id='service_provider' name='service_provider' size='20' \/><br \/>";
            status_text = status_text + "<label for='service_type'>Service Type<\/label><select id='service_type' name='service_type' style='width: 135px' ><option value=''>&nbsp;<\/option><option value='voice'>Voice only<\/option><option value='data'>Data only<\/option><option value='voice and data'>Voice and Data<\/option><\/select><br \/>";
            status_text = status_text + "<label for='service_plan'>Service Plan<\/label><input type='text' id='service_plan' name='service_plan' size='20' title='$49 / month, etc' \/><br \/>";
            status_text = status_text + "<label for='service_network'>Service Network<\/label><input type='text' id='service_network' name='service_network' size='20' title='GSM, 2G, 3G, NextG, 4G, etc' \/><br \/>";
            status_text = status_text + "<label for='unlock_pin'>Phone PIN<\/label><input type='text' id='unlock_pin' name='unlock_pin' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial_imei'>IMEI Serial<\/label><input type='text' id='serial_imei' name='serial_imei' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial_sim'>SIM Serial<\/label><input type='text' id='serial_sim' name='serial_sim' size='20' \/><br \/>";
            status_text = status_text + "<\/td><\/tr><\/table>";
            status_text = status_text + "<br \/><p><label for='submit'>&nbsp;<\/label><input type='submit' name='submit' value='<?php echo __('Submit'); ?>' id='submit' \/><\/p>";
            break;

        case "access token":
            status_text = "<table><tr><td valign=\"top\">";
            status_text = status_text + "<label for='description'>Description<\/label><input type='text' id='description' name='description' size='20' \/><br \/>";
            status_text = status_text + "<?php echo $location_form;?>";
            status_text = status_text + "<?php echo $org_form;?>";
            status_text = status_text + "<label for='owner'>Allocated To<\/label><input type='text' id='owner' name='owner' size='20' \/><br \/>";
            status_text = status_text + "<label for='manufacturer'>Manufacturer<\/label><input type='text' id='manufacturer' name='manufacturer' size='20' \/><br \/>";
            status_text = status_text + "<label for='model'>Model<\/label><input type='text' id='model' name='model' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial'>Serial<\/label><input type='text' id='serial' name='serial' size='20' \/><span style='color: red;'>*<\/span><br \/>";
            status_text = status_text + "<label for='asset_number'>Asset Number<\/label><input type='text' id='asset_number' name='asset_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='status'>Status<\/label><select id='status' name='status' style='width: 135px' ><option selected value='production'>Production<\/option><option value='retired'>Retired<\/option><option value='maintenance'>Maintenance<\/option><option value='deleted'>Deleted<\/option><option value='unallocated'>Unallocated<\/option><option value='lost'>Lost<\/option><\/select><br \/>";
            status_text = status_text + "<label for='environment'>Environment<\/label><select id='environment' name='environment' ><option selected value='production'>Production<\/option><option value='pre-prod'>PreProduction<\/option><option value='test'>Testing<\/option><option value='uat'>User Acceptance Testing<\/option><option value='eval'>Evaluation<\/option><option value='dev'>Development<\/option><option value='dr'>Disaster Recovery<\/option><\/select><br \/>";
            status_text = status_text + "<\/td><td valign=\"top\">";
            status_text = status_text + "<label for='purchase_order_number'>PO Number<\/label><input type='text' id='purchase_order_number' name='purchase_order_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_cost_center'>Cost Center<\/label><input type='text' id='purchase_cost_center' name='purchase_cost_center' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_vendor'>Vendor<\/label><input type='text' id='purchase_vendor' name='purchase_vendor' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_date'>Purchase Date<\/label><input type='text' id='purchase_date' name='purchase_date' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='purchase_amount'>Purchase Amount<\/label><input type='text' id='purchase_amount' name='purchase_amount' size='20' \/><br \/>";
            status_text = status_text + "<label for='warranty_duration'>Warranty Duration<\/label><input type='text' id='warranty_duration' name='warranty_duration' size='20' title='in months' \/><br \/>";
            status_text = status_text + "<label for='warranty_expires'>Warranty Expiration Date<\/label><input type='text' id='warranty_expires' name='warranty_expires' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='service_type'>Service Type<\/label><input type='text' id='service_type' name='service_type' size='20' title='Full, Restricted, etc' \/><br \/>";
            status_text = status_text + "<label for='unlock_pin'>PIN<\/label><input type='text' id='unlock_pin' name='unlock_pin' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial_imei'>IMEI Serial<\/label><input type='text' id='serial_imei' name='serial_imei' size='20' \/><br \/>";
            status_text = status_text + "<\/td><\/tr><\/table>";
            status_text = status_text + "<br \/><p><label for='submit'>&nbsp;<\/label><input type='submit' name='submit' value='<?php echo __('Submit'); ?>' id='submit' \/><\/p>";
            break;

        case "tablet":
            status_text = "<table><tr><td valign=\"top\">";
            status_text = status_text + "<label for='os_family'>OS Family<\/label><select id='os_family' name='os_family' style='width: 135px' ><option value=' '>&nbsp;<\/option><option value='android'>Android<\/option><option value='blackberry'>Blackberry<\/option><option value='apple'>Apple<\/option><option value='windows'>Windows<\/option><\/select><br \/>";
            status_text = status_text + "<label for='os_name'>OS Name<\/label><input type='text' id='os_name' name='os_name' size='20' title='Android 4.0 (Ice Cream Sandwitch), etc' \/><br \/>";
            status_text = status_text + "<label for='description'>Description<\/label><input type='text' id='description' name='description' size='20' \/><br \/>";
            status_text = status_text + "<?php echo $location_form;?>";
            status_text = status_text + "<?php echo $org_form;?>";
            status_text = status_text + "<label for='owner'>Allocated To<\/label><input type='text' id='owner' name='owner' size='20' \/><br \/>";
            status_text = status_text + "<label for='manufacturer'>Manufacturer<\/label><input type='text' id='manufacturer' name='manufacturer' size='20' \/><br \/>";
            status_text = status_text + "<label for='model'>Model<\/label><input type='text' id='model' name='model' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial'>Serial<\/label><input type='text' id='serial' name='serial' size='20' \/><span style='color: red;'>*<\/span><br \/>";
            status_text = status_text + "<label for='asset_number'>Asset Number<\/label><input type='text' id='asset_number' name='asset_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='status'>Status<\/label><select id='status' name='status' style='width: 135px' ><option selected value='production'>Production<\/option><option value='retired'>Retired<\/option><option value='maintenance'>Maintenance<\/option><option value='deleted'>Deleted<\/option><option value='unallocated'>Unallocated<\/option><option value='lost'>Lost<\/option><\/select><br \/>";
            status_text = status_text + "<label for='environment'>Environment<\/label><select id='environment' name='environment' ><option selected value='production'>Production<\/option><option value='pre-prod'>PreProduction<\/option><option value='test'>Testing<\/option><option value='uat'>User Acceptance Testing<\/option><option value='eval'>Evaluation<\/option><option value='dev'>Development<\/option><option value='dr'>Disaster Recovery<\/option><\/select><br \/>";
            status_text = status_text + "<label for='purchase_order_number'>PO Number<\/label><input type='text' id='purchase_order_number' name='purchase_order_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_cost_center'>Cost Center<\/label><input type='text' id='purchase_cost_center' name='purchase_cost_center' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_vendor'>Vendor<\/label><input type='text' id='purchase_vendor' name='purchase_vendor' size='20' \/><br \/>";
            status_text = status_text + "<\/td><td valign=\"top\">";
            status_text = status_text + "<label for='purchase_date'>Purchase Date<\/label><input type='text' id='purchase_date' name='purchase_date' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='purchase_amount'>Purchase Amount<\/label><input type='text' id='purchase_amount' name='purchase_amount' size='20' \/><br \/>";
            status_text = status_text + "<label for='warranty_duration'>Warranty Duration<\/label><input type='text' id='warranty_duration' name='warranty_duration' size='20' title='in months' \/><br \/>";
            status_text = status_text + "<label for='warranty_expires'>Warranty Expiration Date<\/label><input type='text' id='warranty_expires' name='warranty_expires' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='service_number'>Phone Service Number<\/label><input type='text' id='service_number' name='service_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='service_provider'>Service Provider<\/label><input type='text' id='service_provider' name='service_provider' size='20' \/><br \/>";
            status_text = status_text + "<label for='service_type'>Service Type<\/label><select id='service_type' name='service_type' style='width: 135px' ><option value=' '>&nbsp;<\/option><option value='voice'>Voice only<\/option><option value='data'>Data only<\/option><option value='voice and data'>Voice and Data<\/option><\/select><br \/>";
            status_text = status_text + "<label for='service_plan'>Service Plan<\/label><input type='text' id='service_plan' name='service_plan' size='20' title='$49 / month, etc' \/><br \/>";
            status_text = status_text + "<label for='service_network'>Service Network<\/label><input type='text' id='service_network' name='service_network' size='20' title='GSM, 2G, 3G, NextG, 4G, etc' \/><br \/>";
            status_text = status_text + "<label for='unlock_pin'>Tablet PIN<\/label><input type='text' id='unlock_pin' name='unlock_pin' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial_imei'>IMEI Serial<\/label><input type='text' id='serial_imei' name='serial_imei' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial_sim'>SIM Serial<\/label><input type='text' id='serial_sim' name='serial_sim' size='20' \/><br \/>";
            status_text = status_text + "<\/td><\/tr><\/table>";
            status_text = status_text + "<br \/><p><label for='submit'>&nbsp;<\/label><input type='submit' name='submit' value='<?php echo __('Submit'); ?>' id='submit' \/><\/p>";
            break;

        case "computer":
            status_text = "<table><tr><td valign=\"top\">";
            status_text = status_text + "<label for='hostname'>Hostname<\/label><input type='text' id='hostname' name='hostname' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<label for='owner'>Assigned To<\/label><input type='text' id='owner' name='owner' size='20' \/><br \/>";
            status_text = status_text + "<label for='ip'>IP Address<\/label><input type='text' id='ip' name='ip' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<label for='os_group'>OS Group<\/label><input type='text' id='os_group' name='os_group' size='20' title='linux, windows, etc' \/> or <br \/>";
            status_text = status_text + " <?php echo $os_group_form;?>";
            status_text = status_text + "<label for='os_family_typed'>OS Family<\/label><input type='text' id='os_family_typed' name='os_family_typed' size='20' title='Windows XP, etc' \/> or <br \/>";
            status_text = status_text + " <?php echo $os_family_form;?>";
            status_text = status_text + "<label for='os_name'>OS Name<\/label><input type='text' id='os_name' name='os_name' size='20' title='Windows XP Professional, etc' \/> or <br \/>";
            status_text = status_text + " <?php echo $os_name_form;?>";
            status_text = status_text + "<label for='description'>Description<\/label><input type='text' id='description' name='description' size='20' \/><br \/>";
            status_text = status_text + "<?php echo $location_form;?>";
            status_text = status_text + "<?php echo $org_form;?>";
            status_text = status_text + "<label for='manufacturer'>Manufacturer<\/label><input type='text' id='manufacturer' name='manufacturer' size='20' \/><br \/>";
            status_text = status_text + "<label for='model'>Model<\/label><input type='text' id='model' name='model' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial'>Serial<\/label><input type='text' id='serial' name='serial' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<\/td><td valign=\"top\">";
            status_text = status_text + "<label for='asset_number'>Asset Number<\/label><input type='text' id='asset_number' name='asset_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='status'>Status<\/label><select id='status' name='status' style='width: 135px' ><option selected value='production'>Production<\/option><option value='retired'>Retired<\/option><option value='maintenance'>Maintenance<\/option><option value='deleted'>Deleted<\/option><option value='unallocated'>Unallocated<\/option><option value='lost'>Lost<\/option><\/select><br \/><label for='environment'>Environment<\/label><select id='environment' ><option selected value='production'>Production<\/option><option value='pre-prod'>PreProduction<\/option><option value='test'>Testing<\/option><option value='uat'>User Acceptance Testing<\/option><option value='eval'>Evaluation<\/option><option value='dev'>Development<\/option><option value='dr'>Disaster Recovery<\/option><\/select><br \/>";
            status_text = status_text + "<label for='purchase_order_number'>PO Number<\/label><input type='text' id='purchase_order_number' name='purchase_order_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_cost_center'>Cost Center<\/label><input type='text' id='purchase_cost_center' name='purchase_cost_center' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_vendor'>Vendor<\/label><input type='text' id='purchase_vendor' name='purchase_vendor' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_date'>Purchase Date<\/label><input type='text' id='purchase_date' name='purchase_date' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='purchase_amount'>Purchase Amount<\/label><input type='text' id='purchase_amount' name='purchase_amount' size='20' \/><br \/>";
            status_text = status_text + "<label for='warranty_duration'>Warranty Duration<\/label><input type='text' id='warranty_duration' name='warranty_duration' size='20' title='in months' \/><br \/>";
            status_text = status_text + "<label for='warranty_expires'>Warranty Expiration Date<\/label><input type='text' id='warranty_expires' name='warranty_expires' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<\/td><\/tr><\/table>";
            status_text = status_text + "<br \/><p><label for='submit'>&nbsp;<\/label><input type='submit' name='submit' value='<?php echo __('Submit'); ?>' id='submit' \/><\/p>";
            break;

        case "network printer":
        case "network scanner":
            status_text = "<table><tr><td valign=\"top\">";
            status_text = status_text + "<label for='hostname'>Hostname<\/label><input type='text' id='hostname' name='hostname' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<label for='owner'>Assigned To<\/label><input type='text' id='owner' name='owner' size='20' \/><br \/>";
            status_text = status_text + "<label for='ip'>IP Address<\/label><input type='text' id='ip' name='ip' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<label for='description'>Description<\/label><input type='text' id='description' name='description' size='20' \/><br \/>";
            status_text = status_text + "<?php echo $location_form;?>";
            status_text = status_text + "<?php echo $org_form;?>";
            status_text = status_text + "<label for='manufacturer'>Manufacturer<\/label><input type='text' id='manufacturer' name='manufacturer' size='20' \/><br \/>";
            status_text = status_text + "<label for='model'>Model<\/label><input type='text' id='model' name='model' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial'>Serial<\/label><input type='text' id='serial' name='serial' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<label for='asset_number'>Asset Number<\/label><input type='text' id='asset_number' name='asset_number' size='20' \/><br \/>";
            status_text = status_text + "<\/td><td valign=\"top\">";
            status_text = status_text + "<label for='status'>Status<\/label><select id='status' name='status' style='width: 135px' ><option selected value='production'>Production<\/option><option value='retired'>Retired<\/option><option value='maintenance'>Maintenance<\/option><option value='deleted'>Deleted<\/option><option value='unallocated'>Unallocated<\/option><option value='lost'>Lost<\/option><\/select><br \/><label for='environment'>Environment<\/label><select id='environment' ><option selected value='production'>Production<\/option><option value='pre-prod'>PreProduction<\/option><option value='test'>Testing<\/option><option value='uat'>User Acceptance Testing<\/option><option value='eval'>Evaluation<\/option><option value='dev'>Development<\/option><option value='dr'>Disaster Recovery<\/option><\/select><br \/>";
            status_text = status_text + "<label for='purchase_order_number'>PO Number<\/label><input type='text' id='purchase_order_number' name='purchase_order_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_cost_center'>Cost Center<\/label><input type='text' id='purchase_cost_center' name='purchase_cost_center' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_vendor'>Vendor<\/label><input type='text' id='purchase_vendor' name='purchase_vendor' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_date'>Purchase Date<\/label><input type='text' id='purchase_date' name='purchase_date' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='purchase_amount'>Purchase Amount<\/label><input type='text' id='purchase_amount' name='purchase_amount' size='20' \/><br \/>";
            status_text = status_text + "<label for='warranty_duration'>Warranty Duration<\/label><input type='text' id='warranty_duration' name='warranty_duration' size='20' title='in months' \/><br \/>";
            status_text = status_text + "<label for='warranty_expires'>Warranty Expiration Date<\/label><input type='text' id='warranty_expires' name='warranty_expires' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<\/td><\/tr><\/table>";
            status_text = status_text + "<br \/><p><label for='submit'>&nbsp;<\/label><input type='submit' name='submit' value='<?php echo __('Submit'); ?>' id='submit' \/><\/p>";
            break;

        case "printer":
        case "projector":
        case "scanner":
            status_text = "<table><tr><td valign=\"top\">";
            status_text = status_text + "<label for='hostname'>Hostname<\/label><input type='text' id='hostname' name='hostname' size='20' \/><span style='color: red;'>*<\/span> (of the attached PC)<br \/>";
            status_text = status_text + "<label for='owner'>Assigned To<\/label><input type='text' id='owner' name='owner' size='20' \/><br \/>";
            status_text = status_text + "<label for='description'>Description<\/label><input type='text' id='description' name='description' size='20' \/><br \/>";
            status_text = status_text + "<?php echo $location_form;?>";
            status_text = status_text + "<?php echo $org_form;?>";
            status_text = status_text + "<label for='manufacturer'>Manufacturer<\/label><input type='text' id='manufacturer' name='manufacturer' size='20' \/><br \/>";
            status_text = status_text + "<label for='model'>Model<\/label><input type='text' id='model' name='model' size='20' \/><\/span><br \/>";
            status_text = status_text + "<label for='serial'>Serial<\/label><input type='text' id='serial' name='serial' size='20' \/><span style='color: red;'>*<\/span><br \/>";
            status_text = status_text + "<label for='asset_number'>Asset Number<\/label><input type='text' id='asset_number' name='asset_number' size='20' \/><br \/>";
            status_text = status_text + "<\/td><td valign=\"top\">";
            status_text = status_text + "<label for='status'>Status<\/label><select id='status' name='status' style='width: 135px' ><option selected value='production'>Production<\/option><option value='retired'>Retired<\/option><option value='maintenance'>Maintenance<\/option><option value='deleted'>Deleted<\/option><option value='unallocated'>Unallocated<\/option><option value='lost'>Lost<\/option><\/select><br \/><label for='environment'>Environment<\/label><select id='environment' ><option selected value='production'>Production<\/option><option value='pre-prod'>PreProduction<\/option><option value='test'>Testing<\/option><option value='uat'>User Acceptance Testing<\/option><option value='eval'>Evaluation<\/option><option value='dev'>Development<\/option><option value='dr'>Disaster Recovery<\/option><\/select><br \/>";
            status_text = status_text + "<label for='purchase_order_number'>PO Number<\/label><input type='text' id='purchase_order_number' name='purchase_order_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_cost_center'>Cost Center<\/label><input type='text' id='purchase_cost_center' name='purchase_cost_center' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_vendor'>Vendor<\/label><input type='text' id='purchase_vendor' name='purchase_vendor' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_date'>Purchase Date<\/label><input type='text' id='purchase_date' name='purchase_date' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='purchase_amount'>Purchase Amount<\/label><input type='text' id='purchase_amount' name='purchase_amount' size='20' \/><br \/>";
            status_text = status_text + "<label for='warranty_duration'>Warranty Duration<\/label><input type='text' id='warranty_duration' name='warranty_duration' size='20' title='in months' \/><br \/>";
            status_text = status_text + "<label for='warranty_expires'>Warranty Expiration Date<\/label><input type='text' id='warranty_expires' name='warranty_expires' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<\/td><\/tr><\/table>";
            status_text = status_text + "<br \/><p><label for='submit'>&nbsp;<\/label><input type='submit' name='submit' value='<?php echo __('Submit'); ?>' id='submit' \/><\/p>";
            break;

        case "game console":
            status_text = "<table><tr><td valign=\"top\">";
            status_text = status_text + "<label for='hostname'>Hostname<\/label><input type='text' id='hostname' name='hostname' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<label for='ip'>IP Address<\/label><input type='text' id='ip' name='ip' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<label for='os_group'>OS Group<\/label><input type='text' id='os_group' name='os_group' size='20' title='Xbox, Playstation, Wii, etc' \/><br \/>";
            status_text = status_text + "<label for='description'>Description<\/label><input type='text' id='description' name='description' size='20' \/><br \/>";
            status_text = status_text + "<?php echo $location_form;?>";
            status_text = status_text + "<?php echo $org_form;?>";
            status_text = status_text + "<label for='manufacturer'>Manufacturer<\/label><input type='text' id='manufacturer' name='manufacturer' size='20' \/><br \/>";
            status_text = status_text + "<label for='model'>Model<\/label><input type='text' id='model' name='model' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial'>Serial<\/label><input type='text' id='serial' name='serial' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<label for='asset_number'>Asset Number<\/label><input type='text' id='asset_number' name='asset_number' size='20' \/><br \/>";
            status_text = status_text + "<\/td><td valign=\"top\">";
            status_text = status_text + "<label for='status'>Status<\/label><select id='status' name='status' style='width: 135px' ><option selected value='production'>Production<\/option><option value='retired'>Retired<\/option><option value='maintenance'>Maintenance<\/option><option value='deleted'>Deleted<\/option><option value='unallocated'>Unallocated<\/option><option value='lost'>Lost<\/option><\/select><br \/><label for='environment'>Environment<\/label><select id='environment' ><option selected value='production'>Production<\/option><option value='pre-prod'>PreProduction<\/option><option value='test'>Testing<\/option><option value='uat'>User Acceptance Testing<\/option><option value='eval'>Evaluation<\/option><option value='dev'>Development<\/option><option value='dr'>Disaster Recovery<\/option><\/select><br \/>";
            status_text = status_text + "<label for='purchase_order_number'>PO Number<\/label><input type='text' id='purchase_order_number' name='purchase_order_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_cost_center'>Cost Center<\/label><input type='text' id='purchase_cost_center' name='purchase_cost_center' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_vendor'>Vendor<\/label><input type='text' id='purchase_vendor' name='purchase_vendor' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_date'>Purchase Date<\/label><input type='text' id='purchase_date' name='purchase_date' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='purchase_amount'>Purchase Amount<\/label><input type='text' id='purchase_amount' name='purchase_amount' size='20' \/><br \/>";
            status_text = status_text + "<label for='warranty_duration'>Warranty Duration<\/label><input type='text' id='warranty_duration' name='warranty_duration' size='20' title='in months' \/><br \/>";
            status_text = status_text + "<label for='warranty_expires'>Warranty Expiration Date<\/label><input type='text' id='warranty_expires' name='warranty_expires' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<\/td><\/tr><\/table>";
            status_text = status_text + "<br \/><p><label for='submit'>&nbsp;<\/label><input type='submit' name='submit' value='<?php echo __('Submit'); ?>' id='submit' \/><\/p>";
            break;

        default:
            status_text = "<table><tr><td valign=\"top\">";
            status_text = status_text + "<label for='hostname'>Hostname<\/label><input type='text' id='hostname' name='hostname' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<label for='ip'>IP Address<\/label><input type='text' id='ip' name='ip' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<label for='os_group'>OS Group<\/label><input type='text' id='os_group' name='os_group' size='20' title='ios, etc' \/><br \/>";
            status_text = status_text + "<label for='os_family'>OS Family<\/label><input type='text' id='os_family' name='os_family' size='20' title='Cisco IOS 14, etc' \/><br \/>";
            status_text = status_text + "<label for='os_name'>OS Name<\/label><input type='text' id='os_name' name='os_name' size='20' title='Cisco IOS 14 v123, etc' \/><br \/>";;
            status_text = status_text + "<label for='description'>Description<\/label><input type='text' id='description' name='description' size='20' \/><br \/>";
            status_text = status_text + "<?php echo $location_form;?>";
            status_text = status_text + "<?php echo $org_form;?>";
            status_text = status_text + "<label for='manufacturer'>Manufacturer<\/label><input type='text' id='manufacturer' name='manufacturer' size='20' \/><br \/>";
            status_text = status_text + "<label for='model'>Model<\/label><input type='text' id='model' name='model' size='20' \/><br \/>";
            status_text = status_text + "<label for='serial'>Serial<\/label><input type='text' id='serial' name='serial' size='20' \/><span style='color: blue;'>*<\/span><br \/>";
            status_text = status_text + "<label for='asset_number'>Asset Number<\/label><input type='text' id='asset_number' name='asset_number' size='20' \/><br \/>";
            status_text = status_text + "<\/td><td valign=\"top\">";
            status_text = status_text + "<label for='status'>Status<\/label><select id='status' name='status' style='width: 135px' ><option selected value='production'>Production<\/option><option value='retired'>Retired<\/option><option value='maintenance'>Maintenance<\/option><option value='deleted'>Deleted<\/option><option value='unallocated'>Unallocated<\/option><option value='lost'>Lost<\/option><\/select><br \/><label for='environment'>Environment<\/label><select id='environment' ><option selected value='production'>Production<\/option><option value='pre-prod'>PreProduction<\/option><option value='test'>Testing<\/option><option value='uat'>User Acceptance Testing<\/option><option value='eval'>Evaluation<\/option><option value='dev'>Development<\/option><option value='dr'>Disaster Recovery<\/option><\/select><br \/>";
            status_text = status_text + "<label for='purchase_order_number'>PO Number<\/label><input type='text' id='purchase_order_number' name='purchase_order_number' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_cost_center'>Cost Center<\/label><input type='text' id='purchase_cost_center' name='purchase_cost_center' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_vendor'>Vendor<\/label><input type='text' id='purchase_vendor' name='purchase_vendor' size='20' \/><br \/>";
            status_text = status_text + "<label for='purchase_date'>Purchase Date<\/label><input type='text' id='purchase_date' name='purchase_date' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<label for='purchase_amount'>Purchase Amount<\/label><input type='text' id='purchase_amount' name='purchase_amount' size='20' \/><br \/>";
            status_text = status_text + "<label for='warranty_duration'>Warranty Duration<\/label><input type='text' id='warranty_duration' name='warranty_duration' size='20' title='in months' \/><br \/>";
            status_text = status_text + "<label for='warranty_expires'>Warranty Expiration Date<\/label><input type='text' id='warranty_expires' name='warranty_expires' size='20' title='YYYY-MM-DD' \/><br \/>";
            status_text = status_text + "<\/td><\/tr><\/table>";
            status_text = status_text + "<br \/><p><label for='submit'>&nbsp;<\/label><input type='submit' name='submit' value='<?php echo __('Submit'); ?>' id='submit' \/><\/p>";
            break;

    }
    document.getElementById("details").innerHTML = status_text;
}
</script>
