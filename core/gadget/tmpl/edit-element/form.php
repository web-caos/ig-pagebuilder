<?php
/**
 * @version    $Id$
 * @package    IG_PageBuilder
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 */

// Make sure response header is HTML document
@header( 'Content-Type: ' . get_option( 'html_type' ) . '; charset=' . get_option( 'blog_charset' ) );
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<?php
// Do necessary actions for loading header assets
do_action( 'pb_admin_enqueue_scripts' );
do_action( 'admin_print_styles'    );
do_action( 'admin_print_scripts'   );
do_action( 'pb_admin_head'            );
?>
</head>
<body class="jsn-master contentpane">
<?php
// Print HTML code for element editor
echo '' . $data;

// Do necessary actions for loading footer assets
do_action( 'pb_admin_footer'               );
do_action( 'admin_print_footer_scripts' );

// Exit immediately to prevent base gadget class from sending JSON data back
exit('
</body>
</html>
');
