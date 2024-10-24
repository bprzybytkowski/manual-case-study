<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class AnswerOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $text;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nextQuestionId;

    #[ORM\Column(type: 'json', nullable: true)]
    private $productRecommendations = [];

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $restriction = null;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'answerOptions')]
    #[ORM\JoinColumn(nullable: false)]
    private $question;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getNextQuestionId(): ?int
    {
        return $this->nextQuestionId;
    }

    public function setNextQuestionId(?int $nextQuestionId): self
    {
        $this->nextQuestionId = $nextQuestionId;
        return $this;
    }

    public function getProductRecommendations(): ?array
    {
        return $this->productRecommendations;
    }

    public function setProductRecommendations(?array $productRecommendations): self
    {
        $this->productRecommendations = $productRecommendations;
        return $this;
    }

    public function getRestriction(): ?string
    {
        return $this->restriction;
    }

    public function setRestriction(?string $restriction): self
    {
        $this->restriction = $restriction;
        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;
        return $this;
    }
}
