# PhpMobMediaBundle

## Phpcr Filesystem

```yaml
# app/config/config.yml
imports:
    ...
    - { resource: "@PhpMobMediaBundle/Resources/config/app/main.yml" }
    - { resource: "@PhpMobMediaBundle/Resources/config/app/phpcr.yml" }

# override connection -- MUST be after `imports` phpcr.yml
# phpcr need to be utf8 connection
parameters:
    phpmob.flysystem.phpcr.connection: media

```
