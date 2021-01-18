<?php

/**
 * @project:   Community Awards
 *
 * @copyright  (C) 2021 Portland Labs (https://www.portlandlabs.com)
 * @author     Fabian Bitter (fabian@bitter.de)
 */

defined('C5_EXECUTE') or die('Access denied');

use Concrete\Core\Form\Service\Form;
use Concrete\Core\Form\Service\Widget\UserSelector;
use Concrete\Core\Page\Page;
use Concrete\Core\Support\Facade\Url;
use Concrete\Core\User\User;
use Concrete\Core\Support\Facade\Application;
use Concrete\Core\Utility\Service\Identifier;
use PortlandLabs\CommunityAwards\Entity\AwardedAward;
use PortlandLabs\CommunityAwards\Entity\AwardGrant;

/** @var AwardGrant[] $grantedAwards */
/** @var AwardedAward[] $awardedAwards */

$app = Application::getFacadeApplication();
/** @var Identifier $idHelper */
$idHelper = $app->make(Identifier::class);
/** @var Form $form */
$form = $app->make(Form::class);
/** @var UserSelector $userSelector */
$userSelector = $app->make(UserSelector::class);
$user = new User();
?>

<div class="public-profile" style="margin-top: 0">
    <?php if (count($grantedAwards) > 0 && $user->isRegistered()) { ?>
        <div class="card">
            <div class="card-body">
                <div class="card-title">
            <span>
                <?php echo t("Granted Awards"); ?>
            </span>
                </div>
            </div>

            <div class="card-text">
                <div class="row">
                    <div class="col">
                        <div class="profile-badges">
                            <?php foreach ($grantedAwards as $grantedAward) { ?>
                                <?php
                                $id = "give-award-" . $idHelper->getString();
                                ?>
                                <div class="profile-badge">
                                    <a href="javascript:void(0);"
                                       title="<?php echo h(t("Click here to give this award to another user.")); ?>"
                                       class="give-award"
                                       data-toggle="modal" data-target="#<?php echo $id; ?>"
                                    >
                                        <img src="<?php echo $grantedAward->getAward()->getThumbnail()->getApprovedVersion()->getURL(); ?>"
                                             alt="<?php echo h($grantedAward->getAward()->getName()); ?>">
                                    </a>
                                </div>

                                <div class="modal community-award-modal" tabindex="-1" role="dialog"
                                     id="<?php echo $id; ?>">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <?php echo t("Give Award"); ?>
                                                </h5>
                                            </div>

                                            <div class="modal-body">
                                                <?php echo $form->hidden("grantedAwardId", $grantedAward->getId()); ?>

                                                <div class="form-group">
                                                    <?php echo $form->label("user", t("User")); ?>
                                                    <?php echo $userSelector->quickSelect("user"); ?>

                                                    <div class="help-block">
                                                        <?php echo t("Enter the username of the user that you want to give that award."); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <?php echo t("Cancel"); ?>
                                                </button>

                                                <button type="button" class="btn btn-primary">
                                                    <?php echo t("Give Award"); ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if (count($awardedAwards) > 0) { ?>
        <div class="card">
            <div class="card-body">
                <div class="card-title">
            <span>
                <?php echo t("Awarded Awards"); ?>
            </span>
                </div>
            </div>

            <div class="card-text">
                <div class="row">
                    <div class="col">
                        <div class="profile-badges">
                            <?php foreach ($awardedAwards as $awardedAward) { ?>
                                <div class="profile-badge">
                                    <img src="<?php echo $awardedAward->getAward()->getThumbnail()->getApprovedVersion()->getURL(); ?>"
                                         alt="<?php echo h($awardedAward->getAward()->getName()); ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
