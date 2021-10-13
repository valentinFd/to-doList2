<?php

namespace App\Storages;

use App\Models\User;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;

class CSVUsersStorage
{
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function add(User $user): void
    {
        $writer = Writer::createFromPath($this->fileName, "a");
        $writer->setDelimiter(";");
        $writer->insertOne((array)$user);
    }

    public function validate(string $username, string $password): bool
    {
        $reader = Reader::createFromPath($this->fileName, "r");
        $reader->setDelimiter(";");
        $records = Statement::create()->process($reader);
        foreach ($records as $record)
        {
            if ($username === $record[0] && $password === $record[1]) return true;
        }
        throw new \App\Exceptions\LogInException("Incorrect username or password");
    }
}
