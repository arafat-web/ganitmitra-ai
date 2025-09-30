<div align="center">
  
  <h1>গণিতমিত্র AI (Ganitmitra AI)</h1>
  <p><strong>A small, focused Bengali elementary math solver. It reads a natural-language problem (Bangla), predicts the operation with a lightweight ML model, computes the answer, and shows step‑by‑step reasoning in Bengali.</strong></p>
  
  <p>
    <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
    <img src="https://img.shields.io/github/stars/arafat-web/ganitmitra-ai?style=for-the-badge" alt="Stars">
    <img src="https://img.shields.io/github/issues/arafat-web/ganitmitra-ai?style=for-the-badge" alt="Issues">
    <img src="https://img.shields.io/github/forks/arafat-web/ganitmitra-ai?style=for-the-badge" alt="Forks">
  </p>
  <a href="https://ganitmitraai.arafatdev.com" target="_blank">
    <img src="https://img.shields.io/badge/Live Demo-Visit Now-red?style=for-the-badge&logo=google-chrome&logoColor=white" alt="Ganitmitra AI Live Demo">
  </a>
</div>

## What’s inside (at a glance)

- Web UI (web/): Tailwind CSS + vanilla JS front‑end
- API endpoints:
  - web/solver.php (POST) — solve a problem
  - web/generate.php (GET) — sample problems from dataset.csv
- Core logic (PHP):
  - trainer.php — trains a Rubix ML text classifier
  - solver.php — loads the model, predicts operation, extracts numbers, computes result, builds steps
  - helpers.php — normalization, digit conversion, number extraction
  - result.php — Bengali step rendering

## Requirements

- PHP 8.0+
- Composer
- A local server (Laragon/XAMPP) or PHP’s built‑in server

## Install

1. Clone and install dependencies

```
git clone https://github.com/arafat-web/ganitmitra-ai.git
cd ganitmitra-ai
composer install
```

2. Prepare dataset

- Place your datasets (CSV) in the project root.
- Used by this repo:
  - dataset.csv — used by web/generate.php to show example problems
  - dataset_new.csv — used by trainer.php to train the model

Tip: Keep one canonical dataset if you prefer (adjust scripts accordingly).

## Train the ML model

```
php trainer.php
```

- Produces bengali_math_model.dat on success (saved when quick check accuracy > 90%).
- Trainer prints a short report (classes found, quick accuracy check).

## Run locally

Option A — with Laragon/XAMPP: place the project under your web root and visit /web/

Option B — PHP built‑in server:

```
cd web
php -S localhost:8000
```

Open http://localhost:8000 in your browser.

## Use the API directly

POST a Bangla problem to the solver endpoint:

```
curl -X POST \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "problem=রাহিমের কাছে ৫টি আম আছে। করিম তাকে ৩টি আম দিল। এখন তার কাছে কতটি আম?" \
  http://localhost:8000/solver.php
```

Example JSON response (trimmed):

```
{
  "success": true,
  "problem": "...",
  "bengali_answer": "৮",
  "steps": ["..."],
  "method": "ml_model"
}
```

## How it works (ML)

- Feature extraction: WordCountVectorizer(1000, 2) + TfIdfTransformer
- Classifier: RandomForest (100 estimators)
- Label space (operations): add, subtract, multiply, divide, divide_ceil, multi_step
- Runtime flow (solver.php):
  1. Extract numeric values from text (supports Bengali digits, decimals)
  2. Predict operation class with the trained model
  3. Compute result for that operation
  4. Build human‑friendly Bengali steps

Frontend (web/index.php):

- Clean, mobile‑friendly UI (Tailwind CDN + Font Awesome)
- Enter key triggers solve; Ctrl/Shift+Enter adds a newline
- Shows step‑by‑step solution and a bold Bengali answer
- Loads fresh example problems from generate.php after each solve

## Project layout

```
ganitmitra-ai/
├─ web/
│  ├─ index.php           # UI (Tailwind CDN, Font Awesome), calls web/solver.php
│  ├─ solver.php          # JSON endpoint for solving
│  ├─ generate.php        # Returns random problems from dataset.csv
│  └─ style.css           # Bengali font + small UI polish
├─ trainer.php            # Trains and saves bengali_math_model.dat
├─ solver.php             # ML-based solver (loads model, predicts op, computes)
├─ helpers.php            # Text normalization, number extraction/conversion
├─ result.php             # Builds Bengali step-by-step explanations
├─ dataset.csv            # Example problems for UI suggestions
├─ dataset_new.csv        # Training data for trainer.php
├─ bengali_math_model.dat # Saved model (created after training)
└─ composer.json
```

## Dependencies (Composer)

- rubix/ml (^2.5) — ML pipeline, training, and inference
- league/csv (9.24.1) — CSV utilities (e.g., generate/show dataset)
- mpdf/mpdf (^8.0) — Included for potential PDF export (not used in core flow yet)

## Customize and extend (ML)

- Add more labeled examples to dataset_new.csv for operations that underperform
- Tweak vectorizer size or n‑grams in trainer.php
- Try different classifiers (e.g., Naive Bayes, SVC) in trainer.php
- Unify dataset usage (adjust generate.php or trainer.php to the same CSV)

## Troubleshooting

- Model file not found
  - Run `php trainer.php` to generate `bengali_math_model.dat`.
- Low accuracy
  - Enrich and balance `dataset_new.csv`; increase vectorizer vocab; try another classifier.
- JSON parse error in UI
  - Check `web/solver.php` logs; ensure no PHP warnings leak into JSON (buffering+headers are set).
- Mixed dataset files
  - Remember `web/generate.php` uses `dataset.csv` while `trainer.php` uses `dataset_new.csv`.
- Rubix ML errors you may see

  - "Regressors require continuous labels, categorical given" → use a classifier (you already do) or ensure labels are strings for classification.
  - `Class "Rubix\ML\Classifiers\GradientBoostedTrees" not found` → install a Rubix version that contains it or use available classifiers (e.g., RandomForest).

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

For issues and feature requests, use [GitHub Issues](https://github.com/arafat-web/ganitmitra-ai/issues).

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Connect with me

<div align="center">
  
[![Email](https://img.shields.io/badge/Gmail-D14836?style=for-the-badge&logo=gmail&logoColor=white)](mailto:arafat.122260@gmail.com)
[![Facebook](https://img.shields.io/badge/Facebook-1877F2?style=for-the-badge&logo=facebook&logoColor=white)](https://www.facebook.com/arafathossain000)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/arafat-hossain-ar-a174b51a6/)
[![Website](https://img.shields.io/badge/website-000000?style=for-the-badge&logo=About.me&logoColor=white)](https://arafatdev.com)

</div>
