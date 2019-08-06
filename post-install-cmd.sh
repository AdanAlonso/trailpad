#!/bin/sh
if [ -n "$DYNO" ]  && [ -n "$ENV" ]; then
  composer install
  php yii migrate/up --interactive=0
fi