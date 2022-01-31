<?php

namespace PHPMVC\Controllers;

use PHPMVC\Models\QuestionModel;
use PHPMVC\LIB\FilterInputs;
use PHPMVC\LIB\Validation;
use PHPMVC\Models\UserModel;
use PHPMVC\Models\AnswerModel;
use PHPMVC\Models\VoteModel;

class QuestionController extends AbstractController
{
    use FilterInputs;
    public function askAction()
    {
        $this->_data['pageTitle'] = 'Kommunity | Ask Question';
        if (isset($_POST['submit'])) {
            $title = $this->required($_POST['title'], 'Title');
            $body = $this->filterCodeSnippet($_POST['body'], 'Body');
            $tag = $this->required($_POST['tag'], 'Tag');
            $this->_data['errors'] = $this->showErrors();
            if (empty($this->_data['errors'])) {
                $question = new QuestionModel($title, $body, $tag, $_SESSION['loggedUser']->id);
                $question->save();
                // get the id of the question just created
                $question_id = QuestionModel::getLastId();
                header('location:/question/show/' . $question_id);
            }
        }
        $this->_view();
    }
    public function showAction()
    {
        $this->_data['pageTitle'] = 'Kommunity | Show Question';
        // validate id in url to be numeric
        if (!is_numeric($this->_params[0]) || empty($this->_params[0]) || !QuestionModel::getByPk($this->_params[0])) {
            header('location:/404');
        }   
        // get the user who asked last question
        $user = UserModel::getByPk($_SESSION['loggedUser']->id);
        $this->_data['user'] = $user;
        $question = QuestionModel::getByPk($this->_params[0]);
        $this->_data['question'] = $question; 
        // get all answers for this question
        $this->_data['answers'] = AnswerModel::getByQuery('
        SELECT `answer`.*,`user`.`username`,`user`.`photo`,
        SUM(`vote`.`upvote`-`vote`.`downvote`)AS `NumberOfVotes`
        FROM `answer` JOIN `user` 
        ON `answer`.`user_id`=`user`.`id`
        LEFT JOIN `vote` 
        ON `answer`.`id`=`vote`.`answer_id`
        WHERE `answer`.`question_id`=' . $this->_params[0]. '
        GROUP BY `answer`.`id`
        ORDER BY `NumberOfVotes` DESC
        ');
        $this->_data['votes'] = VoteModel::getByQuery('SELECT *, SUM(upvote - downvote) AS NumberOfVotes FROM vote GROUP BY answer_id, question_id');
        $this->_data['usersWhoAnswered'] = AnswerModel::getByQuery('SELECT
        `user`.`username`,
        `user`.`id`,
        `question`.`title`,
        `user`.`photo`,
        `answer`.`updated_at`,
        `answer`.`body`
    FROM
        `user`
    JOIN `question` ON `user`.`id` = `question`.`user_id`
    JOIN `answer` ON `question`.`id`= `answer`.`question_id`');
        $this->_data['answers_count'] = AnswerModel::get('SELECT COUNT(*) As `count` FROM answer WHERE question_id = ' . $this->_params[0]);
        // ANSWER THE QUESTION
        if (isset($_POST['submit'])) {
            $user_id = $_SESSION['loggedUser']->id;
            $body = $this->filterCodeSnippet($_POST['body'], 'Body');
            $question_id =  $question->id;
            $this->_data['errors'] = $this->showErrors();
            //var_dump($this->_data['errors']);die;
            if (empty($this->_data['errors'])) {
                $answer = new AnswerModel($question_id,$user_id, $body);
                $answer->save();
                header('location:/question/show/' . $question_id);
            }
        }

        $this->_view();
    }
    public function editAction()
    {
        $this->_data['pageTitle'] = 'Kommunity | Edit Question';
        //prevent user from editing other users questions
        if ($_SESSION['loggedUser']->id != QuestionModel::getByPk($this->_params[0])->user_id) {
            header('location:/404');
        }
        $question = QuestionModel::getByPk($this->_params[0]);
        $this->_data['editedQuestion'] = $question;
        if (isset($_POST['submit'])) {
            $title = $this->required($_POST['title'], 'Title');
            $body = $this->filterCodeSnippet($_POST['body'], 'Body');
            $tag = $this->required($_POST['tag'], 'Tag');
            $this->_data['errors'] = $this->showErrors();
            if (empty($this->_data['errors'])) {
                $question->title = $title;
                $question->body = $body;
                $question->tag = $tag;
                $question->save();
                header('location:/question/show/' .  $question->id);
            }
        }
        $this->_view();
    }
    public function deleteAction()
    {
        //check if id is numeric and question exists in database
        if (!is_numeric($this->_params[0]) || empty($this->_params[0]) || !QuestionModel::getByPk($this->_params[0])) {
            header('location:/404');
        }
        //prevent user from deleting other users questions
        if ($_SESSION['loggedUser']->id != QuestionModel::getByPk($this->_params[0])->user_id) {
            header('location:/404');
        }
        $question = QuestionModel::getByPk($this->_params[0]);
        $question->delete();
        header('location:/');
    }
}
