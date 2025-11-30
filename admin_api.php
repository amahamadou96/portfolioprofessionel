<?php
/**
 * Admin API - Portfolio
 * API pour gérer les messages de contact
 */

header('Content-Type: application/json; charset=utf-8');

// Include database configuration
require_once __DIR__ . '/db_config.php';

// Get action from request
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'getMessages') {
    getMessages();
} else if ($action === 'getMessage') {
    getMessage();
} else if ($action === 'updateStatus') {
    updateStatus();
} else {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Action non reconnue'
    ]);
}

function getMessages() {
    global $conn;
    
    try {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 100;
        $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
        
        $result = getAllMessages($limit, $offset);
        
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'messages' => $result,
            'count' => count($result)
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Erreur: ' . $e->getMessage()
        ]);
    }
}

function getMessage() {
    global $conn;
    
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'ID du message requis'
        ]);
        return;
    }
    
    try {
        $id = (int)$_GET['id'];
        $message = getMessageById($id);
        
        if (!$message) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Message non trouvé'
            ]);
            return;
        }
        
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => $message
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Erreur: ' . $e->getMessage()
        ]);
    }
}

function updateStatus() {
    global $conn;
    
    if (!isset($_GET['id']) || !isset($_GET['status'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'ID et statut requis'
        ]);
        return;
    }
    
    try {
        $id = (int)$_GET['id'];
        $status = $_GET['status'];
        
        if (!in_array($status, ['unread', 'read', 'replied'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Statut invalide'
            ]);
            return;
        }
        
        if (updateMessageStatus($id, $status)) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Statut mis à jour'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ]);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Erreur: ' . $e->getMessage()
        ]);
    }
}

?>
