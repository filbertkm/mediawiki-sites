<?php

namespace MediaWiki\Sites\Lookup;

interface SiteLookup {

	/**
	 * @return Site
	 */
	public function getSite( $siteId );

}
