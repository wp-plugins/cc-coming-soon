<style>
	#poststuff .theme-browser .theme .theme-name {
	    font-size: 15px;
	    font-weight: 600;
	    height: 18px;
	    margin: 0;
	    padding: 15px;
	    -webkit-box-shadow: inset 0 1px 0 rgba(0,0,0,.1);
	    box-shadow: inset 0 1px 0 rgba(0,0,0,.1);
	    overflow: hidden;
	    white-space: nowrap;
	    text-overflow: ellipsis;
	    background: #fff;
	    background: rgba(255,255,255,.65);
	}

	#poststuff .theme-browser .theme.active .theme-name {
	    background: #2f2f2f;
	    color: #fff;
	    padding-right: 110px;
	    font-weight: 300;
	    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.5);
	    box-shadow: inset 0 1px 1px rgba(0,0,0,.5);
	}

	#poststuff .theme-browser .theme .more-details {
		text-decoration: none;
		transition: all .2s ease-in-out;
	}

	#poststuff .theme-browser .theme .more-details:hover {
		background: rgba(46, 162, 204,.9);
		border-color: #0074a2;
		box-shadow: inset 0 1px 0 rgba(120,200,230,.5),0 1px 0 rgba(0,0,0,.15);
	}
</style>
<div class="themes-php">
	<div class="wrap">
		<h2>Templates <span class="theme-count title-count">1 (Available in Pro: 6)</span></h2>
		<div class="theme-browser rendered">
			<div class="themes">

				<div class="theme active" tabindex="0">
					<div class="theme-screenshot">
						<img src="<?php echo CC_CS_PLUGIN_URL . 'admin/assets/screenshots/default.jpg'; ?>" alt="" />
					</div>
					<h3 class="theme-name" id="default-name"><span>Active:</span> Default</h3>
					<div class="theme-actions">
						<a  href="#" class="chch-put-template-edit button button-primary" data-template="default" data-nounce="<?php echo wp_create_nonce('cc-pu-preview-default'); ?>">Customize</a>
					</div>
					<?php 
						$preview = new CcComingSoonPreview('default', 'Default'); 
						$preview->build_preview();
					?> 
				</div>
	
				<div class="theme" tabindex="0">
					<div class="theme-screenshot">
						<img src="<?php echo CC_CS_PLUGIN_URL . 'admin/assets/screenshots/chic.jpg'; ?>" alt="" />
					</div>
					<a href="http://ch-ch.org/cspro" class="more-details">Available in Pro</a>
					<h3 class="theme-name">Chic</h3>
					<div class="theme-actions">
						<a class="button button-primary" href="https://shop.chop-chop.org/demo/cc-coming-soon-pro/?template=chic" target="_blank">Live Preview</a>
					</div>
				</div>

				<div class="theme" tabindex="0">
					<div class="theme-screenshot">
						<img src="<?php echo CC_CS_PLUGIN_URL . 'admin/assets/screenshots/mobility.jpg'; ?>" alt="" />
					</div>
					<a href="http://ch-ch.org/cspro" class="more-details">Available in Pro</a>
					<h3 class="theme-name">Mobility</h3>
					<div class="theme-actions">
						<a class="button button-primary" href="https://shop.chop-chop.org/demo/cc-coming-soon-pro/?template=mobility" target="_blank">Live Preview</a>
					</div>
				</div>

				<div class="theme" tabindex="0">
					<div class="theme-screenshot">
						<img src="<?php echo CC_CS_PLUGIN_URL . 'admin/assets/screenshots/calm.jpg'; ?>" alt="" />
					</div>
					<a href="http://ch-ch.org/cspro" class="more-details">Available in Pro</a>
					<h3 class="theme-name">Calm</h3>
					<div class="theme-actions">
						<a class="button button-primary" href="https://shop.chop-chop.org/demo/cc-coming-soon-pro/?template=calm" target="_blank">Live Preview</a>
					</div>
				</div>

				<div class="theme" tabindex="0">
					<div class="theme-screenshot">
						<img src="<?php echo CC_CS_PLUGIN_URL . 'admin/assets/screenshots/fitness.jpg'; ?>" alt="" />
					</div>
					<a href="http://ch-ch.org/cspro" class="more-details">Available in Pro</a>
					<h3 class="theme-name">Fitness</h3>
					<div class="theme-actions">
						<a class="button button-primary" href="https://shop.chop-chop.org/demo/cc-coming-soon-pro/?template=fitness" target="_blank">Live Preview</a>
					</div>
				</div>

				<div class="theme" tabindex="0">
					<div class="theme-screenshot">
						<img src="<?php echo CC_CS_PLUGIN_URL . 'admin/assets/screenshots/stylish.jpg'; ?>" alt="" />
					</div>
					<a href="http://ch-ch.org/cspro" class="more-details">Available in Pro</a>
					<h3 class="theme-name">Stylish</h3>
					<div class="theme-actions">
						<a class="button button-primary" href="https://shop.chop-chop.org/demo/cc-coming-soon-pro/?template=stylish" target="_blank">Live Preview</a>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>