<?php 
	var_dump($BEECH_CHIMPTRACK['settings']);
?>
<div class="wrap">
		<h1 class="wp-heading-inline">BEECH Chimptrack Settings</h1> 
		<div class="card">
			<p>Hello! Control simple popups and notifications across your site here.<br /> No bloated plugins with endless ads required.</p>
		</div>
	<form method="post" action="options.php">
		<?php settings_fields( 'BEECH-chimptrack-settings' ); ?>
		<?php do_settings_sections( 'BEECH-chimptrack-settings' ); ?>
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
						<tr valign="top">
                            <th>Enable Chimp Track<br ><span class="light">Turn this pup on!</span></th>
                            <td>
                                <input type="radio" name="BEECH_chimptrack--SETTING__enabled" value="1" <?php checked( '1', get_option( 'BEECH_chimptrack--SETTING__enabled' ) ); ?> /> Yes
                                <input type="radio" name="BEECH_chimptrack--SETTING__enabled" value="0" <?php checked( '0', get_option( 'BEECH_chimptrack--SETTING__enabled' ) ); ?> /> No
                            </td>
                        </tr>


						<tr valign="top">
							<th scope="row">DC<br ><span class="light">The data center code, first 3 letter subdomain for your mailchimp URL</span></th>
							<td >
								<div>
									<input type="text" 
										name="BEECH_chimptrack--CONFIG__dc" 
										id="BEECH_chimptrack--CONFIG__dc" 
										class="regular-text"
										value="<?php echo get_option( 'BEECH_chimptrack--CONFIG__dc' ); ?>"
										/>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Audience ID<br ><span class="light"></span></th>
							<td >
								<div>
									<input type="text" 
										name="BEECH_chimptrack--CONFIG__audience_id" 
										id="BEECH_chimptrack--CONFIG__audience_id" 
										class="regular-text"
										value="<?php echo get_option( 'BEECH_chimptrack--CONFIG__audience_id' ); ?>"
										/>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">API Key<br ><span class="light"></span></th>
							<td >
								<div>
									<input type="password" 
										name="BEECH_chimptrack--CONFIG__apikey" 
										id="BEECH_chimptrack--CONFIG__apikey" 
										class="regular-text"
										value="<?php echo get_option( 'BEECH_chimptrack--CONFIG__apikey' ); ?>"
										/>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">API User<br ><span class="light"></span></th>
							<td >
								<div>
									<input type="text" 
										name="BEECH_chimptrack--CONFIG__apiuser" 
										id="BEECH_chimptrack--CONFIG__apiuser" 
										class="regular-text"
										value="<?php echo get_option( 'BEECH_chimptrack--CONFIG__apiuser' ); ?>"
										/>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="tab-content" id="BEECH-tab2" style="display: none;">
					<h2>Settings</h2>
					<table class="form-table">
						<?php 
						$settings = array(
							'BEECH_chimptrack--SETTING__track_pageviews',
							'BEECH_chimptrack--SETTING__track_gforms',
							'BEECH_chimptrack--SETTING__track_downloads',
							'BEECH_chimptrack--SETTING__all_3rd_party'
						);
						foreach($settings as $setting) :
						?>
						<tr valign="top">
                            <th><?= $setting ?><br ><span class="light"></span></th>
                            <td>
                                <input type="radio" name="<?= $setting ?>" value="1" <?php checked( '1', get_option( $setting  ) ); ?> /> Yes
                                <input type="radio" name="<?= $setting ?>" value="0" <?php checked( '0', get_option( $setting  ) ); ?> /> No
                            </td>
                        </tr>
						<?php endforeach; ?>

					</table>
				</div>
			</div>

			
	</form>
</div>