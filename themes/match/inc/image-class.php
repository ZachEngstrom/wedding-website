<?php

/** 
 * Add Image Class
 * 
 * Add .image-fluid (Bootstrap v4.x.x) class to images
 * Doesn't work on existing images
 **/

function match_add_image_class($class){
    $class .= ' img-fluid';
    return $class;
}
add_filter('get_image_tag_class','match_add_image_class');