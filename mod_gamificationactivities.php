<?php
/**
 * @package      Gamification Platform
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2014 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined("_JEXEC") or die;

jimport("gamification.init");

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

// Get component parameters
$componentParams = JComponentHelper::getParams("com_gamification");

// Load helpers
JHtml::addIncludePath(GAMIFICATION_PATH_COMPONENT_SITE.'/helpers/html');

$imagePath       = $componentParams->get("images_directory", "images/gamification");

jimport('gamification.activities');

$options = array(
    "sort_direction" => "DESC",
    "limit"          => $params->get("results_number", 10)
);

$activities     = new GamificationActivities();
$activities->load($options);

$avatarSize     = $params->get("avatar_size", 50);
$nameLinkable   = $params->get("name_linkable", 1);
$integrateType  = $params->get("integrate", "none");

$socialProfiles = null;
$numberItems    = count($activities);

if ((strcmp("none", $integrateType) != 0) and !empty($numberItems)) {
    
    foreach ($activities as $item) {
        $usersIds[] = $item->user_id;
    }
    
    jimport("itprism.integrate.profiles");
    $socialProfiles = ITPrismIntegrateProfiles::factory($integrateType, $usersIds);
}

require JModuleHelper::getLayoutPath('mod_gamificationactivities', $params->get('layout', 'default'));