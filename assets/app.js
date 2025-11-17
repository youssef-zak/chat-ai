const chatWindow = document.getElementById('chat-window');
const form = document.getElementById('chat-form');
const messageInput = document.getElementById('message');
const clearButton = document.getElementById('clear-chat');
const template = document.getElementById('message-template');
const ticketTemplate = document.getElementById('ticket-template');
const agentsList = document.getElementById('agents-list');
const ticketForm = document.getElementById('ticket-form');
const ticketList = document.getElementById('ticket-list');
const statsElements = {
  messages: document.getElementById('total-messages'),
  open: document.getElementById('open-tickets'),
  resolved: document.getElementById('resolved-tickets'),
  lastTicket: document.getElementById('last-ticket')
};

const avatars = {
  user: '🧑‍💼',
  assistant: '🤖'
};

let agentMap = {};
let selectedAgentId = null;

async function fetchAgents() {
  try {
    const response = await fetch('api/agents.php');
    const data = await response.json();
    agentMap = {};
    (data.agents || []).forEach((agent) => {
      agentMap[agent.id] = agent;
    });
    selectedAgentId = selectedAgentId || data.agents?.[0]?.id || null;
    renderAgents(data.agents || []);
  } catch (error) {
    console.error('Unable to load agents', error);
  }
}

function renderAgents(agents) {
  agentsList.innerHTML = '';
  agents.forEach((agent) => {
    const card = document.createElement('article');
    card.className = 'agent-card';
    if (agent.id === selectedAgentId) {
      card.classList.add('active');
    }

    card.innerHTML = `
      <div class="agent-icon">${agent.emoji || '🤖'}</div>
      <div>
        <h3>${agent.name}</h3>
        <p>${agent.mission}</p>
      </div>
    `;

    card.addEventListener('click', () => {
      selectedAgentId = agent.id;
      renderAgents(agents);
    });

    agentsList.appendChild(card);
  });
}

async function fetchDashboard() {
  try {
    const response = await fetch('api/dashboard.php');
    const data = await response.json();
    if (!data.stats) return;
    statsElements.messages.textContent = data.stats.message_count ?? 0;
    statsElements.open.textContent = data.stats.open_tickets ?? 0;
    statsElements.resolved.textContent = data.stats.resolved_tickets ?? 0;
    statsElements.lastTicket.textContent = data.stats.last_ticket_at
      ? new Date(data.stats.last_ticket_at).toLocaleString('ar-EG', { hour: '2-digit', minute: '2-digit', day: 'numeric', month: 'short' })
      : '—';
  } catch (error) {
    console.error('Unable to load stats', error);
  }
}

async function fetchTickets() {
  try {
    const response = await fetch('api/tickets.php');
    const data = await response.json();
    renderTickets(data.tickets || []);
  } catch (error) {
    console.error('Unable to load tickets', error);
  }
}

function renderTickets(tickets) {
  ticketList.innerHTML = '';
  if (!tickets.length) {
    const empty = document.createElement('p');
    empty.textContent = 'لا توجد تذاكر حتى الآن.';
    empty.className = 'subtitle';
    ticketList.appendChild(empty);
    return;
  }

  tickets.forEach((ticket) => {
    const clone = ticketTemplate.content.cloneNode(true);
    clone.querySelector('h3').textContent = ticket.subject;
    clone.querySelector('.status').textContent = ticket.status === 'open' ? 'قيد المعالجة' : 'مغلقة';
    clone.querySelector('.details').textContent = ticket.description || '—';
    const priorityElement = clone.querySelector('.priority');
    priorityElement.textContent = `أولوية: ${priorityLabel(ticket.priority)}`;
    priorityElement.dataset.level = ticket.priority;
    clone.querySelector('time').textContent = new Date(ticket.created_at).toLocaleString('ar-EG', { hour: '2-digit', minute: '2-digit', day: 'numeric', month: 'short' });
    ticketList.appendChild(clone);
  });
}

function priorityLabel(level) {
  switch (level) {
    case 'urgent':
      return 'عاجلة';
    case 'high':
      return 'مرتفعة';
    default:
      return 'عادية';
  }
}

async function fetchHistory() {
  try {
    const response = await fetch('api/history.php');
    const data = await response.json();
    if (data.messages) {
      chatWindow.innerHTML = '';
      data.messages.forEach(renderMessage);
      scrollToBottom();
    }
  } catch (error) {
    console.error('Unable to load history', error);
  }
}

function renderMessage(message) {
  const clone = template.content.cloneNode(true);
  const container = clone.querySelector('.message');
  container.classList.add(message.role);
  const agent = message.agent ? agentMap[message.agent] : null;
  clone.querySelector('.avatar').textContent = message.role === 'assistant' && agent ? agent.emoji : avatars[message.role] || '💬';

  const roleLabel = message.role === 'user' ? 'العميل' : agent ? agent.name : 'الذكاء الاصطناعي';
  const timestamp = new Date(message.created_at).toLocaleTimeString('ar-EG', {
    hour: '2-digit',
    minute: '2-digit'
  });
  clone.querySelector('.meta').textContent = `${roleLabel} • ${timestamp}`;
  clone.querySelector('.text').textContent = message.content;
  chatWindow.appendChild(clone);
}

async function sendMessage(message) {
  if (!selectedAgentId) {
    alert('يرجى اختيار وكيل دعم قبل إرسال الرسالة.');
    return;
  }

  const optimisticMessage = {
    role: 'user',
    content: message,
    created_at: new Date().toISOString(),
    agent: selectedAgentId
  };
  renderMessage(optimisticMessage);
  scrollToBottom();

  try {
    const response = await fetch('api/chat.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ message, agent: selectedAgentId })
    });
    const data = await response.json();

    if (data.error) {
      throw new Error(data.error);
    }

    renderMessage({
      role: 'assistant',
      content: data.reply,
      created_at: new Date().toISOString(),
      agent: data.agent || selectedAgentId
    });
    scrollToBottom();
    fetchDashboard();
  } catch (error) {
    alert('حدث خطأ أثناء الاتصال بالخادم: ' + error.message);
  }
}

function scrollToBottom() {
  chatWindow.scrollTop = chatWindow.scrollHeight;
}

form.addEventListener('submit', (event) => {
  event.preventDefault();
  const message = messageInput.value.trim();
  if (!message) return;
  messageInput.value = '';
  sendMessage(message);
});

clearButton.addEventListener('click', async () => {
  if (!confirm('هل تريد مسح جميع الرسائل والتذاكر؟')) return;
  try {
    await fetch('database/clear.php');
    chatWindow.innerHTML = '';
    ticketList.innerHTML = '';
    fetchDashboard();
    fetchHistory();
    fetchTickets();
  } catch (error) {
    alert('تعذر مسح السجل: ' + error.message);
  }
});

ticketForm.addEventListener('submit', async (event) => {
  event.preventDefault();
  const subject = document.getElementById('ticket-subject').value.trim();
  const description = document.getElementById('ticket-description').value.trim();
  const priority = document.getElementById('ticket-priority').value;

  if (!subject || !description) {
    alert('يرجى إدخال عنوان ووصف للتذكرة.');
    return;
  }

  try {
    const response = await fetch('api/tickets.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ subject, description, priority })
    });
    const data = await response.json();
    if (data.error) {
      throw new Error(data.error);
    }

    ticketForm.reset();
    fetchTickets();
    fetchDashboard();
  } catch (error) {
    alert('لم يتم إنشاء التذكرة: ' + error.message);
  }
});

async function bootstrap() {
  await fetchAgents();
  fetchHistory();
  fetchDashboard();
  fetchTickets();
}

bootstrap();
