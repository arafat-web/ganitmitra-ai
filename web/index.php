<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<title>🤖 গণিতমিত্র AI - স্মার্ট গণিত সমাধানকারী</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body class="p-6">
<div class="max-w-2xl mx-auto">
    <!-- Header Section -->
    <div class="card rounded-lg p-6 text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">গণিতমিত্র AI</h1>
        <p class="text-gray-600 mb-2">প্রাথমিক শ্রেণীর সহজ গণিতের সমস্যা সমাধানের জন্য বিশেষভাবে তৈরি</p>
        <p class="text-sm text-blue-600 mb-2">স্মার্ট কৃত্রিম বুদ্ধিমত্তা দিয়ে গণিতের সমস্যা সমাধান</p>
        <p class="text-sm text-gray-500 mb-6">মেশিন লার্নিং মডেল | ১০০% নির্ভুলতা | ৭৫০+ সমস্যায় প্রশিক্ষিত</p>

        <!-- Credits -->
        <div class="flex items-center justify-center gap-3">
            <a href="https://github.com/arafathossainar/ganitmitraAI" target="_blank"
               class="flex items-center px-3 py-1.5 bg-gray-900 hover:bg-gray-800 text-white text-xs rounded-md transition-colors">
            <i class="fab fa-github mr-1.5"></i>
            Source
            </a>
            <a href="https://github.com/arafathossainar" target="_blank"
               class="flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-md transition-colors">
            <i class="fas fa-user mr-1.5"></i>
            Profile
            </a>
        </div>
    </div>

    <!-- Main Input Section -->
    <div class="card rounded-lg p-6 mb-2">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">গণিতের সমস্যা লিখুন:</label>
            <textarea
                id="problem"
                rows="3"
                class="w-full p-3 border border-gray-300 rounded-md outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 resize-none"
                placeholder="উদাহরণ: রাহিমের কাছে ৫টি আম আছে। করিম তাকে ৩টি আম দিল। এখন তার কাছে কতটি আম?"
            ></textarea>
        </div>

        <button
            id="solveBtn"
            class="btn-primary w-full text-white p-3 rounded-md font-medium">
            সমাধান করুন
        </button>
    </div>
    <!-- Result Section -->
    <div id="result" class="card rounded-lg p-6 hidden"></div>

    <!-- Examples Section -->
    <div id="initialExamples" class="card rounded-lg p-6 mt-6">
        <h3 class="text-lg font-medium text-gray-800 mb-4">উদাহরণ সমস্যা (ক্লিক করুন):</h3>
        <div class="space-y-3">
            <div class="example-btn p-3 bg-gray-50 rounded-md cursor-pointer text-sm border border-gray-200" onclick="setExample('রাহিমের কাছে ৫টি আম আছে। করিম তাকে ৩টি আম দিল। এখন তার কাছে কতটি আম?')">
                রাহিমের কাছে ৫টি আম আছে। করিম তাকে ৩টি আম দিল। এখন তার কাছে কতটি আম?
            </div>
            <div class="example-btn p-3 bg-gray-50 rounded-md cursor-pointer text-sm border border-gray-200" onclick="setExample('মিতা ১২টি কলম কিনল। সে ৪টি কলম তার ভাইকে দিল। এখন মিতার কাছে কতটি কলম আছে?')">
                মিতা ১২টি কলম কিনল। সে ৪টি কলম তার ভাইকে দিল। এখন মিতার কাছে কতটি কলম আছে?
            </div>
            <div class="example-btn p-3 bg-gray-50 rounded-md cursor-pointer text-sm border border-gray-200" onclick="setExample('একটি ঝুড়িতে ৬টি আপেল আছে। ৪টি ঝুড়িতে মোট কতটি আপেল আছে?')">
                একটি ঝুড়িতে ৬টি আপেল আছে। ৪টি ঝুড়িতে মোট কতটি আপেল আছে?
            </div>
            <div class="example-btn p-3 bg-gray-50 rounded-md cursor-pointer text-sm border border-gray-200" onclick="setExample('২০টি আম ৫ জনের মধ্যে ভাগ করা হলো। প্রত্যেকে কতটি আম পাবে?')">
                ২০টি আম ৫ জনের মধ্যে ভাগ করা হলো। প্রত্যেকে কতটি আম পাবে?
            </div>
        </div>
    </div>

    <!-- Contextual Examples Section (Initially Hidden) -->
    <div id="examples" class="card rounded-lg p-6 mt-6 hidden">
        <h3 class="text-lg font-medium text-gray-800 mb-4">আরো চেষ্টা করুন:</h3>
        <div id="examplesList" class="space-y-3">
            <!-- Examples will be dynamically inserted here -->
        </div>
    </div>
            <!-- Developer Info -->
        <div class="text-center mt-3">
            <p class="text-sm text-gray-600">
                Developed by <span class="font-medium text-blue-600">Arafat Hossain Ar</span>
            </p>
        </div>
</div>

<script>

    document.getElementById('result').classList.add('hidden');
// Set example problem function
function setExample(text) {
    document.getElementById('problem').value = text;
}

// Enhanced solve function with animations
document.getElementById('solveBtn').addEventListener('click', function() {
    solveProblem();
});

function getProblems(){
    fetch('ajax_generate.php?n=4')
    .then(r => r.json())
    .then(data => {
        if (!data.success) throw new Error(data.error || 'failed');
        // show results in the contextual examples area
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
        // hide initial block
        const initial = document.getElementById('initialExamples');
        if (initial) initial.style.display = 'none';
    })
    .catch(err => {
        alert('জেনারেট করতে সমস্যা: ' + (err.message || err));
    });
}

// Allow Enter key to solve (with Ctrl+Enter for newline)
document.getElementById('problem').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.ctrlKey && !e.shiftKey) {
        e.preventDefault();
        solveProblem();
    }
});

function solveProblem() {
    let problem = document.getElementById('problem').value;
    if(problem.trim() === '') {
        alert('অনুগ্রহ করে একটি গণিতের সমস্যা লিখুন');
        return;
    }

    // Hide initial examples section after solving any problem
    const initialExamplesDiv = document.getElementById('initialExamples');
    if (initialExamplesDiv) {
        initialExamplesDiv.style.display = 'none';
    }

    const resultDiv = document.getElementById('result');
    const solveBtn = document.getElementById('solveBtn');

    // Show result section and loading state
    resultDiv.classList.remove('hidden');
    resultDiv.innerHTML = `
        <div class="text-center py-6">
            <div class="loading-spinner mx-auto mb-3"></div>
            <p class='text-blue-600 font-medium'>সমাধান বিশ্লেষণ করছে...</p>
        </div>
    `;

    // Disable button during processing
    solveBtn.disabled = true;
    solveBtn.innerHTML = 'প্রক্রিয়াকরণ...';

    fetch('ajax_solver.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'problem=' + encodeURIComponent(problem)
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('Network response was not ok');
        }
        return res.text();
    })
    .then(text => {
        try {
            const data = JSON.parse(text);

            if(!data.success || data.error){
                resultDiv.innerHTML = `
                    <div class="text-center py-6">
                        <p class='text-red-600 font-medium'>❌ ${data.error || 'সমাধান করতে পারিনি'}</p>
                        <p class="text-sm text-gray-500 mt-1">অন্য একটি সমস্যা চেষ্টা করুন</p>
                    </div>
                `;
                return;
            }

            // Create clean result HTML
            let html = `<div class="space-y-4">`;

            if(data.steps && data.steps.length > 0) {
                html += `
                    <div>
                        <h4 class='font-medium text-gray-800 mb-3'>সমাধান প্রক্রিয়া:</h4>
                        <ol class='space-y-2 text-sm'>
                `;

                data.steps.forEach((step, index) => {
                    html += `<li class='flex'><span class='font-medium mr-2'>${index + 1}.</span><span>${step}</span></li>`;
                });

                html += `</ol></div>`;
            }

            html += `
                <div class="bg-blue-50 p-4 rounded-md border border-blue-200 text-center">
                    <p class='font-bold text-xl text-blue-700'>
                        উত্তর: ${data.bengali_answer || data.answer}
                    </p>
                </div>
            `;

            if(data.method && data.accuracy) {
                html += `
                    <div class="text-xs text-gray-500 text-center">
                        ${data.method} | ${data.accuracy}
                    </div>
                `;
            }

            html += '</div>';

            resultDiv.innerHTML = html;
            resultDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => {
               getProblems();
            }, 1000);

        } catch (e) {
            console.error('JSON Parse Error:', e);
            console.error('Response text:', text);
            resultDiv.innerHTML = `
                <div class="text-center py-6">
                    <p class='text-red-600 font-medium'>❌ সার্ভার প্রতিক্রিয়া পার্স করতে পারিনি</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error);
        resultDiv.innerHTML = `
            <div class="text-center py-6">
                <p class='text-red-600 font-medium'>❌ সার্ভার সংযোগে সমস্যা</p>
            </div>
        `;
    })
    .finally(() => {
        solveBtn.disabled = false;
        solveBtn.innerHTML = 'সমাধান করুন';
    });
}
</script>
</body>
</html>
