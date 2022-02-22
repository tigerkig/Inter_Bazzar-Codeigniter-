<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="admin-content-wrapper "style="position:absolute;">

    <div class="content  content-no-sidebar no-sidebar ufa" id="dashboard_content" style="padding-left:0px; padding-top:0px">
        <div class="content-wrap">
            <div class="dashboard row-fluid" id="dashboard">

                <div class="dashboard-cards span3">  

                    <div class="dashboard-card">
                        <div class="dashboard-card-title">
                            <a href="<?php echo admin_url(); ?>orders"><?php echo trans("orders"); ?></a>
                        </div>
                        <div class="dashboard-card-content">
                            <h3><?php echo $order_count; ?></h3>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="dashboard-card-title">
                            <a href="<?php echo admin_url(); ?>products"><?php echo trans("products"); ?></a>
                        </div>
                        <div class="dashboard-card-content">
                            <h3><?php echo $product_count; ?></h3>
                        </div>
                    </div>  

                    <div class="dashboard-card">
                        <div class="dashboard-card-title">
                            <a href="<?php echo admin_url(); ?>pending-products"><?php echo trans("pending_products"); ?></a>
                        </div>
                        <div class="dashboard-card-content">
                            <h3><?php echo $pending_product_count; ?></h3>
                        </div>
                    </div>  
                    
                    <div class="dashboard-card">
                        <div class="dashboard-card-title">
                            <a href="<?php echo admin_url(); ?>members"><?php echo trans("members"); ?></a>
                        </div>
                        <div class="dashboard-card-content">
                            <h3><?php echo $members_count; ?></h3>
                        </div>
                    </div> 

                </div>

                <div class="dashboard-main-column span9">

                    <div class="dashboard-row">
                        <div class="dashboard-statistics">
                        <h4> Statistics</h4>

                        <div id="statistics_tabs">
                            <div class="cm-j-tabs tabs ">
                                <ul class="nav nav-tabs">
                                    <li id="sales_chart" class="cm-js active"><a>Sales</a></li>
                                </ul>
                            </div>

                            <div class="cm-tabs-content">

                                <div id="content_sales_chart" class="">
                                    <div id="dashboard_statistics_sales_chart" class="dashboard-statistics-chart spinner">
                                    <div style="position: relative;">
                                    <div dir="ltr" style="position: relative; width: 851px; height: 241px;">
                                    <div aria-label="A chart." style="position: absolute; left: 0px; top: 0px; width: 100%; height: 100%;">
                                    <svg width="851" height="241" aria-label="A chart." style="overflow: hidden;">
                                    <defs id="_ABSTRACT_RENDERER_ID_3">
                                    <clippath id="_ABSTRACT_RENDERER_ID_4">
                                    <rect x="7" y="10" width="844" height="208"></rect>
                                    </clippath></defs><rect x="0" y="0" width="851" height="241" stroke="none" stroke-width="0" fill="#ffffff">
                                    </rect>
                                    <g>
                                    <rect x="7" y="10" width="844" height="208" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect>
                                    <rect x="7" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect>
                                    <rect x="35" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect>
                                    <rect x="63" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="91" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="119" y="10" width="1" height="208" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="119" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="148" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="176" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="204" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="232" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="260" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="288" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="316" y="10" width="1" height="208" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="316" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="344" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="372" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="400" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="429" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="457" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="485" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="513" y="10" width="1" height="208" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="513" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="541" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="569" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="597" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="625" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="653" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="681" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="710" y="10" width="1" height="208" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="710" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="738" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="766" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="794" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="822" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="850" y="213" width="1" height="5" stroke="none" stroke-width="0" fill="#f0f5f7"></rect><rect x="7" y="217" width="844" height="1" stroke="none" stroke-width="0" fill="#eaeef0"></rect><rect x="7" y="196" width="844" height="1" stroke="none" stroke-width="0" fill="#eaeef0"></rect><rect x="7" y="176" width="844" height="1" stroke="none" stroke-width="0" fill="#eaeef0"></rect><rect x="7" y="155" width="844" height="1" stroke="none" stroke-width="0" fill="#eaeef0"></rect><rect x="7" y="134" width="844" height="1" stroke="none" stroke-width="0" fill="#eaeef0"></rect><rect x="7" y="114" width="844" height="1" stroke="none" stroke-width="0" fill="#eaeef0"></rect><rect x="7" y="93" width="844" height="1" stroke="none" stroke-width="0" fill="#eaeef0"></rect><rect x="7" y="72" width="844" height="1" stroke="none" stroke-width="0" fill="#eaeef0"></rect><rect x="7" y="51" width="844" height="1" stroke="none" stroke-width="0" fill="#eaeef0"></rect><rect x="7" y="31" width="844" height="1" stroke="none" stroke-width="0" fill="#eaeef0"></rect><rect x="7" y="10" width="844" height="1" stroke="none" stroke-width="0" fill="#eaeef0"></rect><rect x="7" y="207" width="844" height="1" stroke="none" stroke-width="0" fill="#f7f8f9"></rect><rect x="7" y="186" width="844" height="1" stroke="none" stroke-width="0" fill="#f7f8f9"></rect><rect x="7" y="165" width="844" height="1" stroke="none" stroke-width="0" fill="#f7f8f9"></rect><rect x="7" y="145" width="844" height="1" stroke="none" stroke-width="0" fill="#f7f8f9"></rect><rect x="7" y="124" width="844" height="1" stroke="none" stroke-width="0" fill="#f7f8f9"></rect><rect x="7" y="103" width="844" height="1" stroke="none" stroke-width="0" fill="#f7f8f9"></rect><rect x="7" y="82" width="844" height="1" stroke="none" stroke-width="0" fill="#f7f8f9"></rect><rect x="7" y="62" width="844" height="1" stroke="none" stroke-width="0" fill="#f7f8f9"></rect><rect x="7" y="41" width="844" height="1" stroke="none" stroke-width="0" fill="#f7f8f9"></rect><rect x="7" y="20" width="844" height="1" stroke="none" stroke-width="0" fill="#f7f8f9"></rect></g><g><g><path d="M7.5,114L7.5,114L35.599999999999994,114L63.699999999999996,114L91.8,114L119.89999999999999,114L148,114L176.1,114L204.2,114L232.29999999999998,114L260.4,114L288.5,114L316.59999999999997,114L344.7,114L372.79999999999995,114L400.9,114L429,114L457.09999999999997,114L485.2,114L513.3,114L541.4,114L569.5,114L597.5999999999999,114L625.6999999999999,114L653.8,114L681.9,114L710,114L738.0999999999999,114L766.1999999999999,114L794.3,114L822.4,114L850.5,114L850.5,114Z" stroke="none" stroke-width="0" fill-opacity="0.3" fill="#ff9494"></path></g><g><path d="M7.5,114L7.5,114L35.599999999999994,114L63.699999999999996,114L91.8,114L119.89999999999999,114L148,114L176.1,114L204.2,114L232.29999999999998,114L260.4,114L288.5,114L316.59999999999997,114L344.7,114L372.79999999999995,114L400.9,114L429,114L457.09999999999997,114L485.2,114L513.3,114L541.4,114L569.5,114L597.5999999999999,114L625.6999999999999,114L653.8,114L681.9,114L710,114L738.0999999999999,114L766.1999999999999,114L794.3,114L822.4,114L850.5,114L850.5,114Z" stroke="none" stroke-width="0" fill-opacity="0.3" fill="#33c49b"></path></g></g><g><rect x="7" y="114" width="844" height="1" stroke="none" stroke-width="0" fill="#eaeef0"></rect></g><g><path d="M7.5,114L35.599999999999994,114L63.699999999999996,114L91.8,114L119.89999999999999,114L148,114L176.1,114L204.2,114L232.29999999999998,114L260.4,114L288.5,114L316.59999999999997,114L344.7,114L372.79999999999995,114L400.9,114L429,114L457.09999999999997,114L485.2,114L513.3,114L541.4,114L569.5,114L597.5999999999999,114L625.6999999999999,114L653.8,114L681.9,114L710,114L738.0999999999999,114L766.1999999999999,114L794.3,114L822.4,114L850.5,114" stroke="#ff9494" stroke-width="1" fill-opacity="1" fill="none"></path><path d="M7.5,114L35.599999999999994,114L63.699999999999996,114L91.8,114L119.89999999999999,114L148,114L176.1,114L204.2,114L232.29999999999998,114L260.4,114L288.5,114L316.59999999999997,114L344.7,114L372.79999999999995,114L400.9,114L429,114L457.09999999999997,114L485.2,114L513.3,114L541.4,114L569.5,114L597.5999999999999,114L625.6999999999999,114L653.8,114L681.9,114L710,114L738.0999999999999,114L766.1999999999999,114L794.3,114L822.4,114L850.5,114" stroke="#33c49b" stroke-width="1" fill-opacity="1" fill="none"></path></g></g><g><circle cx="7.5" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="35.599999999999994" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="63.699999999999996" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="91.8" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="119.89999999999999" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="148" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="176.1" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="204.2" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="232.29999999999998" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="260.4" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="288.5" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="316.59999999999997" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="344.7" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="372.79999999999995" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="400.9" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="429" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="457.09999999999997" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="485.2" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="513.3" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="541.4" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="569.5" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="597.5999999999999" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="625.6999999999999" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="653.8" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="681.9" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="710" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="738.0999999999999" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle>
                                    <circle cx="766.1999999999999" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="794.3" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="822.4" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="850.5" cy="114" r="4" stroke="none" stroke-width="0" fill="#ff9494"></circle><circle cx="7.5" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="35.599999999999994" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="63.699999999999996" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="91.8" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="119.89999999999999" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="148" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="176.1" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="204.2" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="232.29999999999998" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="260.4" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="288.5" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="316.59999999999997" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="344.7" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="372.79999999999995" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="400.9" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="429" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="457.09999999999997" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="485.2" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="513.3" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="541.4" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="569.5" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="597.5999999999999" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="625.6999999999999" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="653.8" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="681.9" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="710" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="738.0999999999999" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="766.1999999999999" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="794.3" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="822.4" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle><circle cx="850.5" cy="114" r="4" stroke="none" stroke-width="0" fill="#33c49b"></circle></g><g><g><text text-anchor="middle" x="119.89999999999999" y="233.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">Sep 27</text></g><g><text text-anchor="middle" x="316.59999999999997" y="233.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">Oct 4</text></g><g><text text-anchor="middle" x="513.3" y="233.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">Oct 11</text></g><g><text text-anchor="middle" x="710" y="233.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">Oct 18</text></g><g><g><text text-anchor="start" x="10" y="209.15" font-family="Arial" font-size="11" stroke="#ffffff" stroke-width="3" fill="#a3b2bf" aria-hidden="true">-0.8</text><text text-anchor="start" x="10" y="209.15" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">-0.8</text></g></g><g><g><text text-anchor="start" x="10" y="188.45" font-family="Arial" font-size="11" stroke="#ffffff" stroke-width="3" fill="#a3b2bf" aria-hidden="true">-0.6</text><text text-anchor="start" x="10" y="188.45" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">-0.6</text></g></g><g><g><text text-anchor="start" x="10" y="167.75" font-family="Arial" font-size="11" stroke="#ffffff" stroke-width="3" fill="#a3b2bf" aria-hidden="true">-0.4</text><text text-anchor="start" x="10" y="167.75" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">-0.4</text></g></g><g><g><text text-anchor="start" x="10" y="147.04999999999998" font-family="Arial" font-size="11" stroke="#ffffff" stroke-width="3" fill="#a3b2bf" aria-hidden="true">-0.2</text><text text-anchor="start" x="10" y="147.04999999999998" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">-0.2</text></g></g><g><g><text text-anchor="start" x="10" y="126.35" font-family="Arial" font-size="11" stroke="#ffffff" stroke-width="3" fill="#a3b2bf" aria-hidden="true">0.0</text><text text-anchor="start" x="10" y="126.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">0.0</text></g></g><g><g><text text-anchor="start" x="10" y="105.64999999999999" font-family="Arial" font-size="11" stroke="#ffffff" stroke-width="3" fill="#a3b2bf" aria-hidden="true">0.2</text><text text-anchor="start" x="10" y="105.64999999999999" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">0.2</text></g></g><g><g><text text-anchor="start" x="10" y="84.94999999999999" font-family="Arial" font-size="11" stroke="#ffffff" stroke-width="3" fill="#a3b2bf" aria-hidden="true">0.4</text><text text-anchor="start" x="10" y="84.94999999999999" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">0.4</text></g></g><g><g><text text-anchor="start" x="10" y="64.25" font-family="Arial" font-size="11" stroke="#ffffff" stroke-width="3" fill="#a3b2bf" aria-hidden="true">0.6</text><text text-anchor="start" x="10" y="64.25" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">0.6</text></g></g><g><g><text text-anchor="start" x="10" y="43.550000000000004" font-family="Arial" font-size="11" stroke="#ffffff" stroke-width="3" fill="#a3b2bf" aria-hidden="true">0.8</text><text text-anchor="start" x="10" y="43.550000000000004" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">0.8</text></g></g><g><g><text text-anchor="start" x="10" y="22.85" font-family="Arial" font-size="11" stroke="#ffffff" stroke-width="3" fill="#a3b2bf" aria-hidden="true">1.0</text><text text-anchor="start" x="10" y="22.85" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#a3b2bf">1.0</text></g></g></g></g><g></g></svg><div aria-label="A tabular representation of the data in the chart." style="position: absolute; left: -10000px; top: auto; width: 1px; height: 1px; overflow: hidden;"><table><thead><tr><th>Date</th><th>Previous period</th><th>Current Period</th></tr></thead><tbody><tr><td>Current (Sep 23, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Sep 24, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Sep 25, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Sep 26, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Sep 27, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Sep 28, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Sep 29, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Sep 30, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 1, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 2, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 3, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 4, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 5, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 6, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 7, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 8, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 9, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 10, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 11, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 12, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 13, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 14, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 15, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 16, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 17, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 18, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 19, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 20, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 21, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 22, 2021) and previous period</td><td>0</td><td>0</td></tr><tr><td>Current (Oct 23, 2021) and previous period</td><td>0</td><td>0</td></tr></tbody></table></div></div></div><div aria-hidden="true" style="display: none; position: absolute; top: 251px; left: 861px; white-space: nowrap; font-family: Arial; font-size: 11px;">...</div><div></div></div></div>
                                </div>

                            </div>  
                        </div>
                    </div>
                    <!-- Main content  -->

                </div>
                <div class="dashboard-recent-orders cm-j-tabs tabs">
                        <div class="box box-sm pad ">
                            <h4>Recent Orders</h4>
                            <div style="margin-bottom:30px"></div>   

                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home">All</a></li>
                                <li><a data-toggle="tab" href="#menu1">Completed</a></li>
                                <li><a data-toggle="tab" href="#menu2">Processing</a></li>
                                <li><a data-toggle="tab" href="#menu3">Canceled</a></li>
                                <li><a data-toggle="tab" href="#menu4">Payment Recieved</a></li>
                                <li><a data-toggle="tab" href="#menu5">Awaiting Payments</a></li>
                                <li><a data-toggle="tab" href="#menu6">Shipped</a></li>
                            </ul>

                            <div style="margin-bottom:30px"></div>   
                            <div class="index-table">
                                <div class="tab-content ">
                                    <div id="home" class="tab-pane fade in active">
                                        <table class="table no-margin">
                                            <thead>
                                            <tr>
                                                <th><?php echo trans("order"); ?></th>
                                                <th><?php echo trans("total"); ?></th>
                                                <th><?php echo trans("status"); ?></th>
                                                <th><?php echo trans("date"); ?></th>
                                                <th><?php echo trans("details"); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                
                                            <?php foreach ($latest_order_products as $item): ?>
                                                <tr>
                                                    <td>#<?php echo $item->order_number; ?></td>
                                                    <td><?php echo price_formatted($item->price_total, $item->price_currency); ?></td>
                                                    <td>
                                                        <?php if($item->payment_status == 'completed'): ?>
                                                            <?php echo "completed"; ?>
                                                        <?php elseif($item->payment_status == 'payment_received'):?>
                                                            <?php echo "payment received"; ?>
                                                        <?php elseif($item->payment_status == 'refund_cancelled'):?>
                                                            <?php echo "cancelled"; ?>
                                                        <?php elseif($item->payment_status == 'order_processing'):?>
                                                            <?php echo "processing"; ?>
                                                        <?php elseif($item->payment_status == 'awaiting_payment'):?>
                                                            <?php echo "awaiting payment"; ?>
                                                        <?php else:?>
                                                            <?php echo "shipped"; ?>
                                                        <?php endif; ?>            
                                                    </td>
                                                    <td><?php echo date("Y-m-d / h:i", strtotime($item->created_at)); ?></td>
                                                    <td style="width: 10%">
                                                        <a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                                    </td>
                                                </tr>

                                            <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div id="menu1" class="tab-pane fade">
                                        <table class="table no-margin">
                                            <thead>
                                            <tr>
                                                <th><?php echo trans("order"); ?></th>
                                                <th><?php echo trans("total"); ?></th>
                                                <th><?php echo trans("status"); ?></th>
                                                <th><?php echo trans("date"); ?></th>
                                                <th><?php echo trans("details"); ?></th>
                                            </tr>
                                            </thead>
                                                <?php if(empty($this->latest_order_products)):?> 
                                                    <tbody>
                                                    <?php foreach ($latest_order_products as $item): ?>
                                                        <?php if($item->payment_status == 'completed'): ?>
                                                            <tr>
                                                                <td>#<?php echo $item->order_number; ?></td>
                                                                <td><?php echo price_formatted($item->price_total, $item->price_currency); ?></td>
                                                                <td>
                                                                    <?php echo trans("completed"); ?>
                                                                </td>
                                                                <td><?php echo date("Y-m-d / h:i", strtotime($item->created_at)); ?></td>
                                                                <td style="width: 10%">
                                                                    <a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                                                </td>
                                                            </tr>
                                                            <?php else:?>
                                                        <?php endif; ?>   
                                                    </tbody>
                                                    <?php endforeach; ?>
                                                <?php else: ?> 
                                                    <th>No show data</th>
                                                <?php endif; ?> 

                                        </table>
                                    </div>

                                    <div id="menu2" class="tab-pane fade">
                                        <table class="table no-margin">
                                            <thead>
                                            <tr>
                                                <th><?php echo trans("order"); ?></th>
                                                <th><?php echo trans("total"); ?></th>
                                                <th><?php echo trans("status"); ?></th>
                                                <th><?php echo trans("date"); ?></th>
                                                <th><?php echo trans("details"); ?></th>
                                            </tr>
                                            </thead>

                                            <?php if(empty($this->latest_order_products)):?> 
                                                    <tbody>
                                                    <?php foreach ($latest_order_products as $item): ?>
                                                        <?php if($item->payment_status == 'order_processing'): ?>
                                                            <tr>
                                                                <td>#<?php echo $item->order_number; ?></td>
                                                                <td><?php echo price_formatted($item->price_total, $item->price_currency); ?></td>
                                                                <td>
                                                                    <?php echo trans("order_processing"); ?>
                                                                </td>
                                                                <td><?php echo date("Y-m-d / h:i", strtotime($item->created_at)); ?></td>
                                                                <td style="width: 10%">
                                                                    <a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                                                </td>
                                                            </tr>
                                                            <?php else:?>
                                                        <?php endif; ?>   
                                                    </tbody>
                                                    <?php endforeach; ?>
                                                <?php else: ?> 
                                                    <th>No show data</th>
                                                <?php endif; ?> 
                                        </table>
                                    </div>

                                    <div id="menu3" class="tab-pane fade">
                                        <table class="table no-margin">
                                            <thead>
                                            <tr>
                                                <th><?php echo trans("order"); ?></th>
                                                <th><?php echo trans("total"); ?></th>
                                                <th><?php echo trans("status"); ?></th>
                                                <th><?php echo trans("date"); ?></th>
                                                <th><?php echo trans("details"); ?></th>
                                            </tr>
                                            </thead>

                                            <?php if(empty($this->latest_order_products)):?> 
                                                    <tbody>
                                                    <?php foreach ($latest_order_products as $item): ?>
                                                        <?php if($item->payment_status == 'refund_cancelled'): ?>
                                                            <tr>
                                                                <td>#<?php echo $item->order_number; ?></td>
                                                                <td><?php echo price_formatted($item->price_total, $item->price_currency); ?></td>
                                                                <td>
                                                                    <?php echo trans("refund_cancelled"); ?>
                                                                </td>
                                                                <td><?php echo date("Y-m-d / h:i", strtotime($item->created_at)); ?></td>
                                                                <td style="width: 10%">
                                                                    <a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                                                </td>
                                                            </tr>
                                                            <?php else:?>
                                                        <?php endif; ?>   
                                                    </tbody>
                                                    <?php endforeach; ?>
                                                <?php else: ?> 
                                                    <th>No show data</th>
                                                <?php endif; ?> 
                                        </table>
                                    </div>

                                    <div id="menu4" class="tab-pane fade">
                                        <table class="table no-margin">
                                            <thead>
                                            <tr>
                                                <th><?php echo trans("order"); ?></th>
                                                <th><?php echo trans("total"); ?></th>
                                                <th><?php echo "Payment Status"; ?></th>
                                                <th><?php echo trans("date"); ?></th>
                                                <th><?php echo trans("details"); ?></th>
                                            </tr>
                                            </thead>
                                            <?php if(empty($this->latest_order_products)):?> 
                                                    <tbody>
                                                    <?php foreach ($latest_order_products as $item): ?>
                                                        <?php if($item->payment_status == 'payment_received'): ?>
                                                            <tr>
                                                                <td>#<?php echo $item->order_number; ?></td>
                                                                <td><?php echo price_formatted($item->price_total, $item->price_currency); ?></td>
                                                                <td>
                                                                    <?php echo 'payment received' ?>
                                                                </td>
                                                                <td><?php echo date("Y-m-d / h:i", strtotime($item->created_at)); ?></td>
                                                                <td style="width: 10%">
                                                                    <a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                                                </td>
                                                            </tr>
                                                            <?php else:?>
                                                        <?php endif; ?>   
                                                    </tbody>
                                                    <?php endforeach; ?>
                                                <?php else: ?> 
                                                    <th>No show data</th>
                                                <?php endif; ?> 
                                        </table>
                                    </div>

                                    <div id="menu5" class="tab-pane fade">
                                        <table class="table no-margin">
                                            <thead>
                                            <tr>
                                                <th><?php echo trans("order"); ?></th>
                                                <th><?php echo trans("total"); ?></th>
                                                <th><?php echo "Payment Status"; ?></th>
                                                <th><?php echo trans("date"); ?></th>
                                                <th><?php echo trans("details"); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(empty($this->latest_order_products)):?> 
                                                    <tbody>
                                                    <?php foreach ($latest_order_products as $item): ?>
                                                        <?php if($item->payment_status == 'awaiting_payment'): ?>
                                                            <tr>
                                                                <td>#<?php echo $item->order_number; ?></td>
                                                                <td><?php echo price_formatted($item->price_total, $item->price_currency); ?></td>
                                                                <td>
                                                                    <?php echo trans("awaiting_payment"); ?>
                                                                </td>
                                                                <td><?php echo date("Y-m-d / h:i", strtotime($item->created_at)); ?></td>
                                                                <td style="width: 10%">
                                                                    <a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                                                </td>
                                                            </tr>
                                                            <?php else:?>
                                                        <?php endif; ?>   
                                                    </tbody>
                                                    <?php endforeach; ?>
                                                <?php else: ?> 
                                                    <th>No show data</th>
                                                <?php endif; ?> 
                                        </table>
                                    </div>

                                    <div id="menu6" class="tab-pane fade">
                                        <table class="table no-margin">
                                            <thead>
                                            <tr>
                                                <th><?php echo trans("order"); ?></th>
                                                <th><?php echo trans("total"); ?></th>
                                                <th><?php echo "status"; ?></th>
                                                <th><?php echo trans("date"); ?></th>
                                                <th><?php echo trans("details"); ?></th>
                                            </tr>
                                            </thead>
                                            <?php if(empty($this->latest_order_products)):?> 
                                                    <tbody>
                                                    <?php foreach ($latest_order_products as $item): ?>
                                                        <?php if($item->payment_status == 'shipped'): ?>
                                                            <tr>
                                                                <td>#<?php echo $item->order_number; ?></td>
                                                                <td><?php echo price_formatted($item->price_total, $item->price_currency); ?></td>
                                                                <td>
                                                                    <?php echo trans("shipped"); ?>
                                                                </td>
                                                                <td><?php echo date("Y-m-d / h:i", strtotime($item->created_at)); ?></td>
                                                                <td style="width: 10%">
                                                                    <a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                                                </td>
                                                            </tr>
                                                            <?php else:?>
                                                        <?php endif; ?>   
                                                    </tbody>
                                                    <?php endforeach; ?>
                                                <?php else: ?> 
                                                    <th>No show data</th>
                                                <?php endif; ?> 
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- latest transactions -->

                        <div class="box box-sm pad">
                            <div class="box-header with-border">
                                
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i>
                                    </button>
                                </div>
                                                                
                                <div >
                                    <h3 class="box-title"><?php echo trans("latest_transactions"); ?></h3>                               
                                </div>
                            </div><!-- /.box-header -->

                            <div style="margin-bottom:30px"></div>   

                            <div class="box-body index-table">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                        <tr>
                                            <th><?php echo trans("id"); ?></th>
                                            <th><?php echo trans("order"); ?></th>
                                            <th><?php echo trans("payment_amount"); ?></th>
                                            <th><?php echo trans('payment_method'); ?></th>
                                            <th><?php echo trans('status'); ?></th>
                                            <th><?php echo trans("date"); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach ($latest_transactions as $item): ?>
                                            <tr>
                                                <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                                <td style="white-space: nowrap">#<?php
                                                    $order = $this->order_admin_model->get_order($item->id);
                                                    if (!empty($order)):
                                                        echo $order->order_number;
                                                    endif; ?>
                                                </td>
                                                <td><?php echo price_currency_format($item->payment_amount, $item->currency); ?></td>
                                                <td>
                                                    <?php
                                                    if ($item->payment_method == "Bank Transfer") {
                                                        echo trans("bank_transfer");
                                                    } else {
                                                        echo $item->payment_method;
                                                    } ?>
                                                </td>
                                                <td><?php echo trans($item->payment_status); ?></td>
                                                <td><?php echo formatted_date($item->created_at); ?></td>
                                            </tr>

                                        <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>

                            <div style="margin-bottom:30px"></div>   

                            <div class="box-footer clearfix">
                                <a href="<?php echo admin_url(); ?>transactions"
                                class="btn btn-sm btn-primary pull-right"><?php echo trans("view_all"); ?></a>
                            </div>
                        </div>
                        <div style="margin-bottom:30px"></div>   

                        <!-- Latest Products -->
                        
                        <div class="box box-sm pad">
                            <div class="box-header with-border">
                                
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i>
                                    </button>
                                </div>
                                <div><h3 class="box-title"><?php echo trans("latest_products"); ?></h3></div>
                            </div><!-- /.box-header -->
                            <div style="margin-bottom:30px"></div>                        
                            <div class="box-body index-table">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                        <tr>
                                            <th><?php echo trans("id"); ?></th>
                                            <th><?php echo trans("name"); ?></th>
                                            <th><?php echo trans("details"); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach ($latest_products as $item): ?>
                                            <tr>
                                                <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                                <td class="index-td-product">
                                                    <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                                    <?php echo html_escape($item->title); ?>
                                                </td>
                                                <td style="width: 10%">
                                                    <a href="<?php echo admin_url(); ?>product-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>

                            <div class="box-footer clearfix">
                                <a href="<?php echo admin_url(); ?>products"
                                class="btn btn-sm btn-primary pull-right"><?php echo trans("view_all"); ?></a>
                            </div>
                        </div>
                        <div style="margin-bottom:30px"></div>   

                        <!--latest_pending_products  -->

                        <div class="box box-sm pad">
                            <div class="box-header with-border">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i>
                                    </button>
                                </div>
                                <div><h3 class="box-title"><?php echo trans("latest_pending_products"); ?></h3></div>
                            </div><!-- /.box-header -->
                            <div style="margin-bottom:30px"></div>               
                            <div class="box-body index-table">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                        <tr>
                                            <th><?php echo trans("id"); ?></th>
                                            <th><?php echo trans("name"); ?></th>
                                            <th><?php echo trans("details"); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach ($latest_pending_products as $item): ?>
                                            <tr>
                                                <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                                <td class="index-td-product">
                                                    <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                                    <?php echo html_escape($item->title); ?>
                                                </td>
                                                <td style="width: 10%;vertical-align: center !important;">
                                                    <a href="<?php echo admin_url(); ?>product-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <div style="margin-bottom:30px"></div>   

                            <div class="box-footer clearfix">
                                <a href="<?php echo admin_url(); ?>pending-products"
                                class="btn btn-sm btn-primary pull-right"><?php echo trans("view_all"); ?></a>
                            </div>
                        </div>
                        <div style="margin-bottom:30px"></div> 
                        
                        <!-- Latest Transactions -->

                        <div class="box box-sm pad">
                            <div class="box-header with-border">
                                
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i>
                                    </button>
                                </div>
                                <div><h3 class="box-title"><?php echo trans("latest_transactions"); ?>&nbsp;<small style="font-size: 13px;">(<?php echo trans("featured_products"); ?>)</small></h3></div>
                            </div><!-- /.box-header -->
                            <div style="margin-bottom:30px"></div> 

                            <div class="box-body index-table">
                                <div class="table-responsive">
                                    <table class="table no-margin table-striped table--relati">
                                        <thead>
                                        <tr>
                                            <th><?php echo trans("id"); ?></th>
                                            <th><?php echo trans('payment_method'); ?></th>
                                            <th><?php echo trans("payment_amount"); ?></th>
                                            <th><?php echo trans('status'); ?></th>
                                            <th><?php echo trans("date"); ?></th>
                                        </tr>
                                        </thead>                                                        
                                        <tbody>

                                        <?php foreach ($latest_promoted_transactions as $item): ?>
                                            <tr>
                                                <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                                <td>
                                                    <?php
                                                    if ($item->payment_method == "Bank Transfer") {
                                                        echo trans("bank_transfer");
                                                    } else {
                                                        echo $item->payment_method;
                                                    } ?>
                                                </td>
                                                <td><?php echo price_currency_format($item->payment_amount, $item->currency); ?></td>
                                                <td><?php echo trans($item->payment_status); ?></td>
                                                <td><?php echo formatted_date($item->created_at); ?></td>
                                            </tr>

                                        <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <div style="margin-bottom:30px"></div> 

                            <div class="box-footer clearfix">
                                <a href="<?php echo admin_url(); ?>featured-products-transactions"
                                class="btn btn-sm btn-primary pull-right"><?php echo trans("view_all"); ?></a>
                            </div>
                        </div>  
                        <div style="margin-bottom:30px"></div> 
                        
                        <!-- Latest Reviews -->

                        <div class="box box-sm pad">
                            <div class="box-header with-border">
                                
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i>
                                    </button>
                                </div>
                                <div><h3 class="box-title"><?php echo trans("latest_reviews"); ?></h3></div>
                            </div><!-- /.box-header -->
                            <div style="margin-bottom:30px"></div> 

                            <div class="box-body index-table">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                        <tr>
                                            <th><?php echo trans("id"); ?></th>
                                            <th><?php echo trans("username"); ?></th>
                                            <th style="width: 60%"><?php echo trans("review"); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach ($latest_reviews as $item): ?>
                                            <tr>
                                                <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                                <td style="width: 25%" class="break-word">
                                                    <?php echo html_escape($item->user_username); ?>
                                                </td>
                                                <td style="width: 65%" class="break-word">
                                                    <div>
                                                        <?php $this->load->view('admin/includes/_review_stars', ['review' => $item->rating]); ?>
                                                    </div>
                                                    <?php echo character_limiter($item->review, 100); ?>
                                                    <div class="table-sm-meta">
                                                        <?php echo time_ago($item->created_at); ?>
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <div style="margin-bottom:30px"></div> 

                            <div class="box-footer clearfix">
                                <a href="<?php echo admin_url(); ?>reviews"
                                class="btn btn-sm btn-primary pull-right"><?php echo trans("view_all"); ?></a>
                            </div>
                        </div>
                        <div style="margin-bottom:30px"></div> 
                        
                        <!-- Latest Comments -->

                        <div class="box box-sm pad">
                            <div class="box-header with-border">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i>
                                    </button>
                                </div>
                                <div><h3 class="box-title"><?php echo trans("latest_comments"); ?></h3></div>
                            </div><!-- /.box-header -->
                            <div style="margin-bottom:30px"></div> 

                            <div class="box-body index-table">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                        <tr>
                                            <th><?php echo trans("id"); ?></th>
                                            <th><?php echo trans("user"); ?></th>
                                            <th style="width: 60%"><?php echo trans("comment"); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach ($latest_comments as $item): ?>
                                            <tr>
                                                <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                                <td style="width: 25%" class="break-word">
                                                    <?php echo html_escape($item->name); ?>
                                                </td>
                                                <td style="width: 65%" class="break-word">
                                                    <?php echo character_limiter($item->comment, 100); ?>
                                                    <div class="table-sm-meta">
                                                        <?php echo time_ago($item->created_at); ?>
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <div style="margin-bottom:30px"></div> 

                            <div class="box-footer clearfix">
                                <a href="<?php echo admin_url(); ?>product-comments"
                                class="btn btn-sm btn-primary pull-right"><?php echo trans("view_all"); ?></a>
                            </div>
                        </div>
                        <div style="margin-bottom:30px"></div> 
                        
                        <!-- Latest Members -->

                        <div class="box box-sm pad">
                            <div class="box-header with-border">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i>
                                    </button>
                                </div>
                                <div><h3 class="box-title"><?php echo trans("latest_members"); ?></h3></div>
                            </div>
                            <!-- /.box-header -->
                            <div style="margin-bottom:30px"></div> 

                            <div class="box-body">
                                <ul class="users-list clearfix">
                                    <?php if (!empty($latest_members)):
                                        foreach ($latest_members as $item) : ?>
                                            <li>
                                                <a href="<?php echo generate_profile_url($item->slug); ?>">
                                                    <img src="<?php echo get_user_avatar($item); ?>" alt="user" class="img-responsive">
                                                </a>
                                                <a href="<?php echo generate_profile_url($item->slug); ?>" class="users-list-name"><?php echo html_escape($item->username); ?></a>
                                                <span class="users-list-date"><?php echo time_ago($item->created_at); ?></span>
                                            </li>
                                        <?php endforeach;
                                    endif; ?>
                                </ul>
                                <!-- /.users-list -->
                            </div>
                            <!-- /.box-body -->
                            <div style="margin-bottom:30px"></div> 

                            <div class="box-footer clearfix">
                                <a href="<?php echo admin_url(); ?>members" 
                                class="btn btn-sm btn-default btn-flat pull-right"><?php echo trans("view_all"); ?></a>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                    </div>
            </div>
        </div>
    </div>

<div id="ajax_overlay" class="ajax-overlay"></div>
<div id="ajax_loading_box" class="hidden ajax-loading-box"></div>

