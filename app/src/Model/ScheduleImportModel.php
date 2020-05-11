<?php

namespace Api\Model;

/**
 * Class ScheduleImportModel
 *
 * @package Api\Model
 */
class ScheduleImportModel extends AbstractImportModel
{
    protected const FIELD_KEY = [
        'id'             => 'A',
        'date'           => 'B',
        'specialization' => 'C',
    ];

    protected string $fileName;

    /**
     * @param string $fileName
     */
    public function import(string $fileName): void
    {
        $this->fileName = $fileName;

        $i = 0;
        $schedulesData = [];
        $rows = $this->getRows();

        while ($rows->valid()) {
            $schedulesData[] = $rows->current();
            $rows->next();

            if (++$i >= 100 || !$rows->valid()) {
                foreach ($schedulesData as $scheduleData) {
                    // todo
                }

                $i = 0;
                $schedulesData = [];
            }
        }
    }

    /**
     * @return \Generator
     */
    protected function getRows(): \Generator
    {
        $sheetData = $this->getData($this->fileName);

        foreach ($sheetData as $key => $row) {
            $this->currentRow = $key + 2;

            $row = array_filter($row);

            if (empty($row)) {
                break;
            }

            yield [
                'id'             => $this->getValue($row, 'id'),
                'date'           => $this->getValue($row, 'date'),
                'specialization' => $this->getValue($row, 'specialization'),
            ];
        }
    }
}