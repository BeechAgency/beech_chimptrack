<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/joshwayman
 * @since      1.0.0
 *
 * @package    Beech_chimptrack
 * @subpackage Beech_chimptrack/admin/partials
 */

$settings = $this->settings;
?>


<div class="wrap">
		<h1 class="wp-heading-inline">BEECH Chimptrack Settings</h1> 
		<div class="card">
			<p>Hello! The ChimpTrack settings here<br /> No bloated plugins with endless ads required.</p>
		</div>
	<form method="post" action="options.php">
		<?php settings_fields( 'beech_chimptrack_settings' ); ?>
		<?php do_settings_sections( 'beech_chimptrack_settings' ); ?>
		<div class="tab-list">
			<div class="tab-menu tab">
				<ul>
					<li><button class="tab-link active" onclick="openTab(event, 'BEECH-tab1');" >Config</button></li>
					<li><button class="tab-link" onclick="openTab(event, 'BEECH-tab2');" >Settings</button></li>
					<li><?php submit_button(); ?></li>
				</ul>
			</div>
			<div class="tab-body-container">
				<div class="tab-content active" id="BEECH-tab1">	
					<h2>Config</h2>			
					<table class="form-table">
                        <?php foreach($settings as $setting): 
                            if($setting['group'] !== 'Config') continue; ?>
						<tr valign="top">
                            <th><?= $setting['title'] ?><br ><span class="light"><?= $setting['description'] ?></span></th>
                            <td>
                            <?php if($setting['type'] === 'boolean') { ?>
                                <input type="radio" name="<?= $setting['key'] ?>" value="1" <?php checked( '1', get_option( $setting['key'] ) ); ?> /> Yes
                                <input type="radio" name="<?= $setting['key'] ?>" value="0" <?php checked( '0', get_option( $setting['key'] ) ); ?> /> No
                            <?php } else { ?>
                                <div>
									<input type="text" 
										name="<?= $setting['key'] ?>" 
										id="<?= $setting['key'] ?>" 
										class="regular-text"
										value="<?php echo get_option(  $setting['key'] ); ?>"
										/>
								</div>
                            <?php } ?>    
                            </td>
                        </tr>
                        <?php endforeach;?>
					</table>
				</div>
				<div class="tab-content" id="BEECH-tab2" style="display: none;">
					<h2>Settings</h2>
					<table class="form-table">
						<?php foreach($settings as $setting): 
                            if($setting['group'] !== 'Settings') continue; ?>
						<tr valign="top">
                            <th><?= $setting['title'] ?><br ><span class="light"><?= $setting['description'] ?></span></th>
                            <td>
                            <?php if($setting['type'] === 'boolean') { ?>
                                <input type="radio" name="<?= $setting['key'] ?>" value="1" <?php checked( '1', get_option( $setting['key'] ) ); ?> /> Yes
                                <input type="radio" name="<?= $setting['key'] ?>" value="0" <?php checked( '0', get_option( $setting['key'] ) ); ?> /> No
                            <?php } else { ?>
                                <div>
									<input type="text" 
										name="<?= $setting['key'] ?>" 
										id="<?= $setting['key'] ?>" 
										class="regular-text"
										value="<?php echo get_option(  $setting['key'] ); ?>"
										/>
								</div>
                            <?php } ?>    
                            </td>
                        </tr>
                        <?php endforeach;?>

					</table>
				</div>
			</div>

			
	</form>
</div>
