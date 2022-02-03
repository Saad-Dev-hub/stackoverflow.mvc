<?php

namespace PHPMVC\Controllers;

use PHPMVC\Models\AnswerModel;
use PHPMVC\Models\UserModel;
use PHPMVC\Models\QuestionModel;
use PHPMVC\LIB\FilterInputs;

require_once  '..' . DS . 'vendor' . DS . 'stefangabos' . DS . 'zebra_pagination' . DS . 'Zebra_Pagination.php';

class IndexController extends AbstractController
{
    use FilterInputs;
    public function defaultAction()
    {
        $this->_data['pageTitle'] = "Kommunity";
        #region all questions
        $allQuestions = QuestionModel::getByQuery('SELECT
    `question`.*,
    `user`.`username`,
    `user`.`photo`,
    `answer`.`id` AS `Answer`,
    COUNT(`answer`.`id`) AS `NumberOfAnswers`
FROM
    `question`
JOIN `user` ON `question`.`user_id` = `user`.`id`
LEFT JOIN `answer` ON `question`.`id` = `answer`.`question_id`
GROUP BY `question`.`id`');
        $this->_data['allQuestions'] = $allQuestions;
    #endregion
        #region count all answers for each question
        $countOfAnswersForEachQuestion = AnswerModel::getByQuery('SELECT `answer`.*, COUNT(`answer`.`id`) AS `NumberOfAnswers`
        FROM `user`  JOIN `question`
        ON `user`.`id`=`question`.`user_id`
        LEFT JOIN `answer`
        ON `question`.`id`=`answer`.`question_id`
        GROUP BY `question`.`title`');
        $this->_data['countOfAnswersForEachQuestion'] = $countOfAnswersForEachQuestion;
        #endregion
        $allUsers = UserModel::getAll();
        $this->_data['users'] = $allUsers;
        $allAnswers = AnswerModel::getAll();
        $this->_data['answers'] = $allAnswers;
        #region make pagination using Zebra_Pagination
        $recordsPerPage = 2;
        $pagination = new \Zebra_Pagination();
        $allQuestions = QuestionModel::getByQuery('SELECT
        `question`.*,
        `user`.`username`,
        `user`.`photo`,
        `answer`.`id` AS `Answer`,
        COUNT(`answer`.`id`) AS `NumberOfAnswers`
    FROM
        `question`
    JOIN `user` ON `question`.`user_id` = `user`.`id`
    LEFT JOIN `answer` ON `question`.`id` = `answer`.`question_id`
    GROUP BY `question`.`id` ORDER BY `question`.`id` DESC LIMIT ' . (($pagination->get_page() - 1) * $recordsPerPage) . ', ' . $recordsPerPage);
        $rows = QuestionModel::getByQuery('SELECT COUNT(`question`.`id`) AS `NumberOfQuestions` FROM `question`');
        $this->_data['allQuestions'] = $allQuestions;
        $pagination->records($rows[0]->NumberOfQuestions);
        $pagination->records_per_page($recordsPerPage);
        $this->_data['pagination'] = $pagination;
        #endregion
        #region get top contributors
        $topContributors = UserModel::getByQuery('SELECT
        `user`.`username`,
        `user`.`photo`,
        COUNT(`answer`.`id`) AS `NumberOfAnswers`
        FROM `user` JOIN `answer`
        ON `user`.`id`=`answer`.`user_id`
        GROUP BY `user`.`username`
        ORDER BY `NumberOfAnswers` DESC limit 3');
        $this->_data['topContributors'] = $topContributors;
        $this->_view();
    }
    public function showQuestionAction()
    {
        $this->_data['pageTitle'] = "Question Details";
        if (!is_numeric($this->_params[0]) || !QuestionModel::getByPK($this->_params[0])) {
            header('Location:/');
        }
        $questionInformation = QuestionModel::getByQuery('SELECT * FROM `question` WHERE `id`=' . $this->_params[0]);
        $this->_data['Question'] = $questionInformation;
        $userWhoAskedTheQuestion = UserModel::getByPk($questionInformation[0]->user_id);
        //$userWhoWillAnswerTheQuestion = UserModel::getByPk($_SESSION['loggedUser']->id);
        $usersWhoAnsweredTheQuestion = UserModel::getByQuery('SELECT `user`.*
        FROM `user` JOIN `question`
        ON `user`.`id`=`question`.`user_id`
        JOIN `answer`
        ON `answer`.`question_id`=`question`.`id`');
        $this->_data['usersWhoAnsweredTheQuestion'] = $usersWhoAnsweredTheQuestion;
        $this->_data['userWhoAskedTheQuestion'] = $userWhoAskedTheQuestion;
        $answersForCurrentQuestion = AnswerModel::getByQuery('
        SELECT `answer`.*,`user`.`username`,`user`.`photo`,
        SUM(`vote`.`upvote`-`vote`.`downvote`)AS `NumberOfVotes`
        FROM `answer` JOIN `user` 
        ON `answer`.`user_id`=`user`.`id`
        LEFT JOIN `vote` 
        ON `answer`.`id`=`vote`.`answer_id`
        WHERE `answer`.`question_id`=' . $this->_params[0] . '
        GROUP BY `answer`.`id`
        ORDER BY `NumberOfVotes` DESC');
        $this->_data['answersForCurrentQuestion'] = $answersForCurrentQuestion;
        // var_dump($answersForCurrentQuestion);die;        

        if (isset($_POST['submit'])) {       
            $body = $this->filterCodeSnippet($_POST['body'], 'Body');
            $question_id = $questionInformation[0]->id;
            $this->_data['errors'] = $this->showErrors();
           // var_dump($this->_data['errors']);
            if(empty($this->showErrors())){
            $answer = new AnswerModel($question_id, $_SESSION['loggedUser']->id, $body);
            $answer->save();
            header('Location:/index/showQuestion/' . $question_id);
            }
        }
        $this->_view();
    }
  
}
