<?php
/**
 * Look for the widgets inside the trip-widgets directory and register them.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB;

use Elementor\Plugin;

// Scan Directory for Widgets.
$dir = new \DirectoryIterator( __DIR__ . '/trip-widgets' );

foreach ( $dir as $fileinfo ) {
	if ( ! $fileinfo->isDot() ) {
		if ( $fileinfo->isDir() ) {
			$pathname = $fileinfo->getPathname();
			$basename = $fileinfo->getBasename();

			if ( file_exists( $pathname . '/widget.php' ) ) {
				require_once $pathname . '/widget.php';

				$classname = __NAMESPACE__ . '\Trip\\' . ucwords( $basename, '-' ) . 'Widget';

				Plugin::instance()->widgets_manager->register( new $classname() );
			}
		}
	}
}
