<?php
// src/controllers/ProfileController.php
class ProfileController
{
    private $userManager;

    public function __construct($userManager)
    {
        $this->userManager = $userManager;
    }

    private function requireLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
    }

    public function index()
    {
        $user = $this->userManager->getUserById($_SESSION['user_id']);
        renderView('profile/index', ['user' => $user]);
    }

    public function settings()
    {
        $this->requireLogin();
        $user = $this->userManager->getUserById($_SESSION['user_id']);

        // Zbieramy komunikaty z sesji (flash messages)
        $success = $_SESSION['profile_success'] ?? '';
        $error = $_SESSION['profile_error'] ?? '';
        unset($_SESSION['profile_success'], $_SESSION['profile_error']);

        renderView('profile/settings', [
            'user' => $user,
            'active_tab' => 'settings',
            'success_message' => $success,
            'error_message' => $error
        ]);
    }

    public function orders()
    {
        $this->requireLogin();
        // Tutaj w przyszłości użyjesz OrderManager->getUserOrders(...)
        renderView('profile/orders', ['active_tab' => 'orders']);
    }

    public function reviews()
    {
        $this->requireLogin();
        // Tutaj w przyszłości użyjesz ReviewManager->getUserReviews(...)
        renderView('profile/reviews', ['active_tab' => 'reviews']);
    }

    public function addresses()
    {
        $this->requireLogin();
        $user = $this->userManager->getUserById($_SESSION['user_id']);
        $addresses = json_decode($user['addresses'] ?? '[]', true);

        renderView('profile/addresses', [
            'active_tab' => 'addresses',
            'addresses' => $addresses
        ]);
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
