/*
 * Plugins
 */
import 'slick-carousel';
// import 'selectric';
import svg4everybody from 'svg4everybody';

/**
 * Modules
 */
import slider from './modules/slider';

/**
 * Pages
 */
import app from './pages/_app';


(($) => {
  'use strict';

  $(() => {
    svg4everybody();
    slider();
    app();
  });
})(jQuery);