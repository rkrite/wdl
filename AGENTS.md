# AGENTS.md - WDL (Wordle Cheater) Project Guide

Welcome, Agent. This document provides a high-level overview of the WDL project's architecture, components, and data flow to help you navigate and modify the codebase effectively.

---

## 1. Project Overview
**WDL** is a Laravel-based Wordle assistant. It allows users to input their guesses and the resulting "clues" (Green/Yellow/Black) to receive a list of matching 5-letter words from a database.

### Tech Stack
- **Backend**: Laravel 9.x, PHP 8.x
- **Frontend**: Blade, Bootstrap 5, jQuery, Custom CSS/JS
- **Database**: MySQL (optimized with character-specific columns)

---

## 2. Core Components (The Agents)

### [WordController](file:///home/ronny/web/wdl/app/Http/Controllers/WordController.php)
The central logic engine of the application.
- `show()`: Retrieves the current state from the session, builds a complex raw SQL query based on clues, and renders the view.
- `enter()`: Processes the form submission, parses the 6x5 grid of letters and states, and updates the session.
- `clear()`: Resets the session state.

### [helpers.php](file:///home/ronny/web/wdl/app/helpers.php)
A collection of global utility functions used throughout the app.
- `GGetWordMap()` / `GSetWordMap()` / `GClearWordMap()`: Manage the session-based state of current Wordle attempts.
- `GExecSqlRaw()`: Executes raw SQL queries (used by `WordController`).
- `GPutSession()` / `GGetSession()`: Wrappers for Laravel's session helper.

### [Word Model](file:///home/ronny/web/wdl/app/Models/Word.php)
A simple Eloquent model representing the `words` table. 
- Note: Most queries bypass Eloquent and use raw SQL via `DB::select` for performance/complexity reasons.

### [show.blade.php](file:///home/ronny/web/wdl/resources/views/show.blade.php)
The main UI template.
- **Interactivity**: Embedded jQuery handles:
    - Clicking a cell to cycle through states: Gray (`x`), Yellow (`y`), Green (`g`).
    - Auto-focusing the next input field as the user types.
- **Data Display**: Renders the 6x5 input grid and the list of "found words".

---

## 3. Data Flow

1. **Input Phase**: User enters letters and clicks cells to set colors in `show.blade.php`.
2. **Persistence**: Form POSTs to `/enter`, where `WordController@enter` maps the grid into a structured array and stores it in the PHP session using `GSetWordMap`.
3. **Filtering**: `WordController@show` reads the session, iterates through the guesses, and builds a series of `WHERE` clauses for a SQL query.
4. **Execution**: `GExecSqlRaw` runs the query against the `words` table.
5. **Output**: Results are passed back to the Blade view and displayed.

---

## 4. Database Schema: `words` Table

| Column | Type | Description |
| :--- | :--- | :--- |
| `word` | `VARCHAR(5)` | The full 5-letter word. |
| `c01` - `c05` | `CHAR(1)` | Individual characters at each position (for fast filtering). |

---

## 5. Development Guidelines for AI Agents

- **Raw SQL**: The filtering logic relies heavily on raw SQL string concatenation. Be extremely careful when modifying this to avoid syntax errors or injection vulnerabilities (though it's currently internal/clue-based).
- **Session State**: The "Current State" is purely session-based. If you need to debug filtering, check the session data structure in `WordController@show`.
- **CSS/JS**: Styling is a mix of Bootstrap 5 and custom rules in `public/css/custom.css`. Interactivity is in `show.blade.php` scripts.
- **Helpers**: Always use the `G`-prefixed helpers in `app/helpers.php` for consistency when dealing with configuration or session data.

---
*Created by Antigravity AI*
