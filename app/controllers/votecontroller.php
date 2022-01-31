<?php

namespace PHPMVC\Controllers;

use PHPMVC\Models\AnswerModel;
use PHPMVC\LIB\FilterInputs;
use PHPMVC\Models\UserModel;
use PHPMVC\Models\QuestionModel;
use PHPMVC\Models\VoteModel;

class VoteController extends AbstractController
{
   use FilterInputs;
   public function upvoteAction()
   {

      if (!is_numeric($this->_params[0]) || empty($this->_params[0]) || !AnswerModel::getByQuery('SELECT  * FROM answer WHERE id = ' . $this->_params[0]) || !QuestionModel::getByQuery('SELECT  * FROM question WHERE id = ' . $this->_params[1])) {
         header('location:/404');
      }
      $this->isUserVotedHisAnswer();
      $this->isVotedUpTwice();   
      $question = QuestionModel::getByQuery('SELECT  * FROM question WHERE id = ' . $this->_params[1]);
      $Answer = AnswerModel::getByQuery('SELECT * FROM answer WHERE id = ' . $this->_params[0]);
      $user = UserModel::getByPK($_SESSION['loggedUser']->id);
      $vote = new VoteModel(TRUE, False, $user->id, $question[0]->id, $Answer[0]->id);
      $vote->save();
      $previousPage = $_SERVER['HTTP_REFERER'];
      header('location:' . $previousPage);
   }
   public function downvoteAction()
   {
      if (!is_numeric($this->_params[0]) || empty($this->_params[0]) || !AnswerModel::getByQuery('SELECT  * FROM answer WHERE id = ' . $this->_params[0]) || !QuestionModel::getByQuery('SELECT  * FROM question WHERE id = ' . $this->_params[1])) {
         header('location:/404');
      }
      $this->isUserVotedHisAnswer();
      $this->isVotedDownTwice();
     
      $Answer = AnswerModel::getByQuery('SELECT * FROM answer WHERE id = ' . $this->_params[0]);
      $question = QuestionModel::getByQuery('SELECT  * FROM question WHERE id = ' . $this->_params[1]);
      $user = UserModel::getByPK($_SESSION['loggedUser']->id);
      $vote = new VoteModel(False, TRUE, $user->id, $question[0]->id, $Answer[0]->id);
      $vote->save();
      $previousPage = $_SERVER['HTTP_REFERER'];
      header('location:' . $previousPage);
   }

   public function isVotedUpTwice()
   {
      $votes = VoteModel::getByQuery('SELECT * FROM vote WHERE user_id = ' . $_SESSION['loggedUser']->id . ' AND answer_id = ' . $this->_params[0] . ' AND question_id = ' . $this->_params[1]);
      if (!empty($votes)) {
         for ($i = 0, $ii=count($votes); $i< $ii; $i++) {
            if ($votes[$i]->upvote == 1) {
               $_SESSION['voteError'] = '<div class="alert alert-info alert-dismissable">
               You have already voted for this answer
              <button type="button" class="close" data-dismiss="alert">×</button>
            </div>';
               header('location:/index/showQuestion/' . $this->_params[1]);
               exit;
               
            }
         }
      }
   }
   public function isVotedDownTwice()
   {
      $votes = VoteModel::getByQuery('SELECT * FROM vote WHERE user_id = ' . $_SESSION['loggedUser']->id . ' AND answer_id = ' . $this->_params[0] . ' AND question_id = ' . $this->_params[1]);
      if (!empty($votes)) {
         for ($i = 0, $ii=count($votes); $i< $ii; $i++) {
            if ($votes[$i]->upvote == 0) {
               $_SESSION['voteError'] = '<div class="alert alert-info alert-dismissable">
               You have already voted for this answer
              <button type="button" class="close" data-dismiss="alert">×</button>
            </div>';
               header('location:/index/showQuestion/' . $this->_params[1]);
               exit;
               
            }
         }
      }
   }
  public function isUserVotedHisAnswer(){  
   // do not allow user to vote his answer
   $answer=AnswerModel::getByQuery('SELECT * FROM answer WHERE id = ' . $this->_params[0]);
   if ($answer[0]->user_id == $_SESSION['loggedUser']->id) {
      $_SESSION['voteError'] = '<div class="alert alert-info alert-dismissable">
      You can not vote for your own answer
      <button type="button" class="close" data-dismiss="alert">×</button>
      </div>';
      header('location:/index/showQuestion/' . $this->_params[1]);
      exit;
   }
   
  }
}

