<style>
/* ===== CHAT CONTAINER ===== */

.game-chat {
    background: rgba(15, 23, 42, 0.95);
    border-radius: 14px;
    padding: 12px;
    width: 100%;
    height: 100%;
    color: #e5e7eb;
    box-shadow: 0 10px 30px rgba(0,0,0,.4);
    font-size: 14px;
}

/* ===== HEADER ===== */
.chat-header {
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 10px;
}

/* ===== MESSAGES ===== */
.chat-messages {
    background: #020617;
    border-radius: 10px;
    padding: 8px;
    height: calc(100% - 80px);
    overflow-y: auto;
    margin-bottom: 10px;
}

/* empty */
.chat-empty {
    color: #64748b;
    text-align: center;
    margin-top: 40px;
    font-size: 13px;
}

/* ===== MESSAGE ITEM ===== */
.chat-item {
    margin-bottom: 8px;
    line-height: 1.4;
    word-break: break-word;
}

.chat-username {
    color: #38bdf8;
    font-weight: 600;
    margin-right: 4px;
}

/* ===== INPUT ===== */
.chat-input {
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    gap: 6px;
}

.chat-input input {
    background: #020617;
    border: 1px solid #1e293b;
    color: #e5e7eb;
    border-radius: 8px;
    padding: 6px 8px;
    font-size: 13px;
    min-width: 0;
}
@media only screen and (max-width: 992px) {
.game-chat {
    height: 300px;
}
}
.chat-input input::placeholder {
    color: #64748b;
}

.chat-input button {
    background: linear-gradient(135deg, #f97316, #fb923c);
    border: none;
    color: #fff;
    font-weight: 600;
    padding: 0 12px;
    border-radius: 8px;
    cursor: pointer;
    white-space: nowrap;
}
</style>
                            <div class="col-md-4">
<div class="game-chat" id="game-chat" data-game-id="{{ $detail->id }}">

    <div class="chat-header">💬 Chat</div>

    <div class="chat-messages" id="chat-messages">
        @forelse ($chats as $chat)
            <div class="chat-item">
                <span class="chat-username">{{ $chat->username }}:</span>
                <span>{{ $chat->message }}</span>
            </div>
        @empty
            <div class="chat-empty">No message received.</div>
        @endforelse
    </div>

    <div class="chat-input">
        <input id="chat-username" placeholder="Your name">
        <input id="chat-text" placeholder="Enter content...">
        <button id="chat-send">Send</button>
    </div>
</div>
</div>
<script>
const gameChat = document.getElementById('game-chat');
const gameId   = gameChat.dataset.gameId;

// key đánh dấu: 1 game / 1 ngày
const todayKey = 'commented_' + gameId + '_' + new Date().toISOString().slice(0,10);

// các element cần dùng
const chatInputBox = gameChat.querySelector('.chat-input');
const sendBtn      = document.getElementById('chat-send');
const usernameEl   = document.getElementById('chat-username');
const messageEl    = document.getElementById('chat-text');

// 👉 nếu hôm nay đã comment → ẨN INPUT NGAY KHI LOAD
if (sessionStorage.getItem(todayKey)) {
    chatInputBox.style.display = 'none';
}

// 👉 khi bấm gửi
sendBtn.onclick = function () {
    const username = usernameEl.value || 'Guest';
    const message  = messageEl.value;

    if (!message) return;

    // nếu đã comment hôm nay thì không cho gửi nữa
    if (sessionStorage.getItem(todayKey)) return;

    fetch(`/api/games/${gameId}/chat`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ username, message })
    }).then(() => {
        // đánh dấu đã comment hôm nay
        sessionStorage.setItem(todayKey, '1');

        // ẨN LUÔN phần nhập + nút gửi
        chatInputBox.style.display = 'none';

        // thông báo đơn giản
        const notice = document.createElement('div');
        notice.style.fontSize = '13px';
        notice.style.color = '#22c55e';
        notice.style.marginTop = '6px';
        notice.innerText = '✔ Your comment is awaiting approval';
        gameChat.appendChild(notice);
    });
};
</script>

