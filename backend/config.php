<?php
// Global configuration for the chat application.
return [
    // Path to the SQLite database file.
    'database_path' => __DIR__ . '/../storage/chat.sqlite',

    // Gemini API endpoint and key (replace with your own key in production).
    'gemini_endpoint' => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent',
    'gemini_api_key' => 'YOUR_GEMINI_API_KEY',

    // AI support agents exposed in the dashboard.
    'support_agents' => [
        [
            'id' => 'system-architect',
            'name' => 'مهندس النظام',
            'emoji' => '🛠️',
            'mission' => 'يبني مخططات الحلول ويشرح كيفية دمج أنظمة العميل مع المنصة.',
            'prompt' => 'أنت مهندس نظام يساعد العملاء على تحويل احتياجاتهم إلى حلول تقنية واضحة. ركز على المتطلبات التقنية والخطوات العملية.'
        ],
        [
            'id' => 'success-coach',
            'name' => 'مدرب النجاح',
            'emoji' => '🚀',
            'mission' => 'يرشد العميل خلال أفضل الممارسات ويحدد مؤشرات الأداء لنجاح المشروع.',
            'prompt' => 'أنت مدرب نجاح العملاء. قدم خطوات تنفيذية، مؤشرات أداء، ونقاط متابعة تساعد العميل على تحقيق قيمة سريعة.'
        ],
        [
            'id' => 'support-guru',
            'name' => 'خبير الدعم',
            'emoji' => '💬',
            'mission' => 'يحاول حل أعطال المنتج ويكتب تعليمات تفصيلية للدعم الفني.',
            'prompt' => 'أنت وكيل دعم فني محترف. اسأل الأسئلة التشخيصية وقدّم حلولاً مرتبة ومفصلة مع تحذيرات السلامة عند الحاجة.'
        ],
    ],
];
