require("../sass/style.scss");
require("../fonts/fontello/css/fontello.css");
require("./vendor/bootstrap-transition");
require("./vendor/bootstrap-collapse");
require("./vendor/fslightbox");

(function ($) {
  $(".header").length > 0 && require("./template_parts/header.es6");
})(jQuery);
(function ($) {
  $(".banner").length > 0 && require("./template_parts/banner.es6");
})(jQuery);


