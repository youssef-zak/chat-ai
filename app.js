const configPromise = import('./config.js').catch(() => ({}));

const knowledgeBase = [
  {
    id: 'pricing',
    title: 'أسعار وباقات Sity Cloud',
    summary:
      'خطط Sity Cloud تنقسم إلى Starter للفرق الصغيرة، Growth للشركات النامية، وElite للمؤسسات التي تحتاج أمان متقدم مع دعم مخصص.',
    cta: { label: 'تعرّف على كل الأسعار', url: '/pricing' },
    keywords: ['سعر', 'اسعار', 'باقات', 'فلوس', 'price', 'خطط', 'billing'],
  },
  {
    id: 'onboarding',
    title: 'بدء التشغيل والتفعيل',
    summary:
      'تقدر تفعل حسابك في أقل من 3 دقائق من زر "ابدأ مع Sity" في الهيدر، وبعدها يزيد يرشدك لرحلات الترحيب الجاهزة داخل لوحة التحكم.',
    cta: { label: 'ابدأ التفعيل', url: '/get-started' },
    keywords: ['سجل', 'حساب', 'ابدأ', 'register', 'sign', 'تفعيل'],
  },
  {
    id: 'features',
    title: 'مزايا يزيد',
    summary:
      'يزيد يربط الذكاء الاصطناعي بقواعد بياناتك: يفلتر نية الزائر، يعطيه جملة واحدة واضحة، ويربطه بأهم CTA داخل المنصة.',
    cta: { label: 'شاهد كل المزايا', url: '/features' },
    keywords: ['ميزة', 'مزايا', 'benefits', 'features', 'ليه', 'يزيد'],
  },
  {
    id: 'support',
    title: 'الدعم البشري من Sity Cloud',
    summary:
      'لو احتجت مساعدة بشرية، افتح صفحة التواصل أو راسل فريق الخبراء على support@sitycloud.com وردّهم خلال ساعات العمل.',
    cta: { label: 'تواصل مع الدعم', url: '/contact' },
    keywords: ['دعم', 'تواصل', 'support', 'مشكلة', 'مساعدة', 'بشري'],
  },
  {
    id: 'security',
    title: 'الأمان والتكاملات',
    summary:
      'Sity Cloud يدعم تشفير TLS 1.3، صلاحيات دقيقة، وتكاملات مع CRM وWhatsApp وSlack لضمان مسار عمل واحد.',
    cta: { label: 'اقرأ عن الأمان', url: '/security' },
    keywords: ['امان', 'حماية', 'security', 'integration', 'تكامل'],
  },
];

const quickReplies = [
  'لو بتدور على الأسعار فـ صفحة الباقات توضح كل خطة وما يشمله دعم يزيد.',
  'زر "ابدأ مع Sity" في الهيدر يفتح تسجيل سريع وموجّه.',
  'عايز خبير حقيقي؟ صفحة التواصل فيها نموذج ووسائل مباشرة.',
  'مزايا يزيد متاحة بالتفصيل داخل قسم الخصائص مع أمثلة فورية.',
];

const chatStream = document.getElementById('chat-stream');
const chatForm = document.getElementById('chat-form');
const chatInput = document.getElementById('chat-input');
const sendBtn = document.getElementById('send-btn');
const resetBtn = document.getElementById('reset-btn');

const openingMessage =
  'أهلاً! أنا يزيد، مساعد Sity Cloud الذكي. اسألني عن أي صفحة أو خطوة وأنا أوصلك لها في لحظات ✨';

addMessage('bot', openingMessage);

resetBtn?.addEventListener('click', () => {
  chatStream.innerHTML = '';
  addMessage('bot', openingMessage);
});

chatForm?.addEventListener('submit', async (event) => {
  event.preventDefault();
  const prompt = chatInput.value.trim();
  if (!prompt) return;

  addMessage('user', prompt);
  chatInput.value = '';
  setSendingState(true);

  try {
    const response = await fetchMiniChatReply(prompt);
    addMessage('bot', response);
  } catch (error) {
    console.error(error);
    addMessage('bot', getLocalFallback(prompt));
  } finally {
    setSendingState(false);
    chatInput.focus();
  }
});

function addMessage(role, text) {
  const bubble = document.createElement('div');
  bubble.className = `message ${role}`;
  bubble.innerText = text;
  chatStream.appendChild(bubble);
  chatStream.scrollTo({ top: chatStream.scrollHeight, behavior: 'smooth' });
}

function setSendingState(isSending) {
  sendBtn.disabled = isSending;
  sendBtn.textContent = isSending ? 'ثانية...' : 'أرسل';
}

function getLocalFallback(prompt) {
  const match = matchKnowledge(prompt);
  if (match) {
    return buildReply(match);
  }
  return (
    quickReplies[Math.floor(Math.random() * quickReplies.length)] ||
    'ابدأ من الصفحة الرئيسية وشوف الروابط اللي يزيد مجهزها لك.'
  );
}

function matchKnowledge(prompt) {
  const normalized = normalize(prompt);
  return knowledgeBase.find((item) =>
    item.keywords.some((keyword) => normalized.includes(keyword))
  );
}

function normalize(text) {
  return text
    .toLowerCase()
    .replace(/[أإآ]/g, 'ا')
    .replace(/[ة]/g, 'ه')
    .replace(/[^\p{L}\p{N}\s]/gu, '');
}

function buildReply(item) {
  const snippet = `${item.summary} → ${item.cta.label}: ${item.cta.url}`;
  return clamp(snippet);
}

function clamp(text, max = 240) {
  return text.length > max ? `${text.slice(0, max - 1)}…` : text;
}

async function fetchMiniChatReply(userPrompt) {
  const config = await configPromise;
  const apiKey = config.GEMINI_API_KEY;
  const model = config.GEMINI_MODEL || 'gemini-1.5-flash-latest';

  if (!apiKey) {
    throw new Error('Missing Gemini API key.');
  }

  const prompt = composePrompt(userPrompt);
  const response = await fetch(
    `https://generativelanguage.googleapis.com/v1beta/models/${model}:generateContent?key=${apiKey}`,
    {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        contents: [
          {
            role: 'user',
            parts: [
              {
                text: prompt,
              },
            ],
          },
        ],
        generationConfig: {
          temperature: 0.4,
          topK: 32,
          topP: 0.8,
          maxOutputTokens: 120,
        },
      }),
    }
  );

  if (!response.ok) {
    throw new Error('Gemini request failed');
  }

  const data = await response.json();
  const text = data?.candidates?.[0]?.content?.parts
    ?.map((part) => part.text)
    .join('')
    .trim();

  if (!text) {
    throw new Error('Empty Gemini response');
  }

  return clamp(text);
}

function composePrompt(userPrompt) {
  const base = `أنت "يزيد"، مساعد موجه من شركة Sity Cloud. لست دعمًا فنيًا كاملًا بل بوابة تساعد الزائر بجملة أو جملتين كحد أقصى وبفصحى بسيطة. ركّز على اقتراح صفحة أو خطوة داخل موقع Sity Cloud، وكن ودودًا بدون وعود لا نملكها.`;
  const knowledge = knowledgeBase
    .map(
      (item) =>
        `- ${item.title}: ${item.summary} (CTA: ${item.cta.label} → ${item.cta.url})`
    )
    .join('\n');

  return `${base}\n\nالمعرفة المتاحة:\n${knowledge}\n\nسؤال الزائر: ${userPrompt}\n\nرد موجز:`;
}
