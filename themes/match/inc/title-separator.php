<?php

function matchchild_change_separator() {
	return '|';
}
add_filter('document_title_separator', 'matchchild_change_separator');