"use strict";
_ = _ || window.lodash

jQuery(document).ready(function() {
  jQuery('#metrics-sidemenu').foundation('down', jQuery(`#${window.wp_js_object.base_slug}-menu`));

  let chartDiv = jQuery('#chart')
  chartDiv.empty().html(`
    <h2>Contact Milestones</h2>
    <p>Showing all contacts from all time with any status</p>
    <div id="mapping_chart"></div>
  `)


  page_mapping_view(window.wp_js_object.rest_endpoints_base)
})
