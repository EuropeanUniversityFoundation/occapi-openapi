# OCCAPI OpenAPI definition & demo

This repository contains the OpenAPI specification for the **Open Course Catalogue API** along with a working demo for development reference.

## Issues

Use the [issue queue](https://github.com/EuropeanUniversityFoundation/occapi-openapi/issues) to report any issues or questions related to the specification.

Pull requests will be considered when concerning the contents of the `openapi/components` directory.

_Pull requests concerning the build tools are discouraged._

---

## Quickstart

    # Clone the repository
    git clone git@github.com:EuropeanUniversityFoundation/occapi-openapi.git
    # Create an environment file
    cp .env.example .env
    # Review parameters: HTTP_PORT, NODE_PORT and BUILD_PROD
    nano .env
    # Start the containers
    make up
    # Access the NodeJS container
    make shell node
    # Start watching for changes to the OpenAPI specs
    npm start
    # Build into openapi_occapi_v1.yaml
    npm run build

### Preview DEV vs Preview PROD

When `npm start` is executed, a web server serves the DEV version of ReDoc, available at `http://PROJECT_BASE_URL:3000` (or whatever `NODE_PORT` is defined).

When `npm run build` is executed, a copy of the `openapi_occapi_v1.yaml` is placed inside the `public` and included in the PROD version, which is always available at `http://PROJECT_BASE_URL:8000` (or whatever `HTTP_PORT` is defined).

### Build DEV vs Build PROD

The `postbuild.sh` is responsible for processing the demo files located in the `data` directory and the specification located in the `public` directory. It reads the `BUILD_PROD` environment variable, which if set to `true` will trigger a URL substitution to overwrite all relevant entries with the production URL; otherwise it falls back to the `PROJECT_BASE_URL`.

These changes are only visible when previewing the ReDoc via nginx (on `HTTP_PORT`).

## Stack

### Build

_Clone of [OpenAPI Definition Starter](https://github.com/Redocly/openapi-starter)._

### Preview

Built with [Slim - a micro framework for PHP](https://www.slimframework.com/).

Based on [this tutorial](https://odan.github.io/2019/11/05/slim4-tutorial.html).

---

# OpenAPI Definition Starter

## Working on your OpenAPI Definition

### Install

1. Install [Node JS](https://nodejs.org/).
2. Clone this repo and run `npm install` in the repo root.

### Usage

#### `npm start`
Starts the reference docs preview server.

#### `npm run build`
Bundles the definition to the dist folder.

#### `npm test`
Validates the definition.

## Contribution Guide

Below is a sample contribution guide. The tools
in the repository don't restrict you to any
specific structure. Adjust the contribution guide
to match your own structure. However, if you
don't have a structure in mind, this is a
good place to start.

Update this contribution guide if you
adjust the file/folder organization.

The `.redocly.yaml` controls settings for various
tools including the lint tool and the reference
docs engine.  Open it to find examples and
[read the docs](https://redoc.ly/docs/cli/configuration/)
for more information.


### Schemas

#### Adding Schemas

1. Navigate to the `openapi/components/schemas` folder.
2. Add a file named as you wish to name the schema.
3. Define the schema.
4. Refer to the schema using the `$ref` (see example below).

##### Example Schema
This is a very simple schema example:
```yaml
type: string
description: The resource ID. Defaults to UUID v4
maxLength: 50
example: 4f6cf35x-2c4y-483z-a0a9-158621f77a21
```
This is a more complex schema example:
```yaml
type: object
properties:
  id:
    description: The customer identifier string
    readOnly: true
    allOf:
      - $ref: ./ResourceId.yaml
  websiteId:
    description: The website's ID
    allOf:
      - $ref: ./ResourceId.yaml
  paymentToken:
    type: string
    writeOnly: true
    description: |
      A write-only payment token; if supplied, it will be converted into a
      payment instrument and be set as the `defaultPaymentInstrument`. The
      value of this property will override the `defaultPaymentInstrument`
      in the case that both are supplied. The token may only be used once
      before it is expired.
  defaultPaymentInstrument:
    $ref: ./PaymentInstrument.yaml
  createdTime:
    description: The customer created time
    allOf:
      - $ref: ./ServerTimestamp.yaml
  updatedTime:
    description: The customer updated time
    allOf:
      - $ref: ./ServerTimestamp.yaml
  tags:
    description: A list of customer's tags
    readOnly: true
    type: array
    items:
      $ref: ./Tags/Tag.yaml
  revision:
    description: >
      The number of times the customer data has been modified.

      The revision is useful when analyzing webhook data to determine if the
      change takes precedence over the current representation.
    type: integer
    readOnly: true
  _links:
    type: array
    description: The links related to resource
    readOnly: true
    minItems: 3
    items:
      anyOf:
        - $ref: ./Links/SelfLink.yaml
        - $ref: ./Links/NotesLink.yaml
        - $ref: ./Links/DefaultPaymentInstrumentLink.yaml
        - $ref: ./Links/LeadSourceLink.yaml
        - $ref: ./Links/WebsiteLink.yaml
  _embedded:
    type: array
    description: >-
      Any embedded objects available that are requested by the `expand`
      querystring parameter.
    readOnly: true
    minItems: 1
    items:
      anyOf:
        - $ref: ./Embeds/LeadSourceEmbed.yaml

```

##### Using the `$ref`

Notice in the complex example above the schema definition itself has `$ref` links to other schemas defined.

Here is a small excerpt with an example:

```yaml
defaultPaymentInstrument:
  $ref: ./PaymentInstrument.yaml
```

The value of the `$ref` is the path to the other schema definition.

You may use `$ref`s to compose schema from other existing schema to avoid duplication.

You will use `$ref`s to reference schema from your path definitions.

#### Editing Schemas

1. Navigate to the `openapi/components/schemas` folder.
2. Open the file you wish to edit.
3. Edit.

### Paths

#### Adding a Path

1. Navigate to the `openapi/paths` folder.
2. Add a new YAML file named like your URL endpoint except replacing `/` with `@` and putting path parameters into curly braces like `{example}`.
3. Add the path and a ref to it inside of your `openapi.yaml` file inside of the `openapi` folder.

Example addition to the `openapi.yaml` file:
```yaml
'/customers/{id}':
  $ref: './paths/customers@{id}.yaml'
```

Here is an example of a YAML file named `customers@{id}.yaml` in the `paths` folder:

```yaml
get:
  tags:
    - Customers
  summary: Retrieve a list of customers
  operationId: GetCustomerCollection
  description: |
    You can have a markdown description here.
  parameters:
    - $ref: ../components/parameters/collectionLimit.yaml
    - $ref: ../components/parameters/collectionOffset.yaml
    - $ref: ../components/parameters/collectionFilter.yaml
    - $ref: ../components/parameters/collectionQuery.yaml
    - $ref: ../components/parameters/collectionExpand.yaml
    - $ref: ../components/parameters/collectionFields.yaml
  responses:
    '200':
      description: A list of Customers was retrieved successfully
      headers:
        Rate-Limit-Limit:
          $ref: ../components/headers/Rate-Limit-Limit.yaml
        Rate-Limit-Remaining:
          $ref: ../components/headers/Rate-Limit-Remaining.yaml
        Rate-Limit-Reset:
          $ref: ../components/headers/Rate-Limit-Reset.yaml
        Pagination-Total:
          $ref: ../components/headers/Pagination-Total.yaml
        Pagination-Limit:
          $ref: ../components/headers/Pagination-Limit.yaml
        Pagination-Offset:
          $ref: ../components/headers/Pagination-Offset.yaml
      content:
        application/json:
          schema:
            type: array
            items:
              $ref: ../components/schemas/Customer.yaml
        text/csv:
          schema:
            type: array
            items:
              $ref: ../components/schemas/Customer.yaml
    '401':
      $ref: ../components/responses/AccessForbidden.yaml
  x-code-samples:
    - lang: PHP
      source:
        $ref: ../code_samples/PHP/customers/get.php
post:
  tags:
    - Customers
  summary: Create a customer (without an ID)
  operationId: PostCustomer
  description: Another markdown description here.
  requestBody:
    $ref: ../components/requestBodies/Customer.yaml
  responses:
    '201':
      $ref: ../components/responses/Customer.yaml
    '401':
      $ref: ../components/responses/AccessForbidden.yaml
    '409':
      $ref: ../components/responses/Conflict.yaml
    '422':
      $ref: ../components/responses/InvalidDataError.yaml
  x-code-samples:
    - lang: PHP
      source:
        $ref: ../code_samples/PHP/customers/post.php
```

You'll see extensive usage of `$ref`s in this example to different types of components including schemas.

You'll also notice `$ref`s to code samples.

### Code samples

1. Navigate to the `openapi/code_samples` folder.
2. Navigate to the `<language>` (e.g. PHP) sub-folder.
3. Navigate to the `path` folder, and add ref to the code sample.

You can add languages by adding new folders at the appropriate path level.

More details inside the `code_samples` folder README.
