<?php


namespace MediaWiki\Sites\Console\Commands;

use Filbertkm\Http\HttpClient;
use Knp\Command\Command;
use MediaWiki\Sites\Import\SiteMatrixSiteImporter;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wikimedia\Assert\Assert;

class ImportSitesCommand extends Command {

	private $httpClient;
	private $outputFile;

	protected function configure() {
		$this->setName( 'import-sites' )
			->setDescription( 'Import sites' )
			->addArgument(
				'site-matrix',
				InputArgument::REQUIRED,
				'Site matrix api url'
			);
	}

	public function setServices( HttpClient $httpClient, $outputFile ) {
		Assert::parameterType( 'string', $outputFile, '$outputFile' );

		$this->httpClient = $httpClient;
		$this->outputFile = $outputFile;
	}

	protected function execute( InputInterface $input, OutputInterface $output ) {
		$output->writeln( "Done" );

		$importer = new SiteMatrixSiteImporter(
			$this->httpClient,
			$input->getArgument( 'site-matrix' ),
			$this->outputFile
		);

		$importer->import();
	}

}
