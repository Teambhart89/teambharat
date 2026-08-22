# seo skill (iannuttall/seo)

Vendored from [iannuttall/seo](https://github.com/iannuttall/seo) at upstream
commit `ec80712`, plugin version `0.2.37`. `SKILL.md` and `agents/openai.yaml`
are unmodified; `LICENSE` is upstream's Apache-2.0 text.

## This skill is a router, not a standalone skill

Unlike the SEO Machine skills in sibling directories, this one does almost
nothing on its own. It teaches the agent how to *discover, describe, and run*
50+ reports that live in the `seo` CLI and its MCP server. Without one of those
two backends present, the skill has nothing to call.

## Backends

**MCP server** — NOT wired up yet. Writing a repo-root `.mcp.json` was blocked
by this environment's permission classifier, so the MCP half of the upstream
plugin is not installed. To add it yourself, either run the packaged installer:

```bash
npm i -g seo
seo mcp install --claude-code
```

or create `.mcp.json` at the repo root by hand:

```json
{ "mcpServers": { "seo": { "command": "npx", "args": ["-y", "seo", "mcp", "serve"] } } }
```

Either way, Claude Code asks you to approve the project-scoped server the first
time the repo is opened. Approving it lets `npx` fetch and run the `seo` package.

**CLI fallback** — the skill checks `command -v seo` and installs it if absent:

```bash
npm i -g seo   # requires Node 22+
seo start      # guided setup: Google sign-in, Search Console property, project
```

The CLI path works when MCP tools are unavailable.

## What needs credentials

Crawl-based reports (`seo report --url`, `site-crawl`, `audit-page`,
`redirect-trace`) run with no sign-in. Everything that reads Search Console,
Google Analytics, Bing, or a research provider (DataForSEO, Semrush, Ahrefs)
needs its own auth, set up via `seo start` or checked with `seo doctor`.

## Upstream install path

Upstream ships this as a Claude Code plugin. The equivalent one-liner install,
which wires the skill and the MCP server together without vendoring, is:

```
/plugin marketplace add iannuttall/seo
/plugin install seo@seo
```

It is vendored here instead so the skill travels with the repo and is available
in web sessions that start from a fresh clone.
