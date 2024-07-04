<?php

namespace Macareux\Boilerplate\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OptionRepository")
 * @ORM\Table(name="tieSettingEnneagram")
 */
class tieSettingEnneagram
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
    private $point_id;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="options")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", nullable=true)
     */
    private $question;

    public function __construct(string $content, int $point_id)
    {
        $this->content = $content;
        $this->point_id = $point_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getPointId(): int
    {
        return $this->point_id;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setPointId(int $point_id): void
    {
        $this->point_id = $point_id;
    }

    public function setQuestion(Question $question): void
    {
        $this->question = $question;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }
}
