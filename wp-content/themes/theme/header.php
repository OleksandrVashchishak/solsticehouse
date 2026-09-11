<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php $logo = get_field('logo', 'options') ?>
  <?php $contact = get_field('contact', 'options') ?>
  <?php $menu_logo = get_field('menu_logo', 'options') ?>

  <div id="page" class="site">
    <header class="header">
      <div class="header__container">
        <div class="header__wrapper">
          <a href="<?php echo $contact['url'] ?>" class="header__contact"><?php echo $contact['title'] ?></a>
          <button class="header__button">Menu</button>
          <div class="header__popup">
            <button type="button" class="header__popup-close" aria-label="Close">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M6.40038 18.3055L5.69238 17.5975L11.2924 11.9975L5.69238 6.39745L6.40038 5.68945L12.0004 11.2895L17.6004 5.68945L18.3084 6.39745L12.7084 11.9975L18.3084 17.5975L17.6004 18.3055L12.0004 12.7055L6.40038 18.3055Z" fill="black"/>
              </svg>
            </button>
            <?php if ($menu_logo) { ?>
              <img src="<?php echo $menu_logo; ?>" class="header__popup-logo" alt="logo">
            <?php } ?>
            <?php
            wp_nav_menu(
              array(
                'menu' => 'Header',
                'container' => '',
                'menu_class' => 'header__popup-menu'
              )
            ); ?>
          </div>
        </div>
      </div>
    </header>




    <div id="content" class="site-content <?php echo isset($_GET['modal']) ? 'book-modal' : '' ?>"></div>