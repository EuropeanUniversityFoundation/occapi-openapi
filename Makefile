include .env

REDOCROOT=$(shell pwd)

bundle:
		@docker run --rm \
				--user $(shell id -u):$(shell id -g) \
				-v ${REDOCROOT}:/spec \
				redocly/cli bundle --dereferenced ${DEFINITION} \
				--output $(BUNDLE)

lint:
		@docker run --rm \
				-v $(shell pwd):/spec \
				redocly/cli lint ${DEFINITION}
