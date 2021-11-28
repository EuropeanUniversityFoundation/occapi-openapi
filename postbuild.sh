#!/bin/bash
cp -f openapi_occapi_v1.yaml public/

source .env

EXAMPLE_URL="http://example.com"
PROD_URL="https://"${PROD_BASE_URL}
DEV_URL="http://"${PROJECT_BASE_URL}":"${HTTP_PORT}

SPEC_FILE="./public/openapi_occapi_v1.yaml"

echo -e ${BUILD_PROD}

if [ ${BUILD_PROD} = true ]; then
  echo -e "Replacing URLs in public files with production URL..."
  find ./data/v1 -name index.json -exec sed -i -e "s,${DEV_URL},${PROD_URL},g" {} \;
  sed -i -e "s,${EXAMPLE_URL},${PROD_URL},g" ${SPEC_FILE}
  sed -i -e "s,${DEV_URL},${PROD_URL},g" ${SPEC_FILE}
else
  echo -e "Replacing URLs in public files with development URL..."
  find ./data/v1 -name index.json -exec sed -i -e "s,${PROD_URL},${DEV_URL},g" {} \;
  sed -i -e "s,${EXAMPLE_URL},${DEV_URL},g" ${SPEC_FILE}
  sed -i -e "s,${PROD_URL},${DEV_URL},g" ${SPEC_FILE}
fi
