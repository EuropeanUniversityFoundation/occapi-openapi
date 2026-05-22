# OCCAPI OpenAPI definition & demo

This repository contains the OpenAPI specification for the **Open Course Catalogue API** along with a working demo for development reference.

## Issues

Use the [issue queue](https://github.com/EuropeanUniversityFoundation/occapi-openapi/issues) to report any issues or questions related to the specification.

Pull requests will be considered when concerning the contents of the `openapi/v2/components` directory.

_Pull requests concerning the build tools are discouraged._

---

## Quickstart

    # Clone the repository
    git clone git@github.com:EuropeanUniversityFoundation/occapi-openapi.git
    # Create an environment file
    cp .env.example .env
    # Review parameters: DEFINITION, BUNDLE
    nano .env
    # Validate the specification
    make lint
    # Bundle the specification
    make bundle


---

## Stack

Built with [Redocly CLI](https://redocly.com/docs/cli) and [Slim - a micro framework for PHP](https://www.slimframework.com/).
