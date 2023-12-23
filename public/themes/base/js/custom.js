/*
Template Name: Miver - LMS & Freelance Services Marketplace for Businesses HTML Template
Author: Askbootstrap
Author URI: https://themeforest.net/user/askbootstrap
Version: 1.0
*/

$(document).ready(function () {
	"use strict";

	/* Select2 */
	$('select').select2();

	/* Tooltip */
	$('[data-toggle="tooltip"]').tooltip();

	/* index */
	$('.recent-slider').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		arrows: false,
		fade: false,
		dots: true,
		responsive: [{
				breakpoint: 1099,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 2,
				}
			}

		]
	});

	$('.freelance-slider').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		arrows: false,
		fade: false,
		dots: true,
		responsive: [{
				breakpoint: 1099,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
				}
			}

		]
	});
	$('.service-slider').slick({
		slidesToShow: 5,
		dots: true,
		slidesToScroll: 1,
		arrows: false,
		fade: false,
		responsive: [{
				breakpoint: 1099,
				settings: {
					slidesToShow: 3,
					dots: true
				}
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					dots: true
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 3,
					dots: true,
					infinite: true,
				}
			}

		]
	});
	$('.prestataire-slider').slick({
		slidesToShow: 12,
		slidesToScroll: 4,
		arrows: false,
		fade: false,
		dots: false,
		responsive: [{
				breakpoint: 1099,
				settings: {
					slidesToShow: 12,
				}
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 6,
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 3,
				}
			}

		]
	});

	/* web design */
	$(function () {
		$('#aniimated-thumbnials').lightGallery({
			thumbnail: true,
		});

		$('.slider-for').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			dots: true,
			adaptiveHeight: true,
			asNavFor: '.slider-nav'
		});

		$('.recommend').slick({
			slidesToShow: 2,
			slidesToScroll: 1,
			arrows: false,
			fade: false,
			dots: true,
		});


		$('.slider-nav').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			asNavFor: '.slider-for',
			dots: true,
			arrows: false,
			focusOnSelect: true,
			variableWidth: true,
			responsive: [{
					breakpoint: 1099,
					settings: {
						slidesToShow: 4,
					}
				},
				{
					breakpoint: 1024,
					settings: {
						slidesToShow: 2,
					}
				},
				{
					breakpoint: 600,
					settings: {
						slidesToShow: 1,
					}
				}

			]
		});
	});
	/* profile */

	/* wireframe */
	$('#aniimated-thumbnials').lightGallery({
		thumbnail: true,
	});

	$('.slider-for').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		dots: true,
		adaptiveHeight: true,
		asNavFor: '.slider-nav'

	});

	$('.recommend').slick({
		slidesToShow: 2,
		slidesToScroll: 1,
		arrows: false,
		fade: false,
		dots: true,
		responsive: [{
				breakpoint: 767,
				settings: {
					slidesToShow: 1,
				}
			}

		]
	});

	$(".view").not('.slick-initialized').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		arrows: false,
		fade: false,
		dots: true,
		responsive: [{
				breakpoint: 1099,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
				}
			}

		]
	});

	$('.slider-nav').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		asNavFor: '.slider-for',
		dots: true,
		arrows: false,
		focusOnSelect: true,
		variableWidth: true,
		responsive: [{
				breakpoint: 1099,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
				}
			}

		]
	});


});