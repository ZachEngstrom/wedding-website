/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */!function(o){wp.customize("blogname",function(n){n.bind(function(n){o(".site-title a").text(n)})}),wp.customize("blogdescription",function(n){n.bind(function(n){o(".site-description").text(n)})}),wp.customize("background_color",function(n){n.bind(function(n){o("body").css("background-color",n)})})}(jQuery);
