/*
 * License: GNU General Public License v2 or later
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 */!function(e){e(document).ready(function(){e(document).keydown(function(t){var n=!1;37==t.which?n=e(".previous-image a").attr("href"):39==t.which&&(n=e(".entry-attachment a").attr("href")),n&&!e("textarea, input").is(":focus")&&(window.location=n)})})}(jQuery);