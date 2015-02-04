<?php 
	if(isset($_POST['np_pages'])&&$_POST['np_pages']!=''){
			//form submitted
			if ( 
				! isset( $_POST['wp_page_nonce_field'] ) 
				|| ! wp_verify_nonce( $_POST['wp_page_nonce_field'], 'wp_page_action' ) 
			) {
			   print 'Sorry, your nonce did not verify.';
			   exit;

			} else {
			if(preg_match_all('/(\d+\|(-|new)?\d+\|[^\|]*\|[^\n]*)/',$_POST['np_pages'],$match_pg)){
				$newpage = array();
				foreach($match_pg[0] as $pg_res){
					if(preg_match('/((\d+)\|((-|new)?\d+)\|([^\|]*)\|(.*))/',$pg_res,$rres)){
						$parent = -1;
						if($rres[4]=='new'){
							$parent = $newpage[str_ireplace('new','',$rres[3])];
						}else{
							$parent = $rres[3];
						}
						if($parent==-1) $parent = 0;
						
						$pcontent = '';
						$pcontent = str_ireplace('[pagetitle]','<h1>' . htmlentities($rres[5]) . '</h1>',$_POST['wp-pages-content']);
						$url = $_POST['slug'];
						
						$params = array( 
							'post_type' => 'page',
							'post_status' => $_POST['posttype'],
							'post_title' => rtrim($rres[5]),
							'post_content' => $pcontent,
							'guid' => $url
							);
							
						
						global $wpdb;
						$params['menu_order'] = $wpdb->get_var("SELECT MAX(menu_order)+1 AS menu_order FROM {$wpdb->posts} WHERE post_type='page'");
						$wpdb->flush();

						$newpage[$rres[2]] = wp_insert_post($params);
					}
				}
				
				echo '<script type="text/javascript">window.location=\'options-general.php?page=wp_add_page&saved=1\';</script>';
			}
		}
		}
		?>
		<div class="wp_page_wrap">
			<?php if(isset($_GET['saved']) && $_GET['saved']=='1'){ ?>
				<div id="setting-error-settings_updated" class="updated settings-error"><p><strong> Page Created successfully! </strong></p></div>
			<?php } ?>
			<h3>Add New Page</h3>
			<table>
				<tr>
					<td id="page_ids" style="display:none;">
						<?php wp_dropdown_pages('sort_column=menu_order&post_status=draft,publish&show_option_none=(No Parent)'); ?>
					</td>
				</tr>
			</table>
			  <form id="wp-add-pages" name="wp-add-pages" method="post" action="?page=<?php echo $_GET['page']; ?>">
			  
		      <?php wp_nonce_field( 'wp_page_action', 'wp_page_nonce_field' ); ?>
				<textarea id="np_pages" name="np_pages" style="display:none;"></textarea>
				 <select id="posttype" name="posttype" style="display:none;" >
					<option value="publish">published</option>
					<option value="draft">draft</option>
				 </select><br /><br />
				 
				   <p>Page url</p>
			       <input type="text" name="slug" id="article_slug"  value="<?php echo site_url();?>/ "  disabled="disabled" />
					<p>Page Title</p>
					<input size="50" type="text" id="wp-page-name" class="article_title" name="wp-page-name" required />
					<p>Description</p>
					<textarea cols="60" rows="5" id="wp-pages-content" name="wp-pages-content" required ></textarea><br /><br />
			     	<input type="submit" class="button-primary" value="Add Page" />
			</form>
		</div>
		  <script>
		      var site_url = '<?php echo site_url();?>/';
			  jQuery('.article_title').change(function() {
			  str = jQuery('.article_title').val();
			  formatted = str.replace(/\s+/g, '-').toLowerCase();
			  jQuery('#article_slug').val(site_url+formatted);
			  });
			</script>
