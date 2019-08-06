#!/bin/sh
if [ -n "$DYNO" ]  && [ -n "$ENV" ]; then
  php yii migrate/up --interactive=0
fi