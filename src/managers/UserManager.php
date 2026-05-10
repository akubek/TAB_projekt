<?php
class UserManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT id, email, first_name, last_name, phone_number, role, created_at FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Zwraca tablicę z danymi lub false
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT id, email, first_name, last_name, phone_number, role, created_at FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createGuestUser($email, $firstName, $lastName, $phone)
    {
        // Tworzymy użytkownika z rolą 'guest' (lub 'user') i bez hasła (lub z losowym hash)
        $stmt = $this->pdo->prepare("
            INSERT INTO users (email, first_name, last_name, phone_number, role) 
            VALUES (?, ?, ?, ?, 'GUEST')
        ");
        $stmt->execute([$email, $firstName, $lastName, $phone]);

        return $this->pdo->lastInsertId();
    }
}
