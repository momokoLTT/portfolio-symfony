<?php

namespace App\Command;

use App\Entity\Credit;
use App\Entity\Link;
use App\Entity\Model;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('model:create', description: 'Dynamically create a model.')]
class CreateModelCommand extends Command
{
    private SymfonyStyle $io;
    private InputInterface $input;
    private OutputInterface $output;
    private HelperInterface $helper;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->input = $input;
        $this->output = $output;
        $this->helper = $this->getHelper('question');

        $model = $this->askModelDetails();
        $credits = $this->askCreditDetails();
        foreach ($credits as $credit) {
            $model->addCredit($credit);
        }

        $this->entityManager->persist($model);
        $this->entityManager->flush();

        $this->io->success('Model created successfully!');

        return Command::SUCCESS;
    }

    private function askString(string $question, bool $emptyAllowed = false): string
    {
        $q = new Question($question);
        if (!$emptyAllowed) {
            $q->setValidator(function ($answer) {
                if (empty(trim($answer))) {
                    throw new RuntimeException('Answer cannot be empty');
                }

                return $answer;
            });
        }

        return $this->helper->ask($this->input, $this->output, $q) ?? '';
    }

    private function askBool(string $question): bool
    {
        $q = new ConfirmationQuestion($question, false);

        return $this->helper->ask($this->input, $this->output, $q);
    }

    private function askChoice(string $question, array $options): string
    {
        $q = new ChoiceQuestion($question, $options);
        $q->setmultiselect(false);
        $q->setErrorMessage('Only options from the list are supported');

        return $this->helper->ask($this->input, $this->output, $q);
    }

    private function askModelDetails(): Model
    {
        $this->io->title('Adding a model');
        $this->io->section('Model Properties');

        $model = new Model();
        $model->setId($this->askString('Identifier: '));
        $model->setTitle($this->askString('Title: '));
        $model->setDescription($this->askString('Description: ', true));
        $model->setImage($this->askString('Image name (on disk): '));

        $this->io->writeln('');

        return $model;
    }

    private function askCreditDetails(): array
    {
        $this->io->section('Credits');
        $credits = [];

        while ($this->askBool('Do we need to add any (more) credits? [y/n]: ')) {
            $credit = new Credit();
            $credit->setName($this->askString('Name: '));
            $credit->setType($this->askChoice(
                'What kind of work did they do?',
                [
                    'Artist',
                    'Designer',
                    'Rigger',
                ]
            ));

            $links = $this->askCreditLinkDetails();
            foreach ($links as $link) {
                $link->setCredit($credit);
                $credit->addLink($link);
            }

            $this->entityManager->persist($credit);
            $credits[] = $credit;
        }

        return $credits;
    }

    private function askCreditLinkDetails(): array
    {
        $links = [];

        while ($this->askBool('Do we need to add any (more) links? [y/n]: ')) {
            $link = new Link();
            $link->setType($this->askString('Platform: '));
            $link->setIdentifier($this->askString('ID on the platform: '));

            $links[] = $link;
        }

        return $links;
    }
}
