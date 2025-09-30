<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <title>🤖 গণিতমিত্র AI - স্মার্ট গণিত সমাধানকারী</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Baloo+Da+2:wght@400..800&family=Noto+Sans+Bengali:wght@100..900&display=swap"
        rel="stylesheet">
</head>

<body class="p-2 bg-gray-50">
    <div class="max-w-2xl mx-auto">

        <!-- Header -->
        <div class="card rounded-lg p-6 text-center mb-8">
            <header class="text-center">
                <h1 class="text-3xl font-extrabold text-purple-700 mb-2 flex items-center justify-center gap-2">
                    <span>গণিতমিত্র <span class="text-blue-600">AI</span></span>
                </h1>
                <p class="text-gray-700 text-sm">প্রাথমিক স্তরের গণিত সমস্যা সমাধানে তৈরি AI সহকারী</p>

                <div class="flex flex-wrap gap-2 justify-center mt-3 mb-2">
                    <span class="px-2.5 py-1 text-xs bg-purple-50 text-purple-700 rounded border border-purple-200">
                        ১০,০০০+ সমস্যা সমাধানে দক্ষ
                    </span>
                </div>
                <div class="flex items-center justify-center gap-3">
                    <a href="https://github.com/arafat-web/ganitmitraAI" target="_blank"
                        class="inline-flex items-center px-2.5 py-1 text-xs bg-gray-50 text-gray-700 rounded border border-gray-200">
                        <i class="fab fa-github mr-1.5"></i>
                        Source
                    </a>
                    <button id="openInfoBtn"
                        class="inline-flex items-center px-2.5 py-1 text-xs bg-blue-50 text-blue-700 rounded border border-blue-200">
                        <i class="fa-regular fa-circle-question mr-1.5"></i>
                        গাইডলাইন
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-2">দ্রষ্টব্য: AI-তৈরি সমাধানে মাঝে মাঝে ত্রুটি থাকতে পারে, সঠিকতার
                    জন্য যাচাই করুন।</p>
            </header>
        </div>


        <!-- Modal -->
        <div id="infoModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true"
            aria-labelledby="infoTitle">
            <div id="infoBackdrop" class="absolute inset-0 bg-black/40"></div>
            <div class="relative mx-auto my-10 w-[92%] max-w-xl">
                <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
                        <h2 id="infoTitle" class="text-base font-semibold text-gray-800">গণিতমিত্র AI - সম্পর্কে</h2>
                        <button id="closeInfoBtn" class="text-gray-500 hover:text-gray-700 p-1 rounded-md"
                            aria-label="Close">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    <div class="px-5 py-4 space-y-4 text-sm text-gray-700">
                        <ul class="space-y-2">
                            <li class="flex items-start"><i
                                    class="fa-solid fa-check text-green-600 mt-0.5 mr-2"></i>যোগ, বিয়োগ, গুণ, ভাগ এবং
                                সহজ শব্দ সমস্যা সমাধান</li>
                            <li class="flex items-start"><i
                                    class="fa-solid fa-check text-green-600 mt-0.5 mr-2"></i>বাংলায় লেখা প্রশ্ন বুঝে
                                স্পষ্ট, ধাপে ধাপে ব্যাখ্যা</li>
                            <li class="flex items-start"><i
                                    class="fa-solid fa-check text-green-600 mt-0.5 mr-2"></i>প্রাসঙ্গিক উদাহরণ থেকে
                                অনুশীলনের সুযোগ</li>
                        </ul>
                        <div class="pt-2 border-t border-gray-100">
                            <p class="font-medium text-gray-800 mb-2">কীভাবে ব্যবহার করবেন</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>উদাহরণে ক্লিক করুন বা আপনার নিজের সমস্যা লিখুন</li>
                                <li>এন্টার চাপুন বা “সমাধান করুন” বাটনে ক্লিক করুন</li>
                                <li>ধাপে ধাপে সমাধান ও চূড়ান্ত উত্তর দেখুন</li>
                            </ul>
                        </div>
                        <div class="pt-2">
                            <p class="font-medium text-gray-800 mb-2">সমর্থিত বিষয়</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>প্রাথমিক গণিত: যোগ, বিয়োগ, গুণ, ভাগ</li>
                                <li>সহজ শব্দ সমস্যা ও ইউনিট কনভার্সন</li>
                            </ul>
                        </div>
                        <div class="pt-2">
                            <p class="font-medium text-gray-800 mb-1">সীমাবদ্ধতা</p>
                            <p class="text-gray-600">AI-তৈরি সমাধানে মাঝে মাঝে ত্রুটি থাকতে পারে, প্রয়োজনে যাচাই করুন।
                            </p>
                        </div>
                    </div>
                    <div class="px-5 py-3 border-t border-gray-200 flex justify-end">
                        <button id="closeInfoBtn2"
                            class="px-3 py-1.5 text-sm bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md">ঠিক
                            আছে</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Section -->
        <div class="card rounded-lg p-6 mb-2 bg-white shadow-sm">
            <label class="block text-sm font-medium text-gray-700 mb-2">গণিতের সমস্যা লিখুন:</label>
            <textarea id="problem" rows="3"
                class="w-full p-3 border border-gray-300 rounded-md outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 resize-none"
                placeholder="উদাহরণ: রাহিমের কাছে ৫টি আম আছে। করিম তাকে ৩টি আম দিল। এখন তার কাছে কতটি আম?"></textarea>
            <button id="solveBtn" class="btn-primary w-full text-white p-3 rounded-md font-medium mt-3">সমাধান
                করুন</button>
        </div>

        <!-- Result Section -->
        <div id="result" class="card rounded-lg p-6 hidden"></div>

        <!-- Examples Section -->
        <div id="initialExamples" class="card rounded-lg p-6 mt-6 bg-white shadow-sm">
            <h3 class="text-lg font-medium text-gray-800 mb-4">উদাহরণ সমস্যা (ক্লিক করুন):</h3>
            <div class="space-y-3">
                <div class="example-btn p-3 bg-gray-50 rounded-md cursor-pointer text-sm border border-gray-200"
                    onclick="setExample('রাহিমের কাছে ৫টি আম আছে। করিম তাকে ৩টি আম দিল। এখন তার কাছে কতটি আম?')">রাহিমের
                    কাছে ৫টি আম আছে। করিম তাকে ৩টি আম দিল। এখন তার কাছে কতটি আম?</div>
                <div class="example-btn p-3 bg-gray-50 rounded-md cursor-pointer text-sm border border-gray-200"
                    onclick="setExample('মিতা ১২টি কলম কিনল। সে ৪টি কলম তার ভাইকে দিল। এখন মিতার কাছে কতটি কলম আছে?')">
                    মিতা ১২টি কলম কিনল। সে ৪টি কলম তার ভাইকে দিল। এখন মিতার কাছে কতটি কলম আছে?</div>
                <div class="example-btn p-3 bg-gray-50 rounded-md cursor-pointer text-sm border border-gray-200"
                    onclick="setExample('একটি ঝুড়িতে ৬টি আপেল আছে। ৪টি ঝুড়িতে মোট কতটি আপেল আছে?')">একটি ঝুড়িতে ৬টি
                    আপেল আছে। ৪টি ঝুড়িতে মোট কতটি আপেল আছে?</div>
                <div class="example-btn p-3 bg-gray-50 rounded-md cursor-pointer text-sm border border-gray-200"
                    onclick="setExample('২০টি আম ৫ জনের মধ্যে ভাগ করা হলো। প্রত্যেকে কতটি আম পাবে?')">২০টি আম ৫ জনের
                    মধ্যে ভাগ করা হলো। প্রত্যেকে কতটি আম পাবে?</div>
            </div>
        </div>

        <!-- Contextual Examples Section -->
        <div id="examples" class="card rounded-lg p-6 mt-6 bg-white shadow-sm hidden">
            <h3 class="text-lg font-medium text-gray-800 mb-4">আরো চেষ্টা করুন:</h3>
            <div id="examplesList" class="space-y-3"></div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-3">
            <p class="text-sm text-gray-600">
                Developed by <a href="https://arafat.dev" target="_blank"
                    class="text-blue-600 hover:underline">Arafat Hossain</a>.
            </p>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        (function () {
            // Modal functionality
            const modal = document.getElementById('infoModal');
            const openBtn = document.getElementById('openInfoBtn');
            const closeBtn = document.getElementById('closeInfoBtn');
            const closeBtn2 = document.getElementById('closeInfoBtn2');
            const backdrop = document.getElementById('infoBackdrop');

            function openModal() {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            function closeModal() {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            openBtn.addEventListener('click', openModal);
            closeBtn.addEventListener('click', closeModal);
            closeBtn2.addEventListener('click', closeModal);
            backdrop.addEventListener('click', closeModal);
            window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

            // Set example problem
            window.setExample = function (text) {
                document.getElementById('problem').value = text;
            };

            // Solve button
            const solveBtn = document.getElementById('solveBtn');
            const resultDiv = document.getElementById('result');
            const problemInput = document.getElementById('problem');

            solveBtn.addEventListener('click', solveProblem);
            problemInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && !e.ctrlKey && !e.shiftKey) {
                    e.preventDefault(); solveProblem();
                }
            });

            function getProblems() {
                fetch('generate.php?n=4')
                    .then(r => r.json())
                    .then(data => {
                        if (!data.success) throw new Error(data.error || 'failed');
                        const examplesDiv = document.getElementById('examples');
                        const examplesList = document.getElementById('examplesList');
                        examplesList.innerHTML = '';
                        data.problems.forEach(p => {
                            const d = document.createElement('div');
                            d.className = 'example-btn p-3 bg-gray-50 rounded-md cursor-pointer text-sm border border-gray-200';
                            d.textContent = p;
                            d.addEventListener('click', () => setExample(p));
                            examplesList.appendChild(d);
                        });
                        examplesDiv.classList.remove('hidden');
                        const initial = document.getElementById('initialExamples');
                        if (initial) initial.style.display = 'none';
                    })
                    .catch(err => alert('জেনারেট করতে সমস্যা: ' + (err.message || err)));
            }

            function solveProblem() {
                let problem = problemInput.value.trim();
                if (!problem) { alert('অনুগ্রহ করে একটি গণিতের সমস্যা লিখুন'); return; }

                resultDiv.classList.remove('hidden');
                resultDiv.innerHTML = `
            <div class="text-center py-6">
                <div class="loading-spinner mx-auto mb-3"></div>
                <p class='text-blue-600 font-medium'>সমাধান বিশ্লেষণ করছে...</p>
            </div>
        `;
                solveBtn.disabled = true;
                solveBtn.innerHTML = 'প্রক্রিয়াকরণ...';

                fetch('solver.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'problem=' + encodeURIComponent(problem)
                })
                    .then(res => res.text())
                    .then(text => {
                        try {
                            const data = JSON.parse(text);
                            if (!data.success || data.error) {
                                resultDiv.innerHTML = `
                        <div class="text-center py-6">
                            <p class="text-red-600 font-medium">❌ ${data.error || 'সমাধান করতে পারিনি'}</p>
                            <p class="text-sm text-gray-500 mt-1">অন্য একটি সমস্যা চেষ্টা করুন</p>
                        </div>`;
                                return;
                            }

                            // Whiteboard-style steps
                            let html = `<div class="space-y-6">`;
                            if (Array.isArray(data.steps) && data.steps.length > 0) {
                                html += `
                        <div class="bg-white p-4 rounded-md shadow-sm whiteboard-steps space-y-2 text-base">
                            <h3 class="font-semibold text-gray-700 mb-2">সমাধান প্রক্রিয়া:</h3>
                            <ol class="list-none space-y-1">
                                ${data.steps.map(step => `<li>→ ${step}</li>`).join('')}
                            </ol>
                        </div>`;
                            }

                            html += `
                    <div class="bg-blue-50 p-4 rounded-md border border-blue-200 whiteboard-steps text-center">
                        <p class="font-bold text-xl text-blue-700">উত্তর: ${data.bengali_answer || data.answer || '❓'}</p>
                    </div>
                    <p class="text-xs text-yellow-800">⚠️ দয়া করে মনে রাখবেন, AI দ্বারা তৈরি সমস্যাগুলি মাঝে মাঝে ভুল বা অসঙ্গত হতে পারে।</p>
                `;
                            html += `</div>`;

                            resultDiv.innerHTML = html;
                            resultDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });

                            setTimeout(getProblems, 1000);

                        } catch (e) {
                            console.error('JSON Parse Error:', e, '\nResponse text:', text);
                            resultDiv.innerHTML = `
                    <div class="text-center py-6">
                        <p class="text-red-600 font-medium">❌ সার্ভার প্রতিক্রিয়া পার্স করতে পারিনি</p>
                        <p class="text-sm text-gray-500 mt-1">পরে আবার চেষ্টা করুন</p>
                    </div>`;
                        }
                    })
                    .catch(err => {
                        console.error('Fetch Error:', err);
                        resultDiv.innerHTML = `
                <div class="text-center py-6">
                    <p class='text-red-600 font-medium'>❌ সার্ভার সংযোগে সমস্যা</p>
                </div>`;
                    })
                    .finally(() => {
                        solveBtn.disabled = false;
                        solveBtn.innerHTML = 'সমাধান করুন';
                    });
            }

        })();
    </script>
</body>

</html>