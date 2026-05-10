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

    public function createUser($firstName, $lastName, $email, $passwordHash, $role = 'CLIENT')
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO users (first_name, last_name, email, password_hash, role) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$firstName, $lastName, $email, $passwordHash, $role]);

        return $this->pdo->lastInsertId();
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

    public function updateBasicData($id, $firstName, $lastName, $email)
    {
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET first_name = ?, last_name = ?, email = ? 
            WHERE id = ?
        ");
        return $stmt->execute([$firstName, $lastName, $email, $id]);
    }

    public function updatePassword($id, $newHash)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        return $stmt->execute([$newHash, $id]);
    }

    public function isEmailTaken($email, $excludeUserId = null)
    {
        $sql = "SELECT 1 FROM users WHERE email = ? AND role != 'GUEST'";
        $params = [$email];

        if ($excludeUserId) {
            $sql .= " AND id != ?";
            $params[] = $excludeUserId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (bool)$stmt->fetch();
    }
}
