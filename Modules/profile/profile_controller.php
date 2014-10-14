<?php
/*

All Emoncms code is released under the GNU Affero General Public License.
See COPYRIGHT.txt and LICENSE.txt.

---------------------------------------------------------------------
Emoncms - open source energy visualisation
Part of the OpenEnergyMonitor project:
http://openenergymonitor.org

*/
// no direct access
defined('EMONCMS_EXEC') or die('Restricted access');

function profile_controller()
{
    global $session, $route, $mysqli;
    $result = false;
    $submenu = false;

    require "Modules/profile/profile_model.php";
    $profile = new Profile($mysqli);

    if ($route->format == 'html' && $session['write'])
    {
        $profile_id = (int) $route->subaction;
        if ($profile_id<1) $profile_id = 1;
        $submenu = view("Modules/profile/greymenu.php",array());

        if ($route->action=='view') $result = view("Modules/profile/profile_view.php",array('profile_id'=>$profile_id));  
    }

    if ($route->format == 'json' && $session['write'])
    {  
        if ($route->action == 'save' && $session['write']) $result = $profile->save($session['userid'],get('profile_id'),get('data'));
        if ($route->action == 'get' && $session['write']) $result = $profile->get($session['userid'], get('profile_id'));
    }

    return array('content'=>$result,'submenu'=>$submenu);
}
