#!/usr/bin/env bash

echo "pre commit hook start"

CURRENT_DIRECTORY=`pwd`
GIT_HOOKS_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

PROJECT_DIRECTORY="$GIT_HOOKS_DIR/../.."

cd $PROJECT_DIRECTORY;
PHP_CS_FIXER="vendor/bin/php-cs-fixer"

HAS_PHP_CS_FIXER=false

if [ -x "$PHP_CS_FIXER" ]; then
    HAS_PHP_CS_FIXER=true
fi

if $HAS_PHP_CS_FIXER; then
    git status --porcelain | grep -e '^[AM]\(.*\).php$' | cut -c 3- | while read line; do
        ${PHP_CS_FIXER} fix --verbose ${line};
        git add "$line"; 
    done
else
    echo ""
    echo "Please install php-cs-fixer, e.g.:"
    echo ""
    echo "  composer update --dev"
    echo ""
fi

cd $CURRENT_DIRECTORY;
echo "pre commit hook finish"

