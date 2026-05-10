<?php
class AuthController
{
    private const ALLOWED_REDIRECTS = [
        'checkout_form',
        'cart',
        'profile',
        'home'
    ];

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function showRegister()
    {
        $error_message = '';
        $success_message = '';

        if (isset($_GET['redirect']) && in_array($_GET['redirect'], self::ALLOWED_REDIRECTS)) {
            $_SESSION['intended_redirect'] = $_GET['redirect'];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $email = strtolower(trim($_POST['email'] ?? ''));
            $password = $_POST['password'] ?? '';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_message = "Niepoprawny format adresu e-mail.";
            } elseif (strlen($password) < 8) {
                $error_message = "Hasło musi mieć co najmniej 8 znaków.";
            } elseif (empty($firstName) || empty($lastName)) {
                $error_message = "Imię i nazwisko są wymagane.";
            } else {
                try {
                    $stmt = $this->pdo->prepare("SELECT id, role FROM users WHERE email = :email");
                    $stmt->execute(['email' => $email]);
                    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($existingUser && $existingUser['role'] !== 'GUEST') {
                        $error_message = "Konto z tym adresem e-mail już istnieje!";
                    } else {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        if ($existingUser && $existingUser['role'] === 'GUEST') {
                            // SCENARIUSZ 1: Użytkownik kupował jako gość -> Zmieniamy go w pełne konto
                            $saveStmt = $this->pdo->prepare("
                                UPDATE users 
                                SET first_name = :first_name, 
                                    last_name = :last_name, 
                                    password_hash = :password_hash, 
                                    role = 'CLIENT' 
                                WHERE id = :id
                            ");
                            $saveStmt->execute([
                                'first_name'    => $firstName,
                                'last_name'     => $lastName,
                                'password_hash' => $hashedPassword,
                                'id'            => $existingUser['id']
                            ]);
                        } else {
                            // SCENARIUSZ 2: Użytkownik jest całkowicie nowy -> Tworzymy konto
                            $saveStmt = $this->pdo->prepare("
                                INSERT INTO users (first_name, last_name, email, password_hash, role) 
                                VALUES (:first_name, :last_name, :email, :password_hash, 'CLIENT')
                            ");
                            $saveStmt->execute([
                                'first_name'    => $firstName,
                                'last_name'     => $lastName,
                                'email'         => $email,
                                'password_hash' => $hashedPassword
                            ]);
                        }
                        $_SESSION['flash_success'] = "Konto zostało pomyślnie utworzone! Możesz się teraz zalogować.";
                        header("Location: index.php?page=login");
                        exit;
                    }
                } catch (PDOException $e) {
                    error_log("Registration error for email {$email} : " . $e->getMessage());
                    if (in_array((string) $e->getCode(), ['23000', '23505'], true)) {
                        $error_message = "Konto z tym adresem e-mail już istnieje";
                    } else {
                        $error_message = "Błąd podczas rejestracji";
                    }
                }
            }
        }
        renderView('register', [
            'error_message'     => $error_message,
            'success_message'   => $success_message
        ]); //todo add old_input?
    }

    public function showLogin()
    {
        $login_error = '';

        $success_message = $_SESSION['flash_success'] ?? '';
        unset($_SESSION['flash_success']);

        if (isset($_GET['redirect']) && in_array($_GET['redirect'], self::ALLOWED_REDIRECTS)) {
            $_SESSION['intended_redirect'] = $_GET['redirect'];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = strtolower(trim($_POST['email'] ?? ''));
            $password = $_POST['password'] ?? '';

            // additional email format check
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // find user by email
                $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // user is registered in database and passwords match
                if ($user && password_verify($password, $user['password_hash'])) {

                    // create session for user
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['first_name'] = $user['first_name'];

                    // redirect back to intended page or main page
                    $targetPage = $_SESSION['intended_redirect'] ?? 'home';
                    unset($_SESSION['intended_redirect']); // bardzo ważne czyszczenie!

                    header("Location: index.php?page=" . $targetPage);
                    exit;
                } else {
                    $login_error = "Nieprawidłowy adres e-mail lub hasło.";
                }
            } else {
                $login_error = "Nieprawidłowy format e-mail.";
            }
        }
        renderView('login', [
            'login_error'       => $login_error,
            'success_message'   => $success_message
        ]);
    }

    public function logout()
    {
        // Expire the cart cookie to prevent it from persisting on shared computers
        setcookie('cart', '', time() - 3600, '/');

        // Czyścimy wszystkie dane sesji
        session_unset();
        session_destroy();

        // Przekierowujemy na stronę główną
        header("Location: index.php?page=home");
        exit;
    }
}
