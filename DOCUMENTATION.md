# WDL – Laravel Wordle Cheater

A Laravel 9.52.20 web app that suggests possible Wordle answers based on the letters and colours you input.

---

## 1. Overview
WDL filters a five-letter word list against Wordle clues (green = correct letter & position, yellow = correct letter wrong position, black = excluded).  
It’s a simple fun tool to help or “cheat” at Wordle.

---

## 2. Setup

```bash
git clone https://github.com/rkrite/wdl.git
cd wdl
cp .env.example .env     # edit DB credentials
composer install
php artisan key:generate
php artisan migrate
mysql -u user -p wdl < words-data.sql
npm install
npm run dev
php artisan serve
```
Visit `http://localhost:8000`.

---

## 3. Usage
* Enter letters into each cell to match your Wordle attempt.
* Click each block to cycle black/yellow/green.
* Press **Enter** to display matching words.
* Press **Clear** to reset.

---

## 4. Project Structure
* **app/** – Laravel controllers & models  
* **resources/views/** – Blade templates, Bootstrap CSS  
* **routes/web.php** – Main route definitions  
* **database/migrations/** – Database schema  
* **words-data.sql** – Full 5-letter word list  

---

## 5. Architecture
* Single-page form posts to a controller that queries the words table.
* Filtering logic applies colour constraints to return matches.
* Bootstrap handles styling; minimal JS toggles cell states.

---

## 6. Extending the App
* Improve UI/UX (auto-filter as letters typed).
* Add tests for filter logic.
* Provide an API endpoint for external clients.
* Enhance mobile responsiveness.
* Update word list via `words-data.sql`.

---

## 7. Development Tips
* Follow PSR-4 naming in app/.
* Use `php artisan tinker` to experiment with queries.
* Cache queries if scaling to large lists.

---

## 8. License
MIT (or your preferred license – currently none specified).
