<?php
namespace TaskForce\Import;

use TaskForce\Exceptions\CsvConverterException;

class Converter
{
    private $tableName;
    private $header;
    private $newFields;
    private $csvFile;
    private $sqlFile;

    public function __construct(string $sourceFilename, string $outputFilename, string $tableName, array $header, array $newFields)
    {
        $this->csvFile  = new \SplFileObject($sourceFilename, 'r');
        if (!$this->csvFile->isReadable()) {
            throw new CsvConverterException('can not open source file ' . $sourceFilename);
        }

        if ($this->getCsvHeaderCount() !== count($header)) {
            throw new CsvConverterException('count headers in csv file and data does not match' );
        }

        if (file_exists($outputFilename)) {
            throw new CsvConverterException('output file ' . $outputFilename . ' already exists');
        }

        $this->sqlFile = new \SplFileObject($outputFilename, 'w');
        if (!$this->sqlFile->isWritable()) {
            throw new CsvConverterException('can not open output file ' . $outputFilename . ' for write');
        }

        $this->tableName = $tableName;
        $this->header = $header;
        $this->newFields = $newFields;
    }

    /**
     * Get headers from csv file
     * @return array
     */
    public function getCsvHeader(): array
    {
        $this->csvFile->seek(0);
        $header = explode(',', trim($this->csvFile->current()));

        return $header;
    }

    /**
     * Get count of headers in csv file
     * @return int
     */

    public function getCsvHeaderCount(): int
    {
        return count($this->getCsvHeader());
    }

    /**
     * Convert csv file to sql file
     * @throws \Exception
     */
    public function convert(): void
    {
        $fullHeaderNames = array_merge(array_keys($this->header), array_keys($this->getAddHeaders()));
        $fullHeaderTypes = array_merge(array_values($this->header), array_values($this->getAddHeaders()));

        while(!$this->csvFile->eof() && ($row = $this->csvFile->fgetcsv()) && ($row[0] !== null)) {
            $row = array_merge($row, $this->addFields());
            $row = $this->formateRow($row, $fullHeaderTypes);
            $sqlLine = "insert into " . $this->tableName . " (" . implode(',', $fullHeaderNames)  . ") values (" . implode(',', $row) . ");\n";
            $this->sqlFile->fwrite($sqlLine);
        }
    }

    /**
     * escaping characters and adds single quotes for text values
     * @param array $row
     * @param array $types
     * @return array
     */
    private function formateRow(array $row, array $types): array
    {
        for ($i = 0; $i < count($row); $i++) {
            $newRow[] = $types[$i] === 'text' ? "'" . addslashes($row[$i]) . "'" : $row[$i];
        }

        return $newRow;
    }

    /**
     * Add random generated values for new fields which missed in csv files
     * Type of field must be 'number' or 'text'
     * @return array
     * @throws \Exception
     */
    private function addFields(): array
    {
        foreach ($this->newFields as $field) {
            switch ($field['field_type']) {
                case "number":
                    $row[] = rand($field['random'][0], $field['random'][1]);
                    break;
                case "text":
                    $randomKey = array_rand($field['random']);
                    $row[] = $field['random'][$randomKey];
                    break;
                default:
                    throw new CsvConverterException('unknown type of field:' . $field['field_type']);
            }
        }

        return $row ?? [];
    }

    /**
     * Get headers for new fields (add_fields in $newFields)
     * @return array
     */
    private function getAddHeaders(): array
    {
        $result = [];
        foreach ($this->newFields as $field) {
           $result[$field['field_name']] = $field['field_type'];
        }

        return $result;
    }
}
