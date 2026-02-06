# TaskManager

## Opis projektu

**TaskManager** to przykładowa aplikacja backendowa napisana w **Symfony**, zbudowana w oparciu o **Domain‑Driven Design (DDD)**. Projekt został zrealizowany jako zadanie techniczne i skupia się na poprawnej architekturze, czytelnej separacji warstw oraz świadomym użyciu wzorców projektowych.

Zakres projektu jest **celowo ograniczony** do wymagań zadania — bez overengineeringu, bez funkcji wykraczających poza specyfikację.

---

## Technologie

* PHP 8.x
* Symfony
* Doctrine ORM
* Symfony Messenger (sync)
* PostgreSQL
* Composer

---

## Architektura

Projekt wykorzystuje **DDD / Clean Architecture** z wyraźnym podziałem na warstwy:

```
src/
├── Domain
├── Application
├── Infrastructure
└── Kernel.php
```

### Domain

Odpowiada za model domenowy:

* Aggregate Roots: `User`, `Task`
* Value Objects / Enumy: `UserId`, `TaskId`, `TaskStatus`
* Domain Events: `TaskCreatedEvent`, `TaskStatusUpdatedEvent`
* Kontrakty repozytoriów

**Domain nie zna** Symfony, Doctrine ani HTTP.

---

### Application

Zawiera logikę aplikacyjną i scenariusze użycia:

* Use Case’y (`CreateTask`, `ChangeTaskStatus`, `ListUserTasks`, `ListAllTasks`, `ImportUsersFromApi`)
* DTO (np. `TaskReadDto`, `ImportedUserDto`)
* Orkiestrację zdarzeń domenowych

Application **zna Domain**, ale nie zna infrastruktury technicznej.

---

### Infrastructure

Warstwa techniczna:

* Doctrine (encje, repozytoria)
* HTTP Controllers (REST API)
* Integracja z JSONPlaceholder
* Symfony Messenger + Event Store

Infrastructure **implementuje kontrakty** z Domain i Application.

---

## Zależności warstw

```
Domain        ← nic
Application   → Domain
Infrastructure→ Application + Domain
```

---

## Zrealizowane wymagania zadania

* ✅ Architektura DDD
* ✅ User aggregate
* ✅ Import użytkowników z JSONPlaceholder
* ✅ Task aggregate
* ✅ Event Sourcing (minimalny, Messenger sync)
* ✅ REST API dla Task
* ✅ Factory Pattern (DomainEventFactory)
* ✅ Strategy Pattern (zmiana statusu, listowanie zadań)

---

## REST API

### Task

Dostępne endpointy:

* `POST /api/tasks` — tworzenie zadania
* `PATCH /api/tasks/{taskId}/status` — zmiana statusu
* `GET /api/tasks` — lista zadań aktualnego użytkownika
* `GET /api/admin/tasks` — lista wszystkich zadań

API Task jest **cienką warstwą HTTP** nad istniejącymi use case’ami.

### Users (Import)

* `POST /api/admin/users/import` — import użytkowników z JSONPlaceholder

Endpoint wywołuje use case `ImportUsersFromApi` i zwraca:

```json
{ "imported": 10 }
```

---

## Auth (uproszczony)

Projekt **nie używa Symfony Security**.

* Id użytkownika pobierane z nagłówka `X-USER-ID`
* Fallback: pierwszy użytkownik w bazie

Rozwiązanie jest **celowo uproszczone** i służy wyłącznie do spełnienia wymagań zadania testowego.

---

## Event Sourcing

* Zdarzenia domenowe: `TaskCreatedEvent`, `TaskStatusUpdatedEvent`
* Dispatch przez Symfony Messenger (sync)
* Event Store w bazie danych

Świadomie **nie zaimplementowano**:

* CQRS
* projections / read models
* replay zdarzeń
* async queues

---

## Jak uruchomić projekt lokalnie

1. Klonowanie repozytorium

```bash
git clone <repo-url>
cd task-manager
```

2. Instalacja zależności

```bash
composer install
```

3. Konfiguracja środowiska

```bash
cp .env.example .env
# uzupełnij dane bazy PostgreSQL
```

4. Migracje bazy danych

```bash
php bin/console doctrine:migrations:migrate
```

5. Uruchomienie serwera

```bash
symfony server:start
```

---

## Świadome ograniczenia

* brak testów automatycznych
* brak paginacji i filtrów w API
* brak pełnego mechanizmu auth
* brak rozbudowanego Event Sourcing

Wszystkie powyższe punkty są **świadomymi decyzjami projektowymi**, zgodnymi ze scope zadania.

---

## Status

Projekt:

* jest uruchamialny
* spełnia wymagania zadania
* posiada czytelną architekturę
* jest gotowy do oceny technicznej
