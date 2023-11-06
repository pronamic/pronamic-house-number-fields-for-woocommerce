# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.0] - 2023-11-06

### New

- Renamed plugin "WooCommerce House Number" to "Pronamic House Number Fields for WooCommerce".
- Added house number field visibility settings to Customizer.
- Added support for WooCommerce HPOS.
- Modernized code.

### Commits

- Set `autocomplete="off"` (fixes #6). ([fe48326](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/fe483265792030c161b33fe06f3048373295a065))
- Added minified CSS and only load on checkout. ([51b1cef](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/51b1cef642dbd54ab1495718b4d84e966d422067))
- Improve styling if house number addition field is hidden. ([f9c7e36](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/f9c7e36801977a50b09c2605ac327a938dfc67d4))
- wip ([140847b](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/140847b0cf142258cee05deb2c26d6b8f97d5199))
- Change 'extra' to 'addition'. ([da940e8](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/da940e8a5b3534377c59f5eb29169bb19d352959))
- Added title. ([42a5bdd](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/42a5bddc1f48f3f2e61caec655b0aeb82026a141))
- Switch to box-sizing: border-box;. ([48c6b22](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/48c6b22f6688c27b6a1be5428efb023d27143dbd))
- Improve styling. ([5181b87](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/5181b87ed741aad4123b92fcd45e51a7a40e53d5))
- Updated translations. ([7f9ac9b](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/7f9ac9b25f0519740ea130312aba4e352f80996a))
- Updated Plugin.php ([4738223](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/47382235c96692fe5016a8e9d90e97d2c3052685))
- At this point the data is already cleaned. ([39e0326](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/39e03265261fc82eb000aa8a1ed38756627e2334))
- Plugin should now be HPOS ready. ([0fbf9cf](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/0fbf9cff0f5ed538f31341bb0f6de6f97a7fc617))
- FQN. ([0f35432](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/0f35432d3cff6bfdcb5f39f20ddcb298807b454e))
- Updated Plugin.php ([59ef737](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/59ef7372aadfb2683f2783e95fe86771212f41a1))
- No longer use `update_post_meta` for HPOS compat. ([fb105d2](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/fb105d209b8c1d34b09ccdff424df194e039dec3))
- This plugin should not disable address line 2, customizer can be used for this. ([29b7fb0](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/29b7fb0b50f1a6452b35531f76b0b101c9c738c8))
- Updated Plugin.php ([038f587](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/038f587993a65d5dfa06c03069a94250b32dc970))
- Short array syntax. ([c5933f0](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/c5933f08a8f91247827436f39d38a72aea5521e2))
- Fixed PHPCS warnings. ([ebda5ee](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/ebda5eea72129c600ceb250590955f93f59ff2d5))
- phpcbf ([5a097ce](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/5a097ce08f26e494aa61c8eed47cbdb61af087e3))
- Updated Plugin.php ([9b1b240](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/9b1b240b9c84d3d22c042a5c963b55c136bdbccc))
- Updated Plugin.php ([5f85e11](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/5f85e112dd8cd366ec940832acaac471bb7ad2e5))
- Updated pronamic-house-number-fields-for-woocommerce.php ([4a6c3fe](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/4a6c3fede4a1fc4e53e2aa6b9916b10d4e671763))
- Updated Plugin.php ([28d8fe4](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/28d8fe4970617cc6d4ac2335513295eda1878085))
- Updated .wp-env.json ([23d2f2a](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/23d2f2ac34edd3753f667b64a204964ccd111c0d))
- Updated pronamic-house-number-fields-for-woocommerce.php ([4fc6cf5](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/4fc6cf584ad3e4c6c3338f377e45f6aee893d126))
- Modernize library. ([14de06f](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/14de06f4b0a1710d398bb239bedae0eb1646a450))
- Rename plugin, closes #3. ([90f23fc](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/90f23fcede134a6973c27580bd6f96310513165f))
- Removed Eclipse project files. ([6f13a2b](https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/commit/6f13a2bf3987caaabe38e0e2c3bc7d920eb1e323))

Full set of changes: [`1.0.0...2.0.0`][2.0.0]

[2.0.0]: https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce_/compare/v1.0.0...v2.0.0

## [1.0.0] - 2023-06-30

- First release.

[unreleased]: https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/pronamic/pronamic-house-number-fields-for-woocommerce/releases/tag/v1.0.0
