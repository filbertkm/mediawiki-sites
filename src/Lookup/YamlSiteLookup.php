<?php

namespace MediaWiki\Sites\Lookup;

use MediaWiki\Sites\Site;
use Symfony\Component\Yaml\Yaml;
use Wikimedia\Assert\Assert;

/**
 *
 */
class YamlSiteLookup implements SiteLookup {

	private $sitesFile;

	public function __construct( $sitesFile ) {
		Assert::parameterType( 'string', $sitesFile, '$sitesFile' );

		if ( !is_readable( $sitesFile ) ) {
			throw new \InvalidArgumentException( '$sitesFile ' . $sitesFile . ' is not readable' );
		}

		$this->sitesFile = $sitesFile;
	}

	/**
	 * @return Site
	 */
	public function getSite( $siteId ) {
		$data = Yaml::parse( file_get_contents( $this->sitesFile ) );

		if ( !isset( $data['sites'][$siteId] ) ) {
			throw new \InvalidArgumentException( '$siteId ' . $siteId . ' not found' );
		}

		$row = $data['sites'][$siteId];

		return new Site(
			$row['siteid'],
			$row['name'],
			$row['groups'],
			$row['apiurl']
		);
	}

}
