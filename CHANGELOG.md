# Changelog

This changelog covers only the two most recent published GitHub releases. Each entry describes changes included in the corresponding tagged release, not later changes on the `master` branch.

## 1.4.5 - 2026-10-19

### Fixed

- Fixed dark mode preference resolution for anonymous visitors, guest users, and authenticated users (issue #56). Visitors use the `darkmode` cookie, while authenticated users use their saved Moodle user preference.
- Removed the incomplete automatic dark mode behavior that could leave parts of the interface inconsistently themed. Only explicit `light` and `dark` values are supported; legacy `auto` and invalid values fall back to `light`.
- Centralized preference resolution in `local_boost_dark\darkmode_preference` and updated the HTML theme attributes to use the resolved preference.
- Validated the requested mode before saving it; visitor cookies now include an expiration time, an applicable path, a secure flag for HTTPS sites, `HttpOnly`, and `SameSite=Lax`.

### Changed

- Removed unused automatic-mode rules from the SCSS sources and generated CSS.
- Replaced the plugin's SVG icon with a PNG image.
- Updated the existing GitHub release workflow with concurrency configuration.
- Corrected PHP namespace usage and file headers as part of the issue #56 follow-up.

### Tests

- Added PHPUnit regression tests for `light`/`dark` normalization, invalid and legacy `auto` preferences, anonymous and guest cookie handling, and authenticated users' saved preferences.

[Compare 1.4.4...1.4.5](https://github.com/EduardoKrausME/moodle-local_boost_dark/compare/1.4.4...1.4.5)

## 1.4.4 - 2026-10-15

### Release metadata

- Updated the root plugin build number from `2026101500` to `2026101501` and the release identifier from `1.4.3` to `1.4.4`.
- No functional code changes were included between the published `1.4.3` and `1.4.4` tags.

[Compare 1.4.3...1.4.4](https://github.com/EduardoKrausME/moodle-local_boost_dark/compare/1.4.3...1.4.4)
