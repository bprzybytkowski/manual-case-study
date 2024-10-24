<?php

namespace App\DataFixtures;

use App\Entity\AnswerOption;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionnaireFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $questionsData = [
            [
                'text' => 'Do you have difficulty getting or maintaining an erection?',
                'answers' => [
                    ['text' => 'Yes', 'productRecommendations' => []],
                    ['text' => 'No', 'productRecommendations' => [], 'restriction' => 'exclude all products'],
                ],
            ],
            [
                'text' => 'Have you tried any of the following treatments before?',
                'answers' => [
                    ['text' => 'Viagra or Sildenafil', 'nextQuestionId' => 2],
                    ['text' => 'Cialis or Tadalafil', 'nextQuestionId' => 3],
                    ['text' => 'Both', 'nextQuestionId' => 4],
                    ['text' => 'None of the above', 'productRecommendations' => ['sildenafil_50', 'tadalafil_10']],
                ],
            ],
            // question 2
            [
                'text' => 'Was the Viagra or Sildenafil product you tried before effective?',
                'answers' => [
                    ['text' => 'Yes', 'productRecommendations' => ['sildenafil_50'], 'restriction' => 'exclude tadalafil'],
                    ['text' => 'No', 'productRecommendations' => ['tadalafil_20'], 'restriction' => 'exclude sildenafil'],
                ],
            ],
            // question 3
            [
                'text' => 'Was the Cialis or Tadalafil product you tried before effective?',
                'answers' => [
                    ['text' => 'Yes', 'productRecommendations' => ['tadalafil_10'], 'restriction' => 'exclude sildenafil'],
                    ['text' => 'No', 'productRecommendations' => ['sildenafil_100'], 'restriction' => 'exclude tadalafil'],
                ],
            ],
            // question 4
            [
                'text' => 'Which is your preferred treatment?',
                'answers' => [
                    ['text' => 'Viagra or Sildenafil', 'productRecommendations' => ['sildenafil_100'], 'restriction' => 'exclude tadalafil'],
                    ['text' => 'Cialis or Tadalafil', 'productRecommendations' => ['tadalafil_20'], 'restriction' => 'exclude sildenafil'],
                    ['text' => 'None of the above',
                        'productRecommendations' => ['sildenafil_100', 'tadalafil_20']],
                ],
            ],
            [
                "text" => 'Do you have, or have you ever had, any heart or neurological conditions?',
                "answers" =>
                    [
                        ['text' => 'Yes', 'productRecommendations' => [], 'restriction' => 'exclude all products'],
                        ['text' => 'No', 'productRecommendations' => []]
                    ]
            ],
            [
                "text" => "Do any of the listed medical conditions apply to you?",
                "answers" => [
                    ['text' => 'Significant liver problems (such as cirrhosis of the liver) or kidney problems', 'productRecommendations' => [], 'restriction' => 'exclude all products'],
                    ['text' => 'Currently prescribed GTN, Isosorbide mononitrate, Isosorbide dinitrate , Nicorandil (nitrates) or Rectogesic ointment', 'productRecommendations' => [], 'restriction' => 'exclude all products'],
                    ['text' => 'Abnormal blood pressure (lower than 90/50 mmHg or higher than 160/90 mmHg)', 'productRecommendations' => [], 'restriction' => 'exclude all products'],
                    ['text' => "Condition affecting your penis (such as Peyronie's Disease, previous injuries or an inability to retract your foreskin)",
                        "productRecommendations" => [],
                        "restriction" => "exclude all products"],
                    ['text' => "I don't have any of these conditions", "productRecommendations" => []]
                ]
            ],
            [
                "text" => "Are you taking any of the following drugs?",
                "answers" => [
                    ['text' => "Alpha-blocker medication such as Alfuzosin, Doxazosin, Tamsulosin, Prazosin, Terazosin or over-the-counter Flomax",
                        "productRecommendations" => [],
                        "restriction" => "exclude all products"],
                    ['text' => "Riociguat or other guanylate cyclase stimulators (for lung problems)",
                        "productRecommendations" => [],
                        "restriction" => "exclude all products"],
                    ['text' => "Saquinavir, Ritonavir or Indinavir (for HIV)",
                        "productRecommendations" => [],
                        "restriction" => "exclude all products"],
                    ['text' => "Cimetidine (for heartburn)",
                        "productRecommendations" => [],
                        "restriction" => "exclude all products"],
                    ["text" => "I don't take any of these drugs", "productRecommendations" => []]
                ]
            ]
        ];

        foreach ($questionsData as $questionData) {
            $question = new Question();
            $question->setText($questionData['text']);

            foreach ($questionData['answers'] as $answerData) {
                $answerOption = new AnswerOption();
                $answerOption->setText($answerData['text']);
                $answerOption->setProductRecommendations($answerData['productRecommendations'] ?? []);

                if (isset($answerData['nextQuestionId'])) {
                    $answerOption->setNextQuestionId($answerData['nextQuestionId']);
                }

                if (isset($answerData['restriction'])) {
                    $answerOption->setRestriction($answerData['restriction']);
                }

                $answerOption->setQuestion($question);
                $manager->persist($answerOption);
            }

            $manager->persist($question);
        }

        $manager->flush();
    }
}