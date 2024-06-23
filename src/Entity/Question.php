<?php

namespace Macareux\Boilerplate\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="QuestionRepository")
 * @ORM\Table(name="MacareuxQuestion")
 */
class Question
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $content;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $disp_order;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Option::class)
     */
    private Collection $options;

    /**
     * @param string $content
     */
    public function __construct(string $content, int $disp_order, int $type)
    {
        $this->content = $content;
        $this->disp_order = $disp_order;
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getDispOrder(): int
    {
        return $this->disp_order;
    }

    public function setDispOrder(int $disp_order): void
    {
        $this->disp_order = $disp_order;
    }
    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $name
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function  getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): void
    {
        if (!$this->options->contains($option)) {
            $option->setQuestion($this);
            $this->options->add($option);
        }
    }
}
