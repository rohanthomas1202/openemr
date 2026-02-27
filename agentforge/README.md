# AgentForge AI Healthcare Assistant for OpenEMR

An AI-powered clinical assistant that integrates with OpenEMR's FHIR API to provide intelligent healthcare support.

## Features

- **Patient Summaries** — Aggregates demographics, conditions, medications, allergies, immunizations, and lab results from FHIR
- **Drug Interaction Checking** — Cross-references medications against a clinically-curated interaction database with severity levels
- **Symptom Analysis** — Maps symptoms to potential conditions with ICD-10 codes, urgency levels, and red flags
- **Provider Search** — Find practitioners by name or specialty using NUCC taxonomy codes
- **Appointment Availability** — Check provider schedules and available time slots
- **3-Layer Verification** — Drug safety verification, confidence scoring (0.0–1.0), and hallucination detection
- **Observability** — Token usage tracking, latency metrics, and user feedback collection

## Architecture

- **Backend**: Python/FastAPI with LangGraph agent state machine
- **Frontend**: Streamlit chat UI with verification metadata display
- **LLM**: Claude Sonnet 4 (primary) with GPT-4o fallback
- **Data**: OpenEMR FHIR R4 API with OAuth2 authentication

## Quick Start

### With Docker Compose (Recommended)

From the `openemr/docker/development-easy/` directory:

```bash
docker-compose -f docker-compose.yml -f docker-compose.agentforge.yml up
```

This starts OpenEMR + the AI Assistant on port 8080.

### Standalone

```bash
cd agentforge
pip install -r requirements.txt

# Set environment variables (see .env.example)
export ANTHROPIC_API_KEY=your_key
export OPENEMR_BASE_URL=https://localhost:9300

# Start backend
uvicorn app.main:app --host 0.0.0.0 --port 8000

# Start frontend (separate terminal)
streamlit run frontend/app.py --server.port 8501
```

## OpenEMR Integration

This agent is integrated into OpenEMR as a custom module (`oe-module-agentforge`). Once enabled, it adds an "AI Assistant" menu item under Modules that loads the chat UI in an iframe.

### Module Location
```
openemr/interface/modules/custom_modules/oe-module-agentforge/
```

## Evaluation

57 test cases across 4 categories with 100% pass rate:
- Happy path (25 cases)
- Edge cases (15 cases)
- Adversarial (10 cases)
- Multi-step reasoning (7 cases)

Run evals:
```bash
python -m pytest evals/ -v --tb=short
```

## Deployment

Deployed on Railway with nginx reverse proxy serving both FastAPI (port 8000) and Streamlit (port 8501) behind a single port (8080).
