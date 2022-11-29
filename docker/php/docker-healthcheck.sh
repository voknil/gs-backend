#!/bin/sh
set -e

if env -i bin/console -V; then
	exit 0
fi

exit 1
