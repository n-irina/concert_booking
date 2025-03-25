import { Artist } from "./artist.model";

export interface Category {

  "@id": string,
  "@type": string,
  "id": number,
  "name": string,
  "artists": Artist[],

}