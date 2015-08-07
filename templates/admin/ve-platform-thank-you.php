<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<fieldset id="veinteractive_main">
    <div class="ve_header">
        <div class="header_top content_grid">
            <div class="left_header">
                <img src="<?php echo _VEPLATFORM_PLUGIN_URL_; ?>assets/img/main-logo.png" alt="VeInteractive"/>
            </div>
        </div>
        <div class="faint-line">
            <div class="main_messages content_grid">
                <h2 class="thx-msg">
                    <?php echo __('VE_THANK_YOU_FOR_SELECTING', 'veplatform'); ?>
                </h2>
                <h2 class="conf-msg">
                    <?php echo __('VE_NEXT_STEPS', 'veplatform'); ?>
                </h2>
            </div>
        </div>
    </div>
    <div class="ve_main">
        <div class="thanks_info content_grid">
            <div class="info_text">
                <img src="<?php echo _VEPLATFORM_PLUGIN_URL_; ?>assets/img/woocommerce_logo.png" alt="WooCommerce" />
                <p><?php echo __('VE_THANK_YOU_FOR_SELECTING_APP', 'veplatform'); ?></p>
                <p><?php echo __('VE_ACCOUNT_MANAGER_CONTACT', 'veplatform'); ?></p>
                <p><?php echo __('VE_CREATIVE_EXAMPLES_APP', 'veplatform'); ?></p>
                <ul class="social-info">
                  <li><span class="icons-envelope"></span><a href="mailto:woocommerce@veinteractive.com">woocommerce@veinteractive.com</a></li>
                  <li><span class="icons-phone"></span><span class="country">US:</span><span>+1 857- 284-7007</span></li>
                  <li><span class="icons-phone"></span><span class="country">UK:</span><span>+44 (0)20 337 22555</span></li>
                </ul>
                <p><?php echo __('VE_BEST_REGARDS', 'veplatform'); ?></p>
                <p>Ve Interactive</p>
            </div>
        </div>
    </div>
    <div class="ve_footer">
        <div class="footer-content content_grid">
            <div class="footer-left">
                <span><a target="_blank" href="http://www.veinteractive.com/">Ve interactive</a></span>
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