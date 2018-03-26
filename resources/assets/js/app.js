
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue();

window.flash = function(message, level = 'success'){
 	window.events.$emit('flash', {message, level});
};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import VueSweetalert2 from 'vue-sweetalert2';
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('transactions', require('./components/Transactions.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('payments', require('./components/Payments.vue'));
Vue.component('machine-chart', require('./components/MachineChart.vue'));
Vue.component('earning-calculator', require('./components/EarningCalculator.vue'));

Vue.component('dashboard', require('./pages/Dashboard.vue'));
Vue.use(VueCharts);
Vue.use(VueSweetalert2);
const app = new Vue({
    el: '#app'
});

// Theme functions
$('.preloader-it > .la-anim-1').addClass('la-animate');
$(".preloader-it").delay(500).fadeOut("fast");

// Full height functions
var height = $(window).height();
$('.full-height').css('height', (height));
$('.page-wrapper').css('min-height', (height));

// Sidebar navigations
$(document).ready(function(){
	var $wrapper = $(".wrapper");

	
	
	/*Sidebar Collapse Animation*/
	var sidebarNavCollapse = $('.fixed-sidebar-left .side-nav  li .collapse');

	var sidebarNavAnchor = '.fixed-sidebar-left .side-nav li a';
	$(document).on("click",sidebarNavAnchor,function (e) {
		if ($(this).attr('aria-expanded') === "false")
				$(this).blur();
		$(sidebarNavCollapse).not($(this).parent().parent()).collapse('hide');
	});

	$(document).on('click', '#toggle_nav_btn,#open_right_sidebar,#setting_panel_btn', function (e) {
		$(".dropdown.open > .dropdown-toggle").dropdown("toggle");
		return false;
	});
	$(document).on('click', '#toggle_nav_btn', function (e) {
		$wrapper.removeClass('open-right-sidebar open-setting-panel').toggleClass('slide-nav-toggle');
		return false;
	});

	$(document).on("mouseenter mouseleave",".wrapper > .fixed-sidebar-left", function(e) {
		if (e.type == "mouseenter") {
			$wrapper.addClass("sidebar-hover"); 
		}
		else { 
			$wrapper.removeClass("sidebar-hover");  
		}
		return false;
	});
	
	$(document).on("mouseenter mouseleave",".wrapper > .setting-panel", function(e) {
		if (e.type == "mouseenter") {
			$wrapper.addClass("no-transition"); 
		}
		else { 
			$wrapper.removeClass("no-transition");  
		}
		return false;
	});
	

});



