<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<title>🤖 গণিতমিত্র AI - স্মার্ট গণিত সমাধানকারী</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap');

    body {
        font-family: 'Noto Sans Bengali', sans-serif;
        background: #f8fafc;
        min-height: 100vh;
    }

    .card {
        background: white;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }



    .btn-primary {
        background: #3b82f6;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .example-btn {
        transition: all 0.2s ease;
    }

    .example-btn:hover {
        background: #f1f5f9;
        border-color: #3b82f6;
    }

    .loading-spinner {
        border: 2px solid #f3f4f6;
        border-top: 2px solid #3b82f6;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        animation: spin 1s linear infinite;
        display: inline-block;
        margin-right: 8px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
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
// All examples organized by type for contextual suggestions
const allExamples = {
    // Addition examples
    add: [
        'রাহিমের কাছে ৫টি আম আছে। করিম তাকে ৩টি আম দিল। এখন তার কাছে কতটি আম?',
        'সারার কাছে ১৫ টাকা আছে। মা তাকে আরো ২৫ টাকা দিল। এখন তার কাছে কত টাকা?',
        'একটি ঝুড়িতে ১২টি কমলা আছে। আরো ৮টি কমলা রাখা হলো। এখন মোট কতটি কমলা?'
    ],
    // Subtraction examples
    subtract: [
        'মিতা ১২টি কলম কিনল। সে ৪টি কলম তার ভাইকে দিল। এখন মিতার কাছে কতটি কলম আছে?',
        'রনির কাছে ৫০ টাকা ছিল। সে ২০ টাকা খরচ করল। এখন তার কাছে কত টাকা আছে?',
        'একটি বাগানে ২৫টি গোলাপ ছিল। ১০টি ঝড়ে নষ্ট হলো। এখন কতটি গোলাপ আছে?'
    ],
    // Multiplication examples
    multiply: [
        'একটি ঝুড়িতে ৬টি আপেল আছে। ৪টি ঝুড়িতে মোট কতটি আপেল আছে?',
        'প্রতিদিন ৭টি করে বই পড়া হয়। ৫ দিনে মোট কতটি বই পড়া হবে?',
        'একটি বাক্সে ১২টি চকলেট আছে। ৩টি বাক্সে মোট কতটি চকলেট?'
    ],
    // Division examples
    divide: [
        '২০টি আম ৫ জনের মধ্যে ভাগ করা হলো। প্রত্যেকে কতটি আম পাবে?',
        '৩৬টি বই ৬টি তাকে সমানভাবে সাজানো হলো। প্রতিটি তাকে কতটি বই?',
        '৮১টি পেন্সিল ৯ জন ছাত্রের মধ্যে ভাগ করা হলো। প্রত্যেকে কতটি পেন্সিল পাবে?'
    ],
    // Mixed examples
    mixed: [
        'একটি ট্রাক ৯ কিমি প্রতি লিটার গ্যাস খায়। ট্রাক ৫৪ কিমি যাবে। কত লিটার গ্যাস লাগবে?',
        'রুবির কাছে ১৫ টাকা আছে। সে ৭ টাকা খরচ করল, পরে ৩ টাকা পেল। এখন তার কাছে কত টাকা?'
    ]
};

// Map problems to their types
const problemTypes = {
    'রাহিমের কাছে ৫টি আম আছে। করিম তাকে ৩টি আম দিল। এখন তার কাছে কতটি আম?': 'add',
    'মিতা ১২টি কলম কিনল। সে ৪টি কলম তার ভাইকে দিল। এখন মিতার কাছে কতটি কলম আছে?': 'subtract',
    'একটি ঝুড়িতে ৬টি আপেল আছে। ৪টি ঝুড়িতে মোট কতটি আপেল আছে?': 'multiply',
    '২০টি আম ৫ জনের মধ্যে ভাগ করা হলো। প্রত্যেকে কতটি আম পাবে?': 'divide'
};

// Set example problem function
function setExample(problemText) {
    document.getElementById('problem').value = problemText;
    document.getElementById('problem').focus();

    // Hide initial examples section after first use
    const initialExamplesDiv = document.getElementById('initialExamples');
    if (initialExamplesDiv) {
        // initialExamplesDiv.style.display = 'none';
    }

    // Add visual feedback
    const textarea = document.getElementById('problem');
    textarea.style.borderColor = '#4f46e5';
    textarea.style.boxShadow = '0 0 0 3px rgba(79, 70, 229, 0.1)';

    setTimeout(() => {
        textarea.style.borderColor = '';
        textarea.style.boxShadow = '';
    }, 1000);
}

// Show contextual examples after solving
function showContextualExamples(currentProblem) {
    const examplesDiv = document.getElementById('examples');
    const examplesList = document.getElementById('examplesList');

    // Determine the type of current problem
    const currentType = problemTypes[currentProblem.trim()];

    let examples = [];

    if (currentType) {
        // If it's a known example problem, show related examples of the same type
        examples = allExamples[currentType].filter(ex => ex !== currentProblem.trim());

        // If we need more examples, add from other types
        if (examples.length < 3) {
            const otherTypes = Object.keys(allExamples).filter(type => type !== currentType);
            for (let type of otherTypes) {
                if (examples.length >= 3) break;
                const otherExamples = allExamples[type].filter(ex => ex !== currentProblem.trim());
                examples = examples.concat(otherExamples.slice(0, 3 - examples.length));
            }
        }
    } else {
        // For custom problems, show mixed examples
        const allPossibleExamples = Object.values(allExamples).flat();
        examples = allPossibleExamples.filter(ex => ex !== currentProblem.trim()).slice(0, 3);
    }

    let html = '';
    examples.forEach(example => {
        html += `
            <div class="example-btn p-3 bg-gray-50 rounded-md cursor-pointer text-sm border border-gray-200" onclick="setExample('${example}')">
                ${example}
            </div>
        `;
    });

    examplesList.innerHTML = html;
    examplesDiv.classList.remove('hidden');
}

// Enhanced solve function with animations
document.getElementById('solveBtn').addEventListener('click', function() {
    solveProblem();
});

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

            // Scroll to result
            resultDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Show contextual examples
            setTimeout(() => {
                showContextualExamples(problem);
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
        // Re-enable button
        solveBtn.disabled = false;
        solveBtn.innerHTML = 'সমাধান করুন';
    });
}
</script>
</body>
</html>
