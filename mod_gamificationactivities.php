<?php
/**
 * @package      Gamification Platform
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined("_JEXEC") or die;

jimport("prism.init");
jimport("gamification.init");

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

// Get component parameters
$componentParams = JComponentHelper::getParams("com_gamification");

// Load helpers
JHtml::addIncludePath(GAMIFICATION_PATH_COMPONENT_SITE.'/helpers/html');

$imagePath       = $componentParams->get("images_directory", "images/gamification");

$options = array(
    "sort_direction" => "DESC",
    "limit"          => $params->get("results_number", 10)
);

$activities     = new Gamification\Activities(JFactory::getDbo());
$activities->load($options);

$avatarSize      = $params->get("integration_avatars_size", "small");
$defaultAvatar   = $componentParams->get("integration_avatars_default");

$nameLinkable    = $params->get("name_linkable", 1);
$socialPlatform  = $componentParams->get("integration_social_platform");

$socialProfiles = null;
$numberItems    = count($activities);

if (!empty($socialPlatform) and !empty($numberItems)) {

    $usersIds = array();
    foreach ($activities as $item) {
        $usersIds[] = $item["user_id"];
    }

    $usersIds = array_unique($usersIds);

    $config = array(
        "social_platform" => $socialPlatform,
        "users_ids" => $usersIds
    );

    JLoader::register("Prism\\Integration\\Profiles\\Builder", JPATH_LIBRARIES . '/prism/integration/profiles/builder.php');

    $socialBuilder = new Prism\Integration\Profiles\Builder($config);
    $socialBuilder->build();

    $socialProfiles = $socialBuilder->getProfiles();

    $returnDefaultAvatar = Prism\Constants::RETURN_DEFAULT;
    if ($socialPlatform == "easyprofile") {
        $returnDefaultAvatar = Prism\Constants::DO_NOT_RETURN_DEFAULT;
    }
}

require JModuleHelper::getLayoutPath('mod_gamificationactivities', $params->get('layout', 'default'));