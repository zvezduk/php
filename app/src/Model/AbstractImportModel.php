<?php

namespace Api\Model;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Class AbstractImportModel
 *
 * @package Api\Model
 */
abstract class AbstractImportModel
{
    protected const FIELD_KEY = [];

    protected int $currentRow = 0;

    protected ?Spreadsheet $phpSpreadsheet;

    /**
     * AbstractImportModel constructor.
     *
     * @param Spreadsheet         $phpSpreadsheet
     */
    public function __construct(Spreadsheet $phpSpreadsheet = null) {
        $this->phpSpreadsheet = $phpSpreadsheet;
    }

    /**
     * @param string $fileName
     */
    abstract public function import(string $fileName): void;

    /**
     * @param string $fileName
     *
     * @return array
     */
    protected function getData(string $fileName): array
    {
        $spreadsheet = $this->phpSpreadsheet ?? IOFactory::load($fileName);

        $sheetData = $spreadsheet->getActiveSheet()->rangeToArray(
            sprintf(
                'A1:%s%d',
                $spreadsheet->getActiveSheet()->getHighestDataColumn(),
                $spreadsheet->getActiveSheet()->getHighestDataRow()
            ),
            null,
            true,
            true,
            true
        );

        array_shift($sheetData);

        return $sheetData;
    }

    /**
     * @param array $array
     * @param       $key
     * @param null  $default
     *
     * @return mixed|null
     */
    protected function getValue(array $array, $key, $default = null)
    {
        return $array[static::FIELD_KEY[$key]] ?? $default;
    }
}