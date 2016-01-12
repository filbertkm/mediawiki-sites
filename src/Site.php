<?php

namespace MediaWiki\Sites;

class Site {

	private $siteId;
	private $siteName;
	private $siteGroups;
	private $apiUrl;

	public function __construct( $siteId, $siteName, array $siteGroups, $apiUrl ) {
		$this->siteId = $siteId;
		$this->siteName = $siteName;
		$this->siteGroups = $siteGroups;
		$this->apiUrl = $apiUrl;
	}

	/**
	 * @return string
	 */
	public function getSiteId() {
		return $this->siteId;
	}

	/**
	 * @return string
	 */
	public function getSiteName() {
		return $this->siteName;
	}

	/**
	 * @return string[]
	 */
	public function getSiteGroups() {
		return $this->siteGroups;
	}

	/**
	 * @return string
	 */
	public function getApiUrl() {
		return $this->apiUrl;
	}

}
