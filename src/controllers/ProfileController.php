<?php
// src/controllers/ProfileController.php
class ProfileController
{
    private $userManager;

    public function __construct($userManager)
    {
        $this->userManager = $userManager;
    }

    public function index()
    {
        $user = $this->userManager->getUserById($_SESSION['user_id']);
        renderView('profile/index', ['user' => $user]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = strtolower(trim($_POST['email']));
            $id = $_SESSION['user_id'];

            // Rozwiązanie błędu SQL: Walidacja e-maila w PHP
            if ($this->userManager->isEmailTaken($email, $id)) {
                $_SESSION['profile_error'] = "Ten adres e-mail jest już zajęty.";
                header("Location: index.php?page=profile_edit");
                exit;
            }

            $this->userManager->updateBasicData($id, $_POST['first_name'], $_POST['last_name'], $email);
            $_SESSION['profile_success'] = "Dane zaktualizowane.";
            header("Location: index.php?page=profile");
            exit;
        }
    }
}
