import { Category } from "./category.model";
import { Event_api } from "./event_api.model";

export interface Artist {

  "@id": string,
  "@type": string,
  "id": number,
  "nickname": string,
  "description": string,
  "image_path": string,
  "category": Category [],
  "events": Event_api[],

}