<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<form name="veplatform_conf" id="veplatform_conf" action="<?php echo _VEPLATFORM_PLUGIN_HTTP_URL_; ?>" method="POST">
    <fieldset id="veinteractive_main">
        <div class="ve_header">
            <div class="header_top content_grid">
                <div class="left_header">
                    <img src="<?php echo _VEPLATFORM_PLUGIN_URL_; ?>assets/img/main-logo.png" alt="VeInteractive"/>
                </div>
                <?php if ( $api->showLogin() ): ?>
                <div class="right_header">
                    <nav class="main_menu">
                        <ul>
                            <li>
                                <span class="cli_quest"><?php echo __('VE_ALREADY_CLIENT', 'veplatform'); ?></span>
                                <a target="_blank" href="http://veplatform.veinteractive.com/Account/Login?ReturnUrl=%2f">
                                    <?php echo __('VE_LOGIN', 'veplatform'); ?>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
            <div class="faint-line">
                <div class="main_messages content_grid">
                    <h2 class="thx-msg">
                        <?php echo __('VE_THANK_YOU_FOR_INSTALLING', 'veplatform'); ?>
                    </h2>
                    <h2 class="conf-msg">
                        <?php echo __('VE_NOW_CHOOSE_APPLICATIONS', 'veplatform'); ?>
                    </h2>
                </div>
            </div>
        </div>
        <div class="ve_main">
            <div class="company_info content_grid">
                <div class="info_text">
                    <img src="<?php echo _VEPLATFORM_PLUGIN_URL_; ?>assets/img/woocommerce_logo.png" alt="WooCommerce" />
                    <p>
                        <?php echo __('VE_BY_INTEGRATING_VEPLATFORM', 'veplatform'); ?>
                    </p>
                    <ul class="ve-list">
                        <li><?php echo __('VE_REDUCE_BOUNCE_RATE', 'veplatform'); ?></li>
                        <li><?php echo __('VE_RECOVER_LOST_SALES', 'veplatform'); ?></li>
                        <li><?php echo __('VE_INCREASE_CONVERSION', 'veplatform'); ?></li>
                        <li><?php echo __('VE_REACH_PROSPECTS', 'veplatform'); ?></li>
                    </ul>
                    <p><?php echo __('VE_ACTIVATING_VE_APPS', 'veplatform'); ?></p>
                </div>
            </div>
            <div class="product_activation">
                <div class="product_activation_content content_grid">
                    <h2 class="product_act_title"><?php echo __('VE_PLEASE_SELECT_APPS', 'veplatform'); ?></h2>
                    <div id="veads-section" class="veads product">
                        <div class="product_logo product-logo-clickable <?php if ($api->isProductActive('veads')): ?>no-clickable<?php endif; ?>" data-target="adsCb"></div>
                        <div class="product_name">
                            <p><?php echo __('VE_DYNAMIC_DISPLAY_ADVERTISING', 'veplatform'); ?></p>
                        </div>
                        <input type="checkbox" class="veplatform-checkbox" id="adsCb" name="product[]" value="veads" checked<?php if ($api->isProductActive('veads')): ?> disabled<?php endif; ?> />
                        <label for="adsCb"></label>
                        <button id="veads_moreinfo" class="quest_btn ve-open-info" data-target="veads_info_content">
                            <?php echo __('VE_FIND_OUT_MORE', 'veplatform'); ?><span class="icons-pike"></span>
                        </button>
                    </div>
                    <div id="veassist-section" class="veassist product">
                        <div class="product_logo product-logo-clickable <?php if ($api->isProductActive('veassist')): ?>no-clickable<?php endif; ?>" data-target="assistCb"></div>
                        <div class="product_name">
                            <p><?php echo __('VE_SEARCH_OPTIMIZATION', 'veplatform'); ?></p>
                        </div>
                        <input type="checkbox" class="veplatform-checkbox" id="assistCb" name="product[]" value="veassist" checked<?php if ($api->isProductActive('veassist')): ?> disabled<?php endif; ?> />
                        <label for="assistCb"></label>
                        <button id="veassist_moreinfo" class="quest_btn ve-open-info" data-target="veassist_info_content">
                            <?php echo __('VE_FIND_OUT_MORE', 'veplatform'); ?> <span class="icons-pike"></span>
                        </button>
                    </div>
                    <div id="veprompt-section" class="veprompt product">
                        <div class="product_logo product-logo-clickable <?php if ($api->isProductActive('vePrompt')): ?>no-clickable<?php endif; ?>" data-target="promptCb"></div>
                        <div class="product_name">
                            <p><?php echo __('VE_INCREASE_WEBSITE_CONVERSION', 'veplatform'); ?></p>
                        </div>
                        <input type="checkbox" class="veplatform-checkbox" id="promptCb" name="product[]" value="veprompt" checked<?php if ($api->isProductActive('veprompt')): ?> disabled<?php endif; ?> />
                        <label for="promptCb"></label>
                        <button id="veprompt_moreinfo" class="quest_btn ve-open-info" data-target="veprompt_info_content">
                            <?php echo __('VE_FIND_OUT_MORE', 'veplatform'); ?><span class="icons-pike"></span>
                        </button>
                    </div>
                    <div id="vecontact-section" class="vecontact product">
                        <div class="product_logo product-logo-clickable <?php if ($api->isProductActive('vecontact')): ?>no-clickable<?php endif; ?>" data-target="contactCb"></div>
                        <div class="product_name">
                            <p><?php echo __('VE_RECOVER_LOST_SHOPPING_CARTS', 'veplatform'); ?></p>
                        </div>
                        <input type="checkbox" class="veplatform-checkbox" id="contactCb" name="product[]" value="vecontact" checked<?php if ($api->isProductActive('vecontact')): ?> disabled<?php endif; ?> />
                        <label for="contactCb"></label>
                        <button id="vecontact_moreinfo" class="quest_btn ve-open-info" data-target="vecontact_info_content">
                            <?php echo __('VE_FIND_OUT_MORE', 'veplatform'); ?> <span class="icons-pike"></span>
                        </button>
                    </div>

                    <div class="vebutton">
                        <input name="ve-confirm-btn" id="confirm-btn" class="confirm-btn" type="submit" value="<?php echo __('VE_CONFIRM_SELECTION', 'veplatform'); ?>" />
                    </div>

                    <div class="product-extra-info">
                        <div id="veprompt_info_content" class="hidden ve-info-content">
                            <div class="extra_content content_grid">
                                <h2 class="product_act_title">VePrompt: <?php echo __('VE_INCREASE_WEBSITE_CONVERSION', 'veplatform'); ?></h2>
                                <div class="product_logo"></div>
                                <p>
                                    <?php echo __('VE_DESCRIPTION_VEPROMPT', 'veplatform'); ?>
                                </p>
                                <button id="veprompt_closeinfo" class="quest_btn ve-close-info" data-target="veprompt_info_content"><?php echo __('VE_CLOSE_APP_DETAILS', 'veplatform'); ?></button>
                            </div>
                        </div>
                        <div id="vecontact_info_content" class="hidden ve-info-content">
                            <div class="extra_content content_grid">
                                <h2 class="product_act_title">VeContact: <?php echo __('VE_RECOVER_LOST_SHOPPING_CARTS', 'veplatform'); ?></h2>
                                <div class="product_logo"></div>
                                <p>
                                    <?php echo __('VE_DESCRIPTION_VECONTACT', 'veplatform'); ?>
                                </p>
                                <button id="vecontact_closeinfo" class="quest_btn ve-close-info" data-target="vecontact_info_content"><?php echo __('VE_CLOSE_APP_DETAILS', 'veplatform'); ?></button>
                            </div>
                        </div>
                        <div id="veassist_info_content" class="hidden ve-info-content">
                            <div class="extra_content content_grid">
                                <h2 class="product_act_title">VeAssist: <?php echo __('VE_SEARCH_OPTIMIZATION', 'veplatform'); ?></h2>
                                <div class="product_logo"></div>
                                <p>
                                    <?php echo __('VE_DESCRIPTION_VEASSIST', 'veplatform'); ?>
                                </p>
                                <button id="veassist_closeinfo" class="quest_btn ve-close-info" data-target="veassist_info_content"><?php echo __('VE_CLOSE_APP_DETAILS', 'veplatform'); ?></button>
                            </div>
                        </div>
                        <div id="veads_info_content" class="hidden ve-info-content">
                            <div class="extra_content content_grid">
                                <h2 class="product_act_title">VeAds: <?php echo __('VE_DYNAMIC_DISPLAY_ADVERTISING', 'veplatform'); ?></h2>
                                <div class="product_logo"></div>
                                <p>
                                    <?php echo __('VE_DESCRIPTION_VEADS', 'veplatform'); ?>
                                </p>
                                <button id="veads_closeinfo" class="quest_btn ve-close-info" data-target="veads_info_content"><?php echo __('VE_CLOSE_APP_DETAILS', 'veplatform'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="legal_info content_grid">
                <div class="info_text">
                    <p><?php echo __('VE_INFO_LEGAL_TEXT', 'veplatform'); ?></p>
                </div>
            </div>
        </div>

        <div class="ve_footer">
            <div class="footer-content content_grid">
                <div class="footer-left">
                    <span><a target="_blank" href="<?php echo __('VE_LINK', 'veplatform'); ?>">Ve Interactive</a></span>
                </div>
                <div class="footer-center">
                    <img src="<?php echo _VEPLATFORM_PLUGIN_URL_; ?>assets/img/woocommerce_footer.png" alt="WooCommerce"/>
                </div>
                <div class="footer-right">
                    <span><?php echo __('VE_COPY_RIGHTS', 'veplatform'); ?> <?php echo date('Y'); ?> Ve Interactive </span>
                </div>
            </div>
        </div>
    </fieldset>
</form>