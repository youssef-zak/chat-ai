<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>مركز القيادة الذكي</title>
    <link rel="stylesheet" href="assets/styles.css" />
</head>
<body>
    <div class="layout">
        <aside class="dashboard">
            <section class="hero">
                <p class="eyebrow">لوحة قيادة فورية</p>
                <h1>تواصل قوي بين النظام والعميل</h1>
                <p class="subtitle">اختر وكيل الذكاء الاصطناعي المناسب، وافتح تذكرة دعم فني، وشاهد كل شيء في مكان واحد.</p>
                <div class="stat-grid">
                    <article class="stat-card">
                        <p>إجمالي الرسائل</p>
                        <strong id="total-messages">0</strong>
                    </article>
                    <article class="stat-card">
                        <p>تذاكر مفتوحة</p>
                        <strong id="open-tickets">0</strong>
                    </article>
                    <article class="stat-card">
                        <p>تذاكر منجزة</p>
                        <strong id="resolved-tickets">0</strong>
                    </article>
                    <article class="stat-card">
                        <p>آخر تذكرة</p>
                        <strong id="last-ticket">—</strong>
                    </article>
                </div>
            </section>

            <section class="agents-panel">
                <div class="panel-header">
                    <h2>وكلاء الدعم الذكي</h2>
                    <p>لكل وكيل مهمة محددة لدعم العميل.</p>
                </div>
                <div id="agents-list" class="agent-grid"></div>
            </section>

            <section class="tickets-panel">
                <div class="panel-header">
                    <h2>افتح تذكرة دعم فني</h2>
                    <p>اربط فريقك مع النظام مباشرة.</p>
                </div>
                <form id="ticket-form" class="ticket-form">
                    <label for="ticket-subject">عنوان التذكرة</label>
                    <input id="ticket-subject" name="subject" type="text" placeholder="مثال: مشكلة في تسجيل الدخول" required />

                    <label for="ticket-priority">الأولوية</label>
                    <select id="ticket-priority" name="priority">
                        <option value="normal">عادية</option>
                        <option value="high">مرتفعة</option>
                        <option value="urgent">عاجلة</option>
                    </select>

                    <label for="ticket-description">وصف مختصر</label>
                    <textarea id="ticket-description" name="description" rows="3" placeholder="اشرح المشكلة أو الطلب" required></textarea>

                    <button type="submit">إرسال التذكرة</button>
                </form>

                <div class="ticket-list" id="ticket-list"></div>
            </section>
        </aside>

        <section class="chat-panel">
            <header class="chat-header">
                <div>
                    <p class="eyebrow">جلسة النظام والعميل</p>
                    <h2>محادثة مباشرة</h2>
                    <p class="subtitle">تاريخ الرسائل محفوظ ويمكنك مسحه في أي وقت.</p>
                </div>
                <button id="clear-chat" type="button">مسح السجل</button>
            </header>

            <main id="chat-window" class="chat-window"></main>

            <form id="chat-form" class="chat-form">
                <label for="message" class="sr-only">رسالتك</label>
                <textarea id="message" name="message" rows="3" placeholder="اكتب رسالتك هنا..." required></textarea>
                <button type="submit">إرسال</button>
            </form>
        </section>
    </div>

    <template id="message-template">
        <div class="message">
            <div class="avatar"></div>
            <div class="content">
                <div class="meta"></div>
                <div class="text"></div>
            </div>
        </div>
    </template>

    <template id="ticket-template">
        <article class="ticket-card">
            <header>
                <h3></h3>
                <span class="status"></span>
            </header>
            <p class="details"></p>
            <footer>
                <span class="priority"></span>
                <time></time>
            </footer>
        </article>
    </template>

    <script src="assets/app.js"></script>
</body>
</html>
