<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Messages de Contact</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f3460 0%, #16213e 100%);
            color: #333;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            background: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            color: #0f3460;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header h1::before {
            content: "📧";
            font-size: 2em;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #00d4ff 0%, #00a8cc 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        
        .stat-card .number {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-card .label {
            font-size: 0.9em;
            opacity: 0.9;
        }
        
        .messages-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .messages-header {
            background: #0f3460;
            color: white;
            padding: 20px;
            font-size: 1.2em;
            font-weight: bold;
        }
        
        .message-item {
            border-bottom: 1px solid #eee;
            padding: 20px;
            transition: all 0.3s ease;
        }
        
        .message-item:last-child {
            border-bottom: none;
        }
        
        .message-item:hover {
            background: #f9f9f9;
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .message-from {
            font-weight: bold;
            color: #0f3460;
            font-size: 1.1em;
        }
        
        .message-email {
            color: #00d4ff;
            text-decoration: none;
            font-size: 0.9em;
        }
        
        .message-email:hover {
            text-decoration: underline;
        }
        
        .message-date {
            color: #999;
            font-size: 0.85em;
        }
        
        .message-content {
            color: #555;
            line-height: 1.6;
            margin: 10px 0;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border-left: 3px solid #00d4ff;
        }
        
        .message-status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
            margin-top: 10px;
        }
        
        .status-unread {
            background: #ffebee;
            color: #c62828;
        }
        
        .status-read {
            background: #e8f5e9;
            color: #2e7d32;
        }
        
        .status-replied {
            background: #e3f2fd;
            color: #1565c0;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .empty-state::before {
            content: "📭";
            font-size: 4em;
            display: block;
            margin-bottom: 20px;
        }
        
        .refresh-btn {
            background: #00d4ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: all 0.3s;
        }
        
        .refresh-btn:hover {
            background: #00a8cc;
            transform: scale(1.05);
        }
        
        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c62828;
        }
        
        .loading {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Panneau d'Administration - Messages de Contact</h1>
            <p>Visualisez et gérez tous les messages reçus via votre portfolio</p>
            <div class="stats">
                <div class="stat-card">
                    <div class="number" id="total-messages">0</div>
                    <div class="label">Total des messages</div>
                </div>
                <div class="stat-card">
                    <div class="number" id="unread-messages">0</div>
                    <div class="label">Non lus</div>
                </div>
                <div class="stat-card">
                    <div class="number" id="read-messages">0</div>
                    <div class="label">Lus</div>
                </div>
            </div>
        </div>
        
        <div id="error-container"></div>
        
        <div class="messages-container">
            <div class="messages-header">
                Messages reçus
                <button class="refresh-btn" onclick="location.reload()">🔄 Actualiser</button>
            </div>
            <div id="messages-list" class="messages-list">
                <div class="loading">Chargement des messages...</div>
            </div>
        </div>
    </div>
    
    <script>
        async function loadMessages() {
            try {
                const response = await fetch('admin_api.php?action=getMessages');
                
                if (!response.ok) {
                    throw new Error('Erreur HTTP ' + response.status);
                }
                
                const data = await response.json();
                
                if (!data.success) {
                    showError(data.message || 'Erreur lors du chargement des messages');
                    return;
                }
                
                displayMessages(data.messages);
                updateStats(data.messages);
                
            } catch (error) {
                showError('Erreur: ' + error.message);
                console.error('Erreur:', error);
            }
        }
        
        function displayMessages(messages) {
            const container = document.getElementById('messages-list');
            
            if (messages.length === 0) {
                container.innerHTML = '<div class="empty-state">Aucun message pour le moment</div>';
                return;
            }
            
            container.innerHTML = messages.map(msg => `
                <div class="message-item">
                    <div class="message-header">
                        <div>
                            <div class="message-from">📮 ${escapeHtml(msg.name)}</div>
                            <a href="mailto:${escapeHtml(msg.email)}" class="message-email">${escapeHtml(msg.email)}</a>
                        </div>
                        <div class="message-date">${formatDate(msg.created_at)}</div>
                    </div>
                    <div class="message-content">${escapeHtml(msg.message)}</div>
                    <span class="message-status status-${msg.status}">${msg.status}</span>
                </div>
            `).join('');
        }
        
        function updateStats(messages) {
            const total = messages.length;
            const unread = messages.filter(m => m.status === 'unread').length;
            const read = messages.filter(m => m.status === 'read').length;
            
            document.getElementById('total-messages').textContent = total;
            document.getElementById('unread-messages').textContent = unread;
            document.getElementById('read-messages').textContent = read;
        }
        
        function showError(message) {
            const container = document.getElementById('error-container');
            container.innerHTML = `<div class="error-message">⚠️ ${escapeHtml(message)}</div>`;
        }
        
        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleString('fr-FR', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
        
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        }
        
        // Load messages on page load
        loadMessages();
    </script>
</body>
</html>
