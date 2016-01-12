<?php

namespace MediaWiki\Sites\Import;

use Filbertkm\Http\HttpClient;
use MediaWiki\Sites\Site;
use Wikimedia\Assert\Assert;

class SiteMatrixSiteImporter implements SiteImporter {

	private $siteMatrixUrl;

	private $outputFile;

	public function __construct( HttpClient $httpClient, $siteMatrixUrl, $outputFile ) {
		Assert::parameterType( 'string', $siteMatrixUrl, '$siteMatrixUrl' );
		Assert::parameterType( 'string', $outputFile, '$outputFile' );

		$this->httpClient = $httpClient;
		$this->siteMatrixUrl = $siteMatrixUrl;
		$this->outputFile = $outputFile;
	}

	public function import() {
		$json = $this->httpClient->get( $this->siteMatrixUrl . '?action=sitematrix&format=json' );

		$results = json_decode( $json, true );
		$rows = $results['sitematrix'];
		$specials = $rows['specials'];

		unset( $rows['specials'] );
		unset( $rows['count'] );

		$sites = array_merge(
			$this->extractSites( $rows ),
			$this->extractSpecialSites( $specials )
		);

		file_put_contents(
			$this->outputFile,
			json_encode( array( 'sites' => $sites ) )
		);
	}

	private function extractSites( array $rows ) {
		$sites = array();

		foreach ( $rows as $row ) {
			$code = $row['code'];
			$name = $row['name'];

			foreach ( $row['site'] as $site ) {
				$siteId = $site['dbname'];

				$sites[$siteId] = array(
					'siteid' => $siteId,
					'name' => $row['name'],
					'groups' => array( $site['code'], 'wikimedia' ),
					'apiurl' => $site['url'] . '/w/api.php'
				);
			}
		}

		return $sites;
	}

	private function extractSpecialSites( $specials ) {
		$sites = array();

		foreach ( $specials as $special ) {
			$siteId = $special['dbname'];

			$sites[$siteId] = array(
				'siteid' => $siteId,
				'name' => $special['sitename'],
				'groups' => array( 'special', 'wikimedia' ),
				'apiurl' => $special['url'] . '/w/api.php'
			);
		}

		return $sites;
	}

}
