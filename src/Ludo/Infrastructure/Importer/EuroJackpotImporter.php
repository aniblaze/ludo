<?php

namespace Ludo\Infrastructure\Importer;

use AppKernel;
use DateTime;
use Ludo\Domain\Chance\DTO\LotteryDTO;
use Ludo\Domain\Chance\DTO\EuroJackpotResultDTO;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * The Euro jackpot importer crawls a specific site for the winning lottery numbers, and caches the data into a JSON
 * object per year. Since the Euro jackpot gets a new winning number each week, the importer will only check for new
 * data once a week.
 */
class EuroJackpotImporter
{
    /** Archive constants */
    const ARCHIVE_URL_VARIABLE      = 'YYYY';
    const ARCHIVE_URL               = 'http://www.euro-jackpot.net/archive-' . self::ARCHIVE_URL_VARIABLE . '.asp';

    /** EuroJackpot constants */
    const EUROJACKPOT_START_YEAR    = 2012;
    const EUROJACKPOT_RENEWAL_DAYS  = 7;

    /**
     * Get all of the EuroJackpot results
     *
     * @return LotteryDTO[]
     */
    public function getResults() {
        $results        = array();
        $currentYear    = (new DateTime())->format('Y');

        for($i = self::EUROJACKPOT_START_YEAR; $i <= $currentYear; $i++) {
            $euroJackpot = new LotteryDTO();
            $euroJackpot->setYear($i);
            $euroJackpot->setResults($this->getResult($i));
            $results[] = $euroJackpot;
        }

        return $results;
    }

    /**
     * Get the EuroJackpot results for a given year.
     *
     * @param integer $year
     *
     * @return EuroJackpotResultDTO[]
     */
    public function getResult($year) {
        $cachedResult   = $this->getCachedResults($year);
        $result         = (!is_null($cachedResult)) ? $cachedResult : $this->importResult($year);
        $result         = ($this->shouldRenewCache($result)) ? $this->importResult($year) : $result;

        if (is_null($cachedResult))
        {
            $result     = $this->sortResult($result);
            $json       = $this->toJson($result);
            $this->writeJson($json, $year);
        }

        return $result;
    }

    /**
     * Should the cache be renewed.
     *
     * @param EuroJackpotResultDTO[] $result
     *
     * @return boolean
     */
    private function shouldRenewCache($result)
    {
        $lastResult         = $result[count($result) -1];
        $lastResultDate     = $lastResult->getDate();
        $currentDate        = new DateTime();
        $differenceInDays   = (integer) $lastResultDate->diff($currentDate)->format('%a');

        return ($differenceInDays >= self::EUROJACKPOT_RENEWAL_DAYS);
    }

    /**
     * Sort the result based on the date (timestamp).
     *
     * @param EuroJackpotResultDTO[] $result
     *
     * @return EuroJackpotResultDTO[]
     */
    public function sortResult($result)
    {
        usort($result, function ($a, $b) {
           return strcmp($a->getTimestamp(), $b->getTimestamp());
        });

        return $result;
    }

    /**
     * Get the cached EuroJackpot results for a given year.
     *
     * @param integer $year
     *
     * @return LotteryDTO|null
     */
    private function getCachedResults($year) {
        $fileName   = $this->getCacheLocation($year);
        $fileExists = file_exists($fileName);
        $jsonRaw    = $fileExists ? file_get_contents($fileName) : null;

        return ($jsonRaw) ? $this->fromJson($jsonRaw) : null;
    }

    /**
     * Import the results for a given year.
     *
     * @param integer $year
     *
     * @return EuroJackpotResultDTO[]
     */
    private function importResult($year) {
        $rawPageString  = $this->getRawResultWebPage($year);
        $rawTable       = $this->getRawResultTable($rawPageString);
        $formattedData  = $this->getFilteredTableData($rawTable);

        return $formattedData;
    }

    /**
     * Get the archive page in a string format.
     *
     * @param integer $year
     *
     * @return string
     */
    protected function getRawResultWebPage($year) {
        $url    = str_replace(self::ARCHIVE_URL_VARIABLE, $year, self::ARCHIVE_URL);
        $data   = file_get_contents($url);

        return $data;
    }

    /**
     * Extract the result part of the DOMDocument.
     *
     * @param string $document
     *
     * @return Crawler
     */
    protected function getRawResultTable($document) {
        $crawler    = new Crawler($document);
        $table      = $crawler->filterXPath('//table');
        $resultRows = $table->filterXPath('//tr[position()>1]');

        return $resultRows;
    }

    /**
     * Get a collection of EuroJackpot DTO's.
     *
     * @param Crawler $resultTableRows
     *
     * @return EuroJackpotResultDTO[]
     */
    private function getFilteredTableData(Crawler $resultTableRows) {
        $euroJackpotResultDTOList = array();

        foreach ($resultTableRows as $key => $resultTableRow)
        {
            $crawlerRow                 = new Crawler($resultTableRow);
            $euroJackpotResultDTO       = new EuroJackpotResultDTO();
            $euroJackpotResultDTO->setTimestamp($this->getTimestamp($crawlerRow));
            $euroJackpotResultDTO->setNumbers($this->getNumbers($crawlerRow));
            $euroJackpotResultDTO->setEuroNumbers($this->getEuroNumbers($crawlerRow));
            $euroJackpotResultDTOList[] = $euroJackpotResultDTO;
        }

        return $euroJackpotResultDTOList;
    }

    /**
     * Get the timestamp from the given row.
     *
     * @param Crawler $resultTableRow
     *
     * @return integer
     */
    private function getTimestamp(Crawler $resultTableRow) {
        $dateLink   = $resultTableRow->filterXPath('//a');
        $dateString = $dateLink->getNode(0)->nodeValue;
        $dateTime   = new DateTime($dateString);

        return $dateTime->getTimestamp();
    }

    /**
     * Get the winning numbers for the given result set.
     *
     * @param Crawler $resultTableRow
     *
     * @return integer[]
     */
    private function getNumbers(Crawler $resultTableRow) {
        $numbers        = array();
        $numberArray    = $resultTableRow->filterXPath('//*[contains(@class, \'ball\')]');

        foreach ($numberArray as $number)
            $numbers[] = (integer) $number->nodeValue;

        return $numbers;
    }

    /**
     * Get the winning euro numbers for the given result set.
     *
     * @param Crawler $resultTableRow
     *
     * @return integer[]
     */
    private function getEuroNumbers(Crawler $resultTableRow) {
        $euroNumbers        = array();
        $euroNumberArray    = $resultTableRow->filterXPath('//*[contains(@class, \'euro\')]');

        foreach ($euroNumberArray as $euroNumber)
            $euroNumbers[] = (integer) $euroNumber->nodeValue;

        return $euroNumbers;
    }
    /**
     * Write a JSON to a file.
     *
     * @param string $json
     * @param string $year
     *
     * @return void
     */
    public function writeJson($json, $year) {
        echo $this->getCacheLocation($year);
        $fp = fopen($this->getCacheLocation($year), 'wb');
        fwrite($fp, $json);
        fclose($fp);
    }

    /**
     * Turn an array into a JSON.
     *
     * @param $result
     *
     * @return string
     */
    public function toJson($result) {
        return (string) $this->jsonSerializer()->serialize($result, 'json');
    }

    /**
     * Turn a JSON into an array.
     *
     * @param $result
     *
     * @return LotteryDTO[]
     */
    public function fromJson($result) {
        $jsonArray = json_decode($result);
        $results = array();

        foreach($jsonArray as $entry)
        {
            $results[] = $this->jsonSerializer()->deserialize(json_encode($entry), EuroJackpotResultDTO::class, 'json');
        }


        return $results;
    }

    /**
     * Get the JSON serializer.
     *
     * @return Serializer
     */
    public function jsonSerializer() {
        $normalizer     = new ObjectNormalizer();
        $jsonEncoder    = new JsonEncoder();
        $serializer     = new Serializer(array($normalizer), array($jsonEncoder));

        return $serializer;
    }

    /**
     * Get the cache location for a given year.
     *
     * @param $year
     *
     * @return string
     */
    private function getCacheLocation($year)
    {
        $kernel = new AppKernel(getenv('APP_ENV'), false);

        return $kernel->getRootDir() . '/../doc/results/eurojackpot_' . $year . '.json';
    }
}