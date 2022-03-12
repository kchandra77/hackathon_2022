<?php

namespace App\Entity;

use App\Repository\ImportDataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImportDataRepository::class)]
class ImportData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $dataFilename;

    #[ORM\Column(type: 'json')]
    private $data = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataFilename(): ?string
    {
        return $this->dataFilename;
    }

    public function setDataFilename(string $dataFilename): self
    {
        $this->dataFilename = $dataFilename;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
