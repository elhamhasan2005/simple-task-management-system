<?php

class Task
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function createTask(int $userId, string $title, string $description): bool
    {
        $sql = "INSERT INTO tasks (user_id, title, description, status)
                VALUES (:user_id, :title, :description, 'Pending')";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':user_id' => $userId,
            ':title' => $title,
            ':description' => $description
        ]);
    }

    public function getTasksByUser(int $userId): array
    {
        $sql = "SELECT * FROM tasks 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentPendingTasks(int $limit = 5): array
    {
        $sql = "SELECT tasks.*, users.first_name, users.last_name
                FROM tasks
                JOIN users ON tasks.user_id = users.id
                WHERE tasks.status = 'Pending'
                ORDER BY tasks.created_at DESC
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTaskById(int $taskId): mixed
    {
        $sql = "SELECT * FROM tasks WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $taskId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTask(int $taskId, string $title, string $description): bool
    {
        $sql = "UPDATE tasks 
                SET title = :title, description = :description 
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':id' => $taskId
        ]);
    }

    public function toggleStatus(int $taskId): bool
    {
        $task = $this->getTaskById($taskId);

        if (!$task) {
            return false;
        }

        $newStatus = $task['status'] === 'Pending' ? 'Completed' : 'Pending';

        $sql = "UPDATE tasks 
                SET status = :status 
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':status' => $newStatus,
            ':id' => $taskId
        ]);
    }

    public function deleteTask(int $taskId): bool
    {
        $sql = "DELETE FROM tasks WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([':id' => $taskId]);
    }

    public function getAllTasks(): array
    {
        $sql = "SELECT tasks.*, users.first_name, users.last_name, users.email
                FROM tasks
                JOIN users ON tasks.user_id = users.id
                ORDER BY tasks.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}