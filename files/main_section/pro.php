<div id="features">
	<div id="post-body" class="metabox-holder columns-2">
		<div id="postbox-container-2 col-md-12" class="postbox-container">
			<div id="normal-sortables" class="meta-box-sortables ui-sortable">
				<div class="postbox popupCreator_features_postbox alpSameWidthPostBox" style="display: block;">
					<div class="handlediv featuresTitle" title="Click to toggle"><br></div>
						<h3 class="hndle ui-sortable-handle featuresTitle" style="cursor: pointer,"><span><b>Pro Features</b></span></h3>
							<div class="featuresContent">
								<span class="liquid-width">Show PopUp In Date Range : </span><label class="switch" data-toggle="tooltip" data-placement="right" title="Show the Popupon Date Range"><input class="input-width-static" type="checkbox" id="Date_Range_Change" name="DateRange" <?php echo $alpDateRange;?> /><span class="slider round"></span></label><br><br>
									<div class="container">									
										<div class="row" id="popup_date_filed">
											 <div for="" class=" lineheight">Select Date</div>
												 <div class='col-md-2'>
													<div class="form-group">	
													<div class='input-group date' id='start_date'>	
													<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
													</span>	
													<input type='text' class="form-control" placeholder="Start Date" id="From_date" name="DaterangeFromDate" value="<?php echo $alpFromDate;?>" /> 
													</div>
													 </div>
													</div>
													<div for="" class=" lineheight">to</div>
													<div class='col-md-2'>
													  <div class="form-group">	
														<div class='input-group date' id='end_date'>	
														<span class="input-group-addon">
														<span class="fa fa-calendar"></span>
														</span>	
														<input type='text' class="form-control" placeholder="End Date" id="To_date" name="DaterangeToDate" value="<?php echo $alpToDate;?>" />        
														</div>
													  </div>
													</div>
												  </div>
												</div>
    											<span class="liquid-width">Schedule PopUp : </span><label class="switch" data-toggle="tooltip" data-placement="right" title="Schedule Popup on Particular Date"><input class="input-width-static" type="checkbox" id="Schedule_PopUp" name="SchedulePopUp" <?php echo $alpSchedulePopUp;?>  /><span class="slider round"></span></label><br><br>										   
												<div class="container">									
												  <div class="row" id="popup_schedule_date">
												    <div for="" class="col-md-2 lineheight">Selecte Date :</div>
													 <div class='col-md-3'>
													  <div class="form-group">	
														<div class='input-group date' id='datetimepicker1'>	
														<span class="input-group-addon">
														<span class="fa fa-calendar"></span>
														</span>	
														<input type='text' class="form-control" placeholder="Select Date" id="select_date" name="SchedulePopUpDate" value="<?php echo $alpScheduleDate; ?>"/>        
														</div>
													  </div>
													</div>
												  </div>
												</div>
											<span class="liquid-width">Disable On Mobile Devices : </span><label class="switch" data-toggle="tooltip" data-placement="right" title="Disable Popup on Mobile Device"><input class="input-width-static" type="checkbox" id="Disable_toggle" name="MobileDisable" <?php echo $alpMobileDisable;?> /><span class="slider round"></span></label><br><br>
											<span class="liquid-width">Show Only on Mobile Devices : </span><label class="switch" data-toggle="tooltip" data-placement="right" title="Show Popup on Mobile Device Only"><input class="input-width-static" type="checkbox" id="Enable_toggle" name="MobileOnly" <?php echo $alpMobileOnly;?> /><span class="slider round"></span></label><br><br>											
											<span class="liquid-width">Show After Inactivity : </span><label class="switch" data-toggle="tooltip" data-placement="right" title="Show Popup on User Inactivity"><input class="input-width-static" type="checkbox" id="inactive" name="Inactivity" <?php echo $alpInactivity;?> /><span class="slider round"></span></label><br><br>
												<div class="acordion-main-div-content" id="popup-inactivitytime">
												   <span class="liquid-width">Popup Inactivity Time :</span>
												    <input type="number" class="popup-inactivity-value popup-delay" name="Inactivitytime" min="10" value="<?php echo esc_attr($alpInactivitytime); ?>">
							 						<span class="span-percent">after X seconds</span><br><br>																										 
												</div>													
											<span class="liquid-width">Show While Scrolling : </span><label class="switch" data-toggle="tooltip" data-placement="right" title="Show Popup on While Scrolling"><input class="input-width-static" id="WhileSrolling" type="checkbox" name="WhileScrolling" <?php echo $alpWhileScrolling;?> /><span class="slider round"></span></label><br><br>
											<span class="liquid-width">Show on Selected Pages : </span><label class="switch" data-toggle="tooltip" data-placement="right" title="Schedule Popup on Selected Page"><input class="input-width-static js-on-all-pages" id="SelectePages" type="checkbox" name="SelectePages" <?php echo @$alpSelectePages;?> /><span class="slider round"></span></label><br>
											<div class="js-all-pages-content acordion-main-div-content">
											<input type="hidden" value="<?php $args = array(														             
													'post_type' => 'page',
													'post_status' => 'publish',
													'posts_per_page' => -1,
													);
														$query = new WP_Query($args);
														while ($query->have_posts()) {
															$query->the_post();
															$alpCustomPostId = get_the_ID();	
															$alpPostId = explode(",",$alpCustomPostId);	
																foreach ($alpPostId as $key => $value) {
																echo "PageId_".$value.",";
																} }																									
													?>" name="ShowAllPageID">
											  <?php echo createRadiobuttons($pagesRadio, "OptionsPages", true, esc_html($alpOptionsPages), "radiobuttons"); ?>
											   	<div class="container">									
												  <div class="row" id="popup_select_page">
												    <div for="" class="col-md-2 lineheight liquid-width-radio">Selected On Custom Page:</div>
													 <div class='col-md-2'>																				
													 <select id="multi-select-page" multiple="multiple"   value="<?php //echo $alpShowPageId;?>">
													 <?php																								 	
														$args = array(
															'post_type' => 'page',
															'post_status' => 'publish',
															'posts_per_page' => -1,
																);
																$query = new WP_Query($args);
																while ($query->have_posts()) {
																	$query->the_post();
																	$alpCustomPostTitle = the_title ('','',false);
																	$alpCustomPostId = get_the_ID();
																	$alpPostId = explode(",",$alpCustomPostId);	
																	foreach ($alpPostId as $key => $value) {	
																	$idvalue = "PageId_".$value;	
															  ?>
													         <option value="<?php echo $idvalue; ?>"><?php echo $alpCustomPostTitle; ?></option>  
																<?php
																}	
															   	}																									
																?>		
																</select>				
																<input type="hidden" id="showcustoid" name="ShowCustomPageID" value="<?php echo $alpShowPageId;?>">															
												        	</div>
														</div>	
								    		        </div>
													<br></div><br>																			
											<span class="liquid-width">Show on Selected Posts : </span><label class="switch" data-toggle="tooltip" data-placement="right" title="Schedule Popup on Selected Post"><input class="input-width-static js-on-all-posts" id="SelectePosts" type="checkbox" name="SelectePosts" <?php echo $alpSelectePosts;?> /><span class="slider round"></span></label><br>
											<div class="js-all-posts-content acordion-main-div-content">
											<?php echo createRadiobuttons($postsRadio, "OptionsPosts", true, esc_html($alpOptionsPosts), "radiobuttons"); ?>
											<input type="hidden" value="				
										    <?php $args = array(
													'post_type' => 'post',
													'post_status' => 'publish',
													'posts_per_page' => -1,
													);
														$query = new WP_Query($args);
															while ($query->have_posts()) {
																$query->the_post();
																$alpCustomPostId = get_the_ID();	
															 	$alpPostId = explode(",",$alpCustomPostId);	
																foreach ($alpPostId as $key => $value) {
																echo "PostId_".$value.",";
																}}																																																		
																// wp_reset_postdata();
																?>" name="ShowAllPostID">
												<div class="container">									
												   <div class="row" id="popup_select_post">
												     <div for="" class="col-md-2 lineheight liquid-width-radio">Selected On Custom Post:</div>
													  <div class='col-md-2'>																				
													   <select id="multi-select-post"  multiple="multiple"  value="" >													
													  <?php																								 	
														$args = array(
															'post_type' => 'post',
															'post_status' => 'publish',
															'posts_per_page' => -1,
														    );
															 $query = new WP_Query($args);
																while ($query->have_posts()) {
																	$query->the_post();
																	$alpCustomPostTitle = get_the_title	 ('','',false);
																	$alpCustomPostId = get_the_ID();
																	$alpPostId = explode(",",$alpCustomPostId);	
																	foreach ($alpPostId as $key => $value) {	
																	$postidvalue = "PostId_".$value;																		
																?>																
													          <option value="<?php echo $postidvalue; ?>"><?php echo $alpCustomPostTitle; ?></option>  
																<?php
																} }																									
																?>																
																</select>													
																<input type="hidden" id="showcustpostid" name="ShowCustomPostID" value="<?php echo $alpShowPostID;?>">															
												    	  </div>
														</div>	
								    	              </div>
													<br></div><br>
									        	<!-- <span class="liquid-width">Add to Random PopUp list : </span><label class="switch"><input class="input-width-static" type="checkbox" name="RandomPopUp" <?php //echo $alpRandomPopUp;?> /><span class="slider round"></span></label><br><br> -->
											<span class="liquid-width">Auto Close Popup:</span><label class="switch" data-toggle="tooltip" data-placement="right" title="Auto Close the Popup Based on time intervel"><input id="js-auto-close"  class="input-width-static js-checkbox-acordion" type="checkbox" name="AutoClosePopup" <?php echo $alpautoClosePopup;?>><span class="slider round"></span></label><br><br>
										    <div class="js-auto-close-content acordion-main-div-content">
											<span class="liquid-width" >Popup Close</span><input class="popupTimer improveOptionsstyle popup-delay" id="popup_close_time" type="number" min="5" name="PopupClosingTimer" value="<?php echo esc_attr(@$alpPopupClosingTimer);?>"><span class="scroll-percent"> after X seconds</span>
										     <br><br></div>											
										    <span class="liquid-width">Disable PopUp Overlay : </span><label class="switch" data-toggle="tooltip" data-placement="right" title="Disable Popup Overlay"><input class="input-width-static" type="checkbox" name="DisableOverlay" <?php echo $alpDisableOverlay;?> /> <span class="slider round"></span></label><br><br>
										<!-- <span class="liquid-width">Show on Selected Custom  Posts : </span><label class="switch"><input class="input-width-static" type="checkbox" name="SelectCustomPost" <?php// echo $alpSelectCustomPost;?> /><span class="slider round"></span></label><br><br>-->
									<span class="liquid-width">Show PopUp by User Status : </span><label class="switch" data-toggle="tooltip" data-placement="right" title="Show Popup on User Status"><input class="input-width-static js-checkbox-acordion js-user-seperator" type="checkbox" name="UserStatus" <?php echo $alpUserStatus;?> ><span class="slider round"></span></label><br><br>
								<div class="acordion-main-div-content js-user-seperator-content">
							<?php echo ALPFunctions::alpCreateRadioElements($usersGroup, @$alpLogedUser);?>
						<br><br></div>							
					</div><br>
				</div>
			</div>
		</div>
	</div>
</div>