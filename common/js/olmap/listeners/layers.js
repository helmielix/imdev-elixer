// Create Function for add Listeners to Basemap Button
setListenersLayer = function() {
	
	// Add Listeners for layer_caboundary button
	$("#layer_caboundary").click(function() {
		if($(this).hasClass('selected')) {layer_caboundary.setVisible(true)} else {layer_caboundary.setVisible(false)};
	});

	// Add Listeners for layer_area_redline button
	$("#layer_area_redline").click(function() {
		if($(this).hasClass('selected')) {layer_area_redline.setVisible(true)} else {layer_area_redline.setVisible(false)};
	});
	
	/*
	// Add Listeners for layer_corporate_boundary button
	$("#layer_corporate_boundary").click(function() {
		if($(this).hasClass('selected')) {layer_corporate_boundary.setVisible(true)} else {layer_corporate_boundary.setVisible(false)};
	});
	*/
	
	// Add Listeners for layer_homepass_plan button
	$("#layer_homepass_plan").click(function() {
		if($(this).hasClass('selected')) {layer_homepass_plan.setVisible(true)} else {layer_homepass_plan.setVisible(false)};
	});
	
	// Add Listeners for layer_homepass_built button
	$("#layer_homepass_built").click(function() {
		if($(this).hasClass('selected')) {layer_homepass_built.setVisible(true)} else {layer_homepass_built.setVisible(false)};
	});
	
	// Add Listeners for layer_jalur_backbone_plan button
	$("#layer_jalur_backbone_plan").click(function() {
		if($(this).hasClass('selected')) {layer_jalur_backbone_plan.setVisible(true)} else {layer_jalur_backbone_plan.setVisible(false)};
	});
	
	// Add Listeners for layer_jalur_backbone_built button
	$("#layer_jalur_backbone_built").click(function() {
		if($(this).hasClass('selected')) {layer_jalur_backbone_built.setVisible(true)} else {layer_jalur_backbone_built.setVisible(false)};
	});
	
	// Add Listeners for layer_olt_built button
	$("#layer_olt_built").click(function() {
		if($(this).hasClass('selected')) {layer_olt_built.setVisible(true)} else {layer_olt_built.setVisible(false)};
	});
	
	// Add Listeners for layer_odc_plan button
	$("#layer_odc_plan").click(function() {
		if($(this).hasClass('selected')) {layer_odc_plan.setVisible(true)} else {layer_odc_plan.setVisible(false)};
	});
	
	// Add Listeners for layer_odc_built button
	$("#layer_odc_built").click(function() {
		if($(this).hasClass('selected')) {layer_odc_built.setVisible(true)} else {layer_odc_built.setVisible(false)};
	});
	
	// Add Listeners for layer_odp_plan button
	$("#layer_odp_plan").click(function() {
		if($(this).hasClass('selected')) {layer_odp_plan.setVisible(true)} else {layer_odp_plan.setVisible(false)};
	});
	
	// Add Listeners for layer_odp_built button
	$("#layer_odp_built").click(function() {
		if($(this).hasClass('selected')) {layer_odp_built.setVisible(true)} else {layer_odp_built.setVisible(false)};
	});
	
	// Add Listeners for layer_pole_plan button
	$("#layer_pole_plan").click(function() {
		if($(this).hasClass('selected')) {layer_pole_plan.setVisible(true)} else {layer_pole_plan.setVisible(false)};
	});
	
	// Add Listeners for layer_pole_built button
	$("#layer_pole_built").click(function() {
		if($(this).hasClass('selected')) {layer_pole_built.setVisible(true)} else {layer_pole_built.setVisible(false)};
	});
	
	// Add Listeners for layer_pole_history button
	$("#layer_pole_history").click(function() {
		if($(this).hasClass('selected')) {layer_pole_history.setVisible(true)} else {layer_pole_history.setVisible(false)};
	});
	
	// Add Listeners for layer_jalur_feeder_plan button
	$("#layer_jalur_feeder_plan").click(function() {
		if($(this).hasClass('selected')) {layer_jalur_feeder_plan.setVisible(true)} else {layer_jalur_feeder_plan.setVisible(false)};
	});
	
	// Add Listeners for layer_jalur_feeder_built button
	$("#layer_jalur_feeder_built").click(function() {
		if($(this).hasClass('selected')) {layer_jalur_feeder_built.setVisible(true)} else {layer_jalur_feeder_built.setVisible(false)};
	});
	
	// Add Listeners for layer_closure_plan button
	$("#layer_closure_plan").click(function() {
		if($(this).hasClass('selected')) {layer_closure_plan.setVisible(true)} else {layer_closure_plan.setVisible(false)};
	});
	
	// Add Listeners for layer_closure_built button
	$("#layer_closure_built").click(function() {
		if($(this).hasClass('selected')) {layer_closure_built.setVisible(true)} else {layer_closure_built.setVisible(false)};
	});
	
	// Add Listeners for layer_slack_support_plan button
	$("#layer_slack_support_plan").click(function() {
		if($(this).hasClass('selected')) {layer_slack_support_plan.setVisible(true)} else {layer_slack_support_plan.setVisible(false)};
	});
	
	// Add Listeners for layer_slack_support_built button
	$("#layer_slack_support_built").click(function() {
		if($(this).hasClass('selected')) {layer_slack_support_built.setVisible(true)} else {layer_slack_support_built.setVisible(false)};
	});
	
	// Add Listeners for layer_hand_hole_plan button
	$("#layer_hand_hole_plan").click(function() {
		if($(this).hasClass('selected')) {layer_hand_hole_plan.setVisible(true)} else {layer_hand_hole_plan.setVisible(false)};
	});
	
	// Add Listeners for layer_hand_hole_built button
	$("#layer_hand_hole_built").click(function() {
		if($(this).hasClass('selected')) {layer_hand_hole_built.setVisible(true)} else {layer_hand_hole_built.setVisible(false)};
	});
	
	// Set Layers Width
	$("#layerPanel").width(Math.ceil($('#layerPanel .toolbarPanelButton').length/3)*68);
	
}

$(window).ready(setListenersLayer);