This is an **example** API to demonstrate features of the Open Course Catalogue API specification.

# Introduction

The **Open Course Catalogue API** specification aims to standardize the way in which Higher Education Institutions expose their course catalogues in a machine-readable format.

By facilitating access to their course catalogues, Institutions can allow consumer applications to implement user friendly ways for prospective students to explore course offers.

## UPDATE July 2025

In June 2025 it was decided that OCCAPI would become an [Erasmus Without Paper](https://developers.erasmuswithoutpaper.eu/) API in the course of the academic year 2025/2026. A [new version](https://github.com/EuropeanUniversityFoundation/occapi-openapi/issues/34) of the OCCAPI specification is being developed for this purpose, reflecting the findings shared by the universities that have deployed OCCAPI servers until this point in time.

While the changes are expected to be limited it is likely that **the new OCCAPI version will not be backwards compatible**. If you are currently in the process of implementing OCCAPI please feel free to get in touch so we can share more details and support the planning of your deployment process.

## Overview

The Open Course Catalogue specification was heavily inspired by the [Erasmus Without Paper](https://www.erasmuswithoutpaper.eu/) API specifications and attempts to follow most of its conventions. However, this API specification differs from other EWP APIs by adopting the [JSON:API](https://jsonapi.org/) format following industry trends.

OCCAPI places an emphasis on exposing curricular structure and adopting existing classification standards, such as the **European Qualifications Framework (EQF)** and the **International Standard Classification for Education (ISCED)**.

_UPDATE July 2025:_ OCCAPI v2 will bring greater alignment with the **European Learning Model (ELM)**, in particular at the level of controlled vocabularies.

## Comparison with other standards and specifications

For a better understanding of existing data standards and API specifications, we suggest consulting the outputs of ongoing projects focused on course catalogues and digital interoperability, such as [DACEM](https://projects.uni-foundation.eu/dacem/) and [QualityLink](https://quality-link.eu/project-outputs/).

## Contributions

We welcome contributions from the community at our [GitHub issue queue](https://github.com/EuropeanUniversityFoundation/occapi-openapi/issues).
