<?php

namespace App\Storages;

use App\Models\Task;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;

class CSVTasksStorage
{
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function add(Task $task): void
    {
        $writer = Writer::createFromPath($this->fileName, "a");
        $writer->setDelimiter(";");
        $writer->insertOne((array)$task);
    }

    public function searchById(string $id): ?Task
    {
        $reader = Reader::createFromPath($this->fileName, "r");
        $reader->setDelimiter(";");
        $records = Statement::create()->process($reader);
        foreach ($records as $recordId => $record)
        {
            if ($recordId == $id) return new Task($record[0]);
        }
        return null;
    }

    public function delete(Task $task): void
    {
        if (($fileRead = fopen($this->fileName, "r")) !== false)
        {
            $records = [];
            while (($row = fgetcsv($fileRead, 1000, ";")) !== false)
            {
                if ($row[0] !== $task->getDescription())
                {
                    $records[] = $row;
                }
            }
            $fileWrite = fopen($this->fileName, "w");
            foreach ($records as $record)
            {
                fputcsv($fileWrite, $record, ";");
            }
            fclose($fileWrite);
            fclose($fileRead);
        }
    }

    public function edit(string $id, string $description): void
    {
        $records = $this->getTasks();
        foreach ($records as $recordId => $record)
        {
            if ($recordId == $id)
            {
                $record->setDescription($description);
            }
        }
        $fileWrite = fopen($this->fileName, "w");
        foreach ($records as $record)
        {
            fputcsv($fileWrite, (array)$record, ";");
        }
        fclose($fileWrite);
    }

    public function getTasks(): array
    {
        $reader = Reader::createFromPath($this->fileName, "r");
        $reader->setDelimiter(";");
        $records = Statement::create()->process($reader);
        $tasks = [];
        foreach ($records as $record)
        {
            $tasks[] = new Task($record[0]);
        }
        return $tasks;
    }
}
