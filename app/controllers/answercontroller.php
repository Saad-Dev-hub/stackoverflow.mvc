<?php

namespace PHPMVC\Controllers;

use PHPMVC\LIB\FilterInputs;
use PHPMVC\Models\AnswerModel;
use PHPMVC\Models\UserModel;

class AnswerController extends AbstractController
{
  use FilterInputs;
  // answer the question which is located in show aciton of question controller

  public function editAction()
  {
    $this->_data['pageTitle'] = 'Kommunity | Edit Answer';
    $myAnswer = AnswerModel::getByPk($this->_params[0]);
    $this->_data['myAnswer'] = $myAnswer;
    if (isset($_POST['submit'])) {
      // update the answer
      $body = $this->filterCodeSnippet($_POST['body'], 'Body');
      //check for errors
      $this->_data['errors'] = $this->showErrors();
      if (empty($this->_data['errors'])) {
        $myAnswer->body = $body;
        $myAnswer->save();
        header('location:/question/show/' . $myAnswer->question_id);
      }
    }
    $this->_view();
  }
  public function deleteAction()
  {
    if (!is_numeric($this->_params[0]) || empty($this->_params[0]) || !AnswerModel::getByPk($this->_params[0])) {
      header('location:/404');
    }
    $myAnswer = AnswerModel::getByPk($this->_params[0]);
    $this->_data['myAnswer'] = $myAnswer;
    // delete the answer
    $myAnswer->delete();
    header('location:/question/show/' . $myAnswer->question_id);
  }
}
