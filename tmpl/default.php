<?php
/**
 * @package      Gamification Platform
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;
?>
<div class="gfy-mod-activities<?php echo $moduleclass_sfx;?>">

<?php for ($i = 0; $i < $numberItems; $i++) {
    // Social Profile
    if (!empty($socialProfiles)) {

        // Get avatar
        $avatar = $socialProfiles->getAvatar($activities[$i]["user_id"], $avatarSize, $returnDefaultAvatar);
        if (!$avatar) {
            $avatar = '<img class="media-object" src="'.$defaultAvatar.'">';
        } else {
            $avatar = '<img class="media-object" src="'.$avatar.'">';
        }
    
        $link   =  $socialProfiles->getLink($activities[$i]["user_id"]);
    
    } else {
        $avatar = '<img class="media-object" src="media/com_gamification/images/default_square.png" width="50" height="50">';
        $link   = 'javascript: void(0);';
    }

    $cleanName = htmlspecialchars($activities[$i]["name"], ENT_QUOTES, "UTF-8");

    if (!$nameLinkable) {
        $name = $cleanName;
    } else {
        $name = '<a href="'.$link.'">'.htmlspecialchars($activities[$i]["name"], ENT_QUOTES, "UTF-8").'</a>';
    }
    
    ?>
    <div class="media">
        <div class="media-left">
            <a href="<?php echo $link;?>">
                <?php echo $avatar; ?>
            </a>
        </div>

        <div class="media-body">
            <h5 class="media-heading"><?php echo $name;?></h5>
            <p><?php echo htmlspecialchars($activities[$i]["info"], ENT_QUOTES, "UTF-8");?></p>
        </div>
    </div>
<?php } ?>

</div>
