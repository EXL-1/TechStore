<?
namespace techstore\Controllers;
class Question
{
    private $functions;
    public function __construct($functions)
    {
        $this->functions = $functions;
    }

    public function customer()
    {
        $this->functions->customerOnly();

        $customer = $this->functions->customerTable->find('email', $_SESSION['email']);
        $questions = $this->functions->questionTable->findMutiple('customer_id', $customer['customer_id']);  

        return [
            'title' => 'Questions',
            'template' => 'questions',
            'variables' => [ 
                'questions' => $questions,
                'noquestions' => $this->functions->notEmptyCheck($questions, "You have no Questions"),
                'adminTable' => $this->functions->adminTable,
                'productTable' => $this->functions->productTable
            ]
        ];
    }

    public function admin()
    {
        $this->functions->adminOnly();

        $error = $msg = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $error = $this->functions->notEmptyCheck($_POST["answer"], "Answer cannot be blank!");
        }

        if ($error == '' && (($_POST['submit']) ?? '')) {

            $admin = $this->functions->adminTable->find('email', $_SESSION['email']);

            $values = [
                'question_id' => $_POST['question_id'],
                'admin_id' => $admin['admin_id'],
                'answer' => $_POST['answer'],
                'status' => 'verified',
                'visibility' => $_POST['visibility']
            ];

            $this->functions->questionTable->update($values);

            $msg = "Your Answer was successfully submitted!";
        }

        if ($_GET['unanswered'] ?? '') {
            $questions = $this->functions->questionTable->findMutiple('status', 'pending');
            $title = 'Unanswered Questions';
        } else {
            $questions = $this->functions->questionTable->findAll();
            $title = 'All Questions';
        }

        return [
            'title' => $title,
            'template' => 'questions',
            'variables' => [
                'questions' => $questions,
                'error' => $error,
                'msg' => $msg,
                'noquestions' => $this->functions->notEmptyCheck($questions, "No Questions were Found"),
                'adminTable' => $this->functions->adminTable,
                'productTable' => $this->functions->productTable,
                'customerTable' => $this->functions->customerTable
            ]
        ];
    }
}