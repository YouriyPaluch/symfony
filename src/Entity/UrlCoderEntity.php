<?php

namespace App\Entity;

use App\Repository\UrlCoderEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: UrlCoderEntityRepository::class)]
#[ORM\Table(name: 'url_codes')]
class UrlCoderEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: 'integer', length: 6, options: ['default' => 0])]
    private int $counter = 0;

    public function __construct(
        #[ORM\Column(length: 255)]
        protected string $url,
        #[ORM\Column(length: 255)]
        protected string $code,
        #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'urls')]
        #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
        #[Ignore]
        protected User $user
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public static function createFromArray(array $data): static
    {
        if (!isset($data['url']) || !isset($data['code']) || !isset($data['user'])) {
            throw new \InvalidArgumentException();
        }
        return new static($data['url'], $data['code'], $data['user']);
    }

    /**
     * @return int
     */
    public function getCounter(): int {
        return $this->counter;
    }


    public function incrementCounter(): void
    {
        $this->counter++;
    }


    public function toString(): string
    {
        return 'ID: ' . $this->getId() . '<br>'
            . 'URL: ' . $this->getUrl() . '<br>'
            . 'Code: ' . $this->getCode() . '<br>'
            . 'Count redirect: ' . $this->getCounter();
    }
}
