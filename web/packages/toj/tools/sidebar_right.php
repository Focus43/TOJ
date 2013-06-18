<?php defined('C5_EXECUTE') or die("Access Denied.");

    // *have* to set $c variable to pass in because of funky global
    $c = Page::getByID(1);

    Loader::packageElement('partials/sidebar_right', 'toj', array('c' => $c));