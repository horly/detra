# Visuels

Les prompts et les fichiers des quatre nouvelles illustrations sont décrits dans [additional-visual-assets.md](additional-visual-assets.md).

Les versions `.webp` du logo et des sept illustrations sont les assets servis par le site. Elles sont générées sans recadrage à partir des PNG avec `scripts/optimize-images.php` (PHP GD, qualité 86). Les originaux sont conservés. La police Manrope est intégrée localement depuis `resources/fonts/`.

Les deux autres illustrations, également générées avec l’outil intégré, sont conservées dans `public/images/storage-terminal.png` et `public/images/logistics.png`. Elles ne représentent pas des installations ou véhicules appartenant à DETRA.

Prompt du terminal : Photorealistic editorial industrial photograph for a sophisticated petroleum import-export corporate website. Wide landscape 3:2. Aerial three-quarter close view of a clean petroleum storage terminal, several large cylindrical white and pale silver floating roof tanks, precise geometric steel piping and service roads, subtle trees at far edge, soft warm afternoon light. Muted cream, warm gray and deep olive tones, natural fine detail, tasteful restrained cinematic color grade. Architecture and infrastructure photography, no people, no text, no logos, no watermarks. Fictional facility used as an editorial illustration, no identifiable real company.

Prompt de la logistique : Premium editorial industrial photograph, wide landscape 3:2. A modern white cab truck pulling a brushed stainless steel cylindrical petroleum tanker trailer, viewed at front three-quarter angle on a clean paved road at the edge of a lush green central African industrial landscape. Warm soft late afternoon daylight, subtle palms and low green wooded hills in distance, small industrial structures far away. Truck occupies center-right and looks realistic with accurate wheels and piping. Natural photography, muted warm cream and gray color grade, sophisticated corporate composition, quiet and orderly scene. No company names or branding, no written text, no watermark. Fictional vehicle for illustration, not an actual company fleet.

Le logo fourni par le client est conservé dans `public/images/detra-logo.png`. Son cadrage d’affichage est réalisé en CSS sans modifier le fichier original.

`public/images/maritime-hero.png` a été créé avec l’outil intégré de génération d’images. Il s’agit d’une illustration et non d’une photographie de la flotte de DETRA.

Prompt final :

Create a photorealistic editorial maritime industry photograph to use as the full-width hero background of a premium African petroleum import-export corporate website. Wide cinematic landscape 16:9 composition. A large modern dark graphite hull oil tanker with pale cream superstructure occupies the right half, viewed from low aerial angle from its bow quarter, cruising slowly into a coastal oil terminal. Harbor industrial cranes and a few cylindrical storage tanks in the far background at right. Open dark blue charcoal water and subtle distant coast on the left half, providing low-detail dark negative space behind large white website headlines. Late golden hour with a hazy soft warm copper glow in the sky at upper right, muted olive gray horizon, beautiful small waves and realistic steel details. Understated sophisticated photography with film grain, natural neutral colors, real industrial atmosphere. No text, no typography, no logos, no watermark, no collages or interface. This is an illustrative fictional vessel, not evidence of a particular company's fleet.
