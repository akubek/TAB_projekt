<?php
class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function showRegister() {
        $error_message = '';
        $success_message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            
            if ($stmt->fetch()) {
                $error_message = "Konto z tym adresem e-mail już istnieje!";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $insertStmt = $this->pdo->prepare("
                    INSERT INTO users (first_name, last_name, email, password_hash) 
                    VALUES (:first_name, :last_name, :email, :password_hash)
                ");
                try {
                    $insertStmt->execute([
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'password_hash' => $hashedPassword
                    ]);
                    $success_message = "Konto zostało pomyślnie utworzone! Możesz się teraz zalogować.";
                } catch (PDOException $e) {
                    $error_message = "Wystąpił błąd: " . $e->getMessage();
                }
            }
        }
        require_once '../views/register.php';
    }
    public function showLogin() {
        $login_error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['first_name'] = $user['first_name'];
                header("Location: index.php?page=home");
                exit;
            } else {
                $login_error = "Nieprawidłowy adres e-mail lub hasło.";
            }
        }
        require_once '../views/login.php';
    }
    public function logout() {
        // Czyścimy wszystkie dane sesji
        session_unset();
        session_destroy();
        
        // Przekierowujemy na stronę główną
        header("Location: index.php?page=home");
        exit;
    }
    public function showProfile() {
    // Sprawdzenie autoryzacji
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=login');
        exit;
    }

    // Pobieranie danych użytkownika
    $stmt = $this->pdo->prepare("SELECT first_name, last_name, email, created_at FROM users WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $success_message = '';
    $error_message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Podaj poprawny adres e-mail.";
        } else {
            $updateStmt = $this->pdo->prepare("
                UPDATE users 
                SET first_name = :first_name, last_name = :last_name, email = :email 
                WHERE id = :id
            ");
            
            if ($updateStmt->execute([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'id' => $_SESSION['user_id']
            ])) {
                $_SESSION['first_name'] = $firstName;
                $success_message = "Dane zostały zaktualizowane!";
                $user['first_name'] = $firstName;
                $user['last_name'] = $lastName;
                $user['email'] = $email;
            } else {
                $error_message = "Wystąpił błąd podczas aktualizacji.";
            }
        }
    }
    require_once '../views/profile.php';
}
    public function changePassword() {
    // Sprawdzenie autoryzacji
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=login');
        exit;
    }

    $error_message = '';
    $success_message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Pobieranie obecnego hasło
        $stmt = $this->pdo->prepare("SELECT password_hash FROM users WHERE id = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Walidacja
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $error_message = "Wszystkie pola są wymagane.";
        } elseif (!password_verify($currentPassword, $user['password_hash'])) {
            $error_message = "Obecne hasło jest nieprawidłowe.";
        } elseif ($newPassword !== $confirmPassword) {
            $error_message = "Nowe hasła nie są identyczne.";
        } elseif (strlen($newPassword) < 6) {
            $error_message = "Nowe hasło musi mieć co najmniej 6 znaków.";
        } else {
            // Aktualizacja hasła
            $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $this->pdo->prepare("UPDATE users SET password_hash = :hash WHERE id = :id");
            
            if ($updateStmt->execute(['hash' => $newHash, 'id' => $_SESSION['user_id']])) {
                $success_message = "Hasło zostało pomyślnie zmienione!";
            } else {
                $error_message = "Wystąpił błąd podczas zmiany hasła.";
            }
        }
    }

    if (!empty($success_message)) {
        $_SESSION['profile_success'] = $success_message;
    }
    if (!empty($error_message)) {
        $_SESSION['profile_error'] = $error_message;
    }
    
    header('Location: index.php?page=profile');
    exit;
}

        
}