<?php


namespace MediaWiki\Sites\Console\Commands;

use Filbertkm\Http\HttpClient;
use Knp\Command\Command;
use MediaWiki\Sites\Import\SiteMatrixSiteImporter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wikimedia\Assert\Assert;

class ImportSitesCommand extends Command {

	/**
	 * @var HttpClient
	 */
	private $httpClient;

	/**
	 * @var string
	 */
	private $siteMatrix;

	/**
	 * @var string
	 */
	private $outputFile;

	protected function configure() {
		$this->setName( 'import-sites' )
			->setDescription( 'Import sites' );
	}

	public function setServices( HttpClient $httpClient, $siteMatrix, $outputFile ) {
		Assert::parameterType( 'string', $siteMatrix, '$siteMatrix' );
		Assert::parameterType( 'string', $outputFile, '$outputFile' );

		$this->httpClient = $httpClient;
		$this->siteMatrix = $siteMatrix;
		$this->outputFile = $outputFile;
	}

	protected function execute( InputInterface $input, OutputInterface $output ) {
		$importer = new SiteMatrixSiteImporter(
			$this->httpClient,
			$this->siteMatrix,
			$this->outputFile
		);

		$importer->import();

		$output->writeln( "Done\n" );
	}

}
