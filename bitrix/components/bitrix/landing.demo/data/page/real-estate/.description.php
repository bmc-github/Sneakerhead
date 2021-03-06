<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use \Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);

return array(
	'name' => Loc::getMessage('LANDING_DEMO_REALESTATE_TITLE'),
	'description' => Loc::getMessage('LANDING_DEMO_REALESTATE_DESCRIPTION'),
	'fields' => array(
		'ADDITIONAL_FIELDS' => array(
			'THEME_CODE' => 'real-estate',
			'THEME_CODE_TYPO' => 'real-estate',
			'METAOG_IMAGE' => 'https://cdn.bitrix24.site/bitrix/images/demo/page/real-estate/preview.jpg',
			'METAOG_TITLE' => Loc::getMessage('LANDING_DEMO_REALESTATE_TITLE'),
			'METAOG_DESCRIPTION' => Loc::getMessage('LANDING_DEMO_REALESTATE_DESCRIPTION'),
			'METAMAIN_TITLE' => Loc::getMessage('LANDING_DEMO_REALESTATE_TITLE'),
			'METAMAIN_DESCRIPTION' => Loc::getMessage('LANDING_DEMO_REALESTATE_DESCRIPTION')
		)
	),
	'items' => array (
		'0.menu_16' =>
			array (
				'CODE' => '0.menu_16',
				'SORT' => '-100',
				'CONTENT' => '
<header class="landing-block landing-block-menu u-header u-header--floating u-header--floating-relative">
	<div class="landing-block-node-top-block text-center text-lg-left u-header__section u-header__section--hidden u-header__section--light g-bg-white g-brd-bottom g-brd-gray-light-v4 g-py-20">
		<div class="container">
			<div class="row flex-lg-row align-items-center justify-content-lg-start">
				<div class="col-6 col-sm-3 col-lg-2">
					<!-- Logo -->
					<a href="#" class="navbar-brand landing-block-node-menu-logo-link">
						<img class="landing-block-node-menu-logo img-fluid g-max-width-180"
							 src="https://cdn.bitrix24.site/bitrix/images/landing/logos/real-estate-logo.png" alt="Logo">
					</a>
					<!-- End Logo -->
				</div>

				<div class="col-6 col-sm-9 col-lg-10">
					<div class="row">
						<div class="landing-block-card-menu-contact col-sm g-brd-right--sm g-brd-gray-light-v4">
							<div class="g-pa-10--lg">
								<div class="landing-block-node-menu-contact-img-container d-lg-inline-block g-valign-top g-color-primary g-mr-5">
									<i class="landing-block-node-menu-contact-img icon icon-screen-smartphone g-font-size-18"></i>
								</div>
								<div class="landing-block-node-menu-contact-text-container d-inline-block">
									<div class="landing-block-node-menu-contact-title text-uppercase g-font-size-13">
										Call Us
									</div>
									<div class="landing-block-node-menu-contact-value g-color-gray-dark-v2 g-font-weight-700">
										<a href="tel:+469548521">+469 548 521</a>
									</div>
								</div>
							</div>
						</div>

						<div class="landing-block-card-menu-contact col-sm g-hidden-md-down g-brd-right--sm g-brd-gray-light-v4">
							<div class="g-pa-10--lg">
								<div class="landing-block-node-menu-contact-img-container d-lg-inline-block g-valign-top g-color-primary g-mr-5">
									<i class="landing-block-node-menu-contact-img icon icon-clock g-font-size-18"></i>
								</div>
								<div class="landing-block-node-menu-contact-text-container d-inline-block">
									<div class="landing-block-node-menu-contact-title text-uppercase g-font-size-13">
										Opening time
									</div>
									<div class="landing-block-node-menu-contact-value g-color-gray-dark-v2 g-font-weight-700">
										Mon-Sat: 08.00 -18.00
									</div>
								</div>
							</div>
						</div>

						<div class="landing-block-card-menu-contact col-sm g-hidden-sm-down g-brd-right--sm g-brd-gray-light-v4">
							<div class="g-pa-10--lg">
								<div class="landing-block-node-menu-contact-img-container d-lg-inline-block g-valign-top g-color-primary g-mr-5">
									<i class="landing-block-node-menu-contact-img icon icon-envelope g-font-size-18"></i>
								</div>
								<div class="landing-block-node-menu-contact-text-container d-inline-block">
									<div class="landing-block-node-menu-contact-title text-uppercase g-font-size-13">
										Email us
									</div>
									<div class="landing-block-node-menu-contact-value g-color-gray-dark-v2 g-font-weight-700">
										<a href="mailto:info@company24.com">info@company24.com</a>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm g-hidden-sm-down">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="landing-block-node-bottom-block u-header__section u-header__section--dark g-bg-black g-py-15" data-header-fix-moment-classes="u-shadow-v18">
		<nav class="navbar navbar-expand-lg py-0">
			<div class="container">
				<!-- Navigation -->
				<div class="collapse navbar-collapse align-items-center flex-sm-row g-mr-40--sm" id="navBar">
					<ul class="landing-block-node-menu-list js-scroll-nav navbar-nav text-uppercase g-font-weight-700 g-font-size-13 g-py-10--md mr-auto">
						<li class="landing-block-node-menu-list-item nav-item g-mr-15--lg g-mb-7 g-mb-0--lg active">
							<a href="#block@block[46.9.cover_bgimg_vertical_slider]" class="landing-block-node-menu-list-item-link nav-link g-color-primary--hover p-0" target="_self">HOME</a><span class="sr-only">(current)</span>
						</li>
						<li class="landing-block-node-menu-list-item nav-item g-mx-15--lg g-mb-7 g-mb-0--lg">
							<a href="#block@block[04.7.one_col_fix_with_title_and_text_2]" class="landing-block-node-menu-list-item-link nav-link g-color-primary--hover p-0" target="_self">APARTMENTS FOR RENT</a>
						</li>
						<li class="landing-block-node-menu-list-item nav-item g-mx-15--lg g-mb-7 g-mb-0--lg">
							<a href="#block@block[04.1.one_col_fix_with_title]" class="landing-block-node-menu-list-item-link nav-link g-color-primary--hover p-0" target="_self">SPECIAL OFFERS</a>
						</li>
						<li class="landing-block-node-menu-list-item nav-item g-mx-15--lg g-mb-7 g-mb-0--lg">
							<a href="#block@block[04.7.one_col_fix_with_title_and_text_2@2]" class="landing-block-node-menu-list-item-link nav-link g-color-primary--hover p-0" target="_self">OUR HOUSES</a>
						</li>
						<li class="landing-block-node-menu-list-item nav-item g-mx-15--lg g-mb-7 g-mb-0--lg">
							<a href="#block@block[01.big_with_text_blocks]" class="landing-block-node-menu-list-item-link nav-link g-color-primary--hover p-0" target="_self">GALLERY</a>
						</li>
						<li class="landing-block-node-menu-list-item nav-item g-mx-15--lg g-mb-7 g-mb-0--lg">
							<a href="#block@block[04.7.one_col_fix_with_title_and_text_2@3]" class="landing-block-node-menu-list-item-link nav-link g-color-primary--hover p-0" target="_self">AGENTS</a>
						</li>
						<li class="landing-block-node-menu-list-item nav-item g-mx-15--lg g-mb-7 g-mb-0--lg">
							<a href="#block@block[01.big_with_text_3]" class="landing-block-node-menu-list-item-link nav-link g-color-primary--hover p-0" target="_self">DISCOUNT</a>
						</li>
						<li class="landing-block-node-menu-list-item nav-item g-mx-15--lg g-mb-7 g-mb-0--lg">
							<a href="#block@block[04.7.one_col_fix_with_title_and_text_2@4]" class="landing-block-node-menu-list-item-link nav-link g-color-primary--hover p-0" target="_self">TESTIMONIALS</a>
						</li>
						<li class="landing-block-node-menu-list-item nav-item g-ml-15--lg">
							<a href="#block@block[33.3.form_1_transparent_black_no_text]" class="landing-block-node-menu-list-item-link nav-link g-color-primary--hover p-0" target="_self">CONTACT US</a>
						</li>
					</ul>
				</div>
				<!-- End Navigation -->

				<!-- Responsive Toggle Button -->
				<button class="navbar-toggler btn g-pos-rel g-line-height-1 g-brd-none g-pa-0 ml-auto" type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navBar" data-toggle="collapse" data-target="#navBar">
                <span class="hamburger hamburger--slider">
                  <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                  </span>
                </span>
				</button>
				<!-- End Responsive Toggle Button -->
			</div>
		</nav>
	</div>
</header>',
			),
		'46.9.cover_bgimg_vertical_slider' =>
			array (
				'CODE' => '46.9.cover_bgimg_vertical_slider',
				'SORT' => '500',
				'CONTENT' => '<section class="landing-block">
	<div class="js-carousel carouselVertical002 g-overflow-hidden" data-autoplay="true" data-infinite="true" data-speed="10000" data-vertical="true" data-pagi-classes="u-carousel-indicators-v7 text-center g-ml-30">


		<div class="landing-block-node-card js-slide">
			<!-- Promo Block -->
			<div class="landing-block-node-card-img g-flex-centered g-height-100vh g-bg-cover g-bg-pos-center g-bg-img-hero g-bg-black-opacity-0_2--after" style="background-image: url(https://cdn.bitrix24.site/bitrix/images/landing/business/1920x1280/img25.jpg);">
				<div class="landing-block-node-text-container js-animation fadeIn container text-center g-z-index-1 animated">
					<h3 class="landing-block-node-card-subtitle h6 g-font-size-32 g-color-white g-mb-10 g-mb-25--md">
						<span style="font-weight: bold;">$3.500</span> / per month
					</h3>
					<h2 class="landing-block-node-card-title text-uppercase g-line-height-1_2 g-font-weight-700 g-font-size-20 g-font-size-46 g-color-white mb-0 g-mb-35--md g-text-break-word">
						Apartment in<br />London\'s center
					</h2>
					<div class="landing-block-node-card-button-container">
						<a class="landing-block-node-card-button btn btn-lg g-mt-20 g-mt-0--md text-uppercase u-btn-primary g-font-weight-700 g-font-size-12 g-py-15 g-px-40 g-rounded-4" href="#">Learn more</a>
					</div>
				</div>
			</div>
			<!-- End Promo Block -->
		</div>
		<div class="landing-block-node-card js-slide">
			<!-- Promo Block -->
			<div class="landing-block-node-card-img g-flex-centered g-height-100vh g-bg-cover g-bg-pos-center g-bg-img-hero g-bg-black-opacity-0_2--after" style="background-image: url(https://cdn.bitrix24.site/bitrix/images/landing/business/1920x1280/img26.jpg);">
				<div class="landing-block-node-text-container js-animation fadeIn container text-center g-z-index-1 animated">
					<h3 class="landing-block-node-card-subtitle h6 g-font-size-32 g-color-white g-mb-10 g-mb-25--md">
						<span style="font-weight: bold;">$3.500</span> / per month
					</h3>
					<h2 class="landing-block-node-card-title text-uppercase g-line-height-1_2 g-font-weight-700 g-font-size-20 g-font-size-46 g-color-white mb-0 g-mb-35--md g-text-break-word">
						Apartment in<br />London\'s center
					</h2>
					<div class="landing-block-node-card-button-container">
						<a class="landing-block-node-card-button btn btn-lg g-mt-20 g-mt-0--md text-uppercase u-btn-primary g-font-weight-700 g-font-size-12 g-py-15 g-px-40 g-rounded-4" href="#">Learn more</a>
					</div>
				</div>
			</div>
			<!-- End Promo Block -->
		</div>
		<div class="landing-block-node-card js-slide">
			<!-- Promo Block -->
			<div class="landing-block-node-card-img g-flex-centered g-height-100vh g-bg-cover g-bg-pos-center g-bg-img-hero g-bg-black-opacity-0_2--after" style="background-image: url(https://cdn.bitrix24.site/bitrix/images/landing/business/1920x1280/img27.jpg);">
				<div class="landing-block-node-text-container js-animation fadeIn container text-center g-z-index-1 animated">
					<h3 class="landing-block-node-card-subtitle h6 g-font-size-32 g-color-white g-mb-10 g-mb-25--md">
						<span style="font-weight: bold;">$3.500</span> / per month
					</h3>
					<h2 class="landing-block-node-card-title text-uppercase g-line-height-1_2 g-font-weight-700 g-font-size-20 g-font-size-46 g-color-white mb-0 g-mb-35--md g-text-break-word">
						Apartment in<br />London\'s center
					</h2>
					<div class="landing-block-node-card-button-container">
						<a class="landing-block-node-card-button btn btn-lg g-mt-20 g-mt-0--md text-uppercase u-btn-primary g-font-weight-700 g-font-size-12 g-py-15 g-px-40 g-rounded-4" href="#">Learn more</a>
					</div>
				</div>
			</div>
			<!-- End Promo Block -->
		</div>

		<div class="landing-block-node-card js-slide">
			<!-- Promo Block -->
			<div class="landing-block-node-card-img g-flex-centered g-height-100vh g-bg-cover g-bg-pos-center g-bg-img-hero g-bg-black-opacity-0_2--after" style="background-image: url(https://cdn.bitrix24.site/bitrix/images/landing/business/1920x1280/img28.jpg);">
				<div class="landing-block-node-text-container js-animation fadeIn container text-center g-z-index-1 animated">
					<h3 class="landing-block-node-card-subtitle h6 g-font-size-32 g-color-white g-mb-10 g-mb-25--md">
						<span style="font-weight: bold;">$3.500</span> / per month
					</h3>
					<h2 class="landing-block-node-card-title text-uppercase g-line-height-1_2 g-font-weight-700 g-font-size-20 g-font-size-46 g-color-white mb-0 g-mb-35--md g-text-break-word">
						Apartment in<br />London\'s center
					</h2>
					<div class="landing-block-node-card-button-container">
						<a class="landing-block-node-card-button btn btn-lg g-mt-20 g-mt-0--md text-uppercase u-btn-primary g-font-weight-700 g-font-size-12 g-py-15 g-px-40 g-rounded-4" href="#">Learn more</a>
					</div>
				</div>
			</div>
			<!-- End Promo Block -->
		</div>

	</div>
</section>',
			),
		'04.7.one_col_fix_with_title_and_text_2' =>
			array (
				'CODE' => '04.7.one_col_fix_with_title_and_text_2',
				'SORT' => '1000',
				'CONTENT' => '<section class="landing-block g-py-20 js-animation fadeInUp animated g-pt-60 g-bg-main g-pb-20">

        <div class="container landing-block-node-subcontainer text-center g-max-width-800 g-mb-20">

            <div class="landing-block-node-inner text-uppercase u-heading-v2-4--bottom g-brd-primary">
                <h4 class="landing-block-node-subtitle g-font-weight-700 g-font-size-12 g-color-primary g-mb-15"> </h4>
                <h2 class="landing-block-node-title u-heading-v2__title g-line-height-1_1 g-font-weight-700 g-font-size-40 g-color-black g-mb-minus-10">POPULAR APARTMENTS FOR RENT</h2>
            </div>

			<div class="landing-block-node-text g-color-gray-dark-v5"><p>Mauris sodales tellus vel felis dapibus, sit amet porta nibh egestas. Sed dignissim tellus quis sapien sagittis cursus. Cras porttitor auctor sapien eu tempus nunc placerat</p></div>
        </div>

    </section>',
			),
		'39.1.five_blocks_carousel' =>
			array (
				'CODE' => '39.1.five_blocks_carousel',
				'SORT' => '1500',
				'CONTENT' => '<section class="landing-block g-pt-20 g-pb-60">
	<div id="carouselRealEstate1" class="js-carousel" data-infinite="true" data-slides-show="5">
		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img3.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img4.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img5.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img6.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img7.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img8.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>
	</div>
</section>',
			),
		'04.1.one_col_fix_with_title' =>
			array (
				'CODE' => '04.1.one_col_fix_with_title',
				'SORT' => '2000',
				'CONTENT' => '<section class="landing-block g-pb-20 js-animation fadeInUp animated g-pt-60">
        <div class="container">
            <div class="landing-block-node-inner text-uppercase text-center u-heading-v2-4--bottom g-brd-primary">
                <h4 class="landing-block-node-subtitle h6 g-font-weight-800 g-font-size-12 g-letter-spacing-1 g-color-primary g-mb-20"> </h4>
                <h2 class="landing-block-node-title h1 u-heading-v2__title g-line-height-1_3 g-font-weight-600 g-font-size-40 g-mb-minus-10">SPECIAL OFFER</h2>
            </div>
        </div>
    </section>',
			),
		'31.2.two_cols_img_text' =>
			array (
				'CODE' => '31.2.two_cols_img_text',
				'SORT' => '2500',
				'CONTENT' => '<section class="landing-block g-theme-architecture-bg-blue-dark-v1">
	<div>
		<div class="row mx-0">
			<div class="landing-block-node-img col-md-6 g-min-height-300 g-bg-img-hero g-px-0 g-bg-size-contain--xs g-bg-size-cover--sm" style="background-image: url(\'https://cdn.bitrix24.site/bitrix/images/landing/business/800x460/img1.jpg\');" data-fileid="-1" data-filehash="9eef207add73028ae50f74a9033c20cb"></div>
			
			<div class="col-md-6 text-center text-md-left g-py-50 g-py-100--md g-px-15 g-px-50--md">
				<h3 class="landing-block-node-title text-uppercase g-font-weight-700 g-font-size-default g-color-white g-mb-25 js-animation fadeInUp animated">Ut pulvinar tellus sed elit luctus</h3>
				<div class="landing-block-node-text g-mb-30 g-color-gray-light-v2 js-animation fadeInUp animated"><p>Fusce dolor libero, efficitur et lobortis at, faucibus nec nunc. Proin fermentum turpis eget nisi lobortis.<br /><br />FOR $1.500.000 INSTEAD $1.750.000! </p></div>
				<div class="landing-block-node-button-container">
					<a class="landing-block-node-button text-uppercase btn btn-xl u-btn-primary g-font-weight-700 g-font-size-12 js-animation fadeInUp animated g-rounded-4" href="#" tabindex="0" target="_self">LEARN MORE</a>
				</div>
			</div>
		</div>
	</div>
</section>',
			),
		'04.7.one_col_fix_with_title_and_text_2@2' =>
			array (
				'CODE' => '04.7.one_col_fix_with_title_and_text_2',
				'SORT' => '3000',
				'CONTENT' => '<section class="landing-block g-py-20 js-animation fadeInUp animated g-pt-60 g-pb-20 g-bg-main">

        <div class="container landing-block-node-subcontainer text-center g-max-width-800 g-mb-20">

            <div class="landing-block-node-inner text-uppercase u-heading-v2-4--bottom g-brd-primary">
                <h4 class="landing-block-node-subtitle g-font-weight-700 g-font-size-12 g-color-primary g-mb-15"> </h4>
                <h2 class="landing-block-node-title u-heading-v2__title g-line-height-1_1 g-font-weight-700 g-font-size-40 g-color-black g-mb-minus-10">OUR HOUSES</h2>
            </div>

			<div class="landing-block-node-text g-color-gray-dark-v5"><p>Fusce dolor libero, efficitur et lobortis at, faucibus nec nunc. Proin fermentum turpis eget nisi facilisis lobortis. Praesent malesuada facilisis maximus.</p></div>
        </div>

    </section>',
			),
		'39.1.five_blocks_carousel@2' =>
			array (
				'CODE' => '39.1.five_blocks_carousel',
				'SORT' => '3500',
				'CONTENT' => '<section class="landing-block g-pt-20 g-pb-20">
	<div id="carouselRealEstate1" class="js-carousel" data-infinite="true" data-slides-show="5">
		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img3.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img4.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img5.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img6.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img7.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img8.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>
	</div>
</section>',
			),
		'39.1.five_blocks_carousel@3' =>
			array (
				'CODE' => '39.1.five_blocks_carousel',
				'SORT' => '4000',
				'CONTENT' => '<section class="landing-block g-pt-20 g-pb-60">
	<div id="carouselRealEstate1" class="js-carousel" data-infinite="true" data-slides-show="5">
		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img3.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img4.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img5.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img6.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img7.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>

		<div class="landing-block-node-card js-slide g-px-15">
			<!-- Article -->
			<article class="landing-block-node-card-bg text-center g-bg-white g-brd-around g-brd-gray-light-v3 g-rounded-4 g-my-2 js-animation fadeInUp animated">
				<!-- Article Header -->
				<header class="g-pa-25">
					<div class="landing-block-node-card-subtitle text-uppercase g-letter-spacing-1 g-color-gray-dark-v5 g-mb-15">
						<span style="font-weight: bold;">$3.500</span>
						/ per month
					</div>
					<h3 class="landing-block-node-card-title text-uppercase g-line-height-1_4 g-font-weight-700 g-font-size-16 g-mb-10">
						Ut pulvinar tellus sed elit luctus
					</h3>
					<div class="text-uppercase g-font-size-12">
						<a class="landing-block-node-card-link g-font-size-10 g-color-gray-dark-v5 g-color-primary--hover g-text-underline--none--hover" href="#">12 Reviews</a>
					</div>
				</header>
				<!-- End Article Header -->

				<!-- Article Image -->
				<img class="landing-block-node-card-img w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/800x534/img8.jpg" alt="" />
				<!-- End Article Image -->

				<!-- Article Footer -->
				<footer class="d-table w-100">
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-022"></i>
						<div class="landing-block-node-card-icon-text d-inline">4</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-brd-right g-brd-gray-light-v3 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-hotel-restaurant-158"></i>
						<div class="landing-block-node-card-icon-text d-inline">2</div>
					</div>
					<div class="landing-block-node-card-icon-container g-color-gray-dark-v5 d-table-cell align-middle g-font-size-12 g-px-10 g-pt-15 g-pb-10">
						<i class="landing-block-node-card-icon align-middle u-line-icon-pro g-font-size-18 g-mr-5 icon-real-estate-017"></i>
						<div class="landing-block-node-card-icon-text d-inline">130 sqft</div>
					</div>
				</footer>
				<!-- End Article Footer -->
			</article>
			<!-- End Article -->
		</div>
	</div>
</section>',
			),
		'01.big_with_text_blocks' =>
			array (
				'CODE' => '01.big_with_text_blocks',
				'SORT' => '4500',
				'CONTENT' => '<section class="landing-block">
	<div class="js-carousel g-overflow-hidden g-max-height-100vh " data-autoplay="true" data-infinite="true" data-speed="10000">


		<div class="landing-block-node-card js-slide" data-title="About us">
			<!-- Promo Block -->
			<div class="landing-block-node-card-img g-flex-centered g-height-100vh g-min-height-500--md g-bg-cover g-bg-pos-center g-bg-img-hero g-bg-black-opacity-0_5--after" style="background-image: url(\'https://cdn.bitrix24.site/bitrix/images/landing/business/1200x802/img1.jpg\');" data-fileid="-1" data-filehash="9eef207add73028ae50f74a9033c20cb">
				<div class="container text-center g-max-width-800 g-z-index-1 js-animation landing-block-node-container fadeInLeftBig animated">
					<h2 class="landing-block-node-card-title text-uppercase g-font-weight-700 g-font-size-22 g-font-size-36--md g-color-white g-mb-20">Nunc sed trisrique mi</h2>
					<div class="landing-block-node-card-text g-max-width-645 g-color-white-opacity-0_9 mx-auto g-mb-35"><p>Fusce dolor libero, efficitur et lobortis at, faucibus nec nunc. Proin fermentum turpis eget nisi facilisis lobortis. Praesent malesuada facilisis maximus.<br /><br /><span style="font-weight: bold;">For $2.500.000</span></p></div>
					<div class="landing-block-node-card-button-container">
						<a class="landing-block-node-card-button btn btn-lg u-btn-primary g-font-weight-700 g-font-size-12 text-uppercase g-px-25 g-py-15 g-rounded-4" href="#" tabindex="-1" target="_self">LEARN MORE</a>
					</div>
				</div>
			</div>
			<!-- End Promo Block -->
		</div>
		<div class="landing-block-node-card js-slide" data-title="Experience">
			<!-- Promo Block -->
			<div class="landing-block-node-card-img g-flex-centered g-height-100vh g-min-height-500--md g-bg-cover g-bg-pos-center g-bg-img-hero g-bg-black-opacity-0_5--after" style="background-image: url(\'https://cdn.bitrix24.site/bitrix/images/landing/business/1200x802/img2.jpg\');" data-fileid="-1" data-filehash="9eef207add73028ae50f74a9033c20cb">
				<div class="container text-center g-max-width-800 g-z-index-1 js-animation landing-block-node-container fadeInLeftBig animated">
					<h2 class="landing-block-node-card-title text-uppercase g-font-weight-700 g-font-size-22 g-font-size-36--md g-color-white g-mb-20">Nunc sed trisrique mi</h2>
					<div class="landing-block-node-card-text g-max-width-645 g-color-white-opacity-0_9 mx-auto g-mb-35"><p>Fusce dolor libero, efficitur et lobortis at, faucibus nec nunc. Proin fermentum turpis eget nisi facilisis lobortis. Praesent malesuada facilisis maximus.</p><p><span style="font-weight: bold;">For $2.500.000</span></p></div>
					<div class="landing-block-node-card-button-container">
						<a class="landing-block-node-card-button btn btn-lg u-btn-primary g-font-weight-700 g-font-size-12 text-uppercase g-px-25 g-py-15 g-rounded-4" href="#" tabindex="-1" target="_self">LEARN MORE</a>
					</div>
				</div>
			</div>
			<!-- End Promo Block -->
		</div>
		<div class="landing-block-node-card js-slide" data-title="Services">
			<!-- Promo Block -->
			<div class="landing-block-node-card-img g-flex-centered g-height-100vh g-min-height-500--md g-bg-cover g-bg-pos-center g-bg-img-hero g-bg-black-opacity-0_5--after" style="background-image: url(\'https://cdn.bitrix24.site/bitrix/images/landing/business/1200x802/img3.jpg\');" data-fileid="-1" data-filehash="9eef207add73028ae50f74a9033c20cb">
				<div class="container text-center g-max-width-800 g-z-index-1 js-animation landing-block-node-container fadeInLeftBig animated">
					<h2 class="landing-block-node-card-title text-uppercase g-font-weight-700 g-font-size-22 g-font-size-36--md g-color-white g-mb-20">NUNC SED TRISRIQUE MI</h2>
					<div class="landing-block-node-card-text g-max-width-645 g-color-white-opacity-0_9 mx-auto g-mb-35"><p>Fusce dolor libero, efficitur et lobortis at, faucibus nec nunc. Proin fermentum turpis eget nisi facilisis lobortis. Praesent malesuada facilisis maximus.</p><p><span style="font-weight: bold; color: rgb(244, 81, 30);">For $2.500.000</span></p></div>
					<div class="landing-block-node-card-button-container">
						<a class="landing-block-node-card-button btn btn-lg u-btn-primary g-font-weight-700 g-font-size-12 text-uppercase g-px-25 g-py-15 g-rounded-4" href="#" tabindex="0" target="_self">LEARN MORE</a>
					</div>
				</div>
			</div>
			<!-- End Promo Block -->
		</div>

		<div class="landing-block-node-card js-slide" data-title="Services">
			<!-- Promo Block -->
			<div class="landing-block-node-card-img g-flex-centered g-height-100vh g-min-height-500--md g-bg-cover g-bg-pos-center g-bg-img-hero g-bg-black-opacity-0_5--after" style="background-image: url(\'https://cdn.bitrix24.site/bitrix/images/landing/business/1200x802/img4.jpg\');" data-fileid="-1" data-filehash="9eef207add73028ae50f74a9033c20cb">
				<div class="container text-center g-max-width-800 g-z-index-1 js-animation landing-block-node-container fadeInLeftBig animated">
					<h2 class="landing-block-node-card-title text-uppercase g-font-weight-700 g-font-size-22 g-font-size-36--md g-color-white g-mb-20">Nunc sed trisrique mi</h2>
					<div class="landing-block-node-card-text g-max-width-645 g-color-white-opacity-0_9 mx-auto g-mb-35"><p>Fusce dolor libero, efficitur et lobortis at, faucibus nec nunc. Proin fermentum turpis eget nisi facilisis lobortis. Praesent malesuada facilisis maximus.</p><p><span style="font-weight: bold;">For $2.500.000</span></p></div>
					<div class="landing-block-node-card-button-container">
						<a class="landing-block-node-card-button btn btn-lg u-btn-primary g-font-weight-700 g-font-size-12 text-uppercase g-px-25 g-py-15 g-rounded-4" href="#" tabindex="0" target="_self">LEARN MORE</a>
					</div>
				</div>
			</div>
			<!-- End Promo Block -->
		</div>

	</div>
</section>',
			),
		'04.7.one_col_fix_with_title_and_text_2@3' =>
			array (
				'CODE' => '04.7.one_col_fix_with_title_and_text_2',
				'SORT' => '5000',
				'CONTENT' => '<section class="landing-block g-py-20 js-animation fadeInUp animated g-pt-60 g-pb-20 g-bg-main">

        <div class="container landing-block-node-subcontainer text-center g-max-width-800 g-mb-20">

            <div class="landing-block-node-inner text-uppercase u-heading-v2-4--bottom g-brd-primary">
                <h4 class="landing-block-node-subtitle g-font-weight-700 g-font-size-12 g-color-primary g-mb-15"> </h4>
                <h2 class="landing-block-node-title u-heading-v2__title g-line-height-1_1 g-font-weight-700 g-font-size-40 g-color-black g-mb-minus-10">OUR AGENTS</h2>
            </div>

			<div class="landing-block-node-text g-color-gray-dark-v5"><p>Ut pulvinar tellus sed elit luctus aliquet. Suspendisse hendrerit sapien a aliquet porttitor. In hendrerit consequat neque eget egestas. In a consectetur felis.</p></div>
        </div>

    </section>',
			),
		'28.3.team' =>
			array (
				'CODE' => '28.3.team',
				'SORT' => '5500',
				'CONTENT' => '<section class="landing-block g-py-30 g-pb-80--md g-pt-20 g-pb-60">
	
	<div class="container">
		<!-- Team Block -->
		<div class="row">
			<div class="landing-block-card-employee js-animation col-md-6 col-lg-3 g-mb-30 g-mb-0--lg fadeIn animated landing-card">
				<div class="text-center">
					<!-- Figure -->
					<figure class="g-pos-rel g-parent g-mb-30">
						<!-- Figure Image -->
						<img class="landing-block-node-employee-photo w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/270x450/img1.jpg" alt="" />
						<!-- End Figure Image -->

						<!-- Figure Caption -->
						<figcaption class="g-pos-abs g-top-0 g-left-0 g-flex-middle w-100 h-100 g-bg-primary-opacity-0_8 opacity-0 g-opacity-1--parent-hover g-pa-20 g-transition-0_2 g-transition--ease-in">
							<div class="landing-block-node-employee-quote text-uppercase g-flex-middle-item g-line-height-1_4 g-font-weight-700 g-font-size-16 g-color-white">Changing
								your mind and changing world</div>
						
						<!-- End Figure Caption -->
					</figcaption></figure>
					<!-- End Figure -->

					<!-- Figure Info -->
					<div class="landing-block-node-employee-post d-block text-uppercase g-font-style-normal g-font-weight-700 g-font-size-11 g-color-primary g-mb-5">Mauris sodales</div>
					<h4 class="landing-block-node-employee-name text-uppercase g-font-weight-700 g-font-size-18 g-color-gray-dark-v2 g-mb-7">TOMAS SOWYER</h4>
					<div class="landing-block-node-employee-subtitle g-font-size-13 g-color-gray-dark-v5 mb-0"> </div>
					<!-- End Figure Info-->
				</div>
			</div>

			<div class="landing-block-card-employee js-animation col-md-6 col-lg-3 g-mb-30 g-mb-0--lg fadeIn animated landing-card">
				<div class="text-center">
					<!-- Figure -->
					<figure class="g-pos-rel g-parent g-mb-30">
						<!-- Figure Image -->
						<img class="landing-block-node-employee-photo w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/270x450/img2.jpg" alt="" />
						<!-- End Figure Image -->

						<!-- Figure Caption -->
						<figcaption class="g-pos-abs g-top-0 g-left-0 g-flex-middle w-100 h-100 g-bg-primary-opacity-0_8 opacity-0 g-opacity-1--parent-hover g-pa-20 g-transition-0_2 g-transition--ease-in">
							<div class="landing-block-node-employee-quote text-uppercase g-flex-middle-item g-line-height-1_4 g-font-weight-700 g-font-size-16 g-color-white">Changing
								your mind and changing world</div>
						
						<!-- End Figure Caption -->
					</figcaption></figure>
					<!-- End Figure -->

					<!-- Figure Info -->
					<div class="landing-block-node-employee-post d-block text-uppercase g-font-style-normal g-font-weight-700 g-font-size-11 g-color-primary g-mb-5">Integer blandit </div>
					<h4 class="landing-block-node-employee-name text-uppercase g-font-weight-700 g-font-size-18 g-color-gray-dark-v2 g-mb-7">SAMINA KINGSTAR</h4>
					<div class="landing-block-node-employee-subtitle g-font-size-13 g-color-gray-dark-v5 mb-0"> </div>
					<!-- End Figure Info-->
				</div>
			</div>

			<div class="landing-block-card-employee js-animation col-md-6 col-lg-3 g-mb-30 g-mb-0--lg fadeIn animated landing-card">
				<div class="text-center">
					<!-- Figure -->
					<figure class="g-pos-rel g-parent g-mb-30">
						<!-- Figure Image -->
						<img class="landing-block-node-employee-photo w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/270x450/img3.jpg" alt="" />
						<!-- End Figure Image -->

						<!-- Figure Caption -->
						<figcaption class="g-pos-abs g-top-0 g-left-0 g-flex-middle w-100 h-100 g-bg-primary-opacity-0_8 opacity-0 g-opacity-1--parent-hover g-pa-20 g-transition-0_2 g-transition--ease-in">
							<div class="landing-block-node-employee-quote text-uppercase g-flex-middle-item g-line-height-1_4 g-font-weight-700 g-font-size-16 g-color-white">Changing
								your mind and changing world</div>
						
						<!-- End Figure Caption -->
					</figcaption></figure>
					<!-- End Figure -->

					<!-- Figure Info -->
					<div class="landing-block-node-employee-post d-block text-uppercase g-font-style-normal g-font-weight-700 g-font-size-11 g-color-primary g-mb-5">Proin sollicitudin</div>
					<h4 class="landing-block-node-employee-name text-uppercase g-font-weight-700 g-font-size-18 g-color-gray-dark-v2 g-mb-7">SAMANTHA FELLY</h4>
					<div class="landing-block-node-employee-subtitle g-font-size-13 g-color-gray-dark-v5 mb-0"> </div>
					<!-- End Figure Info-->
				</div>
			</div>

			<div class="landing-block-card-employee js-animation col-md-6 col-lg-3 g-mb-30 g-mb-0--lg fadeIn animated landing-card">
				<div class="text-center">
					<!-- Figure -->
					<figure class="g-pos-rel g-parent g-mb-30">
						<!-- Figure Image -->
						<img class="landing-block-node-employee-photo w-100" src="https://cdn.bitrix24.site/bitrix/images/landing/business/270x450/img4.jpg" alt="" />
						<!-- End Figure Image -->

						<!-- Figure Caption -->
						<figcaption class="g-pos-abs g-top-0 g-left-0 g-flex-middle w-100 h-100 g-bg-primary-opacity-0_8 opacity-0 g-opacity-1--parent-hover g-pa-20 g-transition-0_2 g-transition--ease-in">
							<div class="landing-block-node-employee-quote text-uppercase g-flex-middle-item g-line-height-1_4 g-font-weight-700 g-font-size-16 g-color-white">Changing
								your mind and changing world</div>
						
						<!-- End Figure Caption -->
					</figcaption></figure>
					<!-- End Figure -->

					<!-- Figure Info -->
					<div class="landing-block-node-employee-post d-block text-uppercase g-font-style-normal g-font-weight-700 g-font-size-11 g-color-primary g-mb-5">Vestibulum pulvinar</div>
					<h4 class="landing-block-node-employee-name text-uppercase g-font-weight-700 g-font-size-18 g-color-gray-dark-v2 g-mb-7">ERICA PYTON</h4>
					<div class="landing-block-node-employee-subtitle g-font-size-13 g-color-gray-dark-v5 mb-0"> </div>
					<!-- End Figure Info-->
				</div>
			</div>
		</div>
		<!-- End Team Block -->
	</div>
</section>',
			),
		'01.big_with_text_3' =>
			array (
				'CODE' => '01.big_with_text_3',
				'SORT' => '6000',
				'CONTENT' => '<section class="landing-block landing-block-node-img u-bg-overlay g-flex-centered g-min-height-100vh g-height-70vh g-bg-img-hero g-bg-black-opacity-0_5--after g-py-80" style="background-image: url(\'https://cdn.bitrix24.site/bitrix/images/landing/business/1400x934/img1.jpg\');" data-fileid="-1" data-filehash="9eef207add73028ae50f74a9033c20cb">
	<div class="container g-max-width-800 text-center u-bg-overlay__inner g-mx-1 js-animation landing-block-node-container fadeInDown animated">
		<h2 class="landing-block-node-title text-uppercase g-line-height-1 g-font-weight-700 g-font-size-30 g-color-white g-mb-20">CONTACT US AND <span style="color: rgb(230, 74, 25);">GET 10%</span> DISCOUNT</h2>

		<div class="landing-block-node-text g-color-white-opacity-0_7 g-mb-35">Donec eleifend mauris eu leo varius consectetur. Aliquam luctus a lorem ac rutrum. Cras in nulla id mi ornare vestibulum. <p>Donec et magna nulla. Pellentesque ut ipsum id nibh pretium blandit quis ac erat.</p></div>
		<div class="landing-block-node-button-container">
			<a href="#" class="landing-block-node-button btn btn-xl u-btn-primary text-uppercase g-font-weight-700 g-font-size-12 g-py-15 g-px-40 g-mb-15 g-rounded-4" target="_self">CONTACT US</a>
		</div>
	</div>
</section>',
			),
		'04.7.one_col_fix_with_title_and_text_2@4' =>
			array (
				'CODE' => '04.7.one_col_fix_with_title_and_text_2',
				'SORT' => '6500',
				'CONTENT' => '<section class="landing-block g-py-20 js-animation fadeInUp animated g-bg-main g-pt-60 g-pb-20">

        <div class="container landing-block-node-subcontainer text-center g-max-width-800 g-mb-20">

            <div class="landing-block-node-inner text-uppercase u-heading-v2-4--bottom g-brd-primary">
                <h4 class="landing-block-node-subtitle g-font-weight-700 g-font-size-12 g-color-primary g-mb-15"> </h4>
                <h2 class="landing-block-node-title u-heading-v2__title g-line-height-1_1 g-font-weight-700 g-font-size-40 g-color-black g-mb-minus-10">FROM OUR CLIENTS</h2>
            </div>

			<div class="landing-block-node-text g-color-gray-dark-v5"><p>Ut pulvinar tellus sed elit luctus aliquet. Suspendisse hendrerit sapien a aliquet porttitor. In hendrerit consequat neque eget egestas. In a consectetur felis.</p></div>
        </div>

    </section>',
			),
		'08.2.two_cols_fix_title_and_text' =>
			array (
				'CODE' => '08.2.two_cols_fix_title_and_text',
				'SORT' => '7000',
				'CONTENT' => '<section class="landing-block g-pb-60 g-pt-20">
	<div class="container">
		<div class="row">

			<div class="landing-block-card col-lg-6 g-mb-40 g-mb-0--lg js-animation fadeIn animated landing-card">
				<div class="landing-block-card-header text-uppercase u-heading-v2-4--bottom g-brd-primary g-mb-40">
					<h4 class="landing-block-node-subtitle h6 g-font-weight-800 g-font-size-12 g-letter-spacing-1 g-color-primary g-mb-20"> </h4>
					<h2 class="landing-block-node-title h1 u-heading-v2__title g-line-height-1_3 g-font-weight-600 g-mb-minus-10 g-font-size-20 g-text-break-word">Spencer Family</h2>
				</div>

				<div class="landing-block-node-text g-font-size-14 g-color-gray-dark-v5"><p>Ut augue diam, lacinia fringilla erat eu, vehicula commodo quam. Aliquam eget accumsan ligula. Maecenas sit amet consectetur lectus. Suspendisse commodo et magna non pulvinar. Quisque et ultricies sem, et vulputate dui. Morbi aliquam leo id ipsum tempus mollis.</p></div>
			</div>

			<div class="landing-block-card col-lg-6 g-mb-40 g-mb-0--lg js-animation fadeIn animated landing-card">
				<div class="landing-block-card-header text-uppercase u-heading-v2-4--bottom g-brd-primary g-mb-40">
					<h4 class="landing-block-node-subtitle h6 g-font-weight-800 g-font-size-12 g-letter-spacing-1 g-color-primary g-mb-20"> </h4>
					<h2 class="landing-block-node-title h1 u-heading-v2__title g-line-height-1_3 g-font-weight-600 g-mb-minus-10 g-font-size-20 g-text-break-word">Melani Shnaider</h2>
				</div>

				<div class="landing-block-node-text g-font-size-14 g-color-gray-dark-v5"><p>Ut augue diam, lacinia fringilla erat eu, vehicula commodo quam. Aliquam eget accumsan ligula. Morbi aliquam leo id ipsum tempus mollis.</p></div>
			</div>

		</div>
	</div>
</section>',
			),
		'33.3.form_1_transparent_black_no_text' =>
			array (
				'CODE' => '33.3.form_1_transparent_black_no_text',
				'SORT' => '7500',
				'CONTENT' => '<section class="landing-block g-pos-rel g-bg-primary-dark-v1 g-pt-120 g-pb-120 landing-block-node-bgimg g-bg-size-cover g-bg-img-hero g-bg-cover g-bg-black-opacity-0_7--after" style="background-image: url(\'https://cdn.bitrix24.site/bitrix/images/landing/business/1920x1275/img1.jpg\');" data-fileid="-1">
		
		<div class="container g-pos-rel g-z-index-1">
			<div class="row align-items-center">

				<div class="landing-block-form-styles" hidden="">
					<div class="g-bg-transparent h1 g-color-white g-brd-none g-pa-0" data-form-style-wrapper-padding="1" data-form-style-bg="1" data-form-style-bg-content="1" data-form-style-bg-block="1" data-form-style-header-font-size="1" data-form-style-header-font-weight="1" data-form-style-button-font-color="1" data-form-style-border-block="1">
					</div>
					<div class="g-bg-primary g-color-primary g-brd-primary" data-form-style-main-bg="1" data-form-style-main-border-color="1" data-form-style-main-font-color-hover="1">
					</div>
					<div class="g-bg-transparent g-brd-none g-brd-bottom g-brd-white" data-form-style-input-bg="1" data-form-style-input-border="1" data-form-style-input-border-radius="1" data-form-style-input-border-color="1">
					</div>
					<div class="g-brd-primary g-brd-none g-brd-bottom g-bg-black-opacity-0_7" data-form-style-input-border-hover="1" data-form-style-input-border-color-hover="1" data-form-style-input-select-bg="1">
					</div>

					<p class="g-color-white-opacity-0_6" data-form-style-main-font-weight="1" data-form-style-header-text-font-size="1" data-form-style-label-font-weight="1" data-form-style-label-font-size="1" data-form-style-second-font-color="1">
					</p>

					<h3 class="h4 g-color-white" data-form-style-main-font-color="1" data-form-style-main-font-family="1">
					</h3>

					<p data-form-style-main-font-family="1" data-form-style-main-font-weight="1" data-form-style-header-text-font-size="1">
				
				</p></div>


				<div class="col-12 col-md-10 col-lg-8 mx-auto">
					<div class="bitrix24forms g-brd-none g-brd-around--sm g-brd-white-opacity-0_6 g-px-0 g-px-20--sm g-px-45--lg g-py-0 g-py-30--sm g-py-60--lg u-form-alert-v1" data-b24form="" data-form-style-input-border-color="1" data-b24form-use-style="Y" data-b24form-show-header="Y" data-b24form-original-domain=""></div>
				</div>

			</div>
		</div>

</section>',
			),
		'35.2.footer_dark' =>
			array (
				'CODE' => '35.2.footer_dark',
				'SORT' => '8000',
				'CONTENT' => '<section class="g-pt-60 g-pb-60 g-theme-architecture-bg-blue-dark-v1">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-6 g-mb-25 g-mb-0--lg">
				<h2 class="landing-block-node-title text-uppercase g-color-white g-font-weight-700 g-font-size-16 g-mb-20"> </h2>
				<div class="landing-block-node-text g-font-size-default g-color-gray-light-v1 g-mb-20"> </div>

				<address class="g-color-gray-light-v1 g-mb-20">
				

				

				
				</address>

			</div>


			<div class="col-sm-12 col-md-2 col-lg-2 g-mb-25 g-mb-0--lg">
				<h2 class="landing-block-node-title text-uppercase g-color-white g-font-weight-700 g-font-size-16 g-mb-20">
					Categories</h2>
				<ul class="landing-block-card-list1 list-unstyled g-mb-30">
					<li class="landing-block-card-list1-item g-mb-10">
						<a class="landing-block-node-list-item g-color-gray-light-v2" href="#">Proin vitae est lorem</a>
					</li>
					<li class="landing-block-card-list1-item g-mb-10">
						<a class="landing-block-node-list-item g-color-gray-light-v2" href="#">Aenean imperdiet nisi</a>
					</li>
					<li class="landing-block-card-list1-item g-mb-10">
						<a class="landing-block-node-list-item g-color-gray-light-v2" href="#">Praesent pulvinar
							gravida</a>
					</li>
					<li class="landing-block-card-list1-item g-mb-10">
						<a class="landing-block-node-list-item g-color-gray-light-v2" href="#">Integer commodo est</a>
					</li>
				</ul>
			</div>

			<div class="col-sm-12 col-md-2 col-lg-2 g-mb-25 g-mb-0--lg">
				<h2 class="landing-block-node-title text-uppercase g-color-white g-font-weight-700 g-font-size-16 g-mb-20">TOP lINKS</h2>
				<ul class="landing-block-card-list2 list-unstyled g-mb-30">
					<li class="landing-block-card-list2-item g-mb-10">
						<a class="landing-block-node-list-item g-color-gray-light-v2" href="#">Vivamus egestas sapien</a>
					</li>
					<li class="landing-block-card-list2-item g-mb-10">
						<a class="landing-block-node-list-item g-color-gray-light-v2" href="#">Sed convallis nec enim</a>
					</li>
					<li class="landing-block-card-list2-item g-mb-10">
						<a class="landing-block-node-list-item g-color-gray-light-v2" href="#">Pellentesque a tristique
							risus</a>
					</li>
					<li class="landing-block-card-list2-item g-mb-10">
						<a class="landing-block-node-list-item g-color-gray-light-v2" href="#">Nunc vitae libero
							lacus</a>
					</li>
				</ul>
			</div>

			<div class="col-sm-12 col-md-2 col-lg-2">
				<h2 class="landing-block-node-title text-uppercase g-color-white g-font-weight-700 g-font-size-16 g-mb-20">USEFUL Links</h2>
				<ul class="landing-block-card-list3 list-unstyled g-mb-30">
					<li class="landing-block-card-list3-item g-mb-10">
						<a class="landing-block-node-list-item g-color-gray-light-v2" href="#">Pellentesque a tristique
							risus</a>
					</li>
					<li class="landing-block-card-list3-item g-mb-10">
						<a class="landing-block-node-list-item g-color-gray-light-v2" href="#">Nunc vitae libero
							lacus</a>
					</li>
					<li class="landing-block-card-list3-item g-mb-10">
						<a class="landing-block-node-list-item g-color-gray-light-v2" href="#">Praesent pulvinar
							gravida</a>
					</li>
					<li class="landing-block-card-list3-item g-mb-10">
						<a class="landing-block-node-list-item g-color-gray-light-v2" href="#">Integer commodo est</a>
					</li>
				</ul>
			</div>

		</div>
	</div>
</section>',
			),
		'17.1.copyright_with_social' =>
			array (
				'CODE' => '17.1.copyright_with_social',
				'SORT' => '8500',
				'CONTENT' => '<section class="landing-block g-brd-top g-brd-gray-dark-v2 g-theme-architecture-bg-blue-dark-v1 js-animation animation-none">
	<div class="text-center text-md-left g-py-40 g-color-gray-dark-v5 container">
		<div class="row">
			<div class="col-md-6 d-flex align-items-center g-mb-15 g-mb-0--md w-100 mb-0">
				<div class="landing-block-node-text mr-1 g-color-gray-light-v2 js-animation animation-none">
					&copy; 2018 All rights reserved.
				</div>
			</div>

			<div class="col-md-6">
			</div>
		</div>
	</div>
</section>',
			),
	)
);