<?php

namespace Macareux\Boilerplate\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="QuestionRepository")
 * @ORM\Table(name="MacareuxEnneagramQuestion")
 */
class EnneagramQuestion
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $content = null;

    /**
     * @var int
     * @ORM\Column(type="integer", options={"default": 1})
     */
    private $disp_order;

    /**
     * @var int
     * @ORM\Column(type="integer", options={"default": 1})
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Option::class, mappedBy="question", cascade={"persist"}, orphanRemoval=true)
     */
    private ?Collection $options = null;

    /**
     * @param integer $disp_order
     * @param integer $type
     */
    public function __construct(int $disp_order, int $type)
    {
        $this->disp_order = $disp_order;
        $this->type = $type;
        $this->options = new ArrayCollection();
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


    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function  getOptions(): ?Collection
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

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
